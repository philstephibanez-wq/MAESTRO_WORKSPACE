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
- restaurer la politique I18n complète et les bindings réseau avec P117W R9 ;
- démarrer les deux serveurs de développement ;
- conserver le backend sans interface utilisateur ;
- exposer son statut sur `/api/v1/status`.

## Décision P117W R10

Remplacer le modèle fragmenté :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

par une section `environments` dans le fichier existant :

```text
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

Déclarer dans chaque application :

```text
dev
test
prod
```

Utiliser :

```text
OPUS_APPLICATION_ENVIRONMENTS_V1
```

Sélectionner par `OPUS_ENV`. Faire sélectionner `dev` par `opus:dev-server`.

Conserver l’adresse et le port d’écoute locaux comme arguments variables. Déclarer dans chaque section les coordonnées de l’application distante.

Référencer les secrets par variables d’environnement. Interdire tout secret littéral.

Faire échouer le lancement avant ouvrir le serveur lorsqu’une variable secrète requise manque.

## Statut

```text
P117W R6 : appliqué
P117W R7 : appliqué
P117W R8 : appliqué
P117W R9 : appliqué puis remplacé pour configuration fragmentée
P117W R10 : actif à appliquer
```

## P117W R10

```text
ZIP : opus_p117w_r10_single_environment_config_sections.zip
SHA-256 : 590f204c6ea2cb36816499443e735174b51d557813731b54efbe8e93878e3c59
Fichiers : 3
Octets : 12938
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial et R3 à R9 appliqués
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier sous `var`, aucune migration, aucun smoke, aucun audit, aucun rapport, aucun secret et aucune racine partagée.

## Valider

```text
composer dump-autoload -o
php -l Opus/Console/Service/SiteCommandService.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Nettoyer

Après appliquer R10, supprimer uniquement :

```text
sites/owasys-front/var/development
sites/owasys-back/var/development
```

## Lancer

Définir les mêmes variables secrètes dans les deux terminaux :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

Puis lancer :

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
