# OPUS CURRENT STATE

Last updated: 2026-06-28.

## Repository

- Local repo: H:/OPUS
- Remote: philstephibanez-wq/OPUS
- Branch: master
- Last pushed commit: c402bd9
- Commit message: P7 repair ACL with ASAP-compatible engine

## Current validated milestone

P7B4 / P7_ACL_ASAP_COMPAT_REPAIR is smoke-validated and pushed.

Full ASAP ACL parity is not certified yet. Next required milestone is P7_ACL_ASAP_PARITY_AUDIT.

## ScoreTemplate ownership

ScoreTemplate and .score belong to OPUS.

Do not describe ScoreTemplate as an ASAP component in the current architecture.

Historical wording such as ASAP ScoreTemplate Engine or ASAP View ScoreTemplate is obsolete for the OPUS line.

Correct rule:

- owner: OPUS;
- rendering layer: OPUS view layer;
- extension: .score;
- ASAP role: historical context only.

## Important ACL correction

P7B4 repairs the earlier ACL regression by smoke tests.

The earlier ACL gate was too small for OPUS because OPUS must evolve ASAP, not degrade it.

P7B4 keeps AclPolicyInterface stable and adds an ASAP-inspired engine behind ConfigAclPolicy. A full parity audit remains required.

## ACL capabilities smoke-covered

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
- ACL smoke repair after the earlier regression;
- LSTSAR contract namespace;
- LSTSAR contract discovery endpoints;
- LSTSAR engine skeleton objects;
- OPUS-owned ScoreTemplate / .score rule.

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

P7_ACL_ASAP_PARITY_AUDIT.

Expected scope:

- read ASAP_PHP_DEMO ACL source;
- map ASAP ACL public API and behavior;
- compare OPUS P7B4 ACL behavior against ASAP;
- add missing parity smoke/tests;
- fix OPUS ACL only after explicit audit matrix;
- then resume P7_LSTSAR_CONTRACT_VALIDATION_CORE.

## Later milestone

P7_LSTSAR_CONTRACT_VALIDATION_CORE.

## Active continuation rule

Before any new OPUS patch, read:

- CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- CONTEXT/DECISIONS/DECISION_20260628_OPUS_SCORETEMPLATE_OWNERSHIP.md
- CONTEXT/HANDOFFS/P7B4_20260628_OPUS_ACL_ASAP_COMPAT_REPAIR.md
- CONTEXT/HANDOFFS/P7B3_20260628_OPUS_LSTSAR_CONTRACT_ENGINE_SKELETON.md
- CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md
- CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
