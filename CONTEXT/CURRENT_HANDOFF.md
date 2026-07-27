# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R9_DEV_NETWORK_BINDINGS_AND_FRONT_I18N_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R9_DEV_NETWORK_I18N_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R8 appliqués
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

Ne partager aucun fichier entre les deux applications. Ne livrer aucun `tools`, aucun `scripts/owasys` et aucune racine `owasys-shared`.

## Constater

Les deux serveurs de développement démarrent après R8.

Le frontend échoue dans :

```text
sites/owasys-front/application/default/services/LocaleRegistry.php:152
```

Cause : `i18n.language_defaults` manque dans `sites/owasys-front/config/site.json`.

La configuration de développement ne déclare pas non plus de binding réseau complet pour relier les arguments locaux `--host` et `--port` aux coordonnées du processus et valider les coordonnées de l’application distante dans chacun des deux environnements locaux.

## Corriger

Modifier génériquement :

```text
Opus/Console/Service/SiteCommandService.php
```

Lire :

```text
OPUS_DEVELOPMENT_NETWORK_BINDING_V1
```

Injecter depuis les arguments :

```text
OPUS_DEV_SERVER_HOST
OPUS_DEV_SERVER_PORT
OPUS_DEV_SERVER_URL
```

Valider le host, le port, l’URL et l’identifiant du peer avant démarrer le serveur.

Modifier :

```text
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

Restaurer la politique I18n complète et déclarer les bindings réseau local/peer propres à chaque application.

## Environnements locaux

Conserver deux fichiers indépendants et non livrés :

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

Ne stocker aucun secret dans Git ou le ZIP.

## Statut

```text
P117W R6 : appliqué ; chargement croisé supprimé
P117W R7 : appliqué ; validation des sites propres corrigée
P117W R8 : appliqué ; contrat d’environnement corrigé
P117W R9 : livrable actif
```

## Livrable actif

```text
ZIP : opus_p117w_r9_dev_network_bindings_and_front_i18n.zip
SHA-256 : 3698a7e7f94ab50b95af24c5f93daec3e24ead081113196162ba59923ccb7455
Fichiers : 3
Octets : 12262
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial et R3 à R8 appliqués
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

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

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables. Réserver `opus:dev-server` au développement.

## Tester

```text
http://<adresse-back>:<port-back>/api/v1/status
http://<adresse-front>:<port-front>/fr-FR/
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
