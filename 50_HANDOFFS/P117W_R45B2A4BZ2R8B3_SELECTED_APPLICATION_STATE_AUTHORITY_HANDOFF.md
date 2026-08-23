# P117W R45B2A4BZ2R8B3 — Selected application EFSM authority + persistent STATE CRUD handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Baseline

OPUS HEAD/master:

`76b59191492f4efabf343e85be841f4832fe0ced`

`opus_p117w_r45b2a4bz2r8b2_actual_graphical_handler_authoring`

The owner has recreated `essai` on this baseline and reports that Conception displays the wrong FSM and cannot create a STATE.

## Artifact

`opus_p117w_r45b2a4bz2r8b3_selected_application_state_authority.zip`

ZIP SHA-256:

`0960240316e577f3546085c83995203e5e64327eee383a20412ea177dd1a34db`

Applicator SHA-256:

`a5eb34105dc1e1489c0ac826469eb6950d5a4033165620484165c24a52128e96`

Contents:

- `apply_a4bz2r8b3.php`

The assistant does not commit/push OPUS or OWASYS.

## Confirmed causes addressed

- design diagram source was the OWASYS host FSM rather than current selected application;
- front semantic command target was hardcoded `owasys-front`;
- back semantic source path was hardcoded `config/fsm.json`;
- R8B2 JavaScript has a temporal-dead-zone reference to `handlerSourceEditor`, aborting designer initialization;
- generated FSMs omit the canonical `signals` registry required by `FsmDefinitionValidator`;
- profiler environment normalization removes the profiler state without removing all profiler transitions/signals;
- `FsmSiteLoader` incorrectly maps a pure state without `module` to an implicit module named by the state ID.

## Resulting authority chain

Conception for selected `essai`:

`current application session -> OwasysApplicationFsmModel -> OwasysSourceModel -> secured REST -> essai/config/application.fsm.json`

STATE mutation:

`browser semantic command -> owasys-front -> secured REST -> owasys-back -> allow-listed Composer -> FsmSiteLoader canonical resolver -> FsmDefinitionEditor/Validator -> SiteSourceWorkspace atomic write -> essai/config/application.fsm.json`

The browser cannot choose the target application ID.

## STATE persistence contract

`state.create`, `state.rename`, `state.delete` are persisted immediately after backend semantic validation.

For persistent STATE operations:

- command history must be empty;
- handler catalog is not required;
- response remains `OWASYS_EFSM_DRAFT_COMMAND_RESULT_V2` for compatibility but adds `persisted=true`, `source_path`, `source_sha256` and returns the new `base_sha256`;
- `history_count=0` after persistence;
- browser reloads current design URL, preserving `fsm_design=1` and re-reading the canonical FSM.

`transition.handlers.update` remains separate and still requires a real handler catalog.

## Generated `essai` repair

The R8B2-generated file currently has states `begin` and `home` but still contains profiler transitions and no signal registry. R8B3 migrates it to a valid canonical definition with `open_home` declared as `origin=user` and no profiler residue.

Future generated sites are fixed at the scaffold-policy source so the same defect is not regenerated.

## Handler safety

The existing graphical PHP handler source authority belongs to OWASYS-front. R8B3 does not silently reuse it for `essai`.

When selected application is not `owasys-front`, handler authoring/binding capability is disabled while STATE CRUD remains active. A later slice can establish a target-specific developer handler source contract for generated applications.

## Differential paths

Exactly 10 tracked files are modified:

1. `Opus/Fsm/FsmSiteLoader.php`
2. `Opus/Scaffold/ProfilerEnvironmentScaffoldPolicy.php`
3. `Opus/Scaffold/SiteScaffoldPlan.php`
4. `sites/essai/config/application.fsm.json`
5. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
6. `sites/owasys-front/application/default/services/FsmDesignerGateway.php`
7. `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`
8. `sites/owasys-front/application/default/services/ScorePageRenderer.php`
9. `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
10. `sites/owasys-front/www/asset/js/fsm-designer.js`

No backend JavaScript/TypeScript/Node artifact is introduced.

## Applicator verification performed before delivery

- final applicator `php -l`: OK;
- ZIP contains exactly `apply_a4bz2r8b3.php`;
- exact current OPUS HEAD and all 10 current Git blob IDs were audited through the connected GitHub repository and embedded as blocking preflight values;
- every replacement anchor was derived from the audited current source sections;
- applicator stages every transformed file in memory before writing;
- transformed PHP is parsed with native `TOKEN_PARSE` by the applicator before any write;
- transformed JSON is decoded with `JSON_THROW_ON_ERROR` before any write;
- write phase is atomic per file with full-byte rollback of earlier files on failure.

The private owner checkout is not materialized in the assistant runtime, so live Windows Composer/site validation, SCORE rendering, secured REST and browser JavaScript execution are owner acceptance gates and are not claimed as executed here.

## Expected applicator markers

`P117W_R45B2A4BZ2R8B3_APPLIED`

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
- `changed_paths=10`

## Owner commands / gate

Apply, lint the changed PHP/JS, regenerate autoload and validate all three applications. Then restart OWASYS front/back, select `essai`, enter Conception, create one temporary STATE and confirm it survives the automatic reload.

Do not commit/push R8B3 until that runtime gate succeeds.