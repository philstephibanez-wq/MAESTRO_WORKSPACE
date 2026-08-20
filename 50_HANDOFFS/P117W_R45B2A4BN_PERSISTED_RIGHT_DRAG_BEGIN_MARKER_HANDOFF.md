# P117W R45B2A4BN — Handoff

State: OWNER APPLIED/PUSHED — SEMANTIC MODEL SUPERSEDED BY A4BO

## Supersession

The owner subsequently clarified that `begin` must itself be the real default FSM state of an OPUS application. A4BN's white pseudo-state marker is therefore not the final canonical model.

A4BO replaces it for canonical entry-state FSMs with a true `begin` state (`type=entry`, `initial_state=begin`). The A4BN behavior remains relevant only as historical progression and legacy pseudo-marker compatibility.

## Baseline

- OPUS baseline before A4BN: `333cf1ad2003aa9dd43d64e543210e9559e5187e` — A4BM.
- Owner later applied/pushed A4BN as `7ded8369167fa6d75df7f0cf6b33b67a45a5d626`.
- Menu work remains frozen.

## Owner request at A4BN time

After A4BM, states and signal cards were manually movable, but the white initial pseudo-state/begin point remained fixed. The owner required that point to be movable too.

## Root cause treated by A4BN

The initial marker was not part of the state or signal draggable registries and had no persisted presentation-geometry entry or save action. Its x/y was always derived from `initial_state` during rendering.

## A4BN behavior

### Begin marker interaction

In writable DEV mode, right-button drag on the white initial marker moves the marker as a presentation object.

The marker keeps stable ID `initial`; under the A4BN model the canonical FSM `initial_state` remained untouched.

### Begin arrow anchoring

The begin arrow is rebuilt live from the moved circle boundary to the current canonical initial-state rectangle boundary.

When the initial-state node is moved, the manually positioned begin point does not move with it; the arrow endpoint is recalculated against the moved state box.

### Layout V4

Portable companion contract became:

`OPUS_FSM_DIAGRAM_LAYOUT_V4`

V4 added presentation marker geometry:

```json
"markers": {
  "initial": {"x": 210.0, "y": 160.0}
}
```

V1/V2/V3 remained readable and migrated in writable DEV mode.

### Save protocol

- `save-state` unchanged;
- `save-signal` unchanged;
- `save-marker` added for the known `initial` marker.

### Preserved invariants

- no document reload;
- repeated saves with CSRF rotation;
- strict local-edge anchor validation/self-heal retained;
- movable signal cards retained;
- no menu changes;
- no `sites/owasys-back` changes;
- no new concrete framework class.

## Artifact

`opus_p117w_r45b2a4bn_persisted_right_drag_begin_marker.zip`

SHA-256:

`711d31948c736ef27e8439e9cb545211284b7a35db90b92cc40b3e52f6aa4864`

Exactly 2 complete files:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Fsm/FsmDiagramLayoutStore.php`

## Validation performed

- PHP lint: 2/2 OK;
- extracted inline interaction JavaScript: `node --check` OK;
- no trailing whitespace;
- `window.location.reload()` absent;
- persisted `initial` marker rendered and DEV-draggable;
- `save-marker` and marker geometry snapshot emitted;
- layout contract V4 normalization validated;
- begin-arrow endpoint anchored to current initial-state rectangle;
- ZIP contained exactly the two expected complete framework files.

## Historical owner validation sequence

1. load FSM and confirm V4 migration;
2. right-drag the white begin point;
3. confirm arrow follows and remains anchored to the then-canonical initial state;
4. release and confirm no reload;
5. move the initial-state node and confirm the point stays put while the arrow reanchors;
6. move a signal and another state without F5;
7. deliberate F5 and confirm manual geometry persists.

This sequence is superseded by the A4BO acceptance sequence for FSMs declaring a real `begin` entry state.
