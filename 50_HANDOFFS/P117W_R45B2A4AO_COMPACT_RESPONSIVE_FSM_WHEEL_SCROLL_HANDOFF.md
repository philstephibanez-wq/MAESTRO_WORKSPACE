# P117W R45B2A4AO — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Accepted baseline

A4AN is owner-validated and committed in OPUS:

`5e8e5d2287e6c9720d61bf7cab7ae604c4811dee`

The bounded orthogonal routing and shared logout rails are retained.

## Owner follow-up

The owner requests:

- less vertical height;
- preferably no horizontal diagram scrollbar at the desktop viewport;
- regular-weight signal labels;
- normal mouse-wheel page scrolling while the pointer is over the FSM.

## Diagnosed wheel defect

A4AN leaves the diagram canvas as a vertical scroll container:

`overflow-y:auto` + `overscroll-behavior:contain`.

This can trap wheel chaining while the pointer is over the large FSM surface. A4AO removes local vertical scroll ownership; the document owns vertical wheel scrolling again.

## Delivery

Artifact:

`opus_p117w_r45b2a4ao_compact_responsive_wheel_scroll.zip`

SHA-256:

`9d8a1f93b3edac62f311003e415763cab70432a092149a29abea63d950a64c36`

Complete files:

1. `Opus/Fsm/FsmDiagramGeometryNormalizer.php`
2. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
3. `sites/owasys-front/application/default/services/ScorePageRenderer.php`
4. `sites/owasys-front/www/asset/css/fsm-native.css`

No patcher and no deletion.

## A4AO changes

### Generic OPUS normalizer

- external rail/node gaps are tightened;
- after A4AN routing, visible vertical bounds are derived from state rectangles, all FSM edge paths and signal label backgrounds;
- unused vertical viewBox space is cropped with a 22-unit safety margin;
- canonical x coordinates and semantic width are unchanged;
- routing identity becomes `bounded-orthogonal-v6-responsive`.

Synthetic A4AI/A4AN smoke:

- prior viewBox: `0 0 3856 1256`;
- A4AO viewBox: `0 34 3856 1016`;
- edge geometry: Y `80..1028`;
- new viewBox bottom: `1050`;
- intrinsic physical SVG: `2313.6 x 609.6` versus A4AN `2313.6 x 753.6`;
- approximately 19% less intrinsic height before responsive fitting.

### OWASYS responsive surface

The SVG keeps its intrinsic physical size when it fits, but uses `max-width:100%` and `height:auto` when the panel is narrower. The card is width-contained and the canvas no longer exposes a local horizontal scrollbar.

The canvas uses `overflow:clip` and `overscroll-behavior:auto`; it is not a scroll container. Mouse-wheel vertical input over the diagram should therefore continue scrolling the OWASYS document.

### Typography/cache

- diagram signal labels: `font-weight:400`;
- actionable signal labels: `font-weight:400`;
- menu signal code: `font-weight:400`;
- signal size remains enlarged for readability;
- SVG visible title is hidden to avoid owning otherwise-unused top viewport space; semantic `<title>` accessibility remains;
- `OwasysFsmDiagramBuilder::REVISION = P117W_R45B2A4AO`;
- stylesheet cache id: `p117w-r45b2a4ao`.

## Pre-delivery checks

- PHP lint passes for all three delivered PHP files;
- no trailing whitespace in the four delivered files;
- generic normalizer runtime smoke passes;
- compact viewBox contains all smoke edge geometry;
- ZIP contains exactly the four complete final-path files listed above.

## Owner browser validation

Apply over committed A4AN, restart owasys-front, hard-refresh, then verify:

1. wheel over the FSM scrolls the page vertically;
2. no horizontal FSM scrollbar at the current desktop viewport;
3. full diagram remains visible inside the panel;
4. height is materially lower than A4AN;
5. signal labels are regular, not bold;
6. logout shared rails remain correct;
7. current-state highlight, signal colors and actionable cyan focus/click remain intact;
8. no menu/FSM/REST/ACL behavior regression.

Do not mark A4AO accepted before owner browser validation.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
