# P117W R8NMI10 handoff

Date: 2026-09-07

Owner rejected R8NMI9 because the Bézier handles disappeared. The accepted visual baseline for handle presence is R8NMI8.

Root cause corrected in R8NMI10:
- the ordinary OPUS SVG pointerdown handler already classified Bézier handles but returned without invoking the drag engine;
- R8NMI8 added a second capture listener to compensate;
- R8NMI9 complicated that acquisition path further and regressed handle visibility;
- R8NMI10 removes the extra capture path and invokes `beginBezierDrag()` directly from the ordinary pointerdown branch.

Delivery scope:
- `Opus/Fsm/Diagram.class.php` only, complete final file;
- based on R8NMI8 visual behavior, not R8NMI9;
- PHP lint and embedded JavaScript syntax validated before delivery.

Owner acceptance sequence:
1. Verify baseline/diff state.
2. Apply native ZIP.
3. PHP lint and `git diff --check`.
4. Start owasys-front dev server.
5. Select an NMI transition: C1/C2 handles must be visible.
6. Drag C1/C2: curve must update continuously.
7. Reload: curve geometry must persist.
8. Commit/push OPUS only after acceptance.

Assistant does not commit or push OPUS/OWASYS.