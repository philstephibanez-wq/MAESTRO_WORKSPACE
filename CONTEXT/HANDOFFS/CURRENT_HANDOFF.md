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
REUSE EXISTING OPUS BRICKS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
```

OPUS is a general-purpose applicative web framework. HTML output must come from `.score` templates through explicit data/view-model contracts. REST is a generic OPUS framework brick, not a private API for one engine.

## Current OPUS state — P7B1 validated

```text
OPUS root      : H:\OPUS
OPUS GitHub    : philstephibanez-wq/OPUS
Workspace root : H:\MAESTRO_WORKSPACE
Workspace repo : philstephibanez-wq/MAESTRO_WORKSPACE
OPUS branch    : master
OPUS commit    : 73f1deb
OPUS message   : P7 add REST API SSO security core
```

Read first:

```text
CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
```

Related ADR:

```text
CONTEXT/DECISIONS/ADR_20260628_OPUS_REST_API_GENERIC_SECURITY_CORE.md
```

History handoffs:

```text
CONTEXT/HANDOFFS/P7A1D4_20260626_OPUS_WEB_PROFILER_CONFIGURED_FSM_VALIDATED.md
CONTEXT/HANDOFFS/P7A1C_20260626_OPUS_TOKENIZER_FRAMEWORK_INTERFACES_CONTRACTS.md
CONTEXT/HANDOFFS/P7A1A_20260626_OPUS_INTERFACE_REFACTOR_ABORT_AND_FSM_DEMO_REMOVAL.md
```

## OPUS status

P7B1 was executed, validated, committed and pushed.

Validated OPUS commit:

```text
73f1deb P7 add REST API SSO security core
```

OPUS remote push completed to origin/master.

## Immediate cleanup before next OPUS patch

After the push, local `H:\OPUS` still showed command-name scories:

```text
?? cd
?? del
?? git
?? php
?? rmdir
```

Before any new OPUS patch, delete these files and confirm:

```text
## master...origin/master
```

No future OPUS work should start from a dirty working tree.

## P7B1 validated output

```text
JSON_OK: config/api/routes.json
JSON_OK: config/security/sso.json
JSON_OK: config/security/acl.json

CLASS_OK: Opus\Api\ApiDispatcher
CLASS_OK: Opus\Api\ApiRouteRegistry
CLASS_OK: Opus\Security\Access\ConfigAclPolicy
CLASS_OK: Opus\Security\Sso\DevHeaderSsoAuthenticator
CLASS_OK: Opus\Security\Fsm\ConfigFsmGuard

API_SMOKE_OK: status
API_SMOKE_OK: me
API_SMOKE_OK: policies
TEMP_PROFILER_CLEANED
```

## What P7B1 validates

```text
Generic REST API dispatcher
Data-driven API route registry
ApiEndpointInterface contract
JSON error response factory
SSO contract with dev-header adapter
IdentityContext contract
ACL policy contract with config-backed policy
FSM guard contract with config-backed guard
Router no longer hardcodes demo API endpoints
Profiler reused during API/security smoke validation
```

Validated endpoints:

```text
GET /api/v1/status
GET /api/v1/me
GET /api/v1/security/policies
```

## Validated decisions still active

`Opus/Fsm/Fsm.php` was removed as a demo FSM and must not be restored.

Runtime FSM transitions must be configuration data, not PHP hardcoded sequences.

```text
config/fsm_runtime
```

REST remains a generic OPUS framework brick. REST consumes SSO, Identity, ACL and FSM contracts. LSTSAR will consume REST and Security Core later, but REST must not contain LSTSAR-specific hardcode.

The OPUS ACL currently exposed in this patch is a policy contract and config-backed adapter. Mature ACL behavior from ASAP may be adapted later behind the OPUS interface; do not replace framework contracts with project-specific hardcode.

## Next milestone

```text
P7_LSTSAR_CONTRACT_CORE
```

Target:

```text
Opus\Lstsar\LstsarPipelineInterface
Opus\Lstsar\LstsarJobInterface
Opus\Lstsar\LstsarReportInterface
Load / Secure / Transform / Store / Audit / Report contracts
LSTSAR endpoints implementing ApiEndpointInterface
No LSTSAR hardcode inside REST core
Reuse REST Security Core contracts
```

Secondary follow-up:

```text
Profiler i18n fr/en/es for dev toolbar and profiler page.
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
