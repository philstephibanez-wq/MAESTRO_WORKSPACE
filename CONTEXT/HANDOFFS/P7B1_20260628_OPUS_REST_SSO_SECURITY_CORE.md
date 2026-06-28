# P7B1 — OPUS REST API SSO Security Core

Status: VALIDATED_AND_PUSHED.

OPUS repo: philstephibanez-wq/OPUS.
OPUS local root: H:\OPUS.
Branch: master.
Commit: 73f1deb.
Commit message: P7 add REST API SSO security core.

## Summary

P7B1 adds a generic OPUS REST API security core. It is not an LSTSAR-specific API.

REST remains a generic OPUS framework brick. REST consumes SSO, Identity, ACL and FSM contracts. LSTSAR will consume REST and Security Core later. REST must not contain LSTSAR-specific hardcode.

## Added framework bricks

- Opus/Api/ApiDispatcher.php
- Opus/Api/ApiEndpointInterface.php
- Opus/Api/ApiErrorResponseFactory.php
- Opus/Api/ApiRoute.php
- Opus/Api/ApiRouteRegistry.php
- Opus/Api/Endpoint/MeEndpoint.php
- Opus/Api/Endpoint/SecurityPoliciesEndpoint.php
- Opus/Api/Endpoint/StatusEndpoint.php
- Opus/Security/Access/AccessDecision.php
- Opus/Security/Access/AccessDecisionInterface.php
- Opus/Security/Access/AclPolicyInterface.php
- Opus/Security/Access/ConfigAclPolicy.php
- Opus/Security/Fsm/ConfigFsmGuard.php
- Opus/Security/Fsm/FsmGuardInterface.php
- Opus/Security/Identity/IdentityContext.php
- Opus/Security/Identity/IdentityContextInterface.php
- Opus/Security/Sso/DevHeaderSsoAuthenticator.php
- Opus/Security/Sso/SsoAuthenticatorInterface.php
- config/api/routes.json
- config/security/acl.json
- config/security/sso.json

Modified framework entry: Opus/Routing/Router.php.

The old hardcoded demo API branch was replaced by delegation to the data-driven API dispatcher.

## Validated endpoints

- GET /api/v1/status
- GET /api/v1/me
- GET /api/v1/security/policies

## Validation evidence from Windows dev

- JSON OK for config/api/routes.json, config/security/sso.json and config/security/acl.json.
- Class autoload OK for ApiDispatcher, ApiRouteRegistry, ConfigAclPolicy, DevHeaderSsoAuthenticator and ConfigFsmGuard.
- API smoke OK for status, me and policies.
- Temporary profiler smoke directory cleaned.

## Immediate local cleanup required before next OPUS work

After the push, local OPUS still showed command-name scories: cd, del, git, php and rmdir. Delete these files before any new OPUS patch and confirm a clean master...origin/master status.

## Architecture contract

- Opus\Api exposes ApiEndpointInterface, ApiDispatcher, ApiRouteRegistry and ApiErrorResponseFactory.
- Opus\Security\Sso exposes SsoAuthenticatorInterface.
- Opus\Security\Identity exposes IdentityContextInterface.
- Opus\Security\Access exposes AclPolicyInterface and AccessDecisionInterface.
- Opus\Security\Fsm exposes FsmGuardInterface.

Runtime flow: Request -> ApiRouteRegistry -> SSO -> IdentityContext -> ACL policy -> optional FSM guard -> ApiEndpointInterface -> Response::json().

## Next milestone

P7_LSTSAR_CONTRACT_CORE.

Expected next contracts: LstsarPipelineInterface, LstsarJobInterface, LstsarReportInterface, Load/Secure/Transform/Store/Audit/Report contracts, LSTSAR endpoints implementing ApiEndpointInterface, and no LSTSAR hardcode inside REST core.

## Continuation rules

NO CONTRACT, NO PATCH. NO SOURCE OF TRUTH, NO PATCH. NO BRICOLAGE DELIVERY. NO FALLBACK SILENCIEUX. REUSE EXISTING OPUS BRICKS. WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
