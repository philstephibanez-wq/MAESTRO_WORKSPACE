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
- conserver les adresses et ports d’écoute comme arguments variables ;
- interdire les secrets littéraux dans la configuration.

## Développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Utiliser `composer opus:dev-server` pour les deux applications.

## Erreur après P117W R10

```text
OWASYS_FRONT_RUNTIME_FAILED
sites/owasys-front/application/default/controllers/RuntimeController.php:738
```

Route :

```text
http://127.0.0.1:8000/fr-FR/applications
```

## Cause P117W R11

`OwasysRegistryModel` frontend est REST-only et son constructeur accepte seulement `$siteRoot`.

`RuntimeController::registryModel()` conserve l’ancien accès local :

```text
$opusRoot
OwasysApplicationSingletonInspector
```

Ce branchement viole la frontière REST du frontend.

## Correction P117W R11

```php
$this->registryModel = new OwasysRegistryModel($this->siteRoot);
```

Supprimer toute inspection locale du Registry dans le frontend.

## Livrable actif

```text
ZIP : opus_p117w_r11_front_registry_rest_boundary_fix.zip
SHA-256 : 1ee0e1738b684f6b674a1c64555cbb22ab85745bc8470fa0352fd1baab272aa9
Fichiers : 1
Octets non compressés : 30866
```

Inclure uniquement :

```text
sites/owasys-front/application/default/controllers/RuntimeController.php
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun secret, aucun fichier runtime et aucune racine partagée.

## Valider

```text
php -l sites/owasys-front/application/default/controllers/RuntimeController.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer

Frontend :

```text
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8000
```

Backend :

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8080
```

Définir auparavant les mêmes valeurs secrètes dans les deux processus :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

## Statut

```text
P117W R6 à R10 : appliqués
P117W R11 : actif à appliquer
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
