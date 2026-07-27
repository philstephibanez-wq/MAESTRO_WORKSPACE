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
- lire l’adresse et le port locaux depuis la configuration avec P117W R13 ;
- cibler le provider Composer backend dans la requête RCP avec P117W R14.

## Développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Utiliser `composer opus:dev-server` pour les deux applications.

## Cause P117W R15

Après le passage REST et Composer, le rendu frontend échoue avec :

```text
OWASYS_FRONT_RUNTIME_FAILED
```

La FSM réduite dans :

```text
sites/owasys-front/config/fsm.json
```

ne déclare plus les métadonnées SCORE/I18n de l’état `registry`.

Le renderer utilise alors sa convention :

```text
menu.<module>
```

et demande :

```text
menu.registry
```

Cette clé n’existe pas. La source canonique déclare :

```text
title_key = menu.applications
summary_key = registry.description
navigation.visible = true
navigation.order = 10
navigation.label = menu.applications
```

## Correction P117W R15

Restaurer dans :

```text
sites/owasys-front/config/fsm.json
```

la FSM complète :

```text
OWASYS_NAVIGATION_FSM_V1
```

Restaurer `diagram`, `states`, `events`, `transitions`, `guards`, `actions`, les clés I18n et les métadonnées de navigation.

Ne pas ajouter un fallback et ne pas modifier SCORE ou I18n pour masquer la configuration dégradée.

## Livrable actif

```text
ZIP : opus_p117w_r15_restore_canonical_front_fsm.zip
SHA-256 : 1a39348365bfe5dbb3a286519b93bb50ccd60a5a09d642f111cf0836224ae575
Fichiers : 1
Octets non compressés : 7206
```

Inclure uniquement :

```text
sites/owasys-front/config/fsm.json
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime, aucun secret et aucune racine partagée.

## Valider

```text
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git status --short
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
P117W R14 : appliqué
P117W R15 : actif à appliquer
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
