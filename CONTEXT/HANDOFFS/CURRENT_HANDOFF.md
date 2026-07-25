# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-25

## Lecture obligatoire

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117V_HF10A_DIRECT_DIFFERENTIAL_DELIVERY_SPEC_2026-07-25.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117V_HF10A_DIRECT_DIFFERENTIAL_2026-07-25.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source de vérité

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
head            : 41f77ad7187c0facb125a5737b62d10928809e66
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE master
owner local     : H:\OPUS
```

## Décision architecture validée

```text
frontend  = application/shared + application/front
backend   = application/shared + application/back
fullstack = application/shared + application/front + application/back
```

`application/full` est interdit.

## Mode de livraison contractuel

Le livrable est un ZIP différentiel superposable directement à `H:\OPUS`.

Il contient uniquement les fichiers nouveaux ou remplacés, complets, à leurs chemins finaux. Sont interdits dans le ZIP actif : installateur externe, répertoire `payload`, répertoire `patch`, staging, rapport, log et copie complète du dépôt.

## Différentiel actif

```text
ZIP     : opus_p117v_hf10a_shared_front_back_direct_differential.zip
SHA-256 : a775f25bd71588d77079f3bc7c430f71ea0ad1a511abc50a720c3c0e7ee165ca
BASE    : 41f77ad7187c0facb125a5737b62d10928809e66
FILES   : 12
```

Le ZIP `opus_p117u_hf10_application_surfaces_runtime_modes.zip` est retiré comme livrable actif : son packaging par installateur/payload n'est pas conforme au workflow owner.

## Périmètre HF10A

- scaffold versionné `shared/front/back` ;
- profils par composition ;
- runtime généré cloisonné ;
- I18n structurée par couches ;
- commandes de création/validation versionnées ;
- `--mode=front|back` obligatoire au service local ;
- ports configurables ;
- refus croisé des routes ;
- Logger et Profiler OWASYS avec `trace_id` ;
- aucune migration physique destructive de l'arbre OWASYS historique dans ce différentiel.

## Classes framework

Les nouvelles classes concrètes suivantes implémentent directement leur interface homonyme :

```text
LayeredGeneratedSiteRuntime
LayeredSiteCommandService
LayeredApplicationTranslationRuntime
LayeredSiteScaffoldPlan
```

Chaque interface homonyme étend :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

## Installation owner

```text
tar -xf <ZIP> -C H:\OPUS
```

Après extraction, exécuter depuis `H:\OPUS` : Composer autoload, lint des 12 fichiers PHP et audit contractuel.

## Lancement local

```text
composer opus:serve-site -- owasys --mode=back --host=127.0.0.1 --port=8792
composer opus:serve-site -- owasys --mode=front --host=127.0.0.1 --port=8000
```

Le rôle dépend de `--mode`, pas du port.

## HTTP 500

État avant HF10A :

```text
/fr-FR/applications/new : OK
/fr-FR/applications     : HTTP 500
log runtime exploitable : absent
```

Après HF10A, reproduire la route et récupérer la ligne `request.failed` et son `trace_id` dans les diagnostics OWASYS.

## Contrats permanents

- Singleton ;
- FSM + I18n + ACL deny-by-default + SSO/Auth0-proxy + bastion ;
- SCORE uniquement pour l'interface ;
- aucun echo UI ni mélange HTML/PHP ;
- locale initiale depuis le navigateur ;
- configuration via `File` puis `Json`, `Xml` ou `Yaml` ;
- toute mutation OWASYS via REST sécurisé puis Composer ;
- Logger et Profiler obligatoires ;
- aucun fallback silencieux ;
- aucun secret dans Git, argv, logs, profiler ou ZIP.

## Nettoyage

Aucun nettoyage requis. Préserver :

```text
sites/owasys_old
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
