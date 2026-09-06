# P117W R8NMI7 — Bézier handle input

Date: 2026-09-06
Status: delivery specification

## Owner evidence

R8NMI6 renders the NMI cubic Bézier handles C1/C2 correctly, but the owner reports that the handles are not usable.

## Root cause

The generic OPUS layout interaction script applies inconsistent pointer-button semantics:
- state, signal-card and diagram-marker layout drag uses the right mouse button (`button=2`);
- Bézier handles alone reject every pointer button except the left mouse button (`button=0`).

This makes the handles appear inert when the established diagram-layout right-drag gesture is used.

## Required behavior

1. NMI Bézier handles C1/C2 accept both left-drag and right-drag.
2. Existing right-drag behavior for states, signal cards and markers is unchanged.
3. Context-menu suppression remains active while right-dragging a Bézier handle.
4. The existing manual cubic update, geometry snapshot and persistence path are reused unchanged.
5. No OWASYS-specific geometry implementation is introduced; the fix remains generic in `OPUS_FSM_Diagram`.

## Delivery

Native differential ZIP containing only the complete changed framework file at its final repository path, applied by the owner to `H:\OPUS`.
