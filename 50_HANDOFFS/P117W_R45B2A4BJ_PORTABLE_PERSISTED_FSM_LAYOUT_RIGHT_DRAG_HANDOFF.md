# P117W R45B2A4BJ — Handoff

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

Owner OPUS HEAD:

`f12de01af39d87c7eaf6783ff277e2b14cad1a07` — A4BI.

A4BJ is a differential over A4BI. Menu work remains frozen.

## Owner contract

The EFSM diagnostic layout is portable application state, not OWASYS database state.

Companion files:

- OWASYS front: `config/fsm.layout.json`;
- generated application: `config/application.fsm.layout.json`.

Required lifecycle:

`no persisted layout -> compute automatic layout -> persist atomically -> reread -> render persisted layout`

Then:

`persisted layout exists -> persisted state coordinates win`

Right-button drag in DEV moves a state. Connected arrows remain anchored during the movement. Releasing the pointer persists x/y, then the page reloads so the canonical server renderer recomputes exact final routing.

## Implementation

New generic OPUS component:

- `Opus/Fsm/FsmDiagramLayoutStore.php`
- `Opus/Fsm/FsmDiagramLayoutStoreInterface.php`

Modified generic renderer:

- `Opus/Fsm/Diagram.class.php`

OWASYS front integration only:

- `sites/owasys-front/application/default/controllers/RuntimeController.php`

No menu file and no `owasys-back` file are changed.

The store uses `StructuredFileLoader` for configuration/readback, `File::writeAtomic()` for persistence and `Json::encode()` for the companion file.

Layout contract:

`OPUS_FSM_DIAGRAM_LAYOUT_V1`

Only presentation coordinates/canvas metadata are persisted. EFSM semantic content is forbidden from the layout file.

## Generated application behavior

Generated applications already render their own `config/application.fsm.json` through generic `OPUS_FSM_Diagram::renderDefinition()`. The new generic store is therefore discovered automatically in the generated application's own runtime. No OWASYS database and no OWASYS-specific callback are required.

The layout file travels with the generated application and can be versioned in Git.

## EFSM evolution

If the canonical EFSM changes after manual layout editing:

- existing known-state manual coordinates remain unchanged;
- new states receive automatic coordinates and are merged;
- removed/stale states are pruned;
- updated definition hash/canvas metadata are persisted in DEV.

## Development write boundary

Writes are enabled under PHP `cli-server` or explicit `OPUS_FSM_LAYOUT_WRITE=1`.

Outside that boundary, existing persisted layouts are still rendered but the drag/save interaction is not exposed.

## Artifact

`opus_p117w_r45b2a4bj_portable_persisted_fsm_layout_right_drag.zip`

SHA-256:

`7451afaa0391c2d1b65bec383d87137f7c56d45861c4ae5c464f5aac535550cf`

Exactly four complete files.

## Validation

- PHP lint 4/4 OK;
- final ZIP contains exactly 4 files;
- no trailing whitespace;
- `A4BJ_PERSISTED_LAYOUT_SMOKE_OK`;
- `A4BJ_EXTENDED_LAYOUT_SMOKE_OK`;
- JavaScript extracted from rendered output passes `node --check`;
- A4BI geometry regression remains approximately `1152 x 3132` with 71 transitions, 46 global cards, 0 label overlaps and 0 label/state overlaps.

## Owner acceptance sequence

1. Extract A4BJ over A4BI.
2. Start OWASYS front with the DEV server.
3. For a clean bootstrap, ensure `sites/owasys-front/config/fsm.layout.json` does not already exist.
4. Load the main OWASYS EFSM diagnostic.
5. Confirm `config/fsm.layout.json` is created on first DEV render.
6. Reload and confirm positions remain identical.
7. Hold right mouse button on a state and drag it.
8. Confirm its incident arrows stay attached to origin/destination while moving.
9. Release, allow the page reload, and confirm the state remains at the saved location.
10. Confirm left-click diagnostic behavior remains intact and the menu is unchanged.
11. Repeat on a generated application: expected companion file is `config/application.fsm.layout.json` inside that generated application.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
