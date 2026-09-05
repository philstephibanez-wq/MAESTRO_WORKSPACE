# P117W R45B2A4BZ2R8B6R1 — OWASYS back signal origin repair

Status: READY FOR OWNER APPLICATION
Date: 2026-09-05

## Owner evidence

Runtime screenshot after R8B6R shows the NMI correctly red but every ordinary transition remains renderer-unspecified grey.

## Root cause

The generic OPUS renderer already colors transitions from canonical `signal_origin` semantics:

- `user` -> `--opus-fsm-signal-user` (cyan fallback);
- `automatic` -> `--opus-fsm-signal-automatic` (amber fallback);
- missing origin -> `unspecified` -> ordinary edge grey.

`sites/owasys-back/config/fsm.json` currently declares six signals without `origin`. Therefore OPUS correctly renders every ordinary backend transition as `signal-origin-unspecified`. A CSS recolor cannot repair that missing semantic source metadata and would violate the generic-first/source-of-truth contract.

## Correction

Add canonical origin metadata only to the six existing backend signals. No state, transition, route, geometry, guard, action, REST behavior or NMI topology changes.

Canonical classification:

- `receive` -> `origin: user` because it is the externally initiated ingress signal at the backend boundary;
- `authenticate` -> `origin: automatic`;
- `authorize` -> `origin: automatic`;
- `dispatch` -> `origin: automatic`;
- `succeed` -> `origin: automatic`;
- `fail` -> `origin: automatic`.

The NMI remains red through the existing NMI semantic theme token; its signal origin remains independently automatic.

## Acceptance

On `owasys-back` Navigation EFSM:

- `receive` transitions render with the generic user-signal color;
- internal backend processing transitions render with the generic automatic-signal color;
- NMI remains red;
- all geometry/topology remains unchanged;
- no OWASYS-only hardcoded ordinary transition recolor is introduced.

## Delivery

Native differential ZIP containing exactly the complete final file:

- `sites/owasys-back/config/fsm.json`

Owner applies locally, validates, then commits/pushes OPUS. Assistant updates MAESTRO_WORKSPACE directly only.