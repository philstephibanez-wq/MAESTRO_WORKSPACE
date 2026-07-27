# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R14

Date : 2026-07-27  
État : livrable actif à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git de base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R13 appliqués
```

## Architecture

Conserver uniquement les deux applications actives :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Cause active

Les registres suivants déclarent les mêmes commandes métier :

```text
sites/owasys/config/composer.commands.json
sites/owasys-back/config/composer.commands.json
```

La requête REST atteint le backend, mais la commande Composer n’indique pas l’application propriétaire. `ApplicationCommandDispatcher` trouve donc deux providers et rejette la commande comme ambiguë.

## Corriger

Ajouter dans `sites/owasys-back/config/backend.rest.json` :

```text
application_id = owasys-back
```

Propager cette valeur dans :

```text
OPUS_RCP_COMPOSER_COMMAND_REQUEST_V1.application_id
```

Filtrer les providers par `command + application_id` avant charger le bootstrap.

## Livrable actif

```text
ZIP : opus_p117w_r14_scope_rcp_application_command_provider.zip
SHA-256 : 8e94705f4a8992a3188ff0c469436e3c458b888713709da877ec79c1e7d8f494
Fichiers : 3
Octets ZIP : 7614
```

Inclure uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
Opus/Rcp/Rest/RcpRestServer.php
sites/owasys-back/config/backend.rest.json
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime, aucun secret et aucune racine partagée.

## Appliquer

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r14_scope_rcp_application_command_provider.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r14_scope_rcp_application_command_provider.zip" -C H:\OPUS
php -l Opus\Console\Application\ApplicationCommandDispatcher.php
php -l Opus\Rcp\Rest\RcpRestServer.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer

Frontend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-front
```

Backend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-back
```

## Tester

```text
curl -i http://127.0.0.1:8080/api/v1/status
curl -i http://127.0.0.1:8000/fr-FR/
curl -i http://127.0.0.1:8000/fr-FR/applications
```

## Valider avant livraison

```text
PHP lint                               : OK
JSON                                   : OK
Deux providers homonymes simulés       : OK
Provider owasys-back ciblé             : OK
Provider historique non chargé         : OK
Requête RCP non ciblée refusée          : OK
Chemins interdits                      : 0
ZIP                                    : OK
```

Validation runtime Windows owner : requise.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
