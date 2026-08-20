# P117W R45B2A4BV — OWASYS application deletion FSM workflow

State: DELIVERABLE READY — OWNER APPLY + RUNTIME VALIDATION REQUIRED

## Baseline

OPUS owner `master`:

`86fb3a49ebde67c5f11631e81db122c47ca65674` — `opus_p117w_r45b2a4bu_owasys_creation_outcome_state_elimination`

A4BU is therefore considered applied by the owner. Its visible result is the canonical creation sequence with `application_creating` as the only transient creation state.

## Root cause

The remaining application-deletion path is not yet a canonical FSM-driven workflow.

Current facts on the A4BU baseline:

1. menu signal `delete_application` routes to `registry`, where generated applications expose the SCORE confirmation form;
2. menu signal `delete_current_application` routes back to `application`, even though the `application` SCORE template is read-only and contains no deletion confirmation surface;
3. the registry controller executes `OwasysRegistryModel::delete()` before the main OWASYS FSM receives any user deletion command; it then emits only the automatic outcome `application_deleted`;
4. `t_delete_app` executes `clear_current_app` unconditionally, so deleting an application other than the selected one also clears the selected application context;
5. the existing secure transport chain is already correct and must be reused unchanged: front `DELETE /api/v1/applications/{id}` -> owasys-back -> allow-listed Composer operation `site.delete` -> `opus:delete-site`.

The cause is therefore frontend workflow orchestration, not backend Composer execution.

## Canonical contract

A4BV keeps deletion on the existing registry surface and makes the destructive confirmation itself an FSM command.

### Menu entry

Both deletion menu operations converge on `registry`:

```text
GLOBAL U:delete_application ---------------------------------------> [registry]
GLOBAL U:delete_current_application [current_app_required] --------> [registry]
```

`delete_current_application` no longer self-targets the read-only `application` state.

### Confirmed deletion

The registry confirmation form no longer performs the REST deletion inside `RegistryController`.

A valid confirmation produces the new user signal:

```text
[registry]
  -- U:begin_application_deletion
       [app_exists, acl:registry:delete]
       {runtime: poke deletion_target} ----------------------------> [registry]
```

This registry self-loop is an operational transition, not a pure navigation loop: it records the target and authorizes the destructive operation before the side effect begins.

Only after this transition has succeeded and been persisted may `RuntimeController` invoke the existing secured REST deletion.

### Success

The existing automatic outcome remains canonical:

```text
[registry]
  -- A:application_deleted
       / clear_deleted_app_context -------------------------------> [registry]
```

`clear_deleted_app_context` clears the selected application context only when the deleted application is the selected application. Deleting another generated application leaves the current context intact.

### Failure

A REST/backend/Composer failure emits the already-existing automatic `registry_action_failed` self-loop. The registry page is rendered without redirect and exposes a sanitized error code through SCORE. No exception message, credentials, token or request secret is rendered.

No stable `application_deleted` or `application_deletion_failed` result state is introduced.

## Profiler contract

The existing correlated request/REST/backend/Composer profiler chain remains authoritative. A4BV adds frontend workflow events:

- `owasys.registry / application.delete.requested`;
- `owasys.registry / application.delete.succeeded`;
- `owasys.registry / application.delete.failed`;
- `owasys.registry / application.delete.failure_transition_failed` only if the failure outcome itself cannot be persisted.

Only application ID and sanitized error code are attached; no confirmation secret or authentication material is recorded.

## SCORE/UI contract

- deletion confirmation remains SCORE-only in `application/registry/templates/index.score`;
- no HTML/PHP mixed rendering is introduced;
- failed deletion remains on the registry page and displays the existing localized deletion label plus a sanitized machine error code;
- `owasys-front` remains the only browser application;
- `owasys-back` receives no JavaScript, template or UI change.

## FSM persisted geometry

Existing manually persisted coordinates remain untouched.

Because `g_delete_current_application` changes target from `application` to `registry`, its stale persisted transition geometry is removed from `fsm.layout.json` so the diagram renderer derives the new edge from the canonical topology. `definition_sha256` is regenerated from the exact resulting `fsm.json` bytes.

No state is added or removed.

## Differential target files

The one-shot A4BV applicator changes only these final OPUS paths:

- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/config/fsm.layout.json`
- `sites/owasys-front/application/registry/controllers/RegistryController.php`
- `sites/owasys-front/application/default/controllers/RuntimeController.php`
- `sites/owasys-front/application/default/services/FsmActionHandlers.php`
- `sites/owasys-front/application/registry/templates/index.score`

No backend file is changed.

## Baseline blob guards

The applicator refuses to write unless the relevant A4BU baseline blobs are present:

- `fsm.json`: `3a194f8476a22d46e746eeafd0c0fdbb024ca17e`
- `fsm.layout.json`: `5acfbc0906f7197a31edae5d5744bca6580ecd76`
- `RegistryController.php`: `486e069ac655df1bd156aad3001ddc438d2f57be`
- `RuntimeController.php`: `af691b4966e2b52f3cb40ecad5d7d6ee2b78b75f`
- `FsmActionHandlers.php`: `ef7a9aa52cc22a65f0b11431171d217e4b7227e3`
- registry `index.score`: `173b156c6fc064801891d5aa1fc6c998fb0b8df4`

The script writes all changed files transactionally at applicator level and restores already-written originals if a later write/verification fails.

## Delivery

Artifact:

`opus_p117w_r45b2a4bv_owasys_application_deletion_fsm_workflow.zip`

ZIP SHA-256:

`87cd6a42e625f1a24722fc32b2d126d44ca4551cef3877d69de18472d418133d`

Contained one-shot applicator:

`apply_a4bv.php`

Applicator SHA-256:

`307137cf789e0bc038b229a54539ceb0db6dd608c093054c98dd90b3096bed2d`

The applicator is run from outside `H:\OPUS` and is not installed into the source tree.

## Required owner validation

After applying A4BV:

1. PHP lint must pass on the three changed PHP classes/controllers plus the applicator;
2. `composer opus:validate-site -- owasys-front` must remain valid;
3. the FSM diagram must show `delete_current_application` targeting `registry` rather than `application`;
4. `begin_application_deletion` must be a user-origin command on `registry`;
5. deleting a non-current generated application must not clear the current application;
6. deleting the current generated application must clear its current context and return to registry;
7. protected applications `owasys-front` and `owasys-back` must still be non-deletable;
8. an invalid confirmation must perform no REST deletion and remain on registry;
9. a backend deletion failure must remain on registry and expose only a sanitized error code;
10. profiler traces must retain the front -> REST -> back -> Composer -> response correlation and include the new deletion workflow events.
