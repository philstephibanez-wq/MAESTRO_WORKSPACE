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
- permettre le lancement autonome sans préparation manuelle de secrets avec P117W R12 ;
- lire l’adresse et le port locaux depuis la configuration avec P117W R13.

## Développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Utiliser `composer opus:dev-server` pour les deux applications.

## Décision P117W R13

Lire l’adresse et le port locaux depuis les variables désignées par :

```text
development_server.network.local.host_env
development_server.network.local.port_env
```

Résoudre leurs valeurs dans :

```text
environments.sections.dev.variables
```

Frontend :

```text
OPUS_DEV_SERVER_HOST = 127.0.0.1
OPUS_DEV_SERVER_PORT = 8000
```

Backend :

```text
OPUS_DEV_SERVER_HOST = 127.0.0.1
OPUS_DEV_SERVER_PORT = 8080
```

Rendre `--host` et `--port` facultatifs. Conserver leur usage comme surcharge explicite validée.

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

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime et aucune racine partagée.

## Valider

```text
php -l Opus/Console/OpusConsoleApplication.php
php -l Opus/Console/Service/SiteCommandService.php
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

## Tester

```text
http://127.0.0.1:8000/fr-FR/
http://127.0.0.1:8000/fr-FR/applications
http://127.0.0.1:8080/api/v1/status
```

## Statut

```text
P117W R6 à R10 : appliqués
P117W R11 : appliqué
P117W R12 : appliqué
P117W R13 : actif à appliquer
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
