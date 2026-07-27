# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R9

Date : 2026-07-27  
État : livrable actif à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
Base locale : P117W initial et R3 à R8 appliqués
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

Ne partager aucun fichier entre les deux applications.

## Constater

Les serveurs démarrent, mais le frontend échoue dans :

```text
sites/owasys-front/application/default/services/LocaleRegistry.php:152
```

Cause : `sites/owasys-front/config/site.json` ne contient plus `i18n.language_defaults` pour toutes les langues configurées.

La configuration de développement ne relie pas non plus explicitement les arguments locaux `--host` et `--port` aux variables du processus, et ne valide pas les coordonnées de l’application distante dans chacun des deux environnements locaux.

## Corriger

Modifier génériquement :

```text
Opus/Console/Service/SiteCommandService.php
```

Faire lire le contrat :

```text
OPUS_DEVELOPMENT_NETWORK_BINDING_V1
```

Injecter depuis les arguments de `opus:dev-server` :

```text
OPUS_DEV_SERVER_HOST
OPUS_DEV_SERVER_PORT
OPUS_DEV_SERVER_URL
```

Valider les coordonnées du peer déclarées dans l’environnement runtime local :

```text
host
port
url ou endpoint
application_id
```

Refuser toute incohérence entre host, port et URL.

Modifier :

```text
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

Restaurer la politique I18n complète et déclarer le binding réseau local/peer propre à chaque application.

## Livrable actif

```text
ZIP : opus_p117w_r9_dev_network_bindings_and_front_i18n.zip
SHA-256 : 3698a7e7f94ab50b95af24c5f93daec3e24ead081113196162ba59923ccb7455
Fichiers : 3
Octets : 12262
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucune migration, aucun smoke, aucun audit, aucun rapport, aucun secret et aucune racine partagée.

## Configurer les environnements locaux

Conserver deux fichiers indépendants :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

Frontend :

```text
OPUS_OWASYS_BACKEND_HOST
OPUS_OWASYS_BACKEND_PORT
OPUS_OWASYS_BACKEND_ENDPOINT
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

Backend :

```text
OPUS_OWASYS_FRONTEND_HOST
OPUS_OWASYS_FRONTEND_PORT
OPUS_OWASYS_FRONTEND_ENDPOINT
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

Ne placer aucun secret dans Git ou le ZIP.

## Valider

```text
composer dump-autoload -o
php -l Opus\Console\Service\SiteCommandService.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer en développement

```text
composer opus:dev-server -- owasys-back --host=<adresse-back> --port=<port-back>
composer opus:dev-server -- owasys-front --host=<adresse-front> --port=<port-front>
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables.

## Tester

```text
http://<adresse-back>:<port-back>/api/v1/status
http://<adresse-front>:<port-front>/fr-FR/
```

## Statut

```text
P117W R6 : appliqué ; chargement croisé supprimé
P117W R7 : appliqué ; validation des sites propres corrigée
P117W R8 : appliqué ; contrat d’environnement corrigé
P117W R9 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
