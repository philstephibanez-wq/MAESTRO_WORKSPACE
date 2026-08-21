# P117W R45B2A4BY — Dynamic vertical FSM content height — HANDOFF

State: DELIVERABLE READY — OWNER APPLY + RUNTIME VALIDATION REQUIRED

## Browser feedback closing A4BX

A4BX is not sufficient for the requested visual result: making the persisted canvas authoritative still leaves the vertical FSM with a large unused lower area.

The requested rule is now explicit: the FSM height must be dynamic and end with a small deterministic margin below the last rendered FSM object.

## Root cause

The standard vertical renderer returns its SVG with the layout/persisted canvas height selected before the final semantic SVG envelope is known.

The generic `FsmDiagramGeometryNormalizer` already knows how to derive bounds from rendered states, transition paths and signal label boxes, but the standard `OPUS_FSM_Diagram::renderSvg()` path does not call a height-only fit pass.

Calling the existing full `normalize()` method would be wrong because it also changes corridor routing, label-box sizing and physical scale.

## A4BY behavior

A4BY adds a dedicated generic `fitVerticalViewport()` API and calls it only after the vertical SVG is complete.

The rendered height becomes:

```text
bottom-most semantic FSM object + 22 px
```

Semantic objects included in the lower bound:

- state rectangles;
- transition edges;
- transition label leaders;
- signal-card / transition-label rectangles.

Title/subtitle/legend chrome is excluded from the lower bound.

The fitted height is also copied back into the renderer's `_renderHeight`, therefore `renderedLayoutSnapshot()` and portable layout persistence no longer report the obsolete pre-fit canvas height.

## Changed OPUS files

Exactly:

- `Opus/Fsm/FsmDiagramGeometryNormalizerInterface.php`
- `Opus/Fsm/FsmDiagramGeometryNormalizer.php`
- `Opus/Fsm/Diagram.class.php`

No OWASYS source/config/template/CSS/JavaScript file changes.

## Baseline

The applicator requires the exact A4BX GitHub blobs:

- `Diagram.class.php`: `a80172ee1b92e00f0328b8cb28d7f4e43d2289cc`
- `FsmDiagramGeometryNormalizer.php`: `a5cec8b917276fb5bd210ab6a3558a3731277c04`
- `FsmDiagramGeometryNormalizerInterface.php`: `8b410c5d5be263beb9d1d37e56385d0de1eec526`

## Artifact

`opus_p117w_r45b2a4by_dynamic_vertical_fsm_content_height.zip`

SHA-256:

`7d4f6eecfe722cc700b438f474375e7474af295ce09929aa5952bf1df8db13de`

ZIP content:

- `apply_a4by.php`

Applicator SHA-256:

`d2a2ce544109656b0f595e7dfdf05fab03ba0313077bb3e6191ff1c69dcd81bd`

Applicator lint: OK.

## Owner commands

```cmd
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4by_dynamic_vertical_fsm_content_height.zip" -C "%USERPROFILE%\Downloads"
cd /d H:\OPUS
php "%USERPROFILE%\Downloads\apply_a4by.php"
php -l Opus\Fsm\Diagram.class.php
php -l Opus\Fsm\FsmDiagramGeometryNormalizer.php
php -l Opus\Fsm\FsmDiagramGeometryNormalizerInterface.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:dev-server -- owasys-front
```

Expected first applicator line:

`P117W_R45B2A4BY_APPLIED`

Expected second line:

`dynamic_vertical_height=last_semantic_object_plus_22px`

## Browser acceptance

1. Reload OWASYS after restarting the dev server.
2. Open the same Applications/FSM projection shown in the A4BX feedback screenshot.
3. The lower border of the FSM surface must now follow the bottom-most rendered FSM object instead of the historic canvas height.
4. There must be only a small margin beneath that object, approximately 22 px in SVG coordinates.
5. No state, transition, signal card or leader may be clipped.
6. Drag the currently lowest movable FSM object downward, reload: height must grow automatically.
7. Move it upward, reload: height must shrink automatically.
8. Horizontal coordinates and all FSM semantics must remain unchanged.

## Workspace specification

`40_SPECS/P117W_R45B2A4BY_DYNAMIC_VERTICAL_FSM_CONTENT_HEIGHT_SPEC.md`

Current specification commit including artifact hashes:

`781943682599297b9db859fb278ebdf8a3e87b98`

## Next

After browser acceptance, continue from the live compacted diagram. Do not add CSS height compensation: any remaining empty vertical region must be traced to a semantic object still present in the rendered envelope or to an incorrect generic bound calculation.
