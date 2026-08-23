# P117W R45B2A4BZ2R8B4A2 — Applicator profiler anchor repair handoff

State: DIFFERENTIAL INTEGRATED — CLI AND RUNTIME VALIDATION PENDING

## Exact OPUS baseline

`76b59191492f4efabf343e85be841f4832fe0ced`

`opus_p117w_r45b2a4bz2r8b2_actual_graphical_handler_authoring`

Owner evidence after the R8B4A1 failure:

- preflight began;
- applicator aborted on `named-efsm-profiler-received:2`;
- `git status --short` remained empty.

Therefore R8B4A1 wrote nothing and the same exact clean R8B2 baseline remained the required R8B4A2 input.

## Failure evidence

`P117W_R45B2A4BZ2R8B4A_PREFLIGHT_BEGIN`

`P117W_R45B2A4BZ2R8B4A_REPLACEMENT_ANCHOR_INVALID:sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php:named-efsm-profiler-received:2`

## Root cause

The failed R8B4A1 applicator used this payload prefix as a uniqueness anchor:

`'site_id' => $siteId,`

`'operation' => $operation,`

The exact R8B2 backend source contains that prefix in both profiler events:

- `designer.draft_command.received`;
- `designer.draft_command.validated`.

The count `2` was therefore correct. No OPUS source mismatch existed.

## R8B4A2 correction

R8B4A2 changes only the applicator anchoring for the two backend profiler injections:

- `named-efsm-profiler-received` is anchored by the full semantic `designer.draft_command.received` event prefix;
- `named-efsm-profiler-validated` is anchored by the full semantic `designer.draft_command.validated` event prefix.

The uniqueness requirement remains exactly one occurrence. No global replacement and no relaxed occurrence count are used.

All R8B4 functional transformations, target paths, expected Git blobs, runtime validation, transactional write/rollback logic, success markers and architecture remain unchanged.

## Artifact

`opus_p117w_r45b2a4bz2r8b4a2_applicator_profiler_anchor_repair.zip`

ZIP SHA-256:

`633fc827ec76df3244f495a92a5e20519ffcdc7348e2e023e47f6d292fad79bc`

Contents exactly:

- `apply_a4bz2r8b4a2.php`

Applicator SHA-256:

`9565f7a1c057089e7328878e432346f49edef338d8f71f26973ece61263f1dfc`

Applicator length: `81990` bytes.

## Assistant-side validation

Completed before delivery:

- source R8B4A1 applicator SHA verified as `5bea0c21d78db31ca0eacea96eb311f93152f7e6577252efc8029aaada5a8538`;
- exact R8B2 backend file fetched and inspected;
- exact baseline confirms the ambiguous payload prefix exists in both `received` and `validated` profiler events;
- R8B4A1 -> R8B4A2 diff inspected: only the two profiler anchor definitions changed;
- PHP lint of `apply_a4bz2r8b4a2.php`: OK;
- deterministic profiler-anchor simulation: old ambiguous count `2`, new qualified counts `received=1`, `validated=1`;
- marker: `R8B4A2_PROFILER_ANCHOR_SIMULATION_OK`;
- remaining transformations after the failed point were statically reviewed for the same ambiguity class;
- ZIP inspection: exactly one file.

## Owner integration evidence — 2026-08-24

The owner applied R8B4A2 to `H:\OPUS` and then reported `git status --short` with exactly the expected 15-path differential:

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

This exactly matches the normative R8B4 product differential. The applicator integration gate is therefore satisfied at the repository-differential level.

The owner has not yet supplied the complete applicator success-marker output in the current evidence. CLI validation and runtime acceptance therefore remain pending. No commit/push is authorized yet.

## Required CLI validation

Run PHP lint on all modified PHP files, JavaScript syntax validation on `fsm-designer.js`, Composer optimized autoload, then validate the three sites:

- `owasys-front`;
- `owasys-back`;
- `essai`.

The 15-path differential must remain present after those checks.

## Runtime gates after CLI acceptance

- Security for selected `essai` must project `essai / security` from `config/security.fsm.json`.
- Structure must project `essai / navigation` from `config/application.fsm.json`.
- Security Conception STATE create must persist and survive reload.
- SSO view must expose real provider/default-provider metadata without secrets.
- Sources + Git must remain functionally unchanged.

Only after those runtime gates may the owner commit/push OPUS/OWASYS.

## Next slice after acceptance

SecurityContext ownership plus first Security/Navigation inter-EFSM COMMAND/EVENT cooperation, followed by generic generated-application PHP ACTION/GUARD source authoring.