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
- restaurer I18n et les bindings réseau avec P117W R9 ;
- conserver `dev`, `test` et `prod` dans chaque `config/site.json` avec P117W R10 ;
- supprimer l’accès local au Registry frontend avec P117W R11 ;
- valider les deux sites OPUS côté owner.

## Développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Utiliser `composer opus:dev-server` pour les deux applications.

## Cause P117W R12

Le profil `dev` référence encore :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

comme sources externes obligatoires.

Cette conception impose une préparation manuelle dans chaque terminal et empêche les deux commandes Composer autonomes demandées.

## Correction P117W R12

Modifier génériquement :

```text
Opus/Console/Service/SiteCommandService.php
```

Ajouter :

```text
OPUS_DEVELOPMENT_DERIVED_SECRET_V1
```

Dériver en mémoire les identifiants de développement depuis :

```text
machine
racine OPUS
canal de développement
nom de variable cible
```

Exiger :

```text
section dev
variable secrète
écoute loopback
```

Conserver `test` et `prod` sur variables d’environnement externes. Conserver l’interdiction de tout secret littéral.

Corriger les peers :

```text
front -> back : 127.0.0.1:8080
back -> front : 127.0.0.1:8000
```

## Livrable actif

```text
ZIP : opus_p117w_r12_dev_credentials_in_environment_sections.zip
SHA-256 : 11f06689cabbddd71dace4445e31b31996c7703d709fa092f2a1bdbbc2d7a936
Fichiers : 3
Octets : 14370
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun secret, aucun fichier sous `var`, aucune migration, aucun smoke, aucun audit et aucun rapport.

## Valider

```text
php -l Opus/Console/Service/SiteCommandService.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer sans variables manuelles

Frontend :

```text
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8000
```

Backend :

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8080
```

## Statut

```text
P117W R6 à R10 : appliqués
P117W R11 : appliqué
P117W R12 : actif à appliquer
```

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
