# P117W R45B2A4AL — FSM diagram 80 percent

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED
Date: 2026-08-17

## Owner request

Reduce the rendered FSM diagram to 80% while keeping the accepted fixed canonical topology.

## Baseline

A4AK viewport containment remains the baseline. A4AL is cumulative from the A4AK `fsm-native.css`.

## Constraint

This is presentation only:

- no FSM state/transition change;
- no route change;
- no diagram reordering;
- no routing recomputation;
- no change to current-state highlight;
- no change to signal typing or actionable cyan behavior.

## Implementation

Scale only `.ow-fsm-native-canvas .fsm-diagram` to 80% using layout-aware CSS `zoom: .8`.

Do not use `transform: scale(.8)` because that leaves the original 100% layout footprint and would reintroduce unnecessary canvas width/height.

The A4AK component-level viewport containment remains unchanged.

## Artifact

`opus_p117w_r45b2a4al_fsm_diagram_80_percent.zip`

SHA-256:

`8a554d6616afa1a09b62bafab2138efa8933147b3a246df101494dd9576f1926`

Complete replacement file:

`sites/owasys-front/www/asset/css/fsm-native.css`

## Acceptance

1. Diagram renders at approximately 80% of A4AK visual size.
2. Fixed geometry/order remains identical.
3. Current state remains highlight-only.
4. Signal labels and clickable hitboxes remain aligned with their edges.
5. Diagram canvas footprint shrinks with the rendered SVG; no 100% ghost area.
6. A4AK viewport containment and menu behavior remain unchanged.
7. Owner validates in browser before acceptance.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
