# P117W R45B2A4BZ2R8B4A — Handoff contextual Security + Navigation micro-EFSM foundation

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Baseline

OPUS owner/master exact baseline:

`76b59191492f4efabf343e85be841f4832fe0ced`

`opus_p117w_r45b2a4bz2r8b2_actual_graphical_handler_authoring`

R8B4A is consolidated directly from R8B2 and supersedes the previously prepared/non-integrated R8B3 package.

## Owner evidence

On selected application `essai`, `/fr-FR/sécurité` still displays the large OWASYS host navigation EFSM rather than a Security micro-EFSM. The owner also reports no repository changes after the prior package attempt.

The supplied runtime logs show:

- front GET `/fr-FR/sécurité` completes normally;
- back receives GET `/api/v1/applications/essai/security`;
- allow-listed Composer `owasys:security-snapshot` succeeds;
- REST returns status 200.

Therefore the selected-application Security data authority is already live; the wrong graph is caused by global host-FSM projection in the SCORE renderer/diagram builder, not by Security REST and not by cache.

## Artifact

`opus_p117w_r45b2a4bz2r8b4a_contextual_security_navigation_micro_efsm_foundation.zip`

ZIP SHA-256:

`7df993e64b703f10a4a45979f9314d15c0ab46fcec0bfbd517d107f9dc20433e`

Contents exactly:

- `apply_a4bz2r8b4a.php`

Applicator SHA-256:

`3ef0de4793ae1e39fbd591da6eea04756589a46500454f9fa9709e87df76d999`

The assistant does not commit/push OPUS or OWASYS.

## Delivered foundation

R8B4A establishes the generic named micro-EFSM authority required by the newly locked architecture:

- `site.json.efsms` registry for generated applications;
- generic `FsmSiteLoader::resolveEfsm()` + processor helper;
- pure EFSM STATE no longer implies an application module;
- generated navigation/app FSM declares its SIGNAL registry;
- generated Security micro-EFSM uses runtime-compatible contract `OPUS_SECURITY_FSM_V1`;
- generated backend registers semantic `rest` + `security`, not UI navigation;
- current `essai` is migrated with `navigation` + `security` registry and `config/security.fsm.json`;
- Security context projects selected `essai/security` in VIEW and DESIGN;
- Structure context projects selected `essai/navigation` in VIEW and DESIGN;
- other unsplit OWASYS domains remain explicitly on host navigation until their own slice;
- visible authority banner shows application, EFSM id, canonical source path and SHA;
- STATE create/rename/delete persists through front -> secured REST -> back -> allow-listed Composer -> OPUS definition editor -> atomic source write;
- JS temporal-dead-zone bug is removed;
- STATE Create opens directly instead of requiring a hidden second canvas click;
- generated-app handler authoring remains disabled instead of being misdirected to OWASYS-front source;
- Security gains a dedicated SSO/provider view backed by the real Security snapshot, without exposing secret values;
- existing Users/Roles/Permissions/Assignments/Resources Security UI and controlled mutation flow remain reused;
- Sources + Git is not functionally rewritten.

## Security micro-EFSM skeleton

`config/security.fsm.json` contains:

STATE:

- anonymous;
- authenticating;
- authenticated;
- reauthenticating.

SIGNAL:

- login_requested;
- authentication_succeeded;
- authentication_failed;
- logout_requested;
- session_expired;
- reauth_required;
- reauthentication_succeeded;
- reauthentication_failed.

Users, roles and SSO providers remain Security data/services and never become STATE.

## Exact differential

14 tracked paths modified + 1 new path:

