# P117W R8NMI11 — Handoff

## Scope

Deliver one native differential ZIP containing the complete final-path file:

- `Opus/Fsm/Diagram.class.php`

## Regression provenance

GitHub pre-NMI source proves the generic Bézier drag was already implemented in the normal SVG `pointerdown` path. The NMI iterations replaced that working path with helper/capture variants, which regressed C1/C2 interaction globally.

## Delivery

R8NMI11 restores the pre-NMI generic Bézier pointerdown path and removes the NMI-era helper acquisition path while preserving accepted NMI rendering/persistence behavior.

## Validation gate

Owner applies ZIP, runs PHP lint and `git diff --check`, then starts `owasys-front`. Runtime acceptance requires movable C1/C2 on one ordinary cubic transition and one NMI transition, followed by reload persistence.
