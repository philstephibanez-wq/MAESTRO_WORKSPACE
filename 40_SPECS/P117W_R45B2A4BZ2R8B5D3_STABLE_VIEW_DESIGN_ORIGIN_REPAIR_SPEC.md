# P117W R45B2A4BZ2 R8B5D3 — Stable VIEW/DESIGN origin repair — SPEC

State: READY FOR OWNER APPLY

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- `sites/owasys-front/www/asset/css/fsm-native.css` blob: `085e6a9e68b775461f18e5276e4b4c95d5b76d29`.
- `sites/owasys-front/application/default/services/ScorePageRenderer.php` blob: `0512c3427a190f4a6184710372d78e21f758b39f`.
- Current persisted Security layout is canonical `OPUS_FSM_DIAGRAM_LAYOUT_V4`, horizontal, canvas `1736x504`.

## Runtime evidence

The same persisted Security EFSM was captured in VIEW and DESIGN after R8B5D2.

Four STATE rectangles were measured:

- VIEW: `(374,643)`, `(636,736)`, `(859,621)`, `(1350,643)`;
- DESIGN: `(209,380)`, `(471,475)`, `(694,358)`, `(1185,380)`.

Every X coordinate differs by exactly `165 px`; relative geometry is unchanged. Therefore R8B5D persistence/readback is correct and R8B5D2 removed scale divergence. The remaining defect is only the origin of the whole intrinsic SVG.

## Root cause

`fsm-native.css` contains layered historical responsive rules.

Current cascade facts:

1. base FSM SVG is centered with `margin-inline: auto`;
2. R8B5D2 removes `max-width: 100%` shrink from the SVG;
3. VIEW has a wider canvas, so the intrinsic SVG is centered;
4. DESIGN reserves the inspector column, so the intrinsic SVG is wider than its canvas and the auto-margin result changes;
5. the entire graph is therefore translated even though all persisted coordinates are identical;
6. final `P117W_R45B2A4BG` also overrides earlier `overflow-x: auto` with `overflow-x: hidden`, which is incompatible with intrinsic-width diagrams.

## Required correction

R8B5D3 is cumulative from clean GitHub baseline `f053f569...` and changes exactly two OWASYS-front files.

### `fsm-native.css`

- three FSM SVG shrink constraints: `max-width: 100%` -> `max-width: none`;
- base FSM SVG: `margin-inline: auto` -> `margin-inline: 0`;
- vertical FSM SVG: `margin-inline: auto` -> `margin-inline: 0`;
- final canvas cascade: `overflow-x: hidden` -> `overflow-x: auto` while keeping `overflow-y: visible`.

Resulting contract:

- persisted coordinates are intrinsic and unchanged;
- the SVG origin is always the left edge of its canvas in VIEW and DESIGN;
- DESIGN inspector may reduce visible width but must not translate or rescale the graph;
- wide diagrams scroll horizontally inside the FSM canvas.

### `ScorePageRenderer.php`

Only FSM CSS cache-buster changes to `p117w-r45b2a4bz2r8b5d3`.

No JS revision change.

## Non-goals

R8B5D3 does not change:

- EFSM definitions;
- persisted layout JSON;
- R8B5D remote layout REST/Composer flow;
- ACL;
- SecurityContext/SignalBus;
- backend code;
- designer semantics;
- STATE/SIGNAL coordinates.

## Delivery/validation contract

Because R8B5D2 is currently local and unpushed while GitHub remains at `f053f569...`, owner first restores only:

- `sites/owasys-front/www/asset/css/fsm-native.css`;
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`.

No layout companion file is restored.

Applicator must then require:

- exact clean HEAD `f053f569...`;
- exact two baseline blobs;
- exact replacement anchors;
- renderer PHP lint;
- exact 2-file differential;
- zero untracked files;
- clean index;
- `git diff --check`;
- unchanged HEAD;
- no internal Composer invocation.

Owner executes `composer opus:validate-site -- owasys-front` externally after application.

## Runtime acceptance

For the same application/EFSM and unchanged persisted layout:

1. open VIEW and record STATE/SIGNAL geometry;
2. open DESIGN;
3. VIEW and DESIGN must use identical intrinsic scale and identical left-origin placement;
4. inspector appearance must not translate the SVG;
5. F5 in either mode must preserve geometry;
6. if canvas width is smaller than intrinsic graph width, horizontal scroll must appear instead of shrink or clipping.
