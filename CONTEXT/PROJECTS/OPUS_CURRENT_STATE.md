# OPUS CURRENT STATE

Last updated: 2026-06-28.

## Repository

- Local repo: H:\OPUS
- Remote: philstephibanez-wq/OPUS
- Branch: master
- Last pushed commit: c402bd9
- Commit message: P7 repair ACL with ASAP-compatible engine

## Current validated milestone

P7B4 / P7_ACL_ASAP_COMPAT_REPAIR is validated and pushed.

## Important correction

P7B4 repairs the earlier ACL regression.

The earlier ACL gate was too small for OPUS because OPUS must evolve ASAP, not degrade it.

The current ACL layer keeps AclPolicyInterface stable and adds an ASAP-compatible engine behind ConfigAclPolicy.

## ACL capabilities now present

- default deny
- roles
- role inheritance
- resources
- resource inheritance
- privileges
- allow and deny rules
- all roles, all resources and all privileges
- conditional assertions
- explicit decision trace
- no silent fallback

## Current architecture state

OPUS now has:

- generic REST API core;
- OPUS identity and ACL contracts;
- ASAP-compatible ACL engine;
- LSTSAR contract namespace;
- LSTSAR contract discovery endpoints;
- LSTSAR engine skeleton objects.

## Validated endpoints

- GET /api/v1/status
- GET /api/v1/me
- GET /api/v1/security/policies
- GET /api/v1/lstsar/contracts
- GET /api/v1/lstsar/pipelines/default
- GET /api/v1/lstsar/engine/skeleton

## Validation evidence

P7B4 validation passed:

- PHP lint OK for ConfigAclPolicy and AsapCompat classes.
- JSON OK on config/security/acl.json.
- Composer autoload OK.
- ACL smoke matrix OK.
- REST smoke OK.
- Temporary profiler smoke data cleaned.
- OPUS commit and push OK.
- Final local status observed: `## master...origin/master`.

## Next milestone

P7_LSTSAR_CONTRACT_VALIDATION_CORE.

Expected scope:

- source constraint validation object;
- target constraint validation object;
- received vs transformed constraint validation separation;
- explicit validation errors;
- no silent fallback;
- no real storage yet;
- API endpoints remain thin adapters over framework services.

## Active continuation rule

Before any new OPUS patch, read:

- CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- CONTEXT/HANDOFFS/P7B4_20260628_OPUS_ACL_ASAP_COMPAT_REPAIR.md
- CONTEXT/HANDOFFS/P7B3_20260628_OPUS_LSTSAR_CONTRACT_ENGINE_SKELETON.md
- CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md
- CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
