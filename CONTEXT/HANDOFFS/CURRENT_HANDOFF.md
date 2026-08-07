# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-07

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B4_PROFILER_ENVIRONMENT_CONFIG_2026-08-07.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B5_GENERATED_RUNTIME_ERROR_STAGE_ALL_2026-08-07.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B5B_REST_CATALOG_REPAIR_2026-08-07.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B6_PERMISSION_SURFACE_CONSISTENCY_2026-08-07.md`
8. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45B6_PERMISSION_SURFACE_CONSISTENCY_2026-08-07.md`
9. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte

OPUS `master` owner publié :

```text
3a7b891c17be447161d5c70299207f2590c9247a
suppression de try via owasys
```

R45B5B a été publié juste avant au commit `99b76efe7905b82176134d1fa745b3c16763654b` et a rétabli le bootstrap REST OWASYS. La capture owner suivante confirme le retour de l'interface `Sources et Git`.

## Livrable actif — R45B6

```text
ZIP     : opus_p117w_r45b6_permission_surface_consistency.zip
SHA-256 : 1c0c7aa71856529c0fd2a4ca3c1886afdd43ced0b04f0e25118afe5772b8ceaf
SCRIPT  : apply_opus_p117w_r45b6_permission_surface_consistency.php
SHA-256 : 332e9f5a7bfe09ed38447209386ef6ab5c13f9866f0934f311b981fd2d8a241a
BASE    : 3a7b891c17be447161d5c70299207f2590c9247a
TARGETS : 8
OUTPUT  : OPUS_P117W_R45B6_APPLIED / FILES=8
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_r45b6_permission_surface_consistency_owner.php
SHA-256 : 3cf8e7deb5ee59d6611e01f9fa3e5a07a1139af5e30204a5a4d207d65590389a
OUTPUT  : OPUS_P117W_R45B6_SMOKE_OK
```

## Cause traitée

L'audit de toutes les pages a identifié une incohérence transversale entre permissions d'ouverture, permissions d'action et contrôles SCORE :

- viewer pouvait ouvrir Applications mais pas sélectionner une application ;
- Registry rendait création/sélection/suppression sans capacités action-spécifiques ;
- viewer pouvait ouvrir Compte mais pas changer son propre mot de passe local, alors que le formulaire était affiché ;
- Sources/Git capturait tout `Throwable` comme un faux refus ACL et pouvait afficher à tort « lecture seule ».

R45B6 aligne identité -> ACL front -> FSM -> ViewModel -> SCORE -> REST -> ACL back -> allow-list Composer.

## Matrice viewer cible

```text
ALLOW registry:open, registry:select
ALLOW structure:open, data:open, workflows:open, security:open
ALLOW source:open, git:read, build:open
ALLOW account:open, account:change

DENY creation:open
DENY registry:delete
DENY source:preview, source:write
DENY git:stage, git:unstage, git:commit, git:restore
DENY profiler:view
```

`account:change` est self-service et le formulaire n'est rendu que pour `local-password`. Auth0-proxy ne reçoit aucun formulaire local.

## Gates owner

1. HEAD exact `3a7b891c17be447161d5c70299207f2590c9247a` ;
2. huit cibles propres ;
3. application du ZIP ;
4. `OPUS_P117W_R45B6_APPLIED` et `FILES=8` ;
5. autoload optimisé ;
6. smoke séparé -> `OPUS_P117W_R45B6_SMOKE_OK` ;
7. tester admin/developer/viewer ;
8. viewer : sélection d'application OK, pages lecture OK, Source/Git lecture seule réelle, aucune mutation ;
9. viewer local-password : changement de son propre mot de passe OK ;
10. admin/developer : mutations conservées ;
11. Auth0 : aucun formulaire local ;
12. commit/push OPUS uniquement par l'owner après succès.

## Suite

Après acquisition R45B6 : R45C wizard OWASYS structuré, puis R45D administration Sécurité/RBAC.

NO ACL BYPASS.
NO UI ACTION WITHOUT CAPABILITY.
NO SILENT ACL FALLBACK.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
