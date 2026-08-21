# P117W R45B2A4BY — Dynamic vertical FSM content height

State: DELIVERABLE READY — OWNER APPLY + RUNTIME VALIDATION REQUIRED

## Preconditions

README-FIRST is authoritative.

A4BY follows A4BX. A4BX is present on OPUS `master`: `OPUS_FSM_Diagram::renderDefinition()` now forwards persisted canvas metadata and `applyPersistedStatePositions()` uses persisted vertical height as the layout floor.

Browser validation nevertheless shows no useful visual reduction: the rendered vertical FSM still carries a large unused lower area.

## Observed failure

The remaining cause is not CSS and not the persisted state coordinates.

The current rendering chain still ends with a canvas height chosen before all final SVG semantic objects are known:

1. layout computes an automatic/persisted canvas height;
2. transitions, signal cards and states are rendered inside that canvas;
3. `renderSvg()` returns the SVG directly;
4. no generic content-envelope pass is invoked by the standard vertical renderer;
5. unused space below the bottom-most rendered FSM object therefore remains part of the SVG height.

`FsmDiagramGeometryNormalizer` already contains the generic primitive needed to derive vertical bounds from rendered state rectangles, transition paths and signal label boxes, but its vertical compaction path is only internal to the broader `normalize()` operation. Calling the whole normalizer would also reroute corridors, expand label boxes and apply physical scale, which is not appropriate for this height-only correction.

## Generic OPUS correction

A4BY exposes a dedicated generic `fitVerticalViewport()` capability on `FsmDiagramGeometryNormalizerInterface` / `FsmDiagramGeometryNormalizer` and invokes it from `OPUS_FSM_Diagram::renderSvg()` only after the complete vertical SVG has been emitted.

The rule is deterministic:

`dynamic height = bottom-most rendered semantic FSM object + 22 px bottom margin`

The semantic envelope includes:

- rendered state rectangles;
- transition edge paths;
- transition label-leader paths;
- signal-card / edge-label rectangles.

The fit deliberately excludes title/subtitle/legend chrome from the bottom-bound calculation so presentation furniture cannot keep the old canvas height alive.

The SVG X geometry and all FSM coordinates remain unchanged. The fitted pass rewrites only:

- physical SVG `height`;
- the vertical extent of `viewBox`.

The renderer also updates its internal `_renderHeight` to the fitted value so `renderedLayoutSnapshot()` reports/persists the same dynamic canvas height rather than the obsolete pre-fit height.

## Why this is the requested behavior

The height is no longer a fixed historical canvas value. Moving a persisted state or signal card downward increases the next render height automatically; moving the lowest object upward reduces it automatically. The final visible surface always ends with the same deterministic 22 px margin below the last semantic FSM object.

## Why no CSS workaround

No `height`, `max-height`, viewport-relative rule, clipping, transform, `zoom` or nested vertical scroll container is added to OWASYS.

The defect belongs to the generic SVG presentation envelope, so the correction remains in OPUS.

## Framework contract

No new concrete framework class is introduced.

`FsmDiagramGeometryNormalizer` continues to implement the homonymous interface, which directly extends the four required OPUS framework interfaces.

`OPUS_FSM_Diagram` continues to implement `OPUS_FSM_DiagramInterface`.

## Differential targets

A4BY changes exactly:

- `Opus/Fsm/FsmDiagramGeometryNormalizerInterface.php`
- `Opus/Fsm/FsmDiagramGeometryNormalizer.php`
- `Opus/Fsm/Diagram.class.php`

No OWASYS frontend file is changed.
No OWASYS backend file is changed.
No JavaScript is changed.
No FSM semantic/configuration file is changed.
No SCORE template is changed.

## Baseline guards

The applicator refuses to write unless the local OPUS files are exactly the A4BX GitHub baseline:

- `Opus/Fsm/Diagram.class.php` blob `a80172ee1b92e00f0328b8cb28d7f4e43d2289cc`;
- `Opus/Fsm/FsmDiagramGeometryNormalizer.php` blob `a5cec8b917276fb5bd210ab6a3558a3731277c04`;
- `Opus/Fsm/FsmDiagramGeometryNormalizerInterface.php` blob `8b410c5d5be263beb9d1d37e56385d0de1eec526`.

## Runtime acceptance

After apply:

1. PHP lint passes for all three changed OPUS files;
2. `composer opus:validate-site -- owasys-front` remains valid;
3. vertical FSM height ends shortly after the bottom-most rendered FSM object with approximately 22 px margin;
4. no large blank lower canvas remains;
5. moving the lowest persisted object down grows the height on the next render;
6. moving it up shrinks the height on the next render;
7. no state, signal card, edge or leader is clipped at the bottom;
8. horizontal FSM rendering is unchanged;
9. signal origin colors, guards, actions, actionability and topology are unchanged;
10. Registry A4BW behavior remains unchanged.
