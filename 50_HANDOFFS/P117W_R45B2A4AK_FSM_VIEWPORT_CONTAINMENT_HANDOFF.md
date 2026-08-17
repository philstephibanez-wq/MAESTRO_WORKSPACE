# P117W R45B2A4AK — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

A4AI owner commit:

`1c86e851fa989473468edf86962b3648e19a0911`

A4AJ was applied locally by the owner for global-rail autocollapse but is not yet visible as a new OPUS remote commit. A4AK therefore includes the A4AJ `navigation.score` file cumulatively.

## Owner finding

The menu no longer consumes half the page vertically, but the page can still become much wider than the viewport. The browser must not require a wider monitor or page-level horizontal scrolling to use OWASYS.

## Root cause

The menu flex row and fixed-width FSM diagram are intrinsic-width surfaces without a strict component-level inline-size boundary. Their width can propagate to the document.

The FSM topology itself is not the defect and must not be reordered or scaled merely to fit.

## Delivery

Artifact:

`opus_p117w_r45b2a4ak_fsm_viewport_containment.zip`

SHA-256:

`a881aca0eb080096963b7ed82001395ca4b1a7e66693ec9b278a7febbed61024`

Complete files:

- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/www/asset/css/fsm-native.css`

## Behavior after application

- menu no longer enlarges document width;
- it remains one row where space permits and wraps only when necessary;
- dropdown signals remain overlays and exclusive native autocollapse is retained;
- FSM panel/canvas are capped to viewport/container width;
- fixed diagram geometry remains unchanged;
- a wide diagram scrolls inside its own canvas only;
- no JavaScript, REST, backend, ACL, FSM model or profiler behavior changes.

## Owner validation

Apply A4AK over the current A4AI+A4AJ checkout, restart `owasys-front`, then verify at the same browser width that:

1. there is no page-level horizontal scrollbar caused by FSM UI;
2. the menu remains fully reachable without widening the document;
3. opening Applications and another state still autocollapses exclusively;
4. the fixed diagram is complete and scrolls only inside its bordered canvas when needed;
5. current-state highlight, typed colors and actionable cyan labels are unchanged.

Do not mark A4AK accepted before browser validation.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.