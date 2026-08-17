# P117W R45B2A4AI — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Owner correction now implemented

A4AH remains rejected. A4AI fixes the FSM model before presentation.

The mandatory owner flow is now explicit in the canonical state domain:

`Applications / registry`

`--create_new_app--> creation_basics`

`--continue_security--> creation_security`

`--continue_review--> creation_review`

`--begin_application_creation--> application_creating`

`--application_created--> application_created`

with explicit failure/retry branch:

`application_creating --application_creation_failed--> application_creation_failed`

`application_creation_failed --begin_application_creation--> application_creating`

## Delivered model

Base OPUS commit:

`316769d4a04a986aacedf0540c878d35b716e719`

Delivered principal FSM:

- 16 states;
- 50 typed signals;
- 55 canonical transitions;
- explicit state categories `system/screen/workflow/result`;
- creation wizard integrated into the principal FSM;
- `application_creating`, `application_created`, `application_creation_failed` are real states;
- separate `creation.wizard.fsm.json` is obsolete and must be deleted.

## Generic OPUS evolution

`FsmProcessor` gains finite ordinary globals:

- `scope: global`;
- explicit `from_states`;
- local exact transition precedence over global;
- validation of finite source applicability and ambiguity;
- NMI remains separate/preemptive.

OWASYS global navigation/logout families are modeled once rather than copied per state.

## Menu

- all canonical states are projected;
- state-specific local signal submenus restored;
- native exclusive autocollapse restored;
- global navigation emitted once on a global rail;
- global actions are not repeated below every state;
- clickable/cyan remains restricted to actual permitted route-backed navigation transitions;
- command/outcome relations remain visible but non-GET/non-cyan when no safe navigation URL exists.

## Diagram

`FsmDiagramBuilder` no longer depends on a hand-maintained `LOGICAL_STATE_ORDER` / `LOGICAL_EDGES` semantic sample.

The fixed diagram derives state order/layout and edges from canonical FSM data. Initial state remains the fixed root. Current state changes highlight only.

Smoke projection:

- 16 canonical states projected;
- 16 visible `logout -> login` source relations;
- fixed geometry metadata retained;
- typed signal/actionable-link behavior retained.

## Source/Git/build audit

The audit was performed before delivery.

Source/Git preview/write/stage/unstage/commit/restore are synchronous request operations whose subsequent capabilities are recalculated from the current source/Git repository state. They do not establish durable OWASYS session-FSM phases, so A4AI keeps them as typed command/outcome transitions rather than inventing persistent result states.

Build preview similarly starts synchronously then externally redirects to the returned local preview URL; server-process lifecycle is not owned by the OWASYS front session FSM.

Creation is the branch where phase genuinely changes valid next operations, so its workflow/result milestones are explicit states.

## Direct differential ZIP

Artifact:

`opus_p117w_r45b2a4ai_canonical_workflow_fsm_menu.zip`

SHA-256:

`38ad0d87a8e7a33a09fb413aad01d4df4d04dfd38290a7b7f831db638f311632`

Six complete replacement files:

1. `Opus/Fsm/FsmProcessor.php`
2. `sites/owasys-front/config/fsm.json`
3. `sites/owasys-front/application/default/services/NavigationBuilder.php`
4. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
5. `sites/owasys-front/application/default/templates/partials/navigation.score`
6. `sites/owasys-front/application/creation/controllers/CreationController.php`

Required owner-side deletion after extraction:

`sites/owasys-front/config/creation.wizard.fsm.json`

No patcher is part of this delivery.

## Pre-delivery checks passed

- PHP lint: all delivered PHP files OK;
- JSON decode: OK;
- no trailing whitespace;
- no stale wizard-FSM reference in payload;
- success creation chain smoke: OK;
- creation failure/retry smoke: OK;
- finite global resolution smoke: OK;
- local-over-global precedence smoke: OK;
- NMI preemption smoke: OK;
- 16-item menu projection smoke: OK;
- 16-state diagram / 16 logout-source projection smoke: OK.

## Owner validation required

Owner must now apply the ZIP to `H:\OPUS`, delete the obsolete secondary creation wizard FSM, run lint/diff/autoload, start `owasys-front`, and validate the real browser menu/diagram.

Do not mark A4AI functionally accepted before that owner run.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
