# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart from this file without relying on hidden conversation memory.

## Permanent rules

NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
REUSE EXISTING OPUS BRICKS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
ASAP BEHAVIOR MUST BE EVOLVED, NOT DEGRADED.

OPUS is a general-purpose applicative web framework. REST is a generic OPUS framework brick, not a private API for one engine.

## Current OPUS state

OPUS root: H:\OPUS
OPUS GitHub: philstephibanez-wq/OPUS
Workspace root: H:\MAESTRO_WORKSPACE
Workspace repo: philstephibanez-wq/MAESTRO_WORKSPACE
OPUS branch: master
OPUS commit: c402bd9
OPUS message: P7 repair ACL with ASAP-compatible engine

## Read first

- CONTEXT/HANDOFFS/P7B4_20260628_OPUS_ACL_ASAP_COMPAT_REPAIR.md
- CONTEXT/HANDOFFS/P7B3_20260628_OPUS_LSTSAR_CONTRACT_ENGINE_SKELETON.md
- CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md
- CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md

## Blocking correction before LSTSAR resumes

P7_ACL_ASAP_PARITY_AUDIT.

P7B4 is validated as a smoke repair, not as a full proof of ASAP ACL parity.

The P7B4 ACL smoke matrix is not enough to prove full historical ASAP ACL compatibility. ASAP_PHP_DEMO.zip must be audited before claiming parity.

## P7B4 validation already passed

- ACL smoke matrix OK.
- REST smoke OK.
- TEMP_PROFILER_CLEANED.
- OPUS commit pushed: c402bd9 P7 repair ACL with ASAP-compatible engine.

## Next milestone

P7_ACL_ASAP_PARITY_AUDIT.

Target:

- read ASAP_PHP_DEMO ACL source;
- map ASAP ACL public API and behavior;
- compare OPUS P7B4 ACL behavior against ASAP;
- add missing parity smoke/tests;
- fix OPUS ACL only after explicit audit matrix;
- then resume P7_LSTSAR_CONTRACT_VALIDATION_CORE.

## Later milestone

P7_LSTSAR_CONTRACT_VALIDATION_CORE.

Target after ACL audit:

- source constraint validation object;
- target constraint validation object;
- received vs transformed constraint validation separation;
- explicit validation errors;
- no silent fallback;
- no real storage yet;
- API endpoints remain thin adapters over framework services.

## Repository write policy

MAESTRO_WORKSPACE: assistant may write directly to GitHub for contracts, ADRs, handoffs and project context updates.
OPUS: no direct assistant write/commit/push; local runners only, then user validates and commits/pushes.
All repositories: no direct mutation outside explicitly authorized scope.

## Current source-of-truth rule

OPUS code and OPUS-owned sites: philstephibanez-wq/OPUS
Workspace context: philstephibanez-wq/MAESTRO_WORKSPACE
No direct work on removed roots: H:\OPUS_REF_BOOK, H:\LOGANDPLAY.ORG
