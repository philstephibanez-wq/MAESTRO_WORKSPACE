# P117W R45B2A4AO — Handoff

State: OWNER COMMITTED — FOLLOW-UP A4AP REQUIRED FOR SHARED LOGOUT ACTIONABILITY

## Committed baseline

A4AO is committed by the owner in OPUS:

`f23d1912cfb2163c409143d9915f6952d66f8379`

A4AN bounded orthogonal routing remains underneath it and the shared logout rails are retained.

## Owner validation retained

The owner accepts the compact/responsive direction and continues from A4AO. Retained behavior:

- materially reduced vertical footprint;
- responsive width at the tested desktop viewport;
- regular-weight signal labels;
- normal OWASYS page wheel scrolling while the pointer is over the FSM;
- no regression of fixed canonical state order/current-state highlight;
- A4AN shared logout rail geometry retained.

## Remaining defect

The visible shared `logout` label is not always clickable.

Root cause is now confirmed as presentation ownership, not FSM/route/security:

1. `config/fsm.json` declares `logout` as a global navigation signal from all 16 states to `login`.
2. `config/routes.json` maps route `logout` to signal `logout`.
3. `NavigationBuilder` correctly marks that global action actionable for the current state when target availability and route mapping permit it.
4. `FsmDiagramBuilder` expands logout into state-specific visual clones and attaches the current action URL to the clone matching the current state.
5. `FsmDiagramGeometryNormalizer` merges only long `outer-*` clones into shared visual rail labels.
6. If the current-state clone is a short/non-outer transition, its `<a>` remains on that local clone while the visible merged outer rail label is owned by a passive clone.

Therefore the visual bus can say `logout` while lacking the exact current logout URL.

This is corrected by A4AP through generic semantic actionability propagation in the OPUS geometry normalizer.

## A4AO delivery record

Artifact:

`opus_p117w_r45b2a4ao_compact_responsive_wheel_scroll.zip`

SHA-256:

`9d8a1f93b3edac62f311003e415763cab70432a092149a29abea63d950a64c36`

No further A4AO modification is required; use committed A4AO as the baseline for A4AP.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
