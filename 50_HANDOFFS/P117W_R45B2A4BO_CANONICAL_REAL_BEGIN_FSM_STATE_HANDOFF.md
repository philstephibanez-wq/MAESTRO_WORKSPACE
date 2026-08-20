# P117W R45B2A4BO — Handoff

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

- OPUS GitHub `master`: `7ded8369167fa6d75df7f0cf6b33b67a45a5d626` — A4BN.
- A4BO is a complete-file differential over that committed owner baseline.
- Menu work remains frozen.

## Owner decision

The A4BN pseudo-state model is no longer the target for canonical OPUS application FSMs. `begin` must be a real default FSM state, not a presentation-only circle.

## Root cause treated

Previously, `initial_state` pointed directly to a functional state (`login` in OWASYS front, `api` in OWASYS back) and the diagram manufactured a white pseudo begin point. Therefore the displayed `begin` concept did not exist in runtime FSM semantics.

A4BO removes that semantic mismatch for OWASYS and adds the corresponding generic processor/diagram contract.

## A4BO behavior

### Generic processor

A canonical entry state is declared as `id=begin`, `type=entry` and must be the unique FSM `initial_state`.

`FsmProcessor` already initializes/reset to `initial_state`; with this definition the runtime state is genuinely `begin` before the first signal.

No missing `begin` is synthesized. Legacy definitions without entry state remain readable.

### Diagram

Canonical entry-state FSMs render `begin` as an ordinary FSM state node. It inherits the normal state right-drag/persistence behavior.

The white pseudo initial marker is suppressed only when the initial state is a real `type=entry` state. Legacy initial-marker rendering remains compatible for old definitions.

### Layout

Layout contract stays `OPUS_FSM_DIAGRAM_LAYOUT_V4`.

For canonical entry-state definitions, marker geometry is not part of the known marker set. Stale `markers.initial` therefore normalizes away, while real `begin` x/y uses ordinary state geometry.

### OWASYS front

- initial state: `begin`;
- explicit real `begin` state, type `entry`;
- `begin --open_login--> login`;
- finite global sources that previously admitted `login` at startup now explicitly admit `begin` too;
- unauthenticated runtime reset now occurs only if the current restored state itself requires authentication, so legitimate unauthenticated `login` is preserved after leaving `begin`.

### OWASYS back

- initial state: `begin`;
- real entry state `begin`;
- `begin --receive--> api`;
- no JavaScript/backend presentation code added.

## Artifact

`opus_p117w_r45b2a4bo_canonical_real_begin_fsm_state.zip`

SHA-256:

`bdd2563535f5886652da1bc2b7f5bfc0ad60205809cc1e380d9a61821d4282c5`

Exactly 6 complete files:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Fsm/FsmDiagramLayoutStore.php`
- `Opus/Fsm/FsmProcessor.php`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/application/default/controllers/RuntimeController.php`
- `sites/owasys-back/config/fsm.json`

No menu file.

## Validation performed

- PHP lint: 4/4 OK;
- both modified FSM JSON files parse successfully;
- generic processor smoke: `initialState=currentState=begin`, explicit begin transition succeeds, `reset()` returns to begin;
- invalid canonical begin (`type != entry`) rejected;
- entry state not equal to `initial_state` rejected;
- OWASYS front config smoke: begin -> login through `open_login`;
- OWASYS back config smoke: begin -> api through `receive`;
- diagram smoke: real `begin` node emitted with `entry current` class and pseudo initial marker absent;
- legacy diagram smoke: pseudo marker still emitted for legacy non-entry initial state;
- layout smoke: canonical entry definition exposes no initial pseudo marker while legacy definition still does;
- no trailing whitespace in delivered PHP/JSON files;
- ZIP contains exactly the six expected complete files.

## Scope boundary

A4BO intentionally does not rewrite existing generated application source files at runtime and does not use a hidden scaffold fallback.

The next required propagation milestone is Composer scaffold generation (`SiteScaffoldPlan`), so every newly generated OPUS frontend/fullstack/backend application is born with canonical `begin` semantics. Until that scaffold milestone is delivered, A4BO acceptance concerns the generic semantic capability plus the two OWASYS applications migrated here.

## Owner application

Apply A4BO over committed A4BN. Keep the existing OWASYS `fsm.layout.json`; do not delete it. The old pseudo-marker geometry should normalize away because `begin` is now a real state.

Validation sequence:

1. start `owasys-front` in DEV;
2. open FSM and confirm the white pseudo point is gone;
3. confirm `begin` appears as a normal state box and can be right-dragged like every other state;
4. confirm the real transition `begin -> login` is visible with signal `open_login`;
5. confirm login/authentication workflow remains functional;
6. confirm other state/signal manual positions still persist without reload;
7. validate/start `owasys-back` and confirm its FSM starts at real `begin` then enters `api` on `receive`;
8. owner commits/pushes only after runtime validation.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