1. `Opus/Fsm/FsmSiteLoader.php`
2. `Opus/Scaffold/ProfilerEnvironmentScaffoldPolicy.php`
3. `Opus/Scaffold/SiteScaffoldPlan.php`
4. `sites/essai/config/application.fsm.json`
5. `sites/essai/config/site.json`
6. `sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`
7. `sites/owasys-front/application/security/controllers/SecurityController.php`
8. `sites/owasys-front/application/security/templates/index.score`
9. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
10. `sites/owasys-front/application/default/services/FsmDesignerGateway.php`
11. `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`
12. `sites/owasys-front/application/default/services/ScorePageRenderer.php`
13. `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
14. `sites/owasys-front/www/asset/js/fsm-designer.js`
15. `sites/essai/config/security.fsm.json` (new)

No JavaScript/TypeScript/Node artifact is introduced under `sites/owasys-back`.

## Applicator safety

Before any write the applicator:

- requires exact HEAD R8B2;
- requires a clean tracked worktree/index;
- verifies exact Git blob SHA for every tracked target;
- refuses if the new Security FSM path already exists;
- stages every transformation in memory;
- parses every resulting PHP file with `TOKEN_PARSE`;
- parses every resulting JSON file;
- loads the existing Composer autoloader;
- validates current repaired `essai` navigation and new Security definitions with `FsmDefinitionValidator`;
- instantiates both definitions with the actual `FsmProcessor` to verify runtime contract/transition compatibility;
- only then performs atomic file writes;
- rolls back all prior bytes/new files on write failure;
- verifies every tracked target actually appears in Git diff and the new Security file exists before declaring success.

The applicator itself has been linted successfully and the ZIP has been inspected to contain exactly that applicator.

The assistant runtime does not possess the owner's private Windows checkout, so Windows Composer validation, secured REST execution after the patch, SCORE rendering and browser JS interaction remain owner acceptance gates and are not claimed as run here.

## Expected applicator markers

`P117W_R45B2A4BZ2R8B4A_PREFLIGHT_BEGIN`

`P117W_R45B2A4BZ2R8B4A_PREFLIGHT_OK`

`P117W_R45B2A4BZ2R8B4A_REPO_CHANGES_VERIFIED`

`P117W_R45B2A4BZ2R8B4A_APPLIED`

Then:

- `baseline_head=76b59191492f4efabf343e85be841f4832fe0ced`
- `designer_source=selected_application_canonical_efsm`
- `designer_transport=front_rest_back`
- `state_create=direct_persistent`
- `state_persistence=back_composer_atomic_source_write`
- `pure_state_module_coupling=removed`
- `generated_signals=canonical_declared`
- `profiler_fsm_residue=removed_at_scaffold_policy`
- `essai_fsm=repaired`
- `handler_authoring_non_owasys_front=isolated_not_misdirected`
- `javascript_tdz=removed`
- `efsm_registry=generic_named`
- `contextual_authority=view_and_design`
- `security_micro_efsm=generated_and_migrated`
- `navigation_micro_efsm=application_fsm_contextualized`
- `security_sso_view=real_provider_snapshot`
- `security_context_view=security`
- `navigation_context_view=structure`
- `changed_paths=15`

## Owner acceptance sequence

1. Apply the ZIP from exact clean R8B2.
2. Confirm the applicator prints the repo-change marker and `git status --short` lists actual changes.
3. Run PHP lint / JS syntax / Composer autoload / site validations.
4. Restart OWASYS front and back.
5. Select `essai`.
6. Open Security: graph authority must be `application: essai`, `efsm: security`, source `config/security.fsm.json`; graph must be the small Security skeleton, not OWASYS host monolith.
7. Open Structure: graph authority must be `application: essai`, `efsm: navigation`, source `config/application.fsm.json`; graph must be the selected application's navigation skeleton.
8. Open Security Conception, create a temporary STATE and verify automatic reload keeps the STATE.
9. Open the new Security SSO view and confirm real provider/default-provider data is displayed without secrets.
10. Confirm Sources + Git still behaves as before.

Do not commit/push R8B4A until those runtime gates succeed.

## Next slice after acceptance

The next slice is the actual runtime cooperation layer: SecurityContext ownership + first Security/Navigation inter-EFSM COMMAND/EVENT transport, then generic generated-application PHP ACTION/GUARD source authoring from the contextual diagram. R8B4A deliberately establishes canonical authority first so those runtime actions cannot target the wrong EFSM/source.
