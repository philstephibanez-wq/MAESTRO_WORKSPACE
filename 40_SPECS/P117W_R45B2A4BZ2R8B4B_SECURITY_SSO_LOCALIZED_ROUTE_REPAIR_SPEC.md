# P117W R45B2A4BZ2R8B4B — Security SSO localized route repair spec

State: SUPERSEDED — PREFLIGHT BASELINE OBSOLETE — SEE R8B4B1

## Supersession evidence

R8B4B was constructed for the pre-commit R8B4A2 state with required HEAD:

`76b59191492f4efabf343e85be841f4832fe0ced`

and an expected dirty 15-path R8B4A2 worktree.

Before R8B4B was executed, the owner had already committed and pushed R8B4A2. GitHub source of truth now records:

`c5e7de78f70d14efc3b8c42f4ec53026b47253cf`

`opus_p117w_r45b2a4bz2r8b4a2_applicator_profiler_anchor_repair`

Owner execution of R8B4B therefore stopped safely at:

`P117W_R45B2A4BZ2R8B4B_PREFLIGHT_BEGIN`

`P117W_R45B2A4BZ2R8B4B_HEAD_INVALID`

and `git status --short` was empty. No source write occurred.

The functional diagnosis below remains valid; only the required input baseline was wrong. The active replacement is R8B4B1, which targets exact committed HEAD `c5e7de78...` with a clean worktree.

## Purpose

Repair the R8B4 runtime Security-page failure caused by the missing localized canonical route for the new dedicated SSO Security view.

## Original required input state — obsolete

R8B4B originally required OPUS HEAD:

`76b59191492f4efabf343e85be841f4832fe0ced`

with the uncommitted R8B4A2 differential. That state no longer matches GitHub and must not be used.

## Runtime evidence

Structure already renders selected application `essai`, EFSM `navigation`, canonical source `config/application.fsm.json`.

For Security trace `bc0c3e165f29f831cb53eb2fba151758`:

- front receives `/fr-FR/sécurité`;
- localized route resolution of public `sécurité` -> canonical `security` succeeds;
- back receives `GET /api/v1/applications/essai/security`;
- Composer `owasys:security-snapshot` succeeds;
- REST `security.snapshot` returns HTTP 200;
- front later fails during URL construction with `OPUS_LOCALIZED_ROUTE_CANONICAL_UNKNOWN`.

## Root cause

R8B4 added Security view `sso` to `OwasysSecurityController` and the view model builds:

`securityUrl($locale, 'sso')`

For non-overview views, `securityUrl()` localizes the canonical path:

`security/sso`

OWASYS-front `config/routes.localized.json` contains explicit routes for all previous Security subviews but does not declare `security/sso`.

`LocalizedRouteResolver::localize()` must reject undeclared canonical routes. The resolver is correct; the route catalog is incomplete.

## Required correction preserved in R8B4B1

Modify only:

`sites/owasys-front/config/routes.localized.json`

Add canonical route `security/sso` with:

- `tail: false`;
- one base-language path for every language already defined by canonical `security`;
- public path derived exactly as `<localized-security-path>/sso`.

The SSO acronym remains opaque and identical in every language. No backend REST route is added or changed.

## Non-regression constraints

- no framework change;
- no backend change;
- no JavaScript/TypeScript/Node artifact under `sites/owasys-back`;
- no route fallback or silent bypass;
- no change to REST naming/transport;
- no change to selected micro-EFSM authority;
- no commit/push by the assistant.

## Replacement

Normative implementation and validation now live in:

`P117W_R45B2A4BZ2R8B4B1_SECURITY_SSO_LOCALIZED_ROUTE_COMMITTED_BASELINE_REPAIR`.
