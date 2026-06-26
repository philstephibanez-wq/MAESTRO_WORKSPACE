# HANDOFF — OPUS P7A1D4 Web Profiler + configured runtime FSM validated

## Date

2026-06-26

## Projet concerné

```text
OPUS local root : H:\OPUS
OPUS repo       : philstephibanez-wq/OPUS
Workspace repo  : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État validé

P7A1D4 a été exécuté, validé, committé et poussé sur OPUS.

Statut final observé :

```text
## master...origin/master
```

Le rapport JSON OPUS est présent sur `master` :

```text
DOC/reference/generated/json/p7a1d4_web_profiler_exception_pipeline.json
```

## Résultat runner P7A1D4

```text
P7A1D4_BIG_WEB_PROFILER_EXCEPTION_PIPELINE_CONFIGURED_FSM_PHP_FILES=188
P7A1D4_BIG_WEB_PROFILER_EXCEPTION_PIPELINE_CONFIGURED_FSM_PHP_LINT_ERRORS=0
P7A1D4_BIG_WEB_PROFILER_EXCEPTION_PIPELINE_CONFIGURED_FSM_COLLECTORS_REGISTERED=9
P7A1D4_BIG_WEB_PROFILER_EXCEPTION_PIPELINE_CONFIGURED_FSM_WEB_PROFILER_ROUTE_AVAILABLE=1
P7A1D4_BIG_WEB_PROFILER_EXCEPTION_PIPELINE_CONFIGURED_FSM_WEB_PROFILER_TEMPLATE_SCORE_AVAILABLE=1
P7A1D4_BIG_WEB_PROFILER_EXCEPTION_PIPELINE_CONFIGURED_FSM_CONFIGURED_FSM_MAPS=4
P7A1D4_BIG_WEB_PROFILER_EXCEPTION_PIPELINE_CONFIGURED_FSM_NO_HARDCODED_RUNTIME_FSM=1
P7A1D4_BIG_WEB_PROFILER_EXCEPTION_PIPELINE_CONFIGURED_FSM_NO_HTML_BUILT_IN_COLLECTORS=1
P7A1D4_BIG_WEB_PROFILER_EXCEPTION_PIPELINE_CONFIGURED_FSM_OK=1
P7A1D4_BIG_WEB_PROFILER_EXCEPTION_PIPELINE_CONFIGURED_FSM_EXIT_CODE=0
```

## Ce que P7A1D4 valide

```text
- Web Profiler OPUS façon Symfony ;
- routes profiler : /_opus/profiler and /_opus/profiler/trace/{trace_id} ;
- page profiler générée par OPUS via template .score ;
- 9 collectors enregistrés ;
- collectors sans HTML ;
- pipeline runtime diagnostics / exceptions / profiler ;
- FSM runtime configurée depuis config/fsm_runtime ;
- 4 maps FSM runtime configurées ;
- aucune transition runtime FSM hardcodée ;
- PHP lint global OK.
```

## Collectors validés

```text
request
routing
exception
template
database
config
mail
memory
runtime
```

## Routes validées

```text
/_opus/profiler
/_opus/profiler/trace/{trace_id}
```

## FSM runtime

Décision active : les transitions runtime OPUS sont des données de configuration, pas du PHP hardcodé.

Emplacement cible validé :

```text
config/fsm_runtime
```

ADR associée :

```text
CONTEXT/ADRS/ADR_20260626_OPUS_RUNTIME_FSM_CONFIGURATION_NOT_HARDCODED.md
```

## Fichiers/familles ajoutés côté OPUS

```text
config/fsm_runtime/
Opus/Fsm/Runtime/
Opus/Profiler/Collector/
Opus/Profiler/TraceFileRepository.php
Opus/Profiler/WebProfilerController.php
Opus/Profiler/WebProfilerView.php
Opus/Profiler/templates/
Opus/Runtime/Diagnostics/
DOC/reference/generated/json/p7a1d4_web_profiler_exception_pipeline.json
DOC/reference/generated/markdown/P7A1D4_WEB_PROFILER_EXCEPTION_PIPELINE.md
```

## Décision précédente toujours active

`Opus/Fsm/Fsm.php` reste supprimé et ne doit pas être restauré.

## Prochaine étape recommandée

P7A1E doit vérifier le rendu réel navigateur/HTTP du profiler, pas seulement la présence statique des classes et templates.

Objectif proposé :

```text
P7A1E_WEB_PROFILER_HTTP_SMOKE_AND_UI_POLISH
```

À valider :

```text
- ouverture HTTP /_opus/profiler ;
- ouverture HTTP /_opus/profiler/trace/{trace_id} ;
- création réelle d'une trace runtime ;
- affichage menu collector ;
- affichage timeline ;
- affichage exception normalisée ;
- rendu visuel propre et officiel ;
- aucune page brute ou HTML bricolé hors .score.
```
