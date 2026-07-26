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

## Résultat P117W R6

Démarrer correctement les serveurs de développement `owasys-front` et `owasys-back` sans chargement croisé des applications.

Conserver le backend sans interface utilisateur. Refuser la racine `/` et exposer le statut sur :

```text
/api/v1/status
```

## Cause restante

Les validateurs OPUS exigent actuellement l'existence préalable de :

```text
var/logs
var/profiler
```

Ces répertoires appartiennent au runtime. Logger et Profiler les créent au démarrage. Ne pas les exiger dans le site source ni dans l'artefact de déploiement.

## Correction P117W R7

Modifier :

```text
Opus/Console/Service/SiteCommandService.php
Opus/Console/Service/LayeredSiteCommandService.php
```

Retirer `var/logs` et `var/profiler` des répertoires source obligatoires de `validate-site`.

Conserver toutes les validations de configuration, FSM, ACL, SSO, Singleton, SCORE, API, modules et routes.

## Statut

```text
P117W R3 : appliqué
P117W R4 : appliqué
P117W R5 : appliqué
P117W R6 : appliqué ; serveurs de développement démarrés
P117W R7 : actif à appliquer
```

## Livrable actif

```text
ZIP : opus_p117w_r7_validate_clean_sites_without_runtime_directories.zip
SHA-256 : e24708b8488769d5baef79372cde46d9006d200f1c166e87486501c08513b7ac
Fichiers : 2
Octets : 14728
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
Opus/Console/Service/LayeredSiteCommandService.php
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucune migration, aucun smoke, aucun audit, aucun rapport, aucun journal et aucune racine partagée.

## Valider

```text
composer dump-autoload -o
php -l Opus/Console/Service/SiteCommandService.php
php -l Opus/Console/Service/LayeredSiteCommandService.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Réserver `opus:dev-server` au développement. Conserver l'identifiant d'application, l'adresse et le port comme arguments variables.

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
