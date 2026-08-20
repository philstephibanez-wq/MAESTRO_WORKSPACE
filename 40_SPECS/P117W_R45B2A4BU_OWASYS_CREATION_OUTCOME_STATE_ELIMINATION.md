# P117W R45B2A4BU — OWASYS creation outcome-state elimination

## Status

DELIVERABLE PREPARED / OWNER APPLY + RUNTIME ACCEPTANCE PENDING

## Canonical baseline

- OPUS `master`: `7038d0264e90b4bb83f124fa752f834ae5ee792d`.
- `sites/owasys-front/config/fsm.json` blob: `86eadfd70eb2717cd951e85ab9b026853e6d4228`.
- `sites/owasys-front/config/fsm.layout.json` blob: `9a8dff4970012db958f637e4ee8f6d5598e4ab80`.
- `sites/owasys-front/application/creation/controllers/CreationController.php` blob: `3a69ba9a1c31c7311ca590924fbbef97ab7440f2`.

A4BS and A4BT touch disjoint frontend files and may remain locally applied while A4BU is applied. A4BR fresh-generation acceptance remains a separate pending gate.

## Owner decision

Creation has only two outcomes after `application_creating`:

- success: the created application is selected automatically;
- failure: an alert is rendered on the creation review page.

A successful or failed operation outcome is not a stable application navigation state.

Therefore the states `application_created` and `application_creation_failed` are non-canonical and must not exist.

The outcome signals remain canonical:

- `application_created`;
- `application_creation_failed`.

## Root cause

The current site FSM models both operation outcomes and stable UI states at the same level. This leaves result-state nodes in the diagram even though success already transitions directly from `application_creating` to `application` with `set_current_app`, while failure only needs to return the user to the review form with an error.

That duplicated semantic layer makes the workflow misleading and introduces unnecessary recovery transitions from a dedicated failure state.

## Canonical FSM

Success:

`creation_review --begin_application_creation--> application_creating --application_created--> application`

The success transition keeps action `set_current_app`. The created application is therefore the current application immediately after creation.

Failure:

`creation_review --begin_application_creation--> application_creating --application_creation_failed--> creation_review`

The draft remains present. The controller renders the existing SCORE creation page with the existing error alert, trace id and error code. Retry is the ordinary `confirm-creation` action from `creation_review`; no failure-state retry transition is needed.

## Required removals

Remove states:

- `application_created`;
- `application_creation_failed`.

Remove failure-only transitions:

- `t_creation_failure_security`;
- `t_creation_failure_retry`;
- `t_creation_failure_cancel`.

Keep `t_creation_created`, already targeting `application`, and keep both outcome signals.

Change `t_creation_failed.next_state` to `creation_review`.

Remove both deleted state ids from every global transition `from_states` array.

## Controller contract

`OwasysCreationController` must:

- accept `confirm-creation` only from `creation_review`;
- keep `application_created` as the success signal;
- record successful terminal FSM state as `application`;
- keep `application_creation_failed` as the failure signal;
- persist the failure transition to `creation_review`;
- record failed terminal FSM state as `creation_review`;
- render `creation_review` with the existing error payload and SCORE alert.

No new template or translation key is needed: the current creation template already renders `creation.has_error` as `role=alert` above the creation wizard.

## Persisted diagram layout

The persisted layout must be reconciled with the semantic FSM change:

- remove the two deleted state geometry entries;
- remove geometry for the three deleted failure-only transitions;
- discard the old `t_creation_failed` route geometry so OPUS recomputes that edge for the new `creation_review` target;
- preserve all unrelated geometry;
- update `definition_sha256` to the resulting `fsm.json` bytes.

## Scope

Exactly three existing OWASYS frontend source/config files are modified by the applicator:

- `sites/owasys-front/config/fsm.json`;
- `sites/owasys-front/config/fsm.layout.json`;
- `sites/owasys-front/application/creation/controllers/CreationController.php`.

No backend change. No REST change. No Composer business command change. No ACL weakening. No JavaScript. No generated application change.

## Delivery format

The delivery is a strict one-shot applicator ZIP executed from Downloads against `H:\OPUS`. The applicator is not copied into the OPUS source root. It validates the three canonical Git blobs after LF normalization before any write, computes all three target contents in memory, then writes them with rollback-on-write-failure semantics.

## Acceptance

1. Apply A4BU against the expected canonical target files.
2. Lint `CreationController.php`.
3. Validate `owasys-front` and `owasys-back` through normal OPUS validation.
4. Open the OWASYS FSM diagram and confirm neither `application_created` nor `application_creation_failed` exists as a state node.
5. Confirm the signals `application_created` and `application_creation_failed` still exist.
6. Create an application successfully: transition reaches `application`, `set_current_app` executes, and the created application is current.
7. Force/observe a creation failure: transition returns to `creation_review`; the creation page remains displayed with an error alert, trace id and error code; the draft remains available for correction/retry.
8. Confirm no dedicated failure-state recovery transition remains.
9. Confirm persisted layout continues to load for unrelated nodes/cards.
10. Owner alone commits/pushes OPUS after runtime acceptance.

## Separate blocker

The broken application-deletion workflow remains a separate OWASYS blocker. It is not mixed into this creation-state correction and remains the next root-cause package if still prioritized after A4BU acceptance.
