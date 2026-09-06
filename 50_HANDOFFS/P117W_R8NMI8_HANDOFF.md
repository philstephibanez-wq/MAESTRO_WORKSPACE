# P117W R8NMI8 handoff

Date: 2026-09-06

Owner feedback: after R8NMI7, NMI Bézier handles are visible but cannot be dragged.

Authoritative sources reviewed from GitHub:
- `README-FIRST.md` and native ZIP workflow contract;
- `sites/owasys-front/www/asset/js/fsm-designer.js`, which dynamically creates `.fsm-designer-bezier-preview` handles on transition inspection;
- current OPUS FSM renderer lineage as applied through the owner workflow.

R8NMI8 changes only complete `Opus/Fsm/Diagram.class.php`.

Acceptance:
1. PHP lint passes.
2. Embedded layout JavaScript passes `node --check`.
3. `git diff --check` passes locally.
4. Selecting an NMI cubic transition shows C1/C2.
5. Dragging C1 or C2 with left or right mouse button deforms the curve immediately.
6. Releasing persists the cubic geometry and reload preserves it.
7. NMI marker movement/persistence and ordinary state/signal/marker dragging remain functional.

Assistant does not commit or push OPUS/OWASYS. Owner applies, validates, commits and pushes after acceptance.