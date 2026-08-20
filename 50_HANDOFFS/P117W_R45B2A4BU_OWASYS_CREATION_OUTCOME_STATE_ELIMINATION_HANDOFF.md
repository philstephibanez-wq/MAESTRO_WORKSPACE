# P117W R45B2A4BU — OWASYS creation outcome-state elimination — HANDOFF

## Current status

DELIVERABLE READY / OWNER APPLY + RUNTIME VALIDATION REQUIRED

## Decision frozen

The creation FSM no longer models success/failure as dedicated stable states.

Canonical success:

`creation_review -> application_creating -> application`

with outcome signal `application_created` and action `set_current_app`.

Canonical failure:

`creation_review -> application_creating -> creation_review`

with outcome signal `application_creation_failed`, preserving the draft and rendering the existing SCORE error alert on the creation page.

States removed:

- `application_created`;
- `application_creation_failed`.

Signals retained:

- `application_created`;
- `application_creation_failed`.

## Baseline

OPUS `master`: `7038d0264e90b4bb83f124fa752f834ae5ee792d`.

Expected canonical blobs before A4BU:

- `config/fsm.json`: `86eadfd70eb2717cd951e85ab9b026853e6d4228`;
- `config/fsm.layout.json`: `9a8dff4970012db958f637e4ee8f6d5598e4ab80`;
- `CreationController.php`: `3a69ba9a1c31c7311ca590924fbbef97ab7440f2`.

A4BS/A4BT are compatible because they touch other files. A4BR remains separately pending.

## Delivery

`opus_p117w_r45b2a4bu_owasys_creation_outcome_state_elimination.zip`

ZIP SHA-256:

`fdb968ab2aa0fbc2255cc03fe945a8c3c8d2ca97739b9f82fdc3ca7965850f50`

The ZIP contains only the one-shot applicator `apply_a4bu.php`.

Applicator SHA-256:

`6bedea164020a0c15b19f154b952e89758bb23311d674f0d3fd72174ad3f8bff`

The applicator was PHP-linted before packaging and runs from Downloads; it is not installed in `H:\OPUS`.

## Delivered behavior

The A4BU applicator:

- refuses unexpected target baselines before changing anything;
- loads configuration through `StructuredFileLoader`;
- removes both result states from `fsm.json`;
- changes `t_creation_failed` to return to `creation_review`;
- removes `t_creation_failure_security`, `t_creation_failure_retry`, `t_creation_failure_cancel`;
- removes deleted states from global `from_states` lists;
- retains `t_creation_created -> application` and `set_current_app`;
- retains both outcome signals;
- makes `confirm-creation` valid only from `creation_review`;
- asserts the actual success target is `application`;
- asserts the actual failure target is `creation_review`;
- updates the controller so failure renders `creation_review` with the existing error payload;
- updates profiler terminal-state metadata to `application` or `creation_review`;
- reconciles persisted diagram geometry and sets its `definition_sha256` to SHA-256 of the exact new FSM bytes;
- computes all targets before writing and rolls back target files if a write/post-write verification fails;
- leaves no delivery script, backup or temporary file in the OPUS repository after success.

## Runtime validation

After application, lint and validate both OWASYS sites. Then inspect the FSM diagram: only `application_creating` remains as the transient creation-operation state; the two result-state nodes are gone.

Success must select the generated application immediately. Failure must display the creation review page with its error alert and leave the draft available for correction/retry.

## Do not do

- Do not rename or remove the two outcome signals.
- Do not introduce a replacement success/failure state.
- Do not hide obsolete nodes only in the diagram; remove them semantically from `fsm.json`.
- Do not weaken ACL or bypass REST/Composer.
- Do not mix the separate deletion-workflow correction into A4BU.
- Assistant does not commit/push OPUS/OWASYS.

## Next

After owner acceptance, the remaining broken application-deletion workflow is the next distinct OWASYS blocker if still prioritized.
