# P117W R45B2A4BZ2R8B4A2 — Applicator profiler anchor repair handoff

State: DIFFERENTIAL INTEGRATED — RUNTIME PARTIAL — SECURITY ROUTE REPAIR MOVED TO R8B4B

## Exact OPUS baseline

`76b59191492f4efabf343e85be841f4832fe0ced`

`opus_p117w_r45b2a4bz2r8b2_actual_graphical_handler_authoring`

R8B4A2 was applied by the owner to `H:\OPUS` on top of that exact HEAD, without commit/push.

## R8B4A2 applicator repair

R8B4A2 repaired only the ambiguous backend profiler anchors from R8B4A1. The two semantic anchors are qualified by their profiler event names:

- `designer.draft_command.received`;
- `designer.draft_command.validated`.

No occurrence-count relaxation or global replacement was introduced.

Artifact:

`opus_p117w_r45b2a4bz2r8b4a2_applicator_profiler_anchor_repair.zip`

ZIP SHA-256:

`633fc827ec76df3244f495a92a5e20519ffcdc7348e2e023e47f6d292fad79bc`

Applicator SHA-256:

`9565f7a1c057089e7328878e432346f49edef338d8f71f26973ece61263f1dfc`

## Owner integration evidence

After application, `git status --short` contained exactly the normative R8B4 differential:

Modified tracked paths:

1. `Opus/Fsm/FsmSiteLoader.php`
2. `Opus/Scaffold/ProfilerEnvironmentScaffoldPolicy.php`
3. `Opus/Scaffold/SiteScaffoldPlan.php`
4. `sites/essai/config/application.fsm.json`
5. `sites/essai/config/site.json`
6. `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`
7. `sites/owasys-front/application/default/services/FsmDesignerGateway.php`
8. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
9. `sites/owasys-front/application/default/services/ScorePageRenderer.php`
10. `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
11. `sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`
12. `sites/owasys-front/application/security/controllers/SecurityController.php`
13. `sites/owasys-front/application/security/templates/index.score`
14. `sites/owasys-front/www/asset/js/fsm-designer.js`

New path:

15. `sites/essai/config/security.fsm.json`

No commit/push is authorized yet.

## Runtime evidence — 2026-08-24

### Structure gate: PASS

With current application `essai`, the OWASYS Structure page renders the contextual authority:

- application: `essai`;
- EFSM: `navigation`;
- source: `config/application.fsm.json`;
- visible canonical source SHA;
- graphical states `begin` and `home` from the selected application definition.

This validates the selected-application navigation micro-EFSM projection in VIEW for this slice.

### Security REST/back gate: PASS

For the same front trace `bc0c3e165f29f831cb53eb2fba151758`, owasys-back received:

`GET /api/v1/applications/essai/security`

The secured REST operation `security.snapshot` invoked allow-listed Composer script `owasys:security-snapshot`; Composer succeeded and REST returned HTTP 200. The backend is therefore not the cause of the Security page failure.

### Security front/render gate: FAIL

The front received `/fr-FR/sécurité`, correctly resolved the public route to canonical `security`, then failed later with:

`OPUS_LOCALIZED_ROUTE_CANONICAL_UNKNOWN`

at `Opus/Http/LocalizedRouteResolver.php` during rendering/navigation URL construction.

The failure reproduces on repeated Security requests while other pages continue to render.

## Root cause of the runtime failure

R8B4 added a dedicated Security view `sso` and made the Security renderer build:

`securityUrl($locale, 'sso')`

`securityUrl()` delegates non-overview views to canonical route:

`security/sso`

The OWASYS-front localized-route catalog contains explicit canonical routes for:

- `security/identities`;
- `security/roles`;
- `security/permissions`;
- `security/assignments`;
- `security/resources`;

but contains no `security/sso` route.

`LocalizedRouteResolver::localize()` therefore correctly throws `OPUS_LOCALIZED_ROUTE_CANONICAL_UNKNOWN` when the Security page model builds the SSO URL. This is an application route-catalog omission introduced by R8B4, not a REST, accent/Unicode, ACL, SSO-provider, or selected-EFSM failure.

## Resolution

The route-catalog repair is isolated into follow-up slice:

`P117W_R45B2A4BZ2R8B4B_SECURITY_SSO_LOCALIZED_ROUTE_REPAIR`

R8B4B must add only the missing localized canonical route and preserve all current R8B4A2 modifications.

## Remaining R8B4 runtime gates after R8B4B

- Security must render `essai / security` from `config/security.fsm.json`.
- Security VIEW and DESIGN must use the same canonical selected-application definition.
- Security Conception STATE create must persist and survive reload.
- SSO view must expose real provider/default-provider metadata without secrets.
- Sources + Git must remain functionally unchanged.

Only after those gates may the owner commit/push OPUS/OWASYS.
