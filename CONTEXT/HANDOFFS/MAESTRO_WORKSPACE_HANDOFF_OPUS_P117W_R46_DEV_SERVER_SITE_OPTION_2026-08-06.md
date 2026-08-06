# HANDOFF — OPUS P117W R46 DEV SERVER `--site=`

Date : 2026-08-06

## État owner

```text
OPUS master : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
E2A         : acquis et publié
```

## Livrable actif

```text
ZIP     : opus_p117w_r46_dev_server_site_option.zip
SHA-256 : 4112fef6bff85d9dc8d064439eda7397793d06917ac5c9390949bdc8b1140f33
FILES   : 1
BASE    : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
STATUS  : livré, application, validation et push owner requis
```

Fichier ciblé :

```text
Opus/Console/OpusConsoleApplication.php
```

Aucun fichier de site, aucun fichier OWASYS et aucun fichier généré n'est ciblé.

## Nouveau lancement contractuel

```text
composer opus:dev-server -- --site=test7 --port=8800
```

Le séparateur Composer `--` reste obligatoire. L'identifiant du site est ensuite transmis par `--site=<site>`.

Les formes suivantes sont volontairement invalides :

```text
composer opus:dev-server -- test7 --port=8800
composer opus:dev-server -- --site test7 --port=8800
composer opus:dev-server --test7 --port=8800
```

## Smoke owner séparé

```text
FILE    : smoke_opus_p117w_r46_dev_server_site_option_owner.php
SHA-256 : 67546d1edb31c68f5490c3b5f25edaa3d6542ed5ed41f72574e6dc8cf3138823
OUTPUT  : OPUS_P117W_R46_DEV_SERVER_SITE_OPTION_OK
```

## Après acquisition

Reprendre E2B : éditeur Sources `owasys-front`, ViewModel, SCORE, preview distincte de write, conflit explicite et conservation de la locale et du fichier dans l'URL.

NO LOCAL SITE FIX.
NO SILENT FALLBACK.
NO POSITIONAL DEV-SERVER SITE.
NO PUSH OPUS PAR L'ASSISTANT.
