# P117W R45B2A4BG — Handoff

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline / dependency

Owner GitHub OPUS HEAD remains:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

Owner runtime evidence confirms A4BE and A4BF are applied locally. The owner has explicitly frozen menu work for now. A4BG is therefore diagram-only and is intended to be extracted over the current local A4BE/A4BF tree.

## Owner runtime direction

The current EFSM diagram is functionally useful but too dense and horizontally compressed to serve as a readable diagnostic.

Owner requires:

- vertical EFSM;
- width equal to the page/component;
- unrestricted practical height;
- signal and guards visually separated;
- guards not on the same line as the signal;
- different colors for signal, guards and effects/actions;
- canonical technical keys in the diagram;
- no menu changes.

## A4BG correction

### Generic vertical renderer

`OPUS_FSM_Diagram` gains an optional generic `vertical` layout direction. The default remains `horizontal`, so existing consumers remain compatible.

Vertical ranks flow top-to-bottom. States within one rank are spread horizontally. Long forward jumps and returns use side corridors. Generous vertical rank spacing is deliberate: readability takes priority over compact height.

### Width / height behavior

The vertical SVG advertises `data-opus-fsm-layout="vertical"` and OWASYS renders it at `width: 100%`, `height: auto`.

The diagram therefore follows page width rather than creating a wide horizontal canvas. The document owns vertical scrolling and the diagram may be several thousand SVG units high.

### Readable EFSM transition semantics

Vertical transition boxes are now stacked:

```text
signal
[guard]
[guard]
/ effect
```

Each semantic level receives its own SVG class and visual color:

- signal = existing origin color;
- guard = dedicated condition color;
- effect/action = dedicated effect color.

Canonical technical IDs are preserved. No I18n is applied to the diagnostic EFSM labels.

### Geometry collision policy

Vertical label placement uses a much larger search area than horizontal mode because height is intentionally unconstrained. Label boxes are clamped inside the SVG viewBox.

A full-definition stress render with 88 transition labels produced:

- width approximately 1930;
- height approximately 5227;
- out-of-viewBox labels: 0;
- overlapping transition label boxes: 0.

### Horizontal compatibility

Horizontal mode continues to use the previous one-line transition label renderer. This preserves compatibility with existing `FsmDiagramGeometryNormalizer` behavior and avoids changing unrelated OPUS diagrams.

### OWASYS builder

`OwasysFsmDiagramBuilder` requests generic vertical mode and no longer applies the horizontal physical geometry normalizer/0.60 scaler to this diagnostic projection.

## Artifact

`opus_p117w_r45b2a4bg_vertical_page_width_readable_efsm.zip`

SHA-256:

`c4b43c0d21856ccc02fec02cedf77b56ce68e19e5b026a2a168855fa6528e1e9`

Exactly 3 complete files:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/www/asset/css/fsm-native.css`

No menu file is included.

## Validation performed

- PHP lint 2/2: OK;
- no trailing whitespace;
- ZIP file count: 3;
- `A4BG_VERTICAL_EFSM_OK`;
- `A4BG_HORIZONTAL_COMPAT_OK`;
- `A4BG_FULL_RENDER_OK` with 88 transitions;
- `A4BG_GEOMETRY_STRESS_OK` with 0 transition-label overlaps and 0 out-of-bounds label boxes.

## Owner acceptance sequence

1. Extract A4BG over current local A4BE/A4BF tree.
2. Restart only `owasys-front` if back is already running.
3. Do not evaluate menu changes: none are part of A4BG.
4. Inspect the main OWASYS EFSM diagnostic.
5. Confirm flow is top-to-bottom and page-width.
6. Scroll vertically through the diagram and confirm height is not compressed to fit one viewport.
7. Confirm every shown transition box separates signal, guards and effects on distinct lines.
8. Confirm guards are visually distinguishable from signal and effect.
9. Confirm signal-origin semantics remain unchanged.
10. Confirm existing clickable diagnostic transitions still execute through the existing EFSM path.

## Next work

After owner runtime feedback, continue refining only the EFSM diagnostic geometry/readability until accepted. Do not resume menu work unless the owner explicitly reopens that scope.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
