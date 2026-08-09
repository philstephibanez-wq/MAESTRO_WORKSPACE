# OPUS P117W R45D2 — CONTROLLED SECURITY MUTATIONS

Date : 2026-08-09  
Statut : LIVRABLE OWNER À VALIDER

## Base canonique

```text
OPUS/master
af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121
opus_p117w_r45d1_security_snapshot_workspace
```

R45D1 est publié. Le screenshot owner du 2026-08-09 confirme que `/fr-FR/security` rend le workspace de sécurité réel sur la cible protégée `owasys-back`, avec ACL/SSO, politique `deny`, fournisseurs et vue Identités ; l'absence d'identités est cohérente avec l'absence de `security.onboarding.json`. Cette preuve ne vaut pas validation des cinq vues ni de la corrélation Profiler complète.

## Objet

R45D2 ajoute les premières mutations réelles de sécurité cible, exclusivement additives et strictement contrôlées. Aucun contrôle décisif n'est déplacé vers le frontend.

Flux obligatoire :

```text
SCORE
-> SSO OWASYS + ACL front + CSRF
-> preview REST sécurisé
-> owasys-back
-> Composer allow-listé
-> validation + plan déterministe
-> aperçu SCORE
-> confirmation explicite + nouvelle réauthentification
-> PATCH REST sécurisé
-> owasys-back
-> Composer allow-listé
-> contrôle de concurrence
-> File::writeAtomic
-> validation
-> commit ou rollback
-> audit Logger/Profiler
-> réponse SCORE
```

## Mutations R45D2

R45D2 supporte uniquement :

```text
identity.reference
role.create
permission.grant
assignment.grant
resource.allow
```

Les opérations destructives ou réductrices de privilèges (`identity.disable`, `role.rename`, `role.disable`, `role.delete`, `permission.revoke`, `assignment.revoke`, règles deny, etc.) restent explicitement hors R45D2. Elles ne sont ni simulées ni approximées ; elles nécessitent les protections supplémentaires du dernier administrateur, des révocations et de l'invalidation d'autorisation.

## Ressources REST

```text
POST  /api/v1/applications/{site_id}/security/previews
      operation = security.mutation.preview

PATCH /api/v1/applications/{site_id}/security
      operation = security.mutation.commit
```

La lecture R45D1 reste :

```text
GET /api/v1/applications/{site_id}/security
operation = security.snapshot
```

## Composer allow-listé

```text
owasys:security-mutation-preview
-> owasys:security:mutation-preview

owasys:security-mutation-commit
-> owasys:security:mutation-commit
```

Les deux mutations backend sont déclarées pour le rôle OWASYS `admin` uniquement. Le provider applique également l'ACL `security:manage`.

## Cibles mutables

Une cible n'est mutable que si son `site.json` déclare simultanément :

```text
role = generated-opus-application
generated_by = composer
```

Les cibles système suivantes sont toujours protégées en lecture seule :

```text
owasys-front
owasys-back
```

Donc R45D2 ne permet jamais d'administrer la sécurité propre d'OWASYS via le workspace de sécurité d'une application cible.

```text
NO ROLE MERGE.
NO FSM MERGE.
NO ACL BYPASS.
```

## Réauthentification

Toute preview et tout commit exige une réauthentification fraîche de l'administrateur OWASYS.

R45D2 implémente cette réauthentification uniquement pour le provider OWASYS `local-password`. Le mot de passe est vérifié localement côté `owasys-front`, immédiatement supprimé de la requête PHP, et n'est jamais envoyé par REST, loggé ou profilé.

Le backend reçoit uniquement une assertion temporelle à courte durée de vie dans le canal REST déjà authentifié/HMAC et rejette toute assertion absente, invalide ou âgée de plus de 120 secondes.

Pour un administrateur OWASYS authentifié par Auth0, R45D2 n'invente pas de preuve de réauthentification : les mutations restent indisponibles jusqu'à un contrat de fresh-auth Auth0 explicite.

## CSRF et confirmation

Le formulaire OWASYS utilise `Opus\Security\Csrf\CsrfTokenManager` avec token lié à la session, au site cible et à usage unique.

La preview produit :

```text
OWASYS_SECURITY_MUTATION_PREVIEW_V1
current_state_hash
proposed_state_hash
confirmation_token
diff
affected_subjects
access_delta.gained
```

Le token de confirmation SHA-256 lie :

```text
site cible
état courant
état proposé
mutation normalisée
acteur OWASYS
motif
```

