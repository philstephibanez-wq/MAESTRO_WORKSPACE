# P117W R8NMI8 — Bézier pointer capture

Status: DELIVERED — runtime acceptance pending

## Context

R8NMI7 corrected the accepted pointer buttons for Bézier handles but the owner reported no observable runtime change. The next bounded correction therefore targets event acquisition rather than geometry or persistence.

## Cause addressed

The OPUS diagram interaction recognized Bézier handles, but acquisition depended on the bubbling `pointerdown` path and an overly specific `SVGCircleElement` type test. This allowed downstream handlers or DOM typing differences to prevent drag acquisition before the generic OPUS interaction owned the gesture.

## Change

`Opus/Fsm/Diagram.class.php`:

- relax Bézier handle typing from `SVGCircleElement` to `SVGElement` while retaining the explicit draggable/data-role contract;
- add a capture-phase `pointerdown` path dedicated to Bézier handles;
- acquire C1/C2 before bubbling handlers, stop immediate propagation once acquired and set pointer capture on the handle when available;
- keep existing pointermove geometry updates, `setManualCurve`, save-signal persistence and all state/marker/signal drag semantics unchanged;
- keep left and right pointer buttons valid for Bézier acquisition.

## Artifact

- ZIP: `R8NMI8.zip`
- ZIP SHA-256: `25c95f51e91fbf84d76b02d2df385b6290e8bf266bc2bf7f75af80fd64bdb972`
- file: `Opus/Fsm/Diagram.class.php`
- file SHA-256: `120691a8e4c11261e8104a294d2899ef8ceef1ce0623d24984aa39127cc403a9`
- expected pre-file SHA-256 from R8NMI7: `9c07a77a1c544f23d7958ae67041c0c3a454322a3d0e1706093eca918dabe970`

## Validation

- PHP syntax: OK
- extracted inline JavaScript syntax: OK
- runtime acceptance remains owner-controlled.

## Acceptance

In OWASYS front design mode, selecting an NMI transition and dragging C1 or C2 must move the cubic curve; reload must preserve the saved geometry. If that does not occur, the next action is runtime instrumentation of writable flag, overlay type and SVG pointer listeners rather than another speculative pointer patch.
