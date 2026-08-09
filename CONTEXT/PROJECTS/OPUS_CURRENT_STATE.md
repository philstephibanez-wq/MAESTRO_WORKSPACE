# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-09.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121
Commit : opus_p117w_r45d1_security_snapshot_workspace
Dernier état acquis publié : R45D1
```

Parent R45D1 :

```text
730f19032a5b69c66c14d4d4401813e0638353d1
opus_p117w_r45c3r1_github_recovery_structured_workflow
```

## Workflow OWASYS acquis

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

Aucun changement `RestClient` n'est retenu. R45C4 reste retiré / invalidé.

## R45D1 — acquis et publié

R45D1 remplace le module `Sécurité` pending/501 par un workspace réel en lecture seule de la sécurité de l'application cible.

Commit publié :

```text
af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121
opus_p117w_r45d1_security_snapshot_workspace
```

Le screenshot owner du 2026-08-09 confirme sur `/fr-FR/security` avec `owasys-back` sélectionné :

```text
workspace Sécurité rendu
cible = owasys-back
mode = lecture seule
ACL = OPUS_ACL_POLICY_V1
SSO = OPUS_SSO_CONFIGURATION_V1
politique par défaut = deny
provider par défaut = auth0-proxy
identités = aucune donnée
providers = auth0-proxy, service-hmac
```

L'absence d'identités est attendue sur cette cible système sans `security.onboarding.json`. Le screenshot confirme la vue Identités et la disparition du pending/501. Il ne valide pas à lui seul les quatre autres vues, le maintien de vue par langue ni toute la corrélation Profiler.

## Séparation de sécurité

OWASYS et l'application cible conservent des référentiels distincts.

```text
NO ROLE MERGE.
NO FSM MERGE.
NO ACL BYPASS.
```

```text
LE DROIT APPARTIENT À LA RESSOURCE, PAS AU BOUTON.
```

## Livrable actif — R45D2 Controlled Security Mutations

```text
ZIP     : opus_p117w_r45d2_controlled_security_mutations.zip
SHA-256 : 3f40e620dae36cd57eb671f2efc8071fbe288831558d6201d40e80a4394558ba
BASE    : af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121
FILES   : 38
```

R45D2 supporte uniquement les mutations additives :

```text
identity.reference
role.create
permission.grant
assignment.grant
resource.allow
```

Les mutations destructives restent hors périmètre R45D2 et ne sont pas simulées.

## Pipeline R45D2

```text
SCORE
-> SSO/ACL/CSRF OWASYS front
-> POST preview REST sécurisé
-> owasys-back
-> Composer allow-listé
-> plan déterministe
-> preview SCORE
-> confirmation explicite + nouvelle réauthentification
-> PATCH REST sécurisé
-> owasys-back
-> Composer allow-listé
-> contrôle de concurrence
-> File::writeAtomic
-> validation
-> commit ou rollback
-> audit Logger/Profiler
-> SCORE
```

REST :

```text
GET   /api/v1/applications/{site_id}/security
POST  /api/v1/applications/{site_id}/security/previews
PATCH /api/v1/applications/{site_id}/security
```

## Protections R45D2

- `admin` OWASYS seulement pour preview/commit backend ;
- `security:manage` vérifié côté front et back ;
- CSRF session/site à usage unique ;
- fresh reauthentication obligatoire ;
- R45D2 implémente la réauthentification OWASYS `local-password` seulement ;
- Auth0 fresh-auth non approximé ;
- mot de passe jamais envoyé par REST ;
- `owasys-front` et `owasys-back` toujours protégés/read-only ;
- mutation uniquement pour `generated-opus-application` + `generated_by=composer` ;
- preview sans écriture ;
- `current_state_hash` et confirmation token déterministe ;
- écriture atomique et rollback ;
- audit acteur/cible/motif/hashes/résultat/trace ;
- aucun secret dans réponse, logs ou Profiler ;
- `assignment.grant` seulement si un vrai store runtime `local-password` existe.

## Validation statique R45D2

```text
PHP lint                 OK
JSON                     OK (32)
I18n base                OK (25)
SCORE control balance    OK
REST security catalogs   OK
Composer allow-list      OK
backend JS/Node delta    0
Opus/**/*.php delta      0
mutation plan dynamic    0
```

## Gate owner R45D2

1. HEAD OPUS exact `af8ac2f5...` et working tree propre ;
2. extraction directe du ZIP ;
3. PHP lint + StructuredFileLoader + autoload ;
4. lancer `owasys-back`, puis `owasys-front` ;
5. confirmer que les cibles OWASYS restent read-only ;
6. créer/sélectionner une application générée de test ;
7. preview d'une mutation additive : aucune écriture ;
8. commit après nouvelle réauthentification ;
9. vérifier snapshot après mutation ;
10. vérifier conflit optimiste avec hash obsolète ;
11. vérifier Logger/Profiler sans secret ;
12. owner commit/push uniquement après succès.

## Profiler `.lock`

Le cycle de vie des `.lock` reste un audit OPUS générique séparé. Aucune suppression aveugle. Ce sujet ne bloque pas R45D2.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO SECRET OVER REST.
NO PUSH OPUS BY ASSISTANT.
