# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-27.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:/OPUS
```

## Architecture

Conserver uniquement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Ne partager aucun fichier, dossier, volume, configuration, secret, manifeste ou état runtime.

Réaliser uniquement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Résultats acquis

- supprimer le chargement croisé des applications avec P117W R6 ;
- corriger la validation des sites propres avec P117W R7 ;
- aligner le contrat d’environnement avec P117W R8 ;
- démarrer les deux serveurs de développement ;
- conserver le backend sans interface utilisateur ;
- exposer son statut sur `/api/v1/status`.

## Cause actuelle

Le frontend échoue dans :

```text
sites/owasys-front/application/default/services/LocaleRegistry.php:152
```

Le `site.json` frontend déclare les locales mais ne déclare plus `i18n.language_defaults`.

La configuration de développement ne relie pas complètement :

```text
les arguments locaux --host et --port
les variables réseau du processus local
les coordonnées de l’application distante
```

## Correction P117W R9

Modifier génériquement :

```text
Opus/Console/Service/SiteCommandService.php
```

Lire :

```text
OPUS_DEVELOPMENT_NETWORK_BINDING_V1
```

Injecter depuis les arguments de lancement :

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

Restaurer la politique I18n complète et déclarer le binding réseau local/peer propre à chaque application.

Conserver deux environnements runtime indépendants :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

Ne stocker aucun secret dans Git ou dans le ZIP.

## Statut

```text
P117W R6 : appliqué
P117W R7 : appliqué
P117W R8 : appliqué
P117W R9 : livrable actif
```

## P117W R9

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

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucune migration, aucun smoke, aucun audit, aucun rapport, aucun secret et aucune racine partagée.

## Configurer les environnements locaux

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

## Valider

```text
composer dump-autoload -o
php -l Opus/Console/Service/SiteCommandService.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer

```text
composer opus:dev-server -- owasys-back --host=<adresse-back> --port=<port-back>
composer opus:dev-server -- owasys-front --host=<adresse-front> --port=<port-front>
```

Réserver `opus:dev-server` au développement. Conserver l’identifiant d’application, l’adresse et le port comme arguments variables.

## Contrats framework

Faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php`.

Faire étendre directement chaque interface homonyme par :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Lire toute configuration via `File` et `StructuredFileLoader`. Imposer Logger et Profiler. Interdire tout fallback silencieux.
