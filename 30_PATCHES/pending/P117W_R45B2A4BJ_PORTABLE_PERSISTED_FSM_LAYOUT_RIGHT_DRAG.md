# P117W R45B2A4BJ — Portable persisted FSM layout and right-button drag

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Owner baseline

OPUS GitHub HEAD:

`f12de01af39d87c7eaf6783ff277e2b14cad1a07` — `opus_p117w_r45b2a4bi_compact_ingress_vertical_efsm`.

A4BJ is a differential over A4BI. Menu work remains frozen.

## Owner-fixed requirement

The EFSM diagnostic layout must be portable with each application and cannot depend on the OWASYS database.

Required behavior:

1. Each FSM has a companion presentation file.
2. Generated application:
   `config/application.fsm.json` -> `config/application.fsm.layout.json`.
3. OWASYS front:
   `config/fsm.json` -> `config/fsm.layout.json`.
4. If no persisted layout exists in DEV, OPUS computes deterministic automatic geometry, persists it atomically, rereads it, then renders from the persisted coordinates.
5. If a persisted layout exists, persisted coordinates are authoritative for known states.
6. Right mouse button + drag moves a state in the diagnostic SVG.
7. Incident arrows remain anchored to source and target while dragging.
8. On release, only the moved state geometry is saved.
9. Layout metadata must never mutate the canonical EFSM.
10. A generated application must be able to render and edit its own persisted layout in its own DEV runtime, without OWASYS database dependency.

## Generic OPUS implementation

### `FsmDiagramLayoutStore`

New generic OPUS component:

- `Opus/Fsm/FsmDiagramLayoutStore.php`
- `Opus/Fsm/FsmDiagramLayoutStoreInterface.php`

The concrete class implements its homonymous interface, which directly extends the four mandatory OPUS framework interfaces.

Contract:

`OPUS_FSM_DIAGRAM_LAYOUT_V1`

The store discovers the current site through its public document root and loads `config/site.json` through `StructuredFileLoader`.

It derives the canonical FSM path from the site contract:

- application FSM from `application_fsm` / `navigation.fsm`;
- system FSM from `navigation.fsm`.

The companion file path is derived deterministically by replacing `.json` with `.layout.json`.

### Layout file content

Layout persistence contains presentation data only:

```json
{
  "contract": "OPUS_FSM_DIAGRAM_LAYOUT_V1",
  "fsm_path": "config/application.fsm.json",
  "definition_sha256": "...",
  "layout_direction": "vertical",
  "canvas": {
    "width": 1152,
    "height": 3132
  },
  "states": {
    "data": {"x": 320, "y": 840}
  }
}
```

Forbidden in the layout file:

- FSM signal definitions;
- guards;
- actions;
- transitions;
- ACL semantics;
- runtime state.

The canonical FSM remains the only semantic source of truth.

### First-render bootstrap

`OPUS_FSM_Diagram::renderDefinition()` performs:

`canonical EFSM -> deterministic automatic layout -> persist -> reread -> render persisted coordinates`

when the companion file is absent and layout writes are enabled.

The write boundary uses:

- `Opus\File\File::writeAtomic()`;
- `Opus\File\Json::encode()`;
- `StructuredFileLoader` for subsequent reads.

### Existing persisted layout

When the companion file exists:

- persisted x/y coordinates win for known states;
- automatic node dimensions/ranks remain renderer facts;
- stale states no longer present in the EFSM are pruned;
- new EFSM states missing from the layout receive deterministic automatic coordinates and are merged;
- definition hash and canvas metadata are refreshed;
- existing manual positions are never discarded by that merge.

### Development write policy

Writes are enabled only when:

- PHP SAPI is `cli-server`, or
- explicit environment override `OPUS_FSM_LAYOUT_WRITE=1` is present.

Outside that mode, persisted layouts remain readable but are not writable. If the EFSM contains a new state, it can still receive an automatic in-memory position without mutating the deployment.

## Right-button drag interaction

The generic SVG renderer emits layout interaction only when persistence is writable.

Interaction:

- left-click behavior remains available for existing diagnostic links/signals;
- right-button pointer-down on a draggable state begins movement;
- browser context menu is suppressed only for draggable FSM states;
- state position changes in SVG coordinates, not screen pixels;
- incident state-to-state paths are recomputed live from the current source and target node boundaries;
- state-anchored global/self cards and initial/final markers move with their state;
- pointer release posts the state id and x/y coordinates;
- after successful persistence the page reloads, allowing the canonical server renderer to recompute exact final transition routing and labels from the persisted positions.

## Save security

The save request carries:

- a deterministic layout key bound to site root + layout path;
- a session-bound OPUS CSRF token;
- state id;
- x/y coordinates.

The generic store validates:

- matching layout key;
- CSRF token;
- state existence in the canonical EFSM;
- numeric finite coordinate bounds.

No EFSM semantic transition is emitted for a geometry-only drag.

OWASYS front's RuntimeController contains only a narrow pass-through for the diagnostic layout POST so the generic store can perform its own validation and atomic write. No menu behavior changes.

## Generated-application portability

No generated-site-specific database or OWASYS callback is required.

Generated applications already call generic `OPUS_FSM_Diagram::renderDefinition()` for their `application.fsm.json`. Therefore the same generic persistence mechanism automatically applies in their own DEV runtime.

The persisted companion file is a normal application configuration artifact and can travel/version with the application repository.

## Files

Artifact contains exactly four complete files:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Fsm/FsmDiagramLayoutStore.php`
- `Opus/Fsm/FsmDiagramLayoutStoreInterface.php`
- `sites/owasys-front/application/default/controllers/RuntimeController.php`

No menu file.
No `sites/owasys-back` file.

## Artifact

`opus_p117w_r45b2a4bj_portable_persisted_fsm_layout_right_drag.zip`

SHA-256:

`7451afaa0391c2d1b65bec383d87137f7c56d45861c4ae5c464f5aac535550cf`

## Validation performed

- final ZIP file count: 4;
- PHP lint: 4/4 OK;
- no trailing whitespace;
- first-render bootstrap: layout file created, reread and rendered;
- save smoke: moved state persisted at decimal SVG coordinates and rendered on next request;
- EFSM evolution smoke: manual positions retained, new state automatically merged, stale state pruned;
- read-only smoke: persisted layout applied with write interaction disabled;
- JavaScript syntax: `node --check` OK;
- A4BI geometry regression: `1152 x 3132`, 71 transitions, 46 global cards, 0 label/label overlaps, 0 label/state overlaps.

## Owner runtime acceptance

1. Apply A4BJ over A4BI.
2. Start `owasys-front` in DEV.
3. Ensure no `config/fsm.layout.json` exists for the first bootstrap test.
4. Load the EFSM diagnostic and verify `config/fsm.layout.json` is created automatically.
5. Reload and verify the same persisted positions are used.
6. Right-drag one state and verify connected arrows stay attached while moving.
7. Release and reload; verify the state remains at the persisted location.
8. Confirm normal left-click diagnostic actions are unchanged.
9. Confirm menu behavior is unchanged.
10. For a generated application, verify the same mechanism uses `config/application.fsm.layout.json` in that application's own DEV runtime.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
