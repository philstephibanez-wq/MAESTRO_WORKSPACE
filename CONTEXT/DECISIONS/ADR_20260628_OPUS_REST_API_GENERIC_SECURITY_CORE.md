# ADR 2026-06-28 — OPUS REST API generic security core

## Status

Accepted.

## Context

OPUS remains a general-purpose framework. The REST layer must not become a private API for one engine such as LSTSAR.

The OPUS Router already had an API entry point, but the old implementation contained hardcoded demo endpoints. P7B1 replaced this with a generic, data-driven API dispatcher protected by security contracts.

## Decision

OPUS REST API is a generic framework brick.

REST consumes security contracts:

- SsoAuthenticatorInterface
- IdentityContextInterface
- AclPolicyInterface
- AccessDecisionInterface
- FsmGuardInterface

REST endpoints implement ApiEndpointInterface and are resolved through a data-driven route registry.

LSTSAR will consume this API/security core later through its own contracts. REST must not contain LSTSAR-specific logic or hardcoded LSTSAR endpoints in the core dispatcher.

## Consequences

- API routes must be declared in config, not hardcoded in Router.
- SSO remains a security adapter contract, not a REST implementation detail.
- ACL remains a policy contract and can be backed by stronger ASAP-derived logic later.
- FSM guard is optional and declared by route/config.
- LSTSAR must add its own contract layer under Opus/Lstsar before adding endpoints.
- Profiler traces should be reused for API/security diagnostics.

## Next milestone

P7_LSTSAR_CONTRACT_CORE.
