# OPUS P117W R45D1 — SECURITY SNAPSHOT WORKSPACE

Date : 2026-08-09  
Statut : LIVRABLE OWNER À VALIDER

## Base canonique

```text
OPUS/master
730f19032a5b69c66c14d4d4401813e0638353d1
opus_p117w_r45c3r1_github_recovery_structured_workflow
```

R45D1 repart exclusivement de cette source GitHub canonique.

## Objet

R45D1 remplace l'écran `Sécurité` encore non implémenté par un workspace de sécurité réel, en lecture seule, pour l'application OPUS actuellement sélectionnée dans OWASYS.

Le flux reste strictement :

```text
SCORE
-> FSM + ACL OWASYS front
-> REST sécurisé GET /api/v1/applications/{site_id}/security
-> owasys-back
-> FSM REST backend
-> Composer allow-listé owasys:security-snapshot
-> OwasysCommandProvider
-> File + StructuredFileLoader
-> réponse structurée
-> SCORE
```

Aucune lecture directe de la sécurité cible n'est effectuée par `owasys-front`.

## Vues R45D1

Le workspace expose cinq vues distinctes, conservant le même état FSM OWASYS `security` :

1. Identités ;
2. Rôles ;
3. Permissions ;
4. Attributions ;
5. Ressources et ACL.

Le sélecteur utilise `GET /<locale>/security?view=...` et ne dépend pas de JavaScript.

## Séparation des référentiels

R45D1 affiche la sécurité de l'application cible sélectionnée. Il ne fusionne jamais les rôles OWASYS avec les rôles de cette application.

```text
NO ROLE MERGE.
NO FSM MERGE.
NO ACL BYPASS.
```

L'administration des utilisateurs/rôles propres à OWASYS reste un référentiel distinct.

## Contrats de sécurité lus

Le backend accepte explicitement les contrats actuellement canoniques :

```text
ACL : OPUS_ACL_POLICY_V1
ACL : OPUS_GENERATED_APPLICATION_ACL_V1
SSO : OPUS_SSO_CONFIGURATION_V1
SSO : OPUS_GENERATED_APPLICATION_SSO_V1
ONBOARDING optionnel : OPUS_SECURITY_ONBOARDING_V1
```

Tout autre contrat est rejeté explicitement.

L'absence de `security.onboarding.json` est exposée comme absence ; aucun utilisateur ou rôle n'est inventé.

Pour les stores `local-password`, seuls les champs non secrets sont projetés. Aucun `password_hash`, mot de passe, token, secret HMAC ou secret proxy n'est renvoyé au frontend, loggé ou profilé.

## Modèle de snapshot

Contrat réponse :

```text
OWASYS_SECURITY_SNAPSHOT_V1
```

Sections :

```text
application
overview
providers
identities
roles
permissions
assignments
resources
```

Pour `OPUS_ACL_POLICY_V1`, les associations rôle-permission sont réelles et peuvent être affichées.

Pour `OPUS_GENERATED_APPLICATION_ACL_V1`, le contrat actuel ne persiste pas encore un mapping complet rôle -> permission. R45D1 l'indique explicitement et n'invente aucune association. Les politiques ressource -> rôles et la liste des permissions restent affichées telles qu'elles existent.

Principe conservé :

```text
LE DROIT APPARTIENT À LA RESSOURCE, PAS AU BOUTON.
```

## REST / Composer

Nouvelle ressource REST :

```text
GET /api/v1/applications/{site_id}/security
operation = security.snapshot
status = 200
```

Nouvelle commande publique allow-listée :

```text
owasys:security-snapshot
-> owasys:security:snapshot
```

Rôles backend autorisés en lecture :

```text
admin
developer
viewer
```

Le backend applique en plus l'ACL `security:read`. `admin` conserve `*:*`.

## FSM / UI

`OwasysSecurityController` est un contrôleur applicatif OWASYS dédié. Il :

- exige une identité OWASYS authentifiée ;
- exige une application courante ;
- applique `security:open` côté frontend ;
- effectue la transition FSM `open_security` ;
- interroge ensuite le backend par REST sécurisé ;
- rend exclusivement `security/templates/index.score`.

Aucun HTML n'est concaténé en PHP et aucun `echo` UI n'est ajouté.

## I18n

Le module fournit un catalogue de base pour toutes les langues OPUS supportées de l'Union européenne et l'ukrainien :

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

Les variantes régionales continuent à utiliser la chaîne de fallback OPUS existante.

## Livrable

```text
ZIP     : opus_p117w_r45d1_security_snapshot_workspace.zip
SHA-256 : 3eb28c2e13b4c3b7f511564c524eaea47d4dad9c6b61041375cab5cf2c68eb27
BASE    : 730f19032a5b69c66c14d4d4401813e0638353d1
FILES   : 38
```

Le ZIP ne contient que des fichiers complets à leurs chemins finaux. Aucun apply script, smoke, rapport, log, cache, temporaire, `vendor`, JavaScript backend ou dépendance Node n'est livré.

## Validation déjà effectuée hors runtime owner

- PHP lint : 5 fichiers PHP modifiés/créés OK ;
- parsing JSON : 32 fichiers JSON du livrable OK ;
- cohérence REST front/back : ressource `security.snapshot` identique ;
- cohérence operation -> script Composer -> alias provider vérifiée ;
- 25 catalogues de langue module présents ;
- aucun `.js/.mjs/.cjs/.ts/.tsx`, `package.json`, lockfile npm/yarn/pnpm dans `sites/owasys-back` du livrable ;
- aucune classe `Opus/**/*.php` modifiée par R45D1.

## Gate owner

1. HEAD OPUS exact sur la base indiquée avant extraction ;
2. extraire le ZIP dans `H:\OPUS` ;
3. lint PHP ;
4. parsing JSON via `StructuredFileLoader` ;
5. `composer dump-autoload -o` ;
6. lancer `owasys-back`, puis `owasys-front` ;
7. sélectionner une application ;
8. ouvrir `Sécurité` ;
9. vérifier absence de HTTP 501 / écran pending ;
10. vérifier les cinq vues ;
11. vérifier que le changement de langue conserve la vue de sécurité ;
12. vérifier la corrélation Profiler front -> REST -> back -> Composer -> réponse ;
13. owner commit/push uniquement après succès.

## Suite

R45D2 portera les mutations de sécurité cible : preview déterministe, confirmation explicite, écriture atomique, validation avant commit, rollback en cas d'échec et audit. R45D1 ne modifie aucune sécurité cible.
