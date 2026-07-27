# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R13

Date : 2026-07-27  
État : livrable actif à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git de base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R12 appliqués
```

## Architecture

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier. Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime et aucune racine partagée.

## Décision active

Lire l’adresse et le port du serveur de développement dans le `config/site.json` de l’application ciblée.

Utiliser :

```text
development_server.network.local.host_env
development_server.network.local.port_env
environments.sections.dev.variables
```

Rendre `--host` et `--port` facultatifs. Les conserver comme surcharges explicites.

## Configuration développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

## Livrable actif

```text
ZIP : opus_p117w_r13_dev_server_binding_from_site_config.zip
SHA-256 : a0ae3b511f68b80504fd5f7a31aa57da973bddbe7a58cfe9c5a51d6158c21983
Fichiers : 4
```

Inclure uniquement :

```text
Opus/Console/OpusConsoleApplication.php
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

## Appliquer

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r13_dev_server_binding_from_site_config.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r13_dev_server_binding_from_site_config.zip" -C H:\OPUS
php -l Opus\Console\OpusConsoleApplication.php
php -l Opus\Console\Service\SiteCommandService.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer depuis la configuration

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

Les options `--host` et `--port` restent disponibles uniquement pour une surcharge explicite.

## Tester

```text
http://127.0.0.1:8000/fr-FR/
http://127.0.0.1:8000/fr-FR/applications
http://127.0.0.1:8080/api/v1/status
```

## Validation effectuée

```text
PHP lint                               : OK
JSON                                   : OK
Binding frontend depuis config         : OK
Binding backend depuis config          : OK
Surcharge explicite                    : OK
Parsing Composer sans options          : OK
Chemins interdits                      : 0
ZIP                                    : OK
```

Validation runtime Windows owner : requise.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
