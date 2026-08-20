# P117W R45B2A4BV — OWASYS application deletion FSM workflow — handoff

State: DELIVERABLE READY — OWNER APPLY + RUNTIME VALIDATION REQUIRED

## Owner baseline

OPUS `master` expected before apply:

`86fb3a49ebde67c5f11631e81db122c47ca65674` — `opus_p117w_r45b2a4bu_owasys_creation_outcome_state_elimination`

A4BU is visible and committed on the owner repository. The next distinct blocker is the application-deletion path.

## Cause fixed by this delivery

The current diagram and source expose three coupled defects:

- `delete_current_application` targets the read-only `application` state and therefore does not lead to a deletion confirmation surface;
- the registry confirmation POST executes the destructive REST call before any user deletion signal is accepted by the main FSM;
- the automatic `application_deleted` transition clears the current application unconditionally, including when a different application was deleted.

A4BV fixes the workflow at the frontend orchestration/FSM boundary. The existing owasys-back REST -> Composer deletion implementation is reused unchanged.

## Resulting canonical flow

```text
menu delete_application -------------------------------> registry
menu delete_current_application -----------------------> registry

registry
  -- U:begin_application_deletion
       [app_exists, acl:registry:delete]
       {poke deletion_target} --------------------------> registry

  -- existing secured REST DELETE /api/v1/applications/{id}
       -> owasys-back
       -> allow-listed site.delete
       -> opus:delete-site

registry
  -- A:application_deleted
       / clear_deleted_app_context ---------------------> registry

registry
  -- A:registry_action_failed --------------------------> registry
```

The `begin_application_deletion` self-loop is intentionally operational: it establishes the authorized target in FSM runtime state before the external side effect.

No result state is added.

## Current-context rule

`clear_deleted_app_context` compares the deleted application ID with the selected front-session application ID.

- deleted app != current app: no current-context change;
- deleted app == current app: canonical current context is cleared through the existing registry/session boundary.

This replaces the previous unconditional `clear_current_app` action on `application_deleted`.

## Failure rule

If REST/backend/Composer deletion fails:

- no success outcome is emitted;
- existing automatic signal `registry_action_failed` is persisted;
- registry is rendered without redirect using the pre-delete registry snapshot;
- SCORE shows only a sanitized machine error code;
- profiler records the failure without confirmation text, credentials or tokens.

## Files changed by applicator

- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/config/fsm.layout.json`
- `sites/owasys-front/application/registry/controllers/RegistryController.php`
- `sites/owasys-front/application/default/controllers/RuntimeController.php`
- `sites/owasys-front/application/default/services/FsmActionHandlers.php`
- `sites/owasys-front/application/registry/templates/index.score`

No `sites/owasys-back` file is changed.

## Baseline guards

- `fsm.json`: `3a194f8476a22d46e746eeafd0c0fdbb024ca17e`
- `fsm.layout.json`: `5acfbc0906f7197a31edae5d5744bca6580ecd76`
- `RegistryController.php`: `486e069ac655df1bd156aad3001ddc438d2f57be`
- `RuntimeController.php`: `af691b4966e2b52f3cb40ecad5d7d6ee2b78b75f`
- `FsmActionHandlers.php`: `ef7a9aa52cc22a65f0b11431171d217e4b7227e3`
- registry `index.score`: `173b156c6fc064801891d5aa1fc6c998fb0b8df4`

The applicator refuses an incompatible baseline and rolls back already-written targets on write/verification failure.

## Artifact

`opus_p117w_r45b2a4bv_owasys_application_deletion_fsm_workflow.zip`

SHA-256:

`87cd6a42e625f1a24722fc32b2d126d44ca4551cef3877d69de18472d418133d`

ZIP content:

- `apply_a4bv.php`

Applicator SHA-256:

`307137cf789e0bc038b229a54539ceb0db6dd608c093054c98dd90b3096bed2d`

Applicator lint: OK under PHP 8.4.23.

## Owner apply commands

```cmd
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4bv_owasys_application_deletion_fsm_workflow.zip" -C "%USERPROFILE%\Downloads"
cd /d H:\OPUS
php "%USERPROFILE%\Downloads\apply_a4bv.php"
php -l sites\owasys-front\application\registry\controllers\RegistryController.php
php -l sites\owasys-front\application\default\controllers\RuntimeController.php
php -l sites\owasys-front\application\default\services\FsmActionHandlers.php
composer opus:validate-site -- owasys-front
composer opus:dev-server -- owasys-front
```

## Expected command results

Applicator:

`P117W_R45B2A4BV_APPLIED`

All PHP lint commands:

`No syntax errors detected ...`

Site validation:

- valid OWASYS front site;
- canonical FSM loads;
- no duplicate signal/transition ID;
- layout definition hash matches the modified FSM.

## Browser acceptance

1. Open OWASYS front and select a generated application.
2. Open FSM: `delete_current_application` must target `registry`, not self-target `application`.
3. Applications -> Delete must present the existing confirmation UI.
4. Confirm deletion of a generated application that is not current: it disappears, current application remains selected.
5. Confirm deletion of the current generated application: it disappears and current context is cleared.
6. Invalid confirmation: no deletion.
7. Verify profiler trace for a successful deletion contains `application.delete.requested` and `application.delete.succeeded`, with correlated REST/backend/Composer activity.

## Workspace references

Specification:

`40_SPECS/P117W_R45B2A4BV_OWASYS_APPLICATION_DELETION_FSM_WORKFLOW_SPEC.md`

Specification commit:

`64c1d36b9da0feb32cb9454c426dbe59524ef593`

## NEXT

After owner runtime acceptance of A4BV, reassess the remaining FSM graph strictly from the new live diagram and observed workflow behavior. Do not start a new topology change from the pre-A4BV graph.
