# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart from this file without relying on hidden conversation memory.

## Permanent rules

```text
NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
```

OPUS is an applicative web framework. HTML output must come from `.score` templates through explicit data/view-model contracts.

## Current OPUS state — P7A1D4 validated

```text
OPUS root      : H:\OPUS
OPUS GitHub    : philstephibanez-wq/OPUS
Workspace root : H:\MAESTRO_WORKSPACE
Workspace repo : philstephibanez-wq/MAESTRO_WORKSPACE
```

Read first:

```text
CONTEXT/HANDOFFS/P7A1D4_20260626_OPUS_WEB_PROFILER_CONFIGURED_FSM_VALIDATED.md
```

Related ADR:

```text
CONTEXT/ADRS/ADR_20260626_OPUS_RUNTIME_FSM_CONFIGURATION_NOT_HARDCODED.md
```

History handoffs:

```text
CONTEXT/HANDOFFS/P7A1C_20260626_OPUS_TOKENIZER_FRAMEWORK_INTERFACES_CONTRACTS.md
CONTEXT/HANDOFFS/P7A1A_20260626_OPUS_INTERFACE_REFACTOR_ABORT_AND_FSM_DEMO_REMOVAL.md
```

## OPUS status

P7A1D4 was executed, validated, committed and pushed.

Final local status observed:

```text
## master...origin/master
```

Report present on OPUS master:

```text
DOC/reference/generated/json/p7a1d4_web_profiler_exception_pipeline.json
```

## P7A1D4 validated output

```text
PHP_FILES=188
PHP_LINT_ERRORS=0
COLLECTORS_REGISTERED=9
WEB_PROFILER_ROUTE_AVAILABLE=1
WEB_PROFILER_TEMPLATE_SCORE_AVAILABLE=1
CONFIGURED_FSM_MAPS=4
NO_HARDCODED_RUNTIME_FSM=1
NO_HTML_BUILT_IN_COLLECTORS=1
OK=1
EXIT_CODE=0
```

## What P7A1D4 validates

```text
Web Profiler OPUS style target
OPUS .score profiler template
9 collectors registered
collectors contain no HTML
runtime diagnostics to exception to profiler pipeline
configured runtime FSM under config/fsm_runtime
no hardcoded runtime FSM transitions
global PHP lint OK
```

Collectors:

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

## Validated decisions still active

`Opus/Fsm/Fsm.php` was removed as a demo FSM and must not be restored.

Runtime FSM transitions must be configuration data, not PHP hardcoded sequences.

```text
config/fsm_runtime
```

## P7A1A warning

P7A1A3 through P7A1A9 are invalidated. Do not reuse them as a base.

Key causes:

```text
regex scanner noise
false OK with CLASSES=0
bad implements injection
invalid generated interface names
broad interface deletion
rejected administrative contract paths
```

## Next milestone

```text
P7A1E_WEB_PROFILER_HTTP_SMOKE_AND_UI_POLISH
```

Target:

```text
HTTP smoke of profiler index
HTTP smoke of one profiler trace
real runtime trace creation
collector menu visible
timeline visible
normalized exception visible
official professional UI polish
no raw page and no HTML outside .score
```

## Repository write policy

```text
MAESTRO_WORKSPACE : assistant may write directly to GitHub for contracts, ADRs, handoffs and project context updates.
OPUS              : no direct assistant write/commit/push; local runners only, then user validates and commits/pushes.
All repositories  : no direct mutation outside explicitly authorized scope.
```

## Current source-of-truth rule

```text
OPUS code and OPUS-owned sites : philstephibanez-wq/OPUS
Workspace context              : philstephibanez-wq/MAESTRO_WORKSPACE
No direct work on removed roots : H:\OPUS_REF_BOOK, H:\LOGANDPLAY.ORG
```
