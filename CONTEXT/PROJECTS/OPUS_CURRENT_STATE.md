# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-07.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 3a7b891c17be447161d5c70299207f2590c9247a
Commit HEAD : suppression de try via owasys
R45B5B publié : 99b76efe7905b82176134d1fa745b3c16763654b
Livrable actif : R45B6 cohérence des permissions OWASYS
```

## État après R45B5B

R45B5B a réparé les catalogues REST Stage all en remplaçant l'identifiant invalide `git.stage_all` par `git.stage-all`. Le commit est publié et l'interface OWASYS est revenue.

Le commit owner suivant `3a7b891c17be447161d5c70299207f2590c9247a` supprime l'application `try` via OWASYS et constitue la base exacte de R45B6.

## Audit R45B6

L'audit couvre toute la surface OWASYS actuellement exposée :

```text
login
account/password
applications
applications/new
structure
data
workflows
security
source / Sources et Git
build
Web Profiler
```

Chaîne contrôlée :

```text
SSO identity
-> normalized session roles
-> front ACL
-> FSM/navigation
-> controller action gate
-> ViewModel capability
-> SCORE control
-> secured REST
-> back ACL
-> Composer operation allow-list
```

### Défauts confirmés

1. `viewer` possède `registry:open`, mais le frontend utilisait `registry:write` pour tous les POST Applications et le backend réservait select/clear aux rôles d'écriture. Le viewer ne pouvait donc pas établir le contexte applicatif nécessaire aux autres pages.
2. Le template Registry rendait create/select/clear/delete sans capacités d'action explicites.
3. `viewer` possède `account:open`, mais pas `account:change`, alors que le formulaire de changement de mot de passe était toujours rendu. Le backend agit pourtant sur le sujet authentifié lui-même.
4. Sources/Git utilisait un helper local qui capturait tout `Throwable` et retournait `false`, pouvant convertir une erreur non-ACL en faux message « lecture seule ».

## Livrable actif R45B6

```text
ZIP     : opus_p117w_r45b6_permission_surface_consistency.zip
SHA-256 : 1c0c7aa71856529c0fd2a4ca3c1886afdd43ced0b04f0e25118afe5772b8ceaf
SCRIPT  : apply_opus_p117w_r45b6_permission_surface_consistency.php
SHA-256 : 332e9f5a7bfe09ed38447209386ef6ab5c13f9866f0934f311b981fd2d8a241a
BASE    : 3a7b891c17be447161d5c70299207f2590c9247a
TARGETS : 8
OUTPUT  : OPUS_P117W_R45B6_APPLIED / FILES=8
```

Smoke séparé :

```text
smoke_opus_p117w_r45b6_permission_surface_consistency_owner.php
SHA-256 : 3cf8e7deb5ee59d6611e01f9fa3e5a07a1139af5e30204a5a4d207d65590389a
OUTPUT  : OPUS_P117W_R45B6_SMOKE_OK
```

## Matrice viewer cible

Autorisé :

```text
registry:open
registry:select
structure:open
data:open
workflows:open
security:open
source:open
git:read
build:open
account:open
account:change
```

Interdit :

```text
creation:open
registry:delete
source:preview
source:write
git:stage
git:unstage
git:commit
git:restore
profiler:view
```

Le changement de mot de passe est self-service et conditionné au provider `local-password`. Auth0-proxy ne reçoit pas de formulaire local.

Admin reste `*:*`. Developer conserve les droits de mutation existants.

## Fichiers R45B6

```text
sites/owasys-front/config/acl.json
sites/owasys-back/config/acl.json
sites/owasys-back/config/backend.operations.json
sites/owasys-back/application/registry/services/OwasysCommandProvider.php
sites/owasys-front/application/default/controllers/RuntimeController.php
sites/owasys-front/application/registry/templates/index.score
sites/owasys-front/application/account/templates/index.score
sites/owasys-front/application/source/controllers/SourceController.php
```

## Prévalidation assistant

- script apply : `php -l` OK ;
- smoke owner : `php -l` OK ;
- ZIP : un script différentiel uniquement ;
- SHA-256 calculés et consignés ;
- application complète sur le dépôt owner et tests navigateur restent obligatoires côté owner.

## Suite gouvernée

1. acquisition owner R45B6 ;
2. R45C wizard OWASYS structuré ;
3. R45D administration Sécurité/RBAC.

NO ACL BYPASS.
NO UI ACTION WITHOUT CAPABILITY.
NO SILENT ACL FALLBACK.
NO ROLE ADMINISTRATION IN R45B6.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
