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
ASAP BEHAVIOR MUST BE EVOLVED, NOT DEGRADED.
```

OPUS is a general-purpose applicative web framework. HTML output must come from `.score` templates through explicit data/view-model contracts. REST is a generic OPUS framework brick, not a private API for one engine.

## Current OPUS state — P7B4 ACL repair validated

```text
OPUS root      : H:\OPUS
OPUS GitHub    : philstephibanez-wq/OPUS
Workspace root : H:\MAESTRO_WORKSPACE
Workspace repo : philstephibanez-wq/MAESTRO_WORKSPACE
OPUS branch    : master
OPUS commit    : c402bd9
OPUS message   : P7 repair ACL with ASAP-compatible engine
```

Read first:

```text
CONTEXT/HANDOFFS/P7B4_20260628_OPUS_ACL_ASAP_COMPAT_REPAIR.md
CONTEXT/HANDOFFS/P7B3_20260628_OPUS_LSTSAR_CONTRACT_ENGINE_SKELETON.md
CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md
CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
```

## OPUS status

P7B4 was executed, validated, committed and pushed.

Validated OPUS commit:

```text
c402bd9 P7 repair ACL with ASAP-compatible engine
```

Final local status observed by user:

```text
## master...origin/master
```

## Why P7B4 was required

The earlier OPUS ACL was a minimal REST gate and degraded the mature ASAP ACL semantics.

This was wrong. OPUS must evolve ASAP, not reduce it.

P7B4 repairs this by keeping OPUS AclPolicyInterface stable while replacing the minimal behavior with an ASAP-compatible engine.

## P7B4 validated output

```text
ACL_SMOKE_OK: anon-status
ACL_SMOKE_OK: anon-me-denied
ACL_SMOKE_OK: auth-me
ACL_SMOKE_OK: dev-security
ACL_SMOKE_OK: scope-security
ACL_SMOKE_OK: visitor-article-read
ACL_SMOKE_OK: visitor-article-publish-denied
ACL_SMOKE_OK: staff-article-edit
ACL_SMOKE_OK: marketing-newsletter-condition
ACL_SMOKE_OK: editor-article-archive
ACL_SMOKE_OK: admin-global-delete
ACL_SMOKE_OK: staff-admin-panel-deny
ACL_REST_SMOKE_OK: status
ACL_REST_SMOKE_OK: me-anon-denied
ACL_REST_SMOKE_OK: me-dev
ACL_REST_SMOKE_OK: security-dev
ACL_REST_SMOKE_OK: lstsar-contracts-dev
ACL_REST_SMOKE_OK: lstsar-engine-dev
TEMP_PROFILER_CLEANED
```

## What P7B4 validates

```text
default deny
roles
role inheritance
resources
resource inheritance
privileges
allow rules
deny rules
all roles
all resources
all privileges
conditional assertions
explicit decision traces
no silent fallback
REST endpoints still work through AclPolicyInterface
```

## Validated decisions still active

REST remains a generic OPUS framework brick. REST consumes SSO, Identity, ACL and FSM contracts. LSTSAR consumes REST and Security Core through its own contracts.

LSTSAR is Load / Secure / Transform / Store / Audit / Report.

`Opus/Fsm/Fsm.php` was removed as a demo FSM and must not be restored. Runtime FSM transitions must be configuration data, not PHP hardcoded sequences.

## Next milestone

```text
P7_LSTSAR_CONTRACT_VALIDATION_CORE
```

Target:

```text
source constraint validation object
target constraint validation object
received vs transformed constraint validation separation
explicit validation errors
no silent fallback
no real storage yet
API endpoints remain thin adapters over framework services
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
