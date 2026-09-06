# P117W R8NMI10 — Bézier pointerdown unification

Date: 2026-09-07
Status: delivery specification

## Owner evidence

R8NMI9 rejected: NMI Bézier handles disappeared. R8NMI8 is the last accepted visual baseline where C1/C2 handles are present.

## Root cause

The OPUS diagram runtime had two competing pointerdown paths for Bézier controls. The ordinary SVG pointerdown path recognized `target.kind === 'bezier'` and then returned without starting a drag, while R8NMI8 introduced a second capture-phase listener to compensate. This split acquisition path is fragile with dynamically inserted OWASYS preview controls.

## Required correction

1. Rebase the correction on R8NMI8 visual behavior.
2. Remove the compensating capture-phase Bézier pointerdown listener.
3. Start `beginBezierDrag(event, target)` directly from the ordinary SVG pointerdown handler whenever `target.kind === 'bezier'`.
4. Preserve existing NMI rendering, red arrows, NMI marker movement/persistence and Bézier geometry persistence.
5. Do not modify OWASYS business semantics or owasys-back.
6. Validate PHP syntax and embedded JavaScript syntax before delivery.

## Delivery

Native differential ZIP containing only the complete `Opus/Fsm/Diagram.class.php` at its final repository path. Owner applies, validates and performs runtime test before commit/push.