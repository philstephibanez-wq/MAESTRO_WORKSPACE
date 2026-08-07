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
13. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B5A_REST_OPERATION_IDENTIFIER_FIX_2026-08-07.md`
14. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45B5A_REST_OPERATION_IDENTIFIER_FIX_2026-08-07.md`
15. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte

OPUS `master` publié : `2376a4de07e4f504aeac1be1d8a183d43c34df80`.

R45B4 est acquis. R45B5 a été appliqué localement sur ce HEAD mais n'est pas acquis et ne doit pas être committé seul.

R46 `dev-server --site=` reste abandonné. Contrat :

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

## Incident bloquant R45B5

Après application R45B5, OWASYS-front échoue au bootstrap avec :

```text
OPUS_REST_API_RESOURCE_DEFINITION_INVALID
```

Cause racine : R45B5 a créé l'identifiant REST invalide :

```text
git.stage_all
```

Le contrat `RestResourceCatalog` autorise des segments séparés uniquement par `.` ou `-`. L'identifiant corrigé est :

```text
git.stage-all
```

Ne pas élargir la grammaire REST pour accepter `_`.

## Livrable actif — R45B5A

```text
ZIP     : opus_p117w_r45b5a_rest_operation_identifier_fix.zip
SHA-256 : 9612f091296cbbcd9f5295f0d77113f40222924531c6787c1d4eda68e6920dfd
SCRIPT  : apply_opus_p117w_r45b5a.php
SHA-256 : 36b7e8715b0c72934007e1bf3cdf3d2f303eef904bb075c9c63f0f425881b71c
OUTPUT  : OPUS_P117W_R45B5A_APPLIED
FILES   : 4
BASE    : HEAD R45B4 + modifications locales R45B5 non committées
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_r45b5a_rest_operation_identifier_fix_owner.php
SHA-256 : 059755a7267b7379aceccc4bd3987e397a827fd9c7a3f7a1c87925ea757e0a19
OUTPUT  : OPUS_P117W_R45B5A_SMOKE_OK
```

R45B5A corrige uniquement :

```text
sites/owasys-back/config/backend.operations.json
sites/owasys-back/config/backend.resources.json
sites/owasys-back/config/backend.rest.json
sites/owasys-front/config/rest.resources.json
```

Le script valide réellement `RestResourceCatalog` avant toute écriture, résout la route Stage all collectionnelle et vérifie que le stage individuel reste disponible.

## Validation owner obligatoire

```text
cd /d H:\OPUS
git rev-parse HEAD
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r45b5a_rest_operation_identifier_fix.zip" SHA256
certutil -hashfile "%USERPROFILE%\Downloads\smoke_opus_p117w_r45b5a_rest_operation_identifier_fix_owner.php" SHA256
if exist "%TEMP%\opus_r45b5a" rmdir /S /Q "%TEMP%\opus_r45b5a"
mkdir "%TEMP%\opus_r45b5a"
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b5a_rest_operation_identifier_fix.zip" -C "%TEMP%\opus_r45b5a"
php "%TEMP%\opus_r45b5a\apply_opus_p117w_r45b5a.php" "H:\OPUS"
composer validate
copy /Y "%USERPROFILE%\Downloads\smoke_opus_p117w_r45b5a_rest_operation_identifier_fix_owner.php" "H:\OPUS\smoke_opus_p117w_r45b5a_rest_operation_identifier_fix_owner.php"
php smoke_opus_p117w_r45b5a_rest_operation_identifier_fix_owner.php
del /Q "H:\OPUS\smoke_opus_p117w_r45b5a_rest_operation_identifier_fix_owner.php"
rmdir /S /Q "%TEMP%\opus_r45b5a"
```

Attendu :

```text
OPUS_P117W_R45B5A_APPLIED
FILES=4
OPUS_P117W_R45B5A_SMOKE_OK
```

Ne pas exécuter l'ancien smoke R45B5 après R45B5A : il attend explicitement `git.stage_all` et est obsolète.

Ensuite relancer d'abord `owasys-back`, puis `owasys-front`. Si OWASYS revient, tester Stage all, puis `try` sur `/fr-FR/` et une route inexistante. Commit/push OPUS uniquement après succès de tous les gates.

## Suite gouvernée après acquisition R45B5 + R45B5A

```text
R45C — wizard OWASYS structuré
R45D — administration Sécurité
```

NO LOCAL TRY FIX.
NO REST REGEX WIDENING.
NO CROSS-SITE STAGE.
NO FREE GIT PATH OR COMMAND.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO REST CATALOG DRIFT.
NO SMOKE IN OPUS ZIP.
NO FALLBACK SILENCIEUX.
NO PUSH OPUS PAR L’ASSISTANT.
