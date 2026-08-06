# OPUS P117W R46 — DEV SERVER `--site=` — ABANDONNÉ

Date de décision owner : 2026-08-06

## Statut définitif

```text
STATUS : ABANDONNÉ
APPLY  : INTERDIT
ZIP    : opus_p117w_r46_dev_server_site_option.zip — NE PAS APPLIQUER
SMOKE  : smoke_opus_p117w_r46_dev_server_site_option_owner.php — NE PAS EXÉCUTER
```

R46 n'a pas été appliqué, validé, committé ni poussé dans OPUS.

La base owner reste :

```text
OPUS master : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
Commit      : opus_p117w_e2a_source_rest_composer
```

## Contrat conservé

L'identifiant de l'application reste positionnel après le séparateur Composer :

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

Exemples :

```text
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8080
```

Le dépôt racine OPUS ne déclare pas de script Composer `dev-server` sans préfixe `opus:`.

## Suite

Le développement reprend directement sur E2B, éditeur Sources `owasys-front`, puis E3 Git contrôlé.

NO R46 APPLY.
NO `--site=` CONTRACT.
NO LOCAL SITE FIX.
NO PUSH OPUS PAR L'ASSISTANT.
