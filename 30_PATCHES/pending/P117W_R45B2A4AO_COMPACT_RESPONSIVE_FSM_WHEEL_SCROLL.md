# P117W R45B2A4AO — Compact responsive FSM + wheel scroll

Status: OWNER COMMITTED — FOLLOW-UP A4AP REQUIRED FOR SHARED LOGOUT ACTIONABILITY
Date: 2026-08-17

## Baseline

Accepted OPUS baseline before A4AO:

`5e8e5d2287e6c9720d61bf7cab7ae604c4811dee`

This is A4AN bounded orthogonal FSM routing.

A4AO is now committed by the owner in OPUS:

`f23d1912cfb2163c409143d9915f6952d66f8379`

## Owner validation

The compact/responsive presentation is retained. The owner confirms the new result visually and proceeds from the committed A4AO baseline.

Validated/retained A4AO behavior:

- reduced vertical diagram footprint;
- responsive width without the previous horizontal FSM scrollbar at the tested desktop viewport;
- regular-weight signal labels;
- normal page mouse-wheel scrolling over the FSM;
- A4AN bounded orthogonal routing and merged logout rails.

## Remaining defect discovered after commit

The visible merged `logout` rail label is not always clickable.

This does not invalidate the canonical logout FSM or its route. The defect is in the visual actionability ownership after rail merging:

- `NavigationBuilder` correctly exposes `logout` as actionable for the current state when the route and target are available;
- `FsmDiagramBuilder` attaches that URL to the displayed logout clone representing the current state;
- `FsmDiagramGeometryNormalizer` chooses one visible label owner only inside each `outer-*` visual rail family;
- when the current actionable logout clone is a short/non-outer edge, the merged outer logout rail label may therefore belong to a passive clone and retain no `<a>`.

Follow-up: P117W R45B2A4AP.

## A4AO contract retained

### Compact vertical viewBox

Generic `Opus\Fsm\FsmDiagramGeometryNormalizer` derives visible vertical bounds from state rectangles, semantic edge paths and signal label backgrounds, and crops unused vertical viewBox space with a deterministic safety margin.

### Responsive width

OWASYS FSM SVG uses intrinsic width with `max-width:100%` and `height:auto`; the FSM surface does not own horizontal page scrolling.

### Mouse-wheel ownership

The FSM canvas is not a vertical scroll container (`overflow:clip`, `overscroll-behavior:auto`), so vertical wheel input belongs to the OWASYS page.

### Signal typography

Diagram/actionable/menu signal labels use regular weight `400`.

### Revisions

- `OwasysFsmDiagramBuilder::REVISION = P117W_R45B2A4AO`;
- stylesheet cache identity `p117w-r45b2a4ao`;
- routing identity `bounded-orthogonal-v6-responsive`.

## Delivery record

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

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
