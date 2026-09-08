# P117W R8NMI17C — Handoff

Status: DELIVERED FOR OWNER VALIDATION

## Scope

Generic OPUS correction: generated applications must not render their own application FSM. OWASYS is the developer/design surface for the selected application's FSM.

## Differential deliverable

Archive: `R8NMI17C.zip`

Changed file:

- `Opus/Application/Runtime/templates/fsm-diagram.score`

## Runtime effect

The generated application continues to execute its FSM for routing/state transitions, but the generic runtime SCORE component emits no visible FSM markup. Existing generated layouts remain compatible because their `common.fsm_diagram` slot receives an empty rendering.

## Owner acceptance gate

- Apply ZIP in `H:\OPUS`.
- Relaunch `essai`.
- Confirm functional page remains available with no FSM diagram.
- Confirm OWASYS still renders the selected `essai` application FSM.
- Owner commits/pushes OPUS only after acceptance.
