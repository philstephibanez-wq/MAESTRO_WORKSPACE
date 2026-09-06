# P117W R8NMI8 — Bézier handle capture

Date: 2026-09-06
Status: delivery specification

## Owner evidence

After R8NMI7, NMI Bézier handles C1/C2 are visible but remain unusable.

## Cause treated

The OPUS FSM renderer still starts Bézier drag through delegated bubbling on the SVG. In the OWASYS designer projection, the visible handles may be injected dynamically by `fsm-designer.js`; acquisition through the generic bubbling listener is not reliable enough for this composed surface.

## Required behavior

1. Bézier C1/C2 acquisition is handled in SVG capture phase before designer bubbling/click handling.
2. The handle type gate accepts generic SVG elements carrying the contracted Bézier attributes instead of depending on `SVGCircleElement` specifically.
3. Both mouse buttons 0 and 2 remain accepted for Bézier handles.
4. Existing OPUS move/update/persistence logic remains authoritative; no OWASYS-local geometry implementation is introduced.
5. Existing state, signal-card and marker dragging behavior must not regress.

## Delivery

Native differential ZIP containing only the complete changed `Opus/Fsm/Diagram.class.php` at its final repository path.