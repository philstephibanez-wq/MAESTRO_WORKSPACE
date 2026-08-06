# OPUS P117W R46 — DEV SERVER `--site=`

Date : 2026-08-06

## Base exacte

```text
OPUS master : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
Commit      : opus_p117w_e2a_source_rest_composer
```

E2A est acquis et publié à cette base.

## Cause traitée

`OpusConsoleApplication::devServer()` lisait encore l'application dans le premier argument positionnel. Avec Composer, le séparateur `--` doit être un argument autonome, ce qui rendait la commande sensible à un espace :

```text
composer opus:dev-server -- test7 --port=8800
```

La forme `--test7` était interprétée comme une option et aucun identifiant n'atteignait la commande OPUS.

## Nouveau contrat

La commande de développement utilise désormais exclusivement une option nommée avec signe égal :

```text
composer opus:dev-server -- --site=<site> [--host=<local-address>] [--port=<local-port>]
```

Exemple :

```text
composer opus:dev-server -- --site=test7 --port=8800
```

Le premier `--` reste le séparateur contractuel Composer. `--site=test7` est l'option OPUS.

## Règles

- `--site=<site>` est obligatoire ;
- la forme positionnelle est interdite ;
- la forme séparée `--site test7` est interdite afin d'éliminer toute ambiguïté d'espacement ;
- `--host=` et `--port=` restent optionnels ;
- aucune modification n'est appliquée à `test7` ni à un autre site ;
- la correction porte uniquement sur le parseur générique OPUS et son aide publique.

## Erreurs contractuelles

```text
OPUS_DEV_SERVER_SITE_REQUIRED
OPUS_DEV_SERVER_POSITIONAL_ARGUMENT_FORBIDDEN
OPUS_DEV_SERVER_PORT_INVALID
```

## Livrable

```text
ZIP     : opus_p117w_r46_dev_server_site_option.zip
SHA-256 : 4112fef6bff85d9dc8d064439eda7397793d06917ac5c9390949bdc8b1140f33
FILES   : 1
BASE    : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
```

Fichier :

```text
Opus/Console/OpusConsoleApplication.php
```

Le smoke owner est livré séparément :

```text
smoke_opus_p117w_r46_dev_server_site_option_owner.php
SHA-256 : 67546d1edb31c68f5490c3b5f25edaa3d6542ed5ed41f72574e6dc8cf3138823
```

## Validation réalisée

- blob source reconstruit identique au blob Git owner `73a8fe5d76f38fd606f7f62338ea05dafe260002` avant modifications ;
- diff limité au parseur `devServer()` et à la ligne d'aide ;
- lint PHP réussi ;
- archive contenant exactement un fichier complet à son chemin final ;
- smoke fonctionnel réussi pour `--site=test7 --port=8800` ;
- refus fonctionnel des formes positionnelles et `--site test7`.

NO LOCAL SITE FIX.
NO SILENT FALLBACK.
NO POSITIONAL DEV-SERVER SITE.
NO PUSH OPUS PAR L'ASSISTANT.
