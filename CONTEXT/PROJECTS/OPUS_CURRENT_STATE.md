# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-26.

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

## Cause racine

`OpusConsoleApplication::fromRoot()` construit actuellement `ApplicationCommandDispatcher` pour toutes les commandes.

`ApplicationCommandDispatcher` exécute immédiatement tous les bootstraps de tous les sites.

Une commande framework charge donc simultanément l’ancien `sites/owasys` et `sites/owasys-back`, puis provoque la redéclaration de `OwasysApplicationSingletonInspector`.

## Correction P117W R6

- Ne pas construire le dispatcher pour une commande framework.
- Lire seulement les métadonnées des registres applicatifs.
- Charger uniquement le bootstrap de l’unique provider qui déclare la commande applicative demandée.
- Refuser une commande inconnue ou ambiguë avant charger un bootstrap.

## Statut

```text
P117W R3 : appliqué
P117W R4 : appliqué
P117W R5 : appliqué, effet corrigé mais cause restante
P117W R6 : actif à appliquer
```

## Livrable actif

```text
ZIP : opus_p117w_r6_lazy_application_provider_bootstrap_root_cause.zip
SHA-256 : b9e6fade25160bd5e6fe3fbb3810267b4544cac67b4deff7c6d0a8a1d75c3896
Fichiers : 2
Octets : 5558
```

Inclure uniquement :

```text
Opus/Console/OpusConsoleApplication.php
Opus/Console/Application/ApplicationCommandDispatcher.php
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucune migration, aucun smoke, aucun audit, aucun rapport et aucune racine partagée.

## Valider

```text
composer dump-autoload -o
php -l Opus/Console/OpusConsoleApplication.php
php -l Opus/Console/Application/ApplicationCommandDispatcher.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
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