Le commit exige le hash d'état attendu et le token de confirmation. Toute modification concurrente de la sécurité cible déclenche `OWASYS_SECURITY_MUTATION_STATE_CONFLICT`.

## Persistance

Toutes les écritures passent par `Opus\File\File::writeAtomic` et tous les documents structurés sont lus/validés par `StructuredFileLoader`.

Les opérations R45D2 touchent un seul document de sécurité par mutation. En cas d'échec après écriture, l'état précédent est restauré par la même frontière `File` ; un échec de rollback est explicite.

Aucun fichier de sécurité d'OWASYS n'est écrit par ce service.

## Sémantique des opérations

### identity.reference

Référence une identité externe dans `config/security.onboarding.json`. Aucun secret n'est créé ou stocké. Le provider doit être activé dans le SSO cible et rester cohérent avec le provider de l'onboarding.

### role.create

Ajoute un rôle stable au contrat ACL cible reconnu. Le rôle est créé sans droit implicite.

### permission.grant

Accorde explicitement `<resource>:<action>` à un rôle existant. Pour `OPUS_ACL_POLICY_V1`, le grant est ajouté au rôle. Pour `OPUS_GENERATED_APPLICATION_ACL_V1`, la permission et la policy explicite sont mises à jour sans inventer de mapping absent.

### assignment.grant

N'est disponible que si un véritable store runtime `local-password` existe. Le rôle est ajouté à l'identité runtime existante, sans exposer ni modifier son hash de mot de passe. Si aucune persistance d'attribution réelle n'existe, l'opération est refusée explicitement.

### resource.allow

Ajoute un `allow` explicite d'un rôle sur une ressource/action existante ou déclarable dans le contrat ACL cible. Le droit reste attaché à la ressource.

```text
LE DROIT APPARTIENT À LA RESSOURCE, PAS AU BOUTON.
```

## Audit

Preview, commit et rollback alimentent Logger/Profiler sans secret. L'audit de commit contient au minimum :

```text
acteur
application cible
mutation
motif
before_state_hash
after_state_hash
fichiers concernés
résultat
trace_id
```

## I18n / SCORE

L'interface reste SCORE-only et sans HTML construit par PHP. Les 25 catalogues de base OPUS (langues de l'Union européenne + ukrainien) contiennent les clés R45D2. Le français est traduit nativement ; le fallback des nouvelles chaînes non françaises reste explicite dans les catalogues fournis et devra être enrichi linguistiquement ultérieurement sans modifier le contrat fonctionnel.

## Livrable

```text
ZIP     : opus_p117w_r45d2_controlled_security_mutations.zip
SHA-256 : 3f40e620dae36cd57eb671f2efc8071fbe288831558d6201d40e80a4394558ba
BASE    : af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121
FILES   : 38
```

Le ZIP contient uniquement les 38 fichiers complets modifiés/créés à leurs chemins finaux. Aucun apply script, smoke, rapport, log, cache, temporaire, vendor ou composant JavaScript backend n'est inclus.

## Validation statique effectuée

- PHP lint : OK ;
- JSON : 32 documents parsés ;
- 25 catalogues I18n : clés R45D2 présentes ;
- balises de contrôle SCORE : équilibrées ;
- catalogues REST front/back : identiques pour les trois opérations `security.*` ;
- chaîne operation -> Composer script -> alias -> provider : cohérente ;
- preview/commit backend : rôle `admin` uniquement ;
- plan de mutation déterministe : aucun horodatage/aléa injecté dans l'état proposé ;
- aucun `.js/.mjs/.cjs/.ts/.tsx`, `package.json` ou lockfile JS dans le delta backend ;
- aucune classe `Opus/**/*.php` modifiée ;
- aucune écriture directe hors frontière `File` dans le nouveau service backend.

## Gate owner

1. HEAD OPUS exact `af8ac2f5...` avant extraction ;
2. working tree propre ;
3. extraire le ZIP directement ;
4. lint PHP et parsing JSON ;
5. `composer dump-autoload -o` ;
6. lancer `owasys-back`, puis `owasys-front` ;
7. vérifier que `owasys-front` et `owasys-back` restent en lecture seule dans Sécurité ;
8. créer/sélectionner une application générée de test ;
9. vérifier qu'un admin `local-password` obtient les formulaires de mutation ;
10. effectuer une preview et vérifier qu'aucun fichier n'a changé ;
11. confirmer avec nouvelle réauthentification et vérifier le commit ;
12. vérifier qu'un hash d'état obsolète est rejeté ;
13. vérifier Logger/Profiler et absence de secret ;
14. owner commit/push uniquement après succès.
