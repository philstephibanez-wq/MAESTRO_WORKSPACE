# HANDOFF — OPUS / OWASYS P117W R45B6 Permission Surface Consistency

Date : 2026-08-07

## Base owner

```text
OPUS master : 3a7b891c17be447161d5c70299207f2590c9247a
Commit       : suppression de try via owasys
```

R45B5B est publié au commit précédent `99b76efe7905b82176134d1fa745b3c16763654b`; l'interface OWASYS est revenue. Le commit courant supprime ensuite `try` via OWASYS.

## Incident déclencheur

Sur `Sources et Git`, une source de `owasys-back` apparaît « lecture seule ». La question owner impose l'audit complet des permissions de toutes les pages et non un patch local.

## Audit effectué

Surface : login, compte, Applications, création, Structure, Sources de données, Workflows, Sécurité, Sources et Git, Construction/validation, Profiler.

Contrôles : identité/roles SSO, ACL front/back, FSM/navigation, contrôleurs, ViewModels, SCORE, REST et allow-list Composer.

Défauts transversaux :

1. viewer pouvait ouvrir Applications mais ne pouvait pas sélectionner une application à cause d'un gate `registry:write` global ;
2. les contrôles Registry étaient rendus sans tenir compte des droits de chaque action ;
3. viewer pouvait ouvrir Compte mais le changement de son propre mot de passe était refusé front/back/allow-list alors que le formulaire était affiché ;
4. le helper local de Sources/Git masquait tout `Throwable` en décision `false`, produisant potentiellement un faux message lecture seule.

## Livrable actif

```text
ZIP     : opus_p117w_r45b6_permission_surface_consistency.zip
SHA-256 : 1c0c7aa71856529c0fd2a4ca3c1886afdd43ced0b04f0e25118afe5772b8ceaf
SCRIPT  : apply_opus_p117w_r45b6_permission_surface_consistency.php
SHA-256 : 332e9f5a7bfe09ed38447209386ef6ab5c13f9866f0934f311b981fd2d8a241a
BASE    : 3a7b891c17be447161d5c70299207f2590c9247a
TARGETS : 8 fichiers
OUTPUT  : OPUS_P117W_R45B6_APPLIED / FILES=8
```

Smoke séparé :

```text
FILE    : smoke_opus_p117w_r45b6_permission_surface_consistency_owner.php
SHA-256 : 3cf8e7deb5ee59d6611e01f9fa3e5a07a1139af5e30204a5a4d207d65590389a
OUTPUT  : OPUS_P117W_R45B6_SMOKE_OK
```

## Matrice viewer cible

Le viewer est lecture seule sur le métier, mais peut établir son contexte et gérer son propre secret local :

```text
ALLOW registry:open
ALLOW registry:select
ALLOW structure:open
ALLOW data:open
ALLOW workflows:open
ALLOW security:open
ALLOW source:open
ALLOW git:read
ALLOW build:open
ALLOW account:open
ALLOW account:change

DENY  creation:open
DENY  registry:delete
DENY  source:preview
DENY  source:write
DENY  git:stage
DENY  git:unstage
DENY  git:commit
DENY  git:restore
DENY  profiler:view
```

Le formulaire mot de passe est en plus conditionné au provider `local-password`; il n'est pas rendu pour Auth0-proxy.

## Validation owner

Appliquer uniquement sur le HEAD exact et dépôt propre pour les huit cibles. Exécuter le smoke, puis tester les trois rôles.

Gates fonctionnels minimum :

- viewer peut sélectionner `owasys-front`/`owasys-back` ou une application générée ;
- viewer peut ouvrir tous les onglets de lecture associés au contexte courant ;
- viewer voit Source/Git en lecture seule, sans boutons Preview/Save/Stage/Commit/Restore ;
- viewer local-password peut changer son propre mot de passe ;
- viewer ne peut ni créer ni supprimer une application ;
- developer/admin conservent les actions d'écriture ;
- Auth0-proxy ne reçoit pas de formulaire de mot de passe local ;
- aucune exception hors ACL n'est silencieusement convertie en faux refus.

## Suite

Après acquisition R45B6 : reprendre R45C wizard structuré, puis R45D administration Sécurité/RBAC.

NO ACL BYPASS.
NO SILENT ACL FALLBACK.
NO LOCAL PAGE PATCH.
NO PUSH OPUS BY ASSISTANT.
