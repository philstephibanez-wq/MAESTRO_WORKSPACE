# P117W R45B2A4AL — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Owner request

Reduce the FSM diagram to 80%.

## Delivery

A4AL keeps the complete A4AK `fsm-native.css` and adds one presentation rule:

`.ow-fsm-native-canvas .fsm-diagram { zoom: .8; }`

The fixed canonical diagram topology is unchanged. The 80% scaling participates in layout sizing, so canvas/card dimensions shrink with the SVG instead of retaining a 100% invisible footprint.

## Artifact

`opus_p117w_r45b2a4al_fsm_diagram_80_percent.zip`

SHA-256:

`8a554d6616afa1a09b62bafab2138efa8933147b3a246df101494dd9576f1926`

Complete file:

`sites/owasys-front/www/asset/css/fsm-native.css`

No deletion required.

## Owner validation

Apply over A4AK, restart `owasys-front`, hard-refresh the browser, then verify:

- diagram is visually about 20% smaller in both dimensions;
- state order/topology does not move;
- edge labels remain attached;
- cyan actionable labels remain clickable/focusable;
- current state remains highlight-only;
- canvas scroll, when still needed, remains component-local;
- menu/autocollapse is unchanged.

Do not mark A4AL accepted before owner browser validation.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
