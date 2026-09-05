# P117W R45B2A4BZ2R8B6R1 — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Governing diagnosis

The owner runtime screenshot after R8B6R proves the NMI palette is correct but ordinary backend transitions are still grey.

The cause is canonical source metadata, not CSS: `sites/owasys-back/config/fsm.json` declares its signals with no `origin`, so the generic OPUS renderer emits `signal-origin-unspecified` and uses the unspecified grey transition color.

## Correction

Only additive canonical signal-origin metadata is introduced in the backend FSM source:

- `receive` -> `user`;
- `authenticate` -> `automatic`;
- `authorize` -> `automatic`;
- `dispatch` -> `automatic`;
- `succeed` -> `automatic`;
- `fail` -> `automatic`.

No topology, state, transition, geometry, route, guard, action, REST behavior, Composer behavior or NMI semantics change.

## Expected visual result

- external ingress `receive`: generic user-signal color;
- internal backend processing: generic automatic-signal color;
- NMI: red, unchanged;
- states/geometry/topology: unchanged.

## Delivery contract

Native differential ZIP containing exactly one complete file at its final path:

`sites/owasys-back/config/fsm.json`

Owner applies, validates, then commits/pushes OPUS/OWASYS. Assistant does not commit or push OPUS/OWASYS.

README-FIRST stepwise gate remains mandatory: one CMD step is issued at a time and the owner returns the complete output before the next gate.