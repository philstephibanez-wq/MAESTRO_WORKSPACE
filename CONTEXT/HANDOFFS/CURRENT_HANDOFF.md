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

## Current OPUS state — P7A1C validated

```text
OPUS root      : H:\OPUS
OPUS GitHub    : philstephibanez-wq/OPUS
Workspace root : H:\MAESTRO_WORKSPACE
Workspace repo : philstephibanez-wq/MAESTRO_WORKSPACE
```

Read first:

```text
CONTEXT/HANDOFFS/P7A1C_20260626_OPUS_TOKENIZER_FRAMEWORK_INTERFACES_CONTRACTS.md
```

History handoff:

```text
CONTEXT/HANDOFFS/P7A1A_20260626_OPUS_INTERFACE_REFACTOR_ABORT_AND_FSM_DEMO_REMOVAL.md
```

## OPUS Git status

P7A1C was executed, committed and pushed.

```text
c1cded0 P7A1C add tokenizer-based framework interfaces and contracts
41a4d2b..c1cded0  master -> master
## master...origin/master
```

## P7A1C validated output

```text
PHP_FILES=79
CLASS_LIKE_TOTAL=80
CLASSES_TOTAL=75
CONCRETE_CLASSES=71
ABSTRACT_EXEMPT=4
INTERFACES_CREATED=71
CLASSES_PATCHED=71
MISSING_IMPLEMENTS=0
PHP_LINT_ERRORS=0
EXIT_CODE=0
```

Reports committed:

```text
DOC/reference/generated/json/p7a1c_contract_map.json
DOC/reference/generated/markdown/P7A1C_CONTRACT_MAP.md
```

Base contracts added:

```text
Opus/Framework/OpusFrameworkComponentInterface.php
Opus/Framework/OpusExceptionAwareInterface.php
Opus/Framework/OpusExceptionContractInterface.php
Opus/Framework/OpusProfilerAwareInterface.php
Opus/Framework/OpusSelfDocumentingInterface.php
```

## Validated decision still active

`Opus/Fsm/Fsm.php` was removed as a demo FSM and must not be restored.

```text
41a4d2b Remove demo FSM from OPUS framework
```

## P7A1A warning

P7A1A3 through P7A1A9 are invalidated. Do not reuse them as a base.

Key causes:

```text
regex scanner noise
false OK with CLASSES=0
bad implements injection
invalid generated interface names
broad *Interface.php deletion
rejected Opus/Contract/PerClass and tools/contracts
```

## Current limitation

P7A1C validates the interface and contract skeleton only. It does not yet validate the full runtime diagnostic bridge into exceptions and profiler traces.

## Next milestone

```text
P7A1D_BIG_RUNTIME_EXCEPTION_PROFILER_PIPELINE
```

Target:

```text
runtime diagnostics -> OPUS exception objects -> profiler trace levels
explicit exemptions
PHP lint global
no false OK
RefBook data update
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
