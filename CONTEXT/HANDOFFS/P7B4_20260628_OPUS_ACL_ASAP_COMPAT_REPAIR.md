# P7B4 — OPUS ACL ASAP-Compatible Repair

## Status

VALIDATED_AND_PUSHED.

## Source repositories

- Workspace repo: philstephibanez-wq/MAESTRO_WORKSPACE
- OPUS repo: philstephibanez-wq/OPUS
- OPUS local root: H:\OPUS
- Branch: master
- Commit: c402bd9
- Commit message: P7 repair ACL with ASAP-compatible engine

## Summary

P7B4 repairs the ACL regression introduced by the earlier minimal REST gate.

The earlier OPUS ACL gate supported only public, authenticated and role_or_scope. That was insufficient because OPUS must evolve ASAP, not degrade it.

P7B4 adds an ASAP-compatible ACL engine behind the existing OPUS AclPolicyInterface so the REST dispatcher contract remains stable while ACL semantics become framework-grade.

## Added OPUS files

- Opus/Security/Access/AsapCompat/AclConditionAssertionInterface.php
- Opus/Security/Access/AsapCompat/AsapCompatAclEngine.php
- Opus/Security/Access/AsapCompat/ClaimEqualsConditionAssertion.php
- Opus/Security/Access/AsapCompat/ScopeAnyConditionAssertion.php

## Modified OPUS files

- Opus/Security/Access/ConfigAclPolicy.php
- config/security/acl.json

## Restored ACL capabilities

- default deny
- roles
- role inheritance
- resources
- resource inheritance
- privileges
- allow rules
- deny rules
- all roles
- all resources
- all privileges
- conditional assertions
- explicit decision traces
- no silent fallback

## Validation evidence from Windows dev

- OPUS was clean before patch: `## master...origin/master`.
- Initial ACL repair patch applied.
- Missing AsapCompat files patch applied after first delivery gap.
- Composer autoload regenerated.
- PHP lint OK for ConfigAclPolicy and all AsapCompat classes.
- JSON OK on config/security/acl.json.
- Autoload OK for ConfigAclPolicy and all AsapCompat classes/interfaces.
- ACL smoke matrix OK for anonymous, authenticated, developer, scoped, staff, marketing, editor and admin identities.
- REST smoke OK for status, me anonymous denied, me developer, security policies, LSTSAR contracts and LSTSAR engine skeleton.
- Temporary profiler smoke directory cleaned.
- OPUS committed and pushed.

## Commit evidence

`c402bd9 P7 repair ACL with ASAP-compatible engine`

Final local status observed by user:

`## master...origin/master`

## Architectural correction

This repair is a priority correction, not a feature.

OPUS must evolve ASAP into a cleaner framework architecture. It must not replace mature ASAP behavior with simplified substitutes.

The ACL engine can be refactored and modernized, but its semantic power must be preserved or improved.

## Next milestone

Resume only after ACL is treated as repaired:

P7_LSTSAR_CONTRACT_VALIDATION_CORE.

Expected scope:

- source constraint validation object;
- target constraint validation object;
- received vs transformed constraint validation separation;
- explicit validation errors;
- no silent fallback;
- no real storage yet;
- keep REST endpoint thin and config driven.

## Continuation rules

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
REUSE EXISTING OPUS BRICKS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
ASAP behavior must be evolved, not degraded.
