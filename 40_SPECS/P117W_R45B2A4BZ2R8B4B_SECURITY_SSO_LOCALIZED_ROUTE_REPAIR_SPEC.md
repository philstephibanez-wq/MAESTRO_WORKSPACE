# P117W R45B2A4BZ2R8B4B — Security SSO localized route repair spec

State: DELIVERY TARGET — R8B4A2 PRODUCT DIFFERENTIAL PRESERVED

## Purpose

Repair the R8B4 runtime Security-page failure caused by the missing localized canonical route for the new dedicated SSO Security view.

## Required input state

OPUS HEAD remains exactly:

`76b59191492f4efabf343e85be841f4832fe0ced`

The owner worktree must contain exactly the already integrated R8B4A2 differential:

- the 14 expected tracked modifications;
- untracked `sites/essai/config/security.fsm.json`;
- no staged changes.

R8B4B is an incremental repair on that uncommitted state. It must not require reset or reapplication of R8B4A2.

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

## Required correction

Modify only:

`sites/owasys-front/config/routes.localized.json`

Add canonical route:

`security/sso`

with:

- `tail: false`;
- one base-language path for every language already defined by canonical `security`;
- public path derived exactly as `<localized-security-path>/sso`.

The SSO acronym remains opaque and identical in every language. No backend REST route is added or changed.

## Required validation

Before repository write, the applicator must:

1. verify exact HEAD;
2. verify exact R8B4A2 tracked/untracked worktree shape;
3. reject staged changes;
4. verify `routes.localized.json` is still the exact R8B2 blob `1ace98302b62a10fb2f817f60063fdfd3f08180c`;
5. verify the R8B4A2 Security controller actually contains the dedicated SSO view and SSO URL construction;
6. read configuration through OPUS File/StructuredFileLoader;
7. derive `security/sso` paths from the existing canonical `security` paths;
8. serialize with OPUS Json;
9. instantiate the real `LocalizedRouteResolver` against the staged catalog;
10. prove `localize()` + `resolve()` round-trip for `security/sso` across every supported OWASYS-front locale.

Write must use OPUS `File::writeAtomic()` and rollback the original bytes if post-write validation fails.

## Non-regression constraints

- no framework change;
- no backend change;
- no JavaScript/TypeScript/Node artifact under `sites/owasys-back`;
- no reset of the current R8B4A2 differential;
- no route fallback or silent bypass;
- no change to REST naming/transport;
- no change to selected micro-EFSM authority;
- no commit/push by the assistant.

## Acceptance after application

Repository gate:

- 15 tracked modified files: the previous 14 plus `sites/owasys-front/config/routes.localized.json`;
- one untracked file: `sites/essai/config/security.fsm.json`;
- no staged changes.

Runtime gate:

1. `/fr-FR/sécurité` renders instead of HTTP 500;
2. Security authority shows application `essai`, EFSM `security`, source `config/security.fsm.json`;
3. SSO view URL resolves and opens;
4. provider/default-provider metadata is real and contains no secrets;
5. Structure remains `essai / navigation`;
6. Sources + Git remains functional;
7. Security Conception STATE create persists and survives reload.

Only after those gates may R8B4 be committed/pushed.
