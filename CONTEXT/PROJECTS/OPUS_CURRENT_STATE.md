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
- démarrer les serveurs de développement avant P117W R7 ;
- ne plus exiger `var/logs` et `var/profiler` pendant la validation avec P117W R7 ;
- conserver le backend sans interface utilisateur et exposer son statut sur `/api/v1/status`.

## Cause actuelle

Après P117W R7, les deux commandes `opus:dev-server` échouent avec :

```text
OPUS_DEV_SERVER_ENVIRONMENT_BINDING_INVALID
```

Aligner les deux `config/site.json` sur :

```text
OPUS_DEVELOPMENT_ENVIRONMENT_BINDING_V1
```

Utiliser deux fichiers runtime indépendants :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

Ne stocker aucun secret dans Git ou dans le ZIP.

## Statut

```text
P117W R6 : appliqué
P117W R7 : appliqué
P117W R8 : actif à appliquer
```

## P117W R8

```text
ZIP : opus_p117w_r8_align_dev_environment_contracts.zip
SHA-256 : 6f2d4f33db9b8e23a134b8e2d1170d26b8009b60c625c02e8d2fee4b94ff82fb
Fichiers : 2
Octets : 1959
```

Inclure uniquement :

```text
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucune migration, aucun smoke, aucun audit, aucun rapport et aucune racine partagée.

## Valider

```text
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
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
