# P117W R45B2A4BL — Handoff

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

- OPUS GitHub `master`: `974217ee14b14ab7b7980a8d74d0df34daf08f9a` — A4BJ.
- A4BK was applied locally for owner runtime validation but is not yet committed/pushed to OPUS.
- A4BL is a differential over the delivered A4BK files.
- Menu work remains frozen.

## Runtime evidence

A4BK corrected the forced page reload, but owner runtime inspection exposed detached transition graphics: local edge/leader geometry can remain at old coordinates after state geometry changes.

This is a presentation-geometry consistency defect, not an FSM semantic defect.

A separate storage incident occurred during A4BK validation: the 4 TB H: SSD temporarily disappeared. Subsequent Windows evidence showed the volume healthy and repeated UASP/device reset warnings. No causal attribution to PHP/A4BK is made; the storage incident is not treated as the cause of the diagram defect.

## Root cause treated

A4BK trusted persisted local SVG path geometry without checking that the path endpoints still touched the current source/target state boxes. Its live drag path update also left the dashed label leader on its previous geometry. The store only filled missing transition geometry and did not replace stale existing entries.

A4BL fixes those causes generically in OPUS.

## A4BL behavior

### Strict edge anchors

Persisted local state-to-state geometry is reused only when its first point is on the current source-state rectangle and its last point is on the current target-state rectangle.

Invalid/orphan geometry falls back to deterministic OPUS routing.

### Self-healing V2 persistence

The layout contract remains `OPUS_FSM_DIAGRAM_LAYOUT_V2`.

After an invalid persisted path is rejected, the validated server-rendered geometry replaces the stale stored entry. Existing companion files therefore heal in place; they must not be manually deleted for this correction.

### Live DEV drag

The browser validates current SVG endpoints against current state boxes. Incident transitions are rebuilt from the moving boxes as the state is dragged.

Before a geometry snapshot is posted, local edges are checked again and repaired if detached.

### Label leaders

Dashed label leaders are rebuilt from the current SVG edge midpoint to the current label center whenever the edge changes, and stale leaders are normalized when writable DEV interaction initializes.

### Preserved A4BK invariants

- no `window.location.reload()`;
- current DOM/menu/scroll state preserved on save;
- repeated save/CSRF rotation unchanged;
- global ingress and self-operation cards remain target-anchored;
- no menu change;
- no `sites/owasys-back` change.

## Artifact

`opus_p117w_r45b2a4bl_strict_anchored_persisted_fsm_geometry.zip`

SHA-256:

`c5f26c21d7ea774e4a27a30db1f4dc12b13417e2c54a3a009cad9a787fe65db3`

Exactly 2 complete files:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Fsm/FsmDiagramLayoutStore.php`

## Validation performed

- PHP lint: 2/2 OK;
- extracted inline interaction JavaScript: `node --check` OK;
- no trailing whitespace;
- no `window.location.reload()`;
- server anchor validator smoke: valid path accepted, detached start/end rejected, unsupported relative persisted path rejected;
- render self-heal smoke: orphan persisted path does not survive render;
- rendered-layout snapshot smoke: repaired geometry replaces orphan geometry in emitted snapshot;
- ZIP contains exactly the 2 expected complete files.

## Owner application

Apply A4BL over the currently applied A4BK files.

Then validate with the existing `sites/owasys-front/config/fsm.layout.json`; do not remove the companion layout before the first test because self-healing of stale A4BK geometry is part of acceptance.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
