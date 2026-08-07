# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-07

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_SECURE_SOURCE_EDITOR_AND_GIT_WORKFLOW_2026-08-05.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E1_SOURCE_WORKSPACE_2026-08-05.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E2A_SOURCE_REST_COMPOSER_2026-08-05.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E2B_SOURCE_EDITOR_FRONT_2026-08-06.md`
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E3A_GIT_WORKSPACE_BACKEND_2026-08-06.md`
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E3B_GIT_WORKSPACE_FRONT_2026-08-06.md`
10. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B3_REST_CLIENT_CONTRACT_2026-08-06.md`
11. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B4_PROFILER_ENVIRONMENT_CONFIG_2026-08-07.md`
12. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B5_GENERATED_RUNTIME_ERROR_STAGE_ALL_2026-08-07.md`
13. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45B5_GENERATED_RUNTIME_ERROR_STAGE_ALL_2026-08-07.md`
14. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte

OPUS `master` : `2376a4de07e4f504aeac1be1d8a183d43c34df80`.

R45B4 est acquis au commit `2376a4de07e4f504aeac1be1d8a183d43c34df80` (`opus_p117w_r45b4_profiler_environment_config`). R45B5 doit être appliqué exclusivement sur ce HEAD.

R46 `dev-server --site=` reste abandonné. Contrat :

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

## Livrable actif — R45B5

```text
ZIP     : opus_p117w_r45b5_generated_runtime_error_stage_all.zip
SHA-256 : 74e70f1b93c7b719497aeb99c704fd4d5c2e38489ec235bba8aacf924caf15cc
FILES   : 1 script différentiel complet
TARGETS : 38 fichiers suivis
BASE    : 2376a4de07e4f504aeac1be1d8a183d43c34df80
STATUS  : livré, application, validation, commit et push owner requis
```

Script :

```text
apply_opus_p117w_r45b5.php
SHA-256 : 967ddf96a845b59994c3c6eb4a118e9a57a9c31145c2cf40aa81de52860c6ef2
OUTPUT  : OPUS_P117W_R45B5_APPLIED
FILES   : 38
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_r45b5_generated_runtime_error_stage_all_owner.php
SHA-256 : 22c496ebf5fe77552bfb39febce5cee81da7306bf6dd4c4a77f865623f0f2ee7
OUTPUT  : OPUS_P117W_R45B5_SMOKE_OK
```

Le ZIP ne contient aucun smoke, audit, rapport, log, cache, vendor, temporaire ou secret. Le script et le smoke ne sont pas destinés à être committés dans OPUS.

## Cause 1 — HTTP 500 `try`

Le `catch` de `GeneratedSiteRuntime` appelait le Profiler avec `status=failed`, valeur interdite par `Trace`.

R45B5 corrige :

```text
request.failed -> status=error
```

Le contrat Profiler reste strict ; aucune valeur `failed` n'est ajoutée aux statuts de `Trace`.

L'URL de la capture `:8800/fr-FR/applications` n'est pas créée artificiellement dans `try`. L'accueil générique du site généré reste `/`, donc le test de `try` se fait sur :

```text
http://127.0.0.1:8800/fr-FR/
```

Une route absente doit ensuite produire une HTTP 404 OPUS propre, jamais le 500 générique de la régression R45B4.

## Cause 2 — Stage all

Nouvelle chaîne contractuelle :

```text
SCORE + CSRF
-> PUT /api/v1/applications/{site_id}/git/index
-> git.stage_all
-> owasys:git-stage-all
-> owasys:git:stage-all
-> SiteGitWorkspace::stageAll()
```

Exécution bornée :

```text
git add -A -- sites/<site_id>
```

Stage all :

- ne reçoit aucun chemin libre du navigateur ;
- ne peut stager qu'un site validé ;
- refuse les conflits ;
- conserve le stage fichier par fichier ;
- conserve l'interdiction de commit si l'index contient un chemin étranger ;
- réutilise l'ACL `git:stage` et la FSM `stage_source/source_staged` ;
- ajoute un bouton SCORE sans JavaScript ;
- ajoute `git.stage_all` et `git.stage_all_success` aux 24 langues officielles UE configurées plus ukrainien.

## Validation owner obligatoire

```text
cd /d H:\OPUS
git rev-parse HEAD
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r45b5_generated_runtime_error_stage_all.zip" SHA256
certutil -hashfile "%USERPROFILE%\Downloads\smoke_opus_p117w_r45b5_generated_runtime_error_stage_all_owner.php" SHA256
if exist "%TEMP%\opus_r45b5" rmdir /S /Q "%TEMP%\opus_r45b5"
mkdir "%TEMP%\opus_r45b5"
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b5_generated_runtime_error_stage_all.zip" -C "%TEMP%\opus_r45b5"
php "%TEMP%\opus_r45b5\apply_opus_p117w_r45b5.php" "H:\OPUS"
composer validate
composer dump-autoload -o
copy /Y "%USERPROFILE%\Downloads\smoke_opus_p117w_r45b5_generated_runtime_error_stage_all_owner.php" "H:\OPUS\smoke_opus_p117w_r45b5_generated_runtime_error_stage_all_owner.php"
php smoke_opus_p117w_r45b5_generated_runtime_error_stage_all_owner.php
del /Q "H:\OPUS\smoke_opus_p117w_r45b5_generated_runtime_error_stage_all_owner.php"
rmdir /S /Q "%TEMP%\opus_r45b5"
```

Attendus :

```text
OPUS_P117W_R45B5_APPLIED
FILES=38
OPUS_P117W_R45B5_SMOKE_OK
```

Puis relancer OWASYS-front/back, tester `Tout stager` sur `try`, vérifier qu'aucun autre site n'est stagé, puis démarrer `try` et tester `/fr-FR/` ainsi qu'une route inexistante.

Commit et push OPUS uniquement par l'owner après succès.

## Suite après acquisition

```text
R45C — wizard OWASYS structuré
R45D — administration Sécurité
```

NO LOCAL TRY FIX.
NO PROFILER STATUS CONTRACT WIDENING.
NO CROSS-SITE STAGE.
NO FREE GIT PATH OR COMMAND.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO REST CATALOG DRIFT.
NO SMOKE IN OPUS ZIP.
NO FALLBACK SILENCIEUX.
NO PUSH OPUS PAR L’ASSISTANT.