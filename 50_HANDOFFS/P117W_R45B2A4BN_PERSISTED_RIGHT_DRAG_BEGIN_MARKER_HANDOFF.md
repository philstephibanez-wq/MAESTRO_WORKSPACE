# P117W R45B2A4BN — Handoff

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

- OPUS GitHub `master`: `333cf1ad2003aa9dd43d64e543210e9559e5187e` — A4BM.
- A4BN is a complete-file differential over that committed baseline.
- Menu work remains frozen.

## Owner request

After A4BM, states and signal cards are manually movable, but the white initial pseudo-state/begin point remains fixed. The owner requires the begin point to be movable too.

## Root cause treated

The initial marker was not part of the state or signal draggable registries and had no persisted presentation-geometry entry or save action. Its x/y was always derived from `initial_state` during rendering.

A4BN fixes this generically in OPUS without changing FSM semantics.

## A4BN behavior

### Begin marker interaction

In writable DEV mode, right-button drag on the white initial marker moves the marker as a presentation object.

The marker keeps stable ID `initial`; the canonical FSM `initial_state` remains untouched.

### Begin arrow anchoring

The begin arrow is rebuilt live from the moved circle boundary to the current canonical initial-state rectangle boundary.

When the initial-state node is moved, the manually positioned begin point does not move with it; the arrow endpoint is recalculated against the moved state box.

### Layout V4

Portable companion contract becomes:

`OPUS_FSM_DIAGRAM_LAYOUT_V4`

V4 adds presentation marker geometry:

```json
"markers": {
  "initial": {"x": 210.0, "y": 160.0}
}
```

V1/V2/V3 remain readable and migrate in writable DEV mode. Existing state and signal-card geometry is retained.

### Save protocol

- `save-state` remains unchanged;
- `save-signal` remains unchanged;
- `save-marker` is added for the known `initial` marker.

Server validation accepts `initial` only when the FSM declares a valid initial state. Marker coordinates are bounded and persisted only as presentation geometry through the existing CSRF/layout-key/atomic File+Json path.

### Preserved invariants

- no document reload;
- repeated saves with CSRF rotation;
- A4BL strict local-edge anchor validation/self-heal retained;
- A4BM movable signal cards retained;
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
- render smoke: persisted `initial` marker emitted at requested x/y and marked DEV-draggable;
- interaction smoke: `save-marker` and marker geometry snapshot emitted;
- server normalization smoke: layout contract V4, valid `initial` marker accepted, unknown marker dropped;
- arrow geometry smoke: rendered begin-arrow endpoint lies on the current canonical initial-state rectangle boundary;
- ZIP contains exactly the two expected complete framework files.

## Owner application

Apply A4BN over committed A4BM.

Do not delete `sites/owasys-front/config/fsm.layout.json` before the first run. V3-to-V4 migration is part of acceptance.

Validation sequence:

1. load FSM and confirm V4 migration;
2. right-drag the white begin point;
3. confirm arrow follows and remains anchored to `login`/the canonical initial state;
4. release and confirm no reload;
5. move the initial-state node and confirm the begin point stays put while the arrow reanchors;
6. move a signal and another state without F5;
7. perform one deliberate F5 and confirm all manual geometry persists.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
