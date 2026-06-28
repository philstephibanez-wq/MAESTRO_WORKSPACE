# OPUS CURRENT STATE

Last updated: 2026-06-28.

## Repository

- Local repo: H:\OPUS
- Remote: philstephibanez-wq/OPUS
- Branch: master
- Last pushed commit: 73f1deb
- Commit message: P7 add REST API SSO security core

## Current validated milestone

P7B1 / P7_API_REST_SSO_SECURITY_CORE is validated and pushed.

## Current architecture state

OPUS now has a generic REST API core with contract-first security integration.

REST is generic framework infrastructure. It is not owned by LSTSAR.

Security contracts added:

- SsoAuthenticatorInterface
- IdentityContextInterface
- AclPolicyInterface
- AccessDecisionInterface
- FsmGuardInterface

API contracts added:

- ApiEndpointInterface
- ApiDispatcher
- ApiRouteRegistry
- ApiErrorResponseFactory

Config roots added:

- config/api/routes.json
- config/security/sso.json
- config/security/acl.json

## Validated endpoints

- GET /api/v1/status
- GET /api/v1/me
- GET /api/v1/security/policies

## Validation evidence

- PHP lint OK for Router, ApiDispatcher, ApiRouteRegistry, ConfigAclPolicy, DevHeaderSsoAuthenticator and ConfigFsmGuard.
- JSON decode OK for API, SSO and ACL config files.
- Composer autoload OK for API and Security classes.
- API smoke OK for status, me and security policies.
- Temporary profiler smoke data cleaned.

## Immediate local cleanup required

The OPUS commit and push are complete, but the local OPUS working tree showed these untracked scories after push:

- cd
- del
- git
- php
- rmdir

Delete them before any new OPUS work and confirm a clean `master...origin/master` state.

## Next milestone

P7_LSTSAR_CONTRACT_CORE.

Expected scope:

- Opus/Lstsar contracts.
- Load / Secure / Transform / Store / Audit / Report interfaces.
- LSTSAR job and report contracts.
- LSTSAR endpoints implementing ApiEndpointInterface.
- No LSTSAR hardcode inside REST core.

## Active continuation rule

Before any new OPUS patch, read:

- CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
- CONTEXT/DECISIONS/ADR_20260628_OPUS_REST_API_GENERIC_SECURITY_CORE.md
