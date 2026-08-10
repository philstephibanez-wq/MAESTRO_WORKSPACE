# HANDOFF — OPUS P117W R45D2A14B LOGOUT ATOMIC MIGRATION

Date : 2026-08-11

## Base canonique

`philstephibanez-wq/OPUS` master : `f195471557727d23d0be036b80382f3ba3ad9787` (`opus_p117w_r45d2a14_generated_logout`).

## États acquis

- connexion locale `essai2/steve` acquise ;
- profiler intégré/repliable acquis ;
- message login I18n acquis ;
- Source/Git ACL UI truth R45D2A12 acquis.

## Régression R45D2A14

Le runtime publié rend le logout dès qu'une identité locale est authentifiée et appelle `auth.logout`. Mais le commit publié ne contient pas la migration des routes/catalogues générés. `essai2` n'a donc ni `/logout` ni `auth.logout`, ce qui provoque `OPUS_GENERATED_RUNTIME_FAILED` sur `/fr`.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a14b_logout_atomic_migration.zip
SHA-256 : 7c5116094616bdd93269ff74b99cfde7ad4047a131a06f96b191793bd88c7964
BASE    : f195471557727d23d0be036b80382f3ba3ad9787
FILES   : 2
```

## Correction

- garde runtime : aucun rendu logout sans route `module=logout` réellement déclarée ;
- migration atomique des sites générés avec login : route `/logout`, I18n `auth.logout`, CSS ;
- smoke fail-fast route + I18n.

## Gate immédiat

```text
php tools\r45d2a14b_apply_logout_atomic_migration.php
php tools\smoke_r45d2a14b_logout_atomic_migration.php
php -l Opus\Application\Runtime\GeneratedSiteRuntime.php
composer dump-autoload -o
composer opus:dev-server -- essai2
```

Validation : `/fr` authentifié fonctionne ; `Déconnexion` est visible ; logout POST invalide la session et redirige vers `/fr/login`.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO ACL/SSO RELAXATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
