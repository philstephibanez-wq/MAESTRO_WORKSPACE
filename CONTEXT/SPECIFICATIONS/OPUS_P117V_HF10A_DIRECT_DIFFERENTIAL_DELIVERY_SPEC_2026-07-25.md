# OPUS P117V HF10A — LIVRAISON DIFFÉRENTIELLE DIRECTE

Date : 2026-07-25  
Statut : remplace le paquet d'installation HF10 précédent

## Décision de livraison

Le livrable OPUS/OWASYS contractuel est un ZIP différentiel superposable directement à la racine du dépôt owner :

```text
H:\OPUS
```

Il ne doit pas contenir :

- d'installateur externe ;
- de répertoire `payload` ;
- de répertoire `patch` ;
- de dossier temporaire d'installation ;
- de rapport ou de journal ;
- de copie complète du dépôt.

Il contient uniquement les fichiers nouveaux ou remplacés, complets, à leurs chemins finaux `Opus/...` et `sites/...`.

## Livrable actif

```text
ZIP     : opus_p117v_hf10a_shared_front_back_direct_differential.zip
SHA-256 : a775f25bd71588d77079f3bc7c430f71ea0ad1a511abc50a720c3c0e7ee165ca
BASE    : OPUS@41f77ad7187c0facb125a5737b62d10928809e66
PATHS   : 12 fichiers
```

Le ZIP précédent `opus_p117u_hf10_application_surfaces_runtime_modes.zip` est retiré comme livrable actif en raison de son mode de packaging incorrect.

## Périmètre

Le différentiel livre le standard validé :

```text
frontend  = application/shared + application/front
backend   = application/shared + application/back
fullstack = application/shared + application/front + application/back
```

`application/full` reste interdit.

Il fournit :

- scaffold versionné shared/front/back ;
- runtime généré cloisonné front/back ;
- I18n structurée par couches ;
- service Composer versionné ;
- modes `--mode=front|back` ;
- ports de développement configurables ;
- refus croisé des routes ;
- Logger et Profiler OWASYS avec `trace_id` ;
- aucune migration physique destructive de l'arbre OWASYS existant dans HF10A.

## Contrat des classes concrètes

Les nouvelles classes concrètes framework implémentent directement leur interface homonyme :

```text
LayeredGeneratedSiteRuntime
LayeredSiteCommandService
LayeredApplicationTranslationRuntime
LayeredSiteScaffoldPlan
```

Chaque interface homonyme étend les quatre marqueurs standards :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

## Installation

L'archive est extraite directement dans `H:\OPUS`. Aucun dossier temporaire n'est créé.

Après extraction :

```text
composer dump-autoload -o
php -l sur les fichiers PHP du différentiel
opus_contractualize_all --audit
```

## Nettoyage

Aucun nettoyage n'est requis après installation. L'archive ne crée aucun fichier de staging dans le dépôt.
