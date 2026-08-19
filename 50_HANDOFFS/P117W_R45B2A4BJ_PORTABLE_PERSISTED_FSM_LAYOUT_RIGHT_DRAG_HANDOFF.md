# P117W R45B2A4BJ — Handoff

State: OWNER APPLIED/PUSHED — SUPERSEDED BY A4BK

## Owner evidence

Owner OPUS commit:

`974217ee14b14ab7b7980a8d74d0df34daf08f9a` — `opus_p117w_r45b2a4bj_portable_persisted_fsm_layout_right_drag`

A4BJ established portable file-backed FSM layout persistence:

- OWASYS front: `config/fsm.layout.json`;
- generated application: `config/application.fsm.layout.json`;
- generic OPUS `FsmDiagramLayoutStore`;
- right-button state dragging in DEV;
- no OWASYS database dependency;
- layout travels with the generated application and may be versioned in Git.

## Runtime evidence supplied by owner

A4BJ right-drag works and moves states while incident arrows stay visually attached during the drag.

Two blocking defects were observed after pointer release:

1. A4BJ explicitly executes `window.location.reload()` after persistence;
2. the reload destroys surrounding page UI state, including native menu collapse;
3. the server then recomputes transition routing, so arrows can be displayed differently from the geometry that was visible immediately before the save.

The root cause is therefore not the menu. It is the A4BJ persistence contract: it persists state x/y but does not persist the exact displayed local transition geometry, and it forces a full document reload to recompute that geometry.

## Supersession contract

A4BK replaces the pointer-release lifecycle with:

`right drag -> live SVG update -> asynchronous persistence -> no reload`

A4BK also upgrades the portable layout contract so the geometry actually displayed after a drag can be restored on the next genuine page load.

The menu remains frozen and is outside this correction.

## A4BJ artifact

`opus_p117w_r45b2a4bj_portable_persisted_fsm_layout_right_drag.zip`

SHA-256:

`7451afaa0391c2d1b65bec383d87137f7c56d45861c4ae5c464f5aac535550cf`

A4BJ is retained as historical baseline only. Do not reissue it.
