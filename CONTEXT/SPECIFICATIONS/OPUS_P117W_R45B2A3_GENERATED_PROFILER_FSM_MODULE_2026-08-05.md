# OPUS P117W R45B2A3 — Generated Profiler FSM Module

Date : 2026-08-05

## Base

OPUS `master` : `17bfadf500148d0bf2de9f00a1806bd756053426`.

## Défaut reproductible

R45B2A1R7 ajoute à la FSM générée l'état `profiler` avec `module: profiler`.
`FsmSiteLoader` impose qu'un répertoire `application/<module>` existe pour chaque module référencé par les états FSM.
Le scaffold frontend/fullstack ne créait pas `application/profiler`.

Toute requête, y compris `/`, échouait donc pendant le chargement de la FSM. Le message détaillé contenait des espaces et était ramené par `GeneratedSiteRuntime::safeErrorCode()` au code générique `OPUS_GENERATED_RUNTIME_FAILED`.

## Correction de cause

Le scaffold générique crée `sites/<site>/application/profiler`.
Aucun site généré, notamment `test6`, n'est corrigé localement.

## Livrable

```text
ZIP     : opus_p117w_r45b2a3_generated_profiler_fsm_module.zip
SHA-256 : 66d270c9dc95fa89e11a2fa0c3f35a5b564e95ea6c2866c6764488169ff81c0d
FILES   : 1
BASE    : 17bfadf500148d0bf2de9f00a1806bd756053426
```

Fichier complet :

- `Opus/Scaffold/SiteScaffoldPlan.php`

## Gates owner

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a3_generated_profiler_fsm_module.zip"
php -l Opus\Scaffold\SiteScaffoldPlan.php
composer dump-autoload -o
composer opus:delete-site -- test6
composer opus:create-site -- test6
composer opus:validate-site -- test6
composer opus:dev-server -- test6 --port=8800
```

Attendu : la page d'accueil de `test6` répond sans `OPUS_GENERATED_RUNTIME_FAILED`.

NO LOCAL SITE FIX.
NO ACL BYPASS.
