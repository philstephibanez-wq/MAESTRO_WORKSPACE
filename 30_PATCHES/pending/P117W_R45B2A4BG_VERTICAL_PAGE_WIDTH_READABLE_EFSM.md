# P117W R45B2A4BG — Vertical page-width readable EFSM

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Governing baseline

`README-FIRST.md` remains authoritative.

OPUS GitHub owner HEAD at preparation time remains:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

The owner has A4BE then A4BF applied locally. A4BG is a focused diagram-only differential compatible with that local tree. It does not modify the menu.

## Owner decision

The operational menu is frozen for now.

Work returns to the OWASYS diagnostic EFSM diagram, which the owner judged too dense and unreadable.

Required diagram contract:

- vertical/top-to-bottom workflow;
- diagram width equals the available page/component width;
- no practical height constraint: document height grows with EFSM depth;
- technical state/signal keys remain visible;
- signal, guards/conditions and actions/effects are no longer concatenated on one visual line;
- signal, guards and effects use distinct visual levels and colors;
- EFSM semantics and clickability remain unchanged;
- no menu modification.

## Generic OPUS evolution

This is not OWASYS business logic, so the capability is implemented generically in `OPUS_FSM_Diagram` first.

`renderDefinition()` gains a backward-compatible optional final argument:

`layoutDirection = horizontal|vertical`

Default remains `horizontal`.

The new vertical mode:

- treats rank as vertical depth;
- distributes same-rank states horizontally;
- uses generous inter-rank spacing because height is intentionally unconstrained;
- routes adjacent forward transitions through vertical inter-rank corridors;
- routes long jumps and returns through bounded side corridors;
- preserves current-state highlighting, signal origin, transition identity and diagnostic action bindings;
- constrains transition label boxes inside the SVG viewBox;
- uses vertical-specific collision search for transition labels.

Horizontal rendering keeps its previous layout and previous single-line transition-label rendering, preserving compatibility with `FsmDiagramGeometryNormalizer` and existing non-OWASYS consumers.

## Structured vertical transition labels

Only vertical mode uses the new stacked technical label:

```text
signal_key
[guard_one]
[guard_two]
/ action(); runtime_effect()
```

Semantic classes are explicit:

- `.fsm-edge-signal`
- `.fsm-edge-guard`
- `.fsm-edge-effect`

Signal keeps the existing signal-origin color semantics. Guards receive their own condition color. Effects/actions receive a separate effect color.

The `<title>` continues to carry the canonical compact semantic string for accessibility/tooltips.

## OWASYS projection

`OwasysFsmDiagramBuilder` now requests `vertical` from the generic OPUS renderer.

The old `FsmDiagramGeometryNormalizer(..., 0.60)` call is removed for this projection because it is a horizontal-corridor normalizer and physical scaler. Vertical OPUS layout now owns its geometry directly.

OWASYS CSS makes the vertical SVG fill 100% of the native EFSM canvas width while keeping height automatic and document-driven.

## Files

Exactly 3 complete files:

1. `Opus/Fsm/Diagram.class.php`
2. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
3. `sites/owasys-front/www/asset/css/fsm-native.css`

No menu template, NavigationBuilder, FSM definition, ACL, route, controller or backend file is changed.

## Artifact

`opus_p117w_r45b2a4bg_vertical_page_width_readable_efsm.zip`

SHA-256:

`c4b43c0d21856ccc02fec02cedf77b56ce68e19e5b026a2a168855fa6528e1e9`

## Validation

- ZIP contains exactly 3 complete files;
- PHP lint `Diagram.class.php`: OK;
- PHP lint `FsmDiagramBuilder.php`: OK;
- no trailing whitespace;
- vertical renderer smoke: `A4BG_VERTICAL_EFSM_OK`;
- horizontal compatibility smoke: `A4BG_HORIZONTAL_COMPAT_OK`;
- OWASYS full-definition geometry stress render: 88 transition labels;
- stress SVG dimensions: approximately `1930 x 5227` internal units;
- transition label boxes outside viewBox: 0;
- transition label box overlaps in stress render: 0;
- technical signal, guards and effects are emitted on distinct SVG text rows.

## Runtime acceptance

After applying A4BG over the local A4BE/A4BF tree:

1. menu must remain byte/behavior unchanged from A4BF;
2. OWASYS main diagnostic EFSM must run top-to-bottom;
3. it must fill the available page width with no horizontal diagram scrollbar required in normal desktop use;
4. page/document may become tall and scroll vertically;
5. each technical transition label must show the signal key first;
6. each guard must appear on its own following line and in a distinct condition color;
7. actions/effects must appear on a following line in a third visual color;
8. signal origin colors remain user versus automatic only;
9. actionable diagnostic signals remain clickable through the existing EFSM execution path;
10. no transition semantic data may be removed solely to make the layout fit vertically.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
