# P117W R45B2A4BL — Strict anchored persisted FSM geometry

## Status

CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

- OPUS GitHub `master` remains at `974217ee14b14ab7b7980a8d74d0df34daf08f9a` — A4BJ.
- A4BK was applied locally by the owner for runtime validation but has not yet been committed/pushed to OPUS.
- A4BL is therefore a differential over the A4BK delivered files, while OPUS GitHub remains the authoritative committed baseline.
- Menu work remains frozen.

## Owner runtime evidence

After A4BK, right-button state dragging works without a page reload, but the owner observed transition graphics that are no longer attached to their current source/target state boxes.

The screenshot evidence includes local dashed/leader geometry visibly starting or ending in empty canvas space rather than remaining tied to the moved state topology.

## Root cause

A4BK introduced persistence of exact local SVG geometry but trusted the persisted `path` and `leader_path` as long as their transition ID remained known.

That leaves two structural defects:

1. a persisted local transition path can survive even when its first/last coordinates no longer touch the current source/target state boxes;
2. the live drag code recalculates an incident edge path but does not recalculate its label leader, so the leader can remain attached to old geometry.

Additionally, `FsmDiagramLayoutStore::persistRenderedGeometry()` only completed missing transition entries. A stale existing entry could therefore survive indefinitely even after the renderer had enough information to replace it.

## Required invariant

For every local state-to-state transition:

`rendered edge start ∈ current source-state boundary`

and

`rendered edge end ∈ current target-state boundary`

A persisted path that violates either invariant is invalid presentation geometry and must not win over the current state topology.

FSM semantics remain canonical and unchanged.

## A4BL correction

### Server-side persisted-path validation

Before a persisted local path is reused, OPUS validates that:

- the transition is local, not global or self-scoped;
- both source and target states exist in the current rendered layout;
- the persisted path is an OPUS-supported absolute SVG path;
- its first point lies on the current source-state rectangle boundary;
- its final point lies on the current target-state rectangle boundary.

If validation fails, the persisted path is ignored for that render and the deterministic OPUS router produces a fresh anchored path.

### Self-healing persisted geometry

`FsmDiagramLayoutStore::persistRenderedGeometry()` now replaces an existing persisted transition geometry entry when the renderer emits a different validated geometry entry.

Consequently:

`stale persisted path -> renderer rejects -> deterministic anchored route -> rendered snapshot -> stale persisted entry replaced`

No manual deletion of `*.fsm.layout.json` is required.

### Browser-side anchor validation

In writable DEV mode, the existing inline layout interaction validates local SVG path endpoints against the current source/target state rectangles using native SVG path geometry.

If an edge is detached, it is immediately rebuilt from the current state boxes before geometry is captured.

During a right-button drag, every incident local transition remains recalculated from the moved source/target boxes.

### Label-leader anchoring

Whenever a local edge changes, its dashed label leader is rebuilt from the current edge midpoint to the current label center.

Existing stale leaders are also normalized when the diagram initializes in writable DEV mode.

This prevents a label leader from remaining attached to pre-drag geometry.

### Unchanged contracts

- layout contract remains `OPUS_FSM_DIAGRAM_LAYOUT_V2`;
- no FSM semantics are persisted;
- no document reload is reintroduced;
- CSRF rotation remains unchanged;
- global ingress cards remain target-anchored;
- self-operation cards remain target-anchored;
- no menu file changes;
- no `owasys-back` changes.

## Changed framework files

- `Opus/Fsm/Diagram.class.php`
- `Opus/Fsm/FsmDiagramLayoutStore.php`

`FsmDiagramLayoutStoreInterface.php` is unchanged.

## Acceptance

1. Load the current OWASYS FSM with the existing A4BK V2 companion layout; do not delete it.
2. Confirm no local transition arrow starts or ends in empty space when its source/target state is visible.
3. Confirm stale persisted local paths self-heal without manual layout-file cleanup.
4. Right-drag a state and confirm all incident local arrows remain attached throughout movement.
5. Confirm dashed transition-label leaders remain attached to the current edge after movement.
6. Release the state and confirm there is no page refresh and the menu state remains unchanged.
7. Drag a second state without refreshing and confirm persistence still succeeds.
8. Perform one deliberate browser refresh and confirm state positions persist and local arrows remain anchored.
9. Repeat on a generated OPUS application using its own `config/application.fsm.layout.json`.
