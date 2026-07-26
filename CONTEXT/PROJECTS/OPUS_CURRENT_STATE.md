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

Déployer indépendamment les deux applications sur deux bastions possibles.

Ne partager aucun fichier, dossier, volume, configuration, secret, catalogue, manifeste, état runtime ou artefact.

Réaliser uniquement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Front

Maintenir `OwasysFrontApplication` et `OwasysFrontApplicationInterface`.

Appliquer Singleton, FSM, I18n navigateur, ACL deny-by-default, SSO/Auth0-proxy/bastion, SCORE, client REST, Logger et Profiler.

Interdire toute mutation métier et toute exécution Composer applicative locale.

Déclarer un registre Composer frontend vide :

```text
sites/owasys-front/config/composer.commands.json
site_id = owasys-front
providers = []
aliases = []
```

## Back

Maintenir `OwasysBackApplication` et `OwasysBackApplicationInterface`.

Appliquer Singleton, FSM métier et REST, I18n API, ACL deny-by-default, SSO/identité de service/bastion, API REST sécurisée, Composer allow-listé, Logger et Profiler.

Interdire tout rendu UI.

Conserver le registre de commandes métier dans :

```text
sites/owasys-back/config/composer.commands.json
```

## Échec après P117W R4

Les registres Composer passent désormais le contrôle `site_id`, puis le runtime échoue avec :

```text
Call to a member function exists() on string
Opus/Console/Application/ApplicationCommandDispatcher.php:60
```

Le composant `ApplicationCommandDispatcher` utilise un handle local non typé pour le service `File`. P117W R5 remplace ce handle et celui du loader structuré par des propriétés typées :

```text
FileInterface $fileService
StructuredFileLoaderInterface $structuredFileLoader
```

Utiliser ces propriétés pour rechercher, lire et valider les registres Composer applicatifs.

## Statut des livrables

```text
HF10A : rejeté
HF10B : rejeté
P117W initial : installé, architecture rejetée
P117W R1 : rejeté pour présence de tools
P117W R2 : rejeté pour présence de scripts opérationnels
P117W R3 : appliqué
P117W R4 : appliqué, registre frontend corrigé
P117W R5 : actif à appliquer
```

## P117W R5

```text
ZIP : opus_p117w_r5_fix_application_command_dispatcher_file_service.zip
SHA-256 : d3c5783314f8b3f48eb54bbd02f2a6e5cb534e4d64fcac0525dc0e34996cbdf7
Fichiers : 2
Octets : 1907
```

Inclure uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
sites/owasys-front/config/composer.commands.json
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucune migration, aucun smoke, aucun audit, aucun rapport et aucune racine partagée.

## Valider

```text
composer dump-autoload -o
php -l Opus/Console/Application/ApplicationCommandDispatcher.php
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

Lire toute configuration via `File` et `StructuredFileLoader`, puis utiliser `Json`, `Xml` ou `Yaml` selon le format.

Imposer Logger et Profiler. Interdire tout fallback silencieux.
