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

Conserver uniquement deux applications OPUS autonomes actives :

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

## Cause P117W R14

La requête frontend atteint correctement :

```text
owasys-back -> POST /api/v1/executions
```

Le backend lance ensuite :

```text
owasys:registry-sync
```

Deux registres déclarent cette commande canonique :

```text
sites/owasys/config/composer.commands.json
sites/owasys-back/config/composer.commands.json
```

`ApplicationCommandDispatcher` découvre deux providers et rejette la commande comme ambiguë avant exécuter le provider backend. Le code d’erreur dynamique contient le nom de commande en minuscules et est réduit à `OPUS_CONSOLE_COMMAND_FAILED` par le filtre de sortie.

## Correction P117W R14

Déclarer dans :

```text
sites/owasys-back/config/backend.rest.json
```

la valeur :

```text
application_id = owasys-back
```

Propager cette valeur dans :

```text
OPUS_RCP_COMPOSER_COMMAND_REQUEST_V1.application_id
```

Filtrer les providers par :

```text
command + application_id
```

Exiger la cible pour toute requête RCP Composer V1. Ne charger aucun provider du site historique lorsque la requête cible `owasys-back`.

## Livrable actif

```text
ZIP : opus_p117w_r14_scope_rcp_application_command_provider.zip
SHA-256 : 8e94705f4a8992a3188ff0c469436e3c458b888713709da877ec79c1e7d8f494
Fichiers : 3
Octets ZIP : 7614
```

Inclure uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
Opus/Rcp/Rest/RcpRestServer.php
sites/owasys-back/config/backend.rest.json
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime, aucun secret et aucune racine partagée.

## Valider

```text
php -l Opus/Console/Application/ApplicationCommandDispatcher.php
php -l Opus/Rcp/Rest/RcpRestServer.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer

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
curl -i http://127.0.0.1:8080/api/v1/status
curl -i http://127.0.0.1:8000/fr-FR/
curl -i http://127.0.0.1:8000/fr-FR/applications
```

## Statut

```text
P117W R6 à R10 : appliqués
P117W R11 : appliqué
P117W R12 : appliqué
P117W R13 : appliqué
P117W R14 : actif à appliquer
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
