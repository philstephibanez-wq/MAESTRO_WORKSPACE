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

## Current OPUS state — P7B3 validated, ACL blocker open

```text
OPUS root      : H:\OPUS
OPUS GitHub    : philstephibanez-wq/OPUS
Workspace root : H:\MAESTRO_WORKSPACE
Workspace repo : philstephibanez-wq/MAESTRO_WORKSPACE
OPUS branch    : master
OPUS commit    : ec2cb0c
OPUS message   : P7 add LSTSAR contract engine skeleton
```

Read first:

```text
CONTEXT/HANDOFFS/P7B3_20260628_OPUS_LSTSAR_CONTRACT_ENGINE_SKELETON.md
CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md
CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
```

## Blocking correction before any new feature work

```text
P7_ACL_ASAP_COMPAT_REPAIR
```

Reason:

```text
The current OPUS ConfigAclPolicy is only a minimal REST security gate.
It supports public, authenticated and role_or_scope only.
It does not preserve the historical ASAP ACL semantics.
No LSTSAR validation-core patch may be prepared before this is corrected.
```

Required ASAP ACL semantics to port behind OPUS interfaces:

```text
default deny
roles
role inheritance
resources
resource inheritance
privileges
allow rules
deny rules
all resources
all roles
all privileges
conditional assertions
explicit decision trace
no silent fallback
```

Uploaded reference source:

```text
ASAP_PHP_DEMO.zip
framework/ASAP/ACL/ASAP_Acl.class.php
framework/ASAP/ACL/ASAP_Acl_conditions.php
framework/ASAP/ACL/ASAP_Acl_Resource.class.php
framework/ASAP/ACL/ASAP_Acl_Role.class.php
framework/ASAP/ACL/ASAP_Roles.class.php
application/default/helpers/AclDemo_helper.class.php
```

## OPUS status

P7B3 was executed, validated, committed and pushed.

Validated OPUS commit:

```text
ec2cb0c P7 add LSTSAR contract engine skeleton
```

Final local status observed by user:

```text
## master...origin/master
```

## P7B3 validated output

```text
LSTSAR_ENGINE_SMOKE_OK
TEMP_PROFILER_CLEANED
```

Additional validation:

```text
PHP lint OK on LSTSAR engine endpoint, registry, constraint/job/source/target classes, runner, run report, declared pipeline and stage result.
JSON_OK: config/api/routes.json
JSON_OK: config/security/acl.json
JSON_OK: config/lstsar/contracts.json
CLASS_OK: all new LSTSAR engine skeleton classes
```

## What P7B3 validates

```text
LSTSAR immutable job descriptor object exists.
LSTSAR source and target contract objects exist.
LSTSAR constraint set object exists.
LSTSAR stage result object exists.
LSTSAR declared pipeline object exists.
LSTSAR pipeline runner skeleton exists.
LSTSAR pipeline run report object exists.
REST exposes LSTSAR engine skeleton through ApiEndpointInterface endpoint.
No real persistence is introduced.
```

Validated endpoint:

```text
GET /api/v1/lstsar/engine/skeleton
```

## Validated decisions still active

REST remains a generic OPUS framework brick. REST consumes SSO, Identity, ACL and FSM contracts. LSTSAR consumes REST and Security Core through its own contracts.

LSTSAR is Load / Secure / Transform / Store / Audit / Report.

LSTSAR contracts and engine skeleton are declared separately under:

```text
Opus\Lstsar
config/lstsar/contracts.json
```

`Opus/Fsm/Fsm.php` was removed as a demo FSM and must not be restored. Runtime FSM transitions must be configuration data, not PHP hardcoded sequences.

## Next milestone

```text
P7_ACL_ASAP_COMPAT_REPAIR
```

Target:

```text
replace minimal ACL behavior with ASAP-compatible OPUS ACL engine
keep AclPolicyInterface stable for REST dispatcher
add role and resource inheritance
add privilege allow/deny semantics
add allResources/allRoles/allPrivileges semantics
add conditional assertion contract
add explicit decision traces and tests/smoke
keep no silent fallback
then resume P7_LSTSAR_CONTRACT_VALIDATION_CORE
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
