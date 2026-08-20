# P117W R45B2A4BO — Canonical real `begin` FSM state

## Status

CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

- OPUS GitHub `master`: `7ded8369167fa6d75df7f0cf6b33b67a45a5d626` — A4BN (`opus_p117w_r45b2a4bn_persisted_right_drag_begin_marker`).
- Menu work remains frozen.
- A4BN's draggable pseudo-marker interpretation is superseded for canonical entry-state FSMs.

## Owner requirement

`begin` is not merely a diagram point. It is the real default FSM state entered when an OPUS application is instantiated/reset.

The required semantic model is:

`application bootstrap -> current_state = initial_state = begin -> first explicit FSM signal -> functional state`

For OWASYS front, the first ordinary unauthenticated route signal is `open_login`, therefore the real relation is:

`begin --open_login--> login`

For OWASYS back, the first execution relation is:

`begin --receive--> api`

## Generic OPUS entry-state contract

`FsmProcessor` now recognizes one canonical entry-state declaration:

```json
{
  "id": "begin",
  "type": "entry"
}
```

When `begin` is declared:

- it must have `type = entry`;
- it must be the FSM `initial_state`;
- an entry state must be unique;
- a state of `type = entry` must use the canonical id `begin`.

Legacy FSM definitions that do not declare an entry state remain valid. There is no silent synthetic `begin` insertion and no runtime guessing.

Because `FsmProcessor` initializes and resets its runtime state to `initial_state`, a compliant canonical-entry FSM now starts and resets on the real `begin` state.

## Diagram semantics

For a canonical entry-state FSM, `Diagram.class.php` renders `begin` through the ordinary state-node renderer:

- normal FSM state box;
- normal `data-state="begin"` semantics;
- normal DEV right-drag state persistence;
- `entry` CSS class for diagnostic distinction;
- no white pseudo initial-marker circle.

The legacy pseudo initial marker remains available only for old FSM definitions whose initial state is not a canonical `type=entry` state.

## Portable layout

The layout contract remains `OPUS_FSM_DIAGRAM_LAYOUT_V4`.

For a canonical real entry state:

- `begin` geometry is stored under ordinary `states.begin` geometry;
- `markers.initial` is no longer accepted/emitted for that definition and stale marker data is normalized away;
- state/signal no-reload persistence from A4BM/A4BN remains unchanged.

No new semantic data is stored in the presentation companion.

## OWASYS front migration

`sites/owasys-front/config/fsm.json` now declares:

- `initial_state = begin`;
- real state `begin`, `type = entry`;
- explicit local transition `t_begin_open_login` (`begin + open_login -> login`);
- `begin` added explicitly to finite global transition source sets wherever `login` was previously an allowed initial source.

Existing functional states, guards, actions and menu projection semantics remain unchanged.

`OwasysRuntimeController::currentState()` no longer resets every unauthenticated non-initial state. It resets only when the restored current state itself requires authentication. This is required because after `begin -> login`, `login` is a legitimate unauthenticated state even though it is no longer the FSM initial state.

## OWASYS back migration

`sites/owasys-back/config/fsm.json` now declares:

- `initial_state = begin`;
- real entry state `begin`;
- explicit `begin + receive -> api` relation.

No JavaScript or frontend asset is added to `owasys-back`.

## Scope boundary / next propagation

A4BO establishes and validates the generic OPUS semantic contract and migrates both OWASYS FSM definitions. It does **not** silently rewrite pre-existing generated applications and does not mutate their source files at runtime.

Propagation of the canonical real `begin` state into Composer's generated `SiteScaffoldPlan` output is the next required scaffold milestone, so newly generated frontend/fullstack/backend applications are born with the same contract rather than being rewritten after generation.

This boundary is explicit to preserve zero-fallback and source-of-truth rules.

## Changed files

- `Opus/Fsm/FsmProcessor.php`
- `Opus/Fsm/Diagram.class.php`
- `Opus/Fsm/FsmDiagramLayoutStore.php`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/application/default/controllers/RuntimeController.php`
- `sites/owasys-back/config/fsm.json`

No menu file is changed. No new concrete framework class is introduced.

## Acceptance

1. Start OWASYS front with a clean FSM session and confirm processor `initial_state/current_state` begins at `begin` before the first route signal.
2. Confirm the first unauthenticated route relation is `begin --open_login--> login`.
3. Confirm the diagram contains a normal movable `begin` state box and no white pseudo initial marker for this FSM.
4. Confirm login still works after `begin -> login` and is not reset back to `begin` before authentication POST handling.
5. Confirm protected unauthenticated restored states still reset through the FSM initial `begin` state.
6. Confirm existing state/signal drag persistence and no-reload behavior remain intact.
7. Confirm `markers.initial` disappears from the effective layout for this canonical entry FSM while ordinary `states.begin` geometry persists.
8. Confirm OWASYS back validates with `begin` as real initial state and `receive` moves it to `api`.
9. Confirm no menu regression and no JavaScript in `sites/owasys-back`.
