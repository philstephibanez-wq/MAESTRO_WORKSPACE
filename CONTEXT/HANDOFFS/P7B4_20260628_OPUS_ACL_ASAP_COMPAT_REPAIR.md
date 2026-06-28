# P7B4 — OPUS ACL ASAP Repair Smoke

## Status

VALIDATED_AND_PUSHED, BUT NOT FULL ASAP PARITY CERTIFIED.

## Source repositories

- Workspace repo: philstephibanez-wq/MAESTRO_WORKSPACE
- OPUS repo: philstephibanez-wq/OPUS
- OPUS local root: H:\OPUS
- Branch: master
- Commit: c402bd9
- Commit message: P7 repair ACL with ASAP-compatible engine

## Correction of wording

Do not claim that P7B4 proves full ASAP ACL parity.

P7B4 repairs the immediate regression caused by the earlier minimal REST gate. It restores an ASAP-inspired ACL engine behind the existing OPUS AclPolicyInterface and passes an initial smoke matrix.

This is not yet a full formal audit against the complete historical ASAP ACL behavior.

## Why this matters

OPUS must evolve ASAP, not degrade it.

A smoke test is not a semantic parity proof.

Before resuming LSTSAR validation work, perform an ACL parity audit against the uploaded ASAP_PHP_DEMO.zip source, especially:

- framework/ASAP/ACL/ASAP_Acl.class.php
- framework/ASAP/ACL/ASAP_Acl_conditions.php
- framework/ASAP/ACL/ASAP_Acl_Resource.class.php
- framework/ASAP/ACL/ASAP_Acl_Role.class.php
- framework/ASAP/ACL/ASAP_Roles.class.php
- application/default/helpers/AclDemo_helper.class.php

## Added OPUS files

- Opus/Security/Access/AsapCompat/AclConditionAssertionInterface.php
- Opus/Security/Access/AsapCompat/AsapCompatAclEngine.php
- Opus/Security/Access/AsapCompat/ClaimEqualsConditionAssertion.php
- Opus/Security/Access/AsapCompat/ScopeAnyConditionAssertion.php

## Modified OPUS files

- Opus/Security/Access/ConfigAclPolicy.php
- config/security/acl.json

## Smoke-covered ACL capabilities

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

- PHP lint OK for ConfigAclPolicy and all AsapCompat classes/interfaces.
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

## Next milestone

P7_ACL_ASAP_PARITY_AUDIT.

Expected scope:

- read ASAP_PHP_DEMO ACL source;
- map all ASAP public ACL APIs and semantics;
- compare OPUS P7B4 engine against ASAP behavior;
- add missing compatibility tests;
- fix OPUS ACL only after the audit matrix is explicit;
- then resume P7_LSTSAR_CONTRACT_VALIDATION_CORE.

## Continuation rules

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
REUSE EXISTING OPUS BRICKS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
ASAP behavior must be evolved, not degraded.
