# P117W R45B2A4BN — Persisted right-drag begin marker

## Status

CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

- OPUS GitHub `master`: `333cf1ad2003aa9dd43d64e543210e9559e5187e` — A4BM (`opus_p117w_r45b2a4bm_persisted_right_drag_signal_cards`).
- A4BN is a differential over that committed owner baseline.
- Menu work remains frozen.

## Owner runtime evidence

A4BM substantially improves manual FSM presentation geometry: state nodes and transition signal cards are movable. The owner screenshot shows the remaining fixed presentation object: the white initial pseudo-state point (the begin marker) above/near the canonical initial state cannot be moved.

## Root cause

The initial pseudo-state marker is rendered by `renderInitialMarker()` outside both existing draggable registries:

- state registry: `.fsm-node[data-layout-draggable]`;
- signal registry: `.fsm-signal-card[data-layout-signal-draggable]`.

It therefore has no DEV right-drag interaction, no dedicated save action and no portable persisted geometry entry. Its position is recomputed from `initial_state` on each render.

This is a generic OPUS diagram-layout omission, not OWASYS business logic.

## Required invariant

The canonical FSM field `initial_state` remains the sole semantic definition of the initial state.

The begin point is presentation-only:

`initial_state semantics != begin marker x/y`

Moving the begin marker must never mutate the FSM, menu projection, ACL, signal semantics, guards, actions or runtime state.

The begin arrow must always terminate on the current boundary of the canonical `initial_state` node.

## A4BN correction

### Right-button begin-marker drag

In writable DEV mode the initial pseudo-state group receives:

- stable presentation ID `initial`;
- current marker x/y;
- DEV-only draggable flag.

Right-button drag moves only the white begin point. Its arrow is rerouted live to the current canonical initial-state rectangle boundary.

### Initial-state movement

If the initial state itself is moved, the manually positioned begin point remains where the owner placed it. Only the begin arrow endpoint is recalculated against the moved initial-state rectangle.

### Portable layout contract V4

Companion contract becomes:

`OPUS_FSM_DIAGRAM_LAYOUT_V4`

V4 keeps all V3 presentation data and adds:

```json
"markers": {
  "initial": {"x": 0.0, "y": 0.0}
}
```

The marker entry is presentation-only. It does not duplicate `initial_state` semantics.

V1, V2 and V3 companions remain accepted and migrate in writable DEV mode. When no persisted begin marker exists, the renderer computes the normal deterministic begin position and persists the emitted marker geometry.

### Save protocol

Existing actions remain:

- `save-state`;
- `save-signal`.

A4BN adds:

- `save-marker` for known presentation markers.

The server currently accepts only the canonical presentation marker ID `initial`, and only when the FSM has a valid `initial_state` contained in the current state set.

Geometry remains untrusted input and uses the existing bounded coordinate, payload, layout-key, CSRF and atomic OPUS File/Json persistence contracts.

### No reload

A4BN preserves A4BK/A4BM behavior:

- asynchronous save;
- no `window.location.reload()`;
- no replacement of the current document;
- CSRF token rotation from the successful response;
- repeated state/signal/marker saves on the same page.

## Generic OPUS scope

Changed framework files:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Fsm/FsmDiagramLayoutStore.php`

No menu file and no `sites/owasys-back` file are changed. No new concrete framework class is introduced.

## Acceptance

1. Load the current OWASYS FSM using the existing V3 companion layout; do not delete it.
2. Confirm the companion migrates to `OPUS_FSM_DIAGRAM_LAYOUT_V4`.
3. Right-drag the white begin point.
4. Confirm the begin point follows the pointer and its arrow remains attached to the canonical initial-state box during movement.
5. Release and confirm no page reload and no menu-state change.
6. Move the canonical initial-state node; confirm the begin point keeps its manual position while the begin arrow reanchors to the moved node.
7. Move another signal/state without F5 and confirm repeated saves still work.
8. Perform one deliberate browser refresh and confirm the manual begin-point, state and signal positions are restored.
9. Confirm the FSM `initial_state` value itself is unchanged.
10. Repeat on a generated OPUS application using its own portable companion layout.
