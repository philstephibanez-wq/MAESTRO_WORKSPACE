# P117W R45B2A4AO — Compact responsive FSM + wheel scroll

Status: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED
Date: 2026-08-17

## Baseline

Accepted OPUS baseline:

`5e8e5d2287e6c9720d61bf7cab7ae604c4811dee`

This is A4AN bounded orthogonal FSM routing, owner-validated and committed.

## Owner requests

1. reduce diagram height further;
2. make the diagram fit the available width without horizontal scrolling if possible;
3. signal labels must not be bold;
4. mouse-wheel vertical scrolling over the FSM must scroll the OWASYS page normally.

## Root causes

### Vertical height

A4AN bounds all external rails but retains the original SVG viewBox height even when large top/bottom areas no longer contain visible FSM geometry.

### Horizontal scrolling

A4AN emits a physically scaled SVG but the canvas/card still uses intrinsic `max-content` behavior and explicit local overflow. A diagram wider than the panel therefore still creates a horizontal scrollbar.

### Mouse wheel

A4AN CSS leaves `.ow-fsm-native-canvas` as `overflow-y:auto` with `overscroll-behavior:contain`. The large diagram therefore remains a vertical scroll container under the pointer and can prevent wheel chaining to the page.

### Signal typography

A4AN uses `font-weight:900` for diagram signal labels and `font-weight:850` for actionable labels. The menu signal code also remains bold.

## A4AO contract

### 1. Compact vertical viewBox

Extend generic `Opus\Fsm\FsmDiagramGeometryNormalizer` after A4AN routing normalization.

Compute visible vertical bounds from:

- state rectangles;
- all semantic `fsm-edge` paths;
- signal label backgrounds.

Crop only unused vertical viewBox space with a deterministic safety margin. Horizontal coordinates and canonical viewBox width remain unchanged.

SVG title/subtitle/legend are presentation-only and are hidden in OWASYS, so they do not own vertical geometry.

### 2. Tighter orthogonal rails

Reduce generic outer-rail guards/gaps while preserving separation:

- node-to-rail gap reduced;
- rail min/max separation reduced;
- all normalized paths remain inside the compacted viewport.

### 3. Responsive width without horizontal scroll

OWASYS FSM SVG uses intrinsic width with `max-width:100%` and `height:auto`.

Therefore:

- if the intrinsic physical SVG fits, its A4AN physical size is preserved;
- if it is wider than the FSM panel, it shrinks to the panel width with its aspect ratio preserved;
- the FSM canvas no longer owns a horizontal scrollbar.

No semantic x coordinate or state order changes.

### 4. Mouse-wheel ownership

The FSM canvas is not a scroll container in A4AO:

- `overflow: clip`;
- `overscroll-behavior:auto`;
- no local vertical scroll ownership.

Vertical mouse-wheel input over the diagram therefore belongs to the OWASYS document/page again.

### 5. Signal typography

Diagram signal labels and actionable signal labels use regular weight `400`.

Menu signal code also uses regular weight `400`.

State labels remain emphasized and unchanged semantically.

### 6. Revisions/cache

- `OwasysFsmDiagramBuilder::REVISION = P117W_R45B2A4AO`;
- FSM stylesheet cache identity becomes `p117w-r45b2a4ao`;
- normalizer routing identity becomes `bounded-orthogonal-v6-responsive`.

## Geometry smoke

Using the A4AI/A4AN synthetic projection:

- semantic width remains `3856`;
- previous viewBox height: `1256`;
- A4AO compact viewBox: `0 34 3856 1016`;
- normalized edge Y range: `80..1028`;
- compact viewBox bottom: `1050`;
- therefore all edge geometry remains inside the compact viewBox with a 22-unit safety margin;
- physical intrinsic size at 60% becomes `2313.6 x 609.6` instead of A4AN `2313.6 x 753.6`;
- intrinsic height reduction: approximately 19% before responsive width fitting.

## Delivery

Artifact:

`opus_p117w_r45b2a4ao_compact_responsive_wheel_scroll.zip`

SHA-256:

`9d8a1f93b3edac62f311003e415763cab70432a092149a29abea63d950a64c36`

Four complete files:

1. `Opus/Fsm/FsmDiagramGeometryNormalizer.php`
2. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
3. `sites/owasys-front/application/default/services/ScorePageRenderer.php`
4. `sites/owasys-front/www/asset/css/fsm-native.css`

No patcher. No deletion.

## Acceptance

1. At the owner desktop viewport the FSM should fit the panel width without a horizontal scrollbar.
2. Diagram height is visibly lower than A4AN.
3. No signal edge or label is clipped by the compact viewBox.
4. Signal labels are regular weight, not bold.
5. Mouse wheel over the diagram scrolls the OWASYS page vertically.
6. Shared logout rails and all A4AN routing behavior remain intact.
7. Cyan actionable labels remain hoverable, focusable and clickable.
8. State order/current-state highlight/signal colors/menu FSM semantics remain unchanged.
9. No REST, ACL, session, backend or FSM semantics change.
10. Owner alone applies, validates, commits and pushes OPUS/OWASYS.
