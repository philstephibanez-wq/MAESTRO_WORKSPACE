# P117W R8NMI12 handoff

## Delivery
Native differential ZIP containing one complete OPUS file at its final path:
- `Opus/Fsm/Diagram.class.php`

## Baseline
Owner local state after R8NMI11. R8NMI12 changes only the JavaScript regex literals inside `simpleCubicPath()` back to the pre-R8NMI3 semantics evidenced by GitHub history.

## Root cause
R8NMI3 doubled JavaScript regex escapes inside a PHP nowdoc. The cubic path parser then stopped recognizing numeric SVG path data, so the generic drag handler aborted before creating `drag` for every Bézier transition, not only NMI.

## Validation gates
- verify ZIP SHA-256 and contents;
- extract at `H:\OPUS`;
- `php -l Opus\Fsm\Diagram.class.php`;
- `git diff --check`;
- inspect diff: only the two JavaScript regex literals are reverted relative to R8NMI11;
- run `composer opus:dev-server -- owasys-front`;
- verify one normal transition and one NMI transition: C1/C2 move;
- reload and verify persisted geometry remains;
- verify NMI marker, anchoring, red rendering and no horizontal bus regress.

Assistant never commits or pushes OPUS/OWASYS. Owner validates, commits and pushes only after acceptance.
