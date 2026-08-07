# HANDOFF — OPUS P117W R45B5A REST operation identifier fix

Date : 2026-08-07

## Incident

Après application locale de R45B5, OWASYS-front ne démarre plus et affiche :

```text
OPUS_REST_API_RESOURCE_DEFINITION_INVALID
```

La régression est dans le contrat REST ajouté par R45B5, pas dans le site `try`.

## Cause

Identifiant ajouté par R45B5 :

```text
git.stage_all
```

Identifiant conforme au contrat `RestResourceCatalog` :

```text
git.stage-all
```

Le caractère `_` n'est pas autorisé par la grammaire des identifiants d'opérations REST.

## Livrable actif

```text
ZIP     : opus_p117w_r45b5a_rest_operation_identifier_fix.zip
SHA-256 : 9612f091296cbbcd9f5295f0d77113f40222924531c6787c1d4eda68e6920dfd
SCRIPT  : apply_opus_p117w_r45b5a.php
SHA-256 : 36b7e8715b0c72934007e1bf3cdf3d2f303eef904bb075c9c63f0f425881b71c
OUTPUT  : OPUS_P117W_R45B5A_APPLIED
FILES   : 4
```

Smoke séparé :

```text
FILE    : smoke_opus_p117w_r45b5a_rest_operation_identifier_fix_owner.php
SHA-256 : 059755a7267b7379aceccc4bd3987e397a827fd9c7a3f7a1c87925ea757e0a19
OUTPUT  : OPUS_P117W_R45B5A_SMOKE_OK
```

## État local attendu avant application

- HEAD Git reste `2376a4de07e4f504aeac1be1d8a183d43c34df80` ;
- R45B5 est présent localement et non committé ;
- les quatre catalogues contiennent exactement une occurrence contractuelle de `git.stage_all` à réparer.

Le script refuse une autre base ou un état déjà réparé/ambigu.

## Validation owner

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

Ensuite relancer `owasys-back`, puis `owasys-front`. OWASYS doit revenir avant de retester `try` et Stage all.

Ne pas exécuter l'ancien smoke R45B5 après cette réparation : il contient lui-même une assertion sur `git.stage_all` et est donc obsolète.

## Après validation réelle

Si OWASYS redémarre et Stage all fonctionne : valider ensuite le runtime `try` sur `/fr-FR/` puis une route absente. Seulement après ces gates, commit/push owner du lot R45B5 + R45B5A.

NO LOCAL TRY FIX.
NO REST REGEX WIDENING.
NO BACKEND JAVASCRIPT.
NO CATALOG DRIFT.
NO PUSH OPUS PAR L'ASSISTANT.
