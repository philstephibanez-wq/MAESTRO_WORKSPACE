# P117W R8NMI6 handoff

Date: 2026-09-06

Owner runtime evidence after R8NMI5:
- NMI source marker visually correct and movable;
- NMI persistence accepted;
- horizontal NMI bus removed;
- selected NMI transition reports `layout.path_kind = cubic_bezier`;
- Bézier handles still not visible.

Root cause confirmed from current GitHub OWASYS designer source plus the R8NMI5 OPUS renderer delivery: `fsm-designer.js` creates `.fsm-designer-bezier-preview` with C1/C2 draggable handles when the cubic transition is inspected, but the OPUS renderer CSS hides that preview unconditionally for every NMI transition.

R8NMI6 scope:
- one complete file: `Opus/Fsm/Diagram.class.php`;
- native NMI controls add `has-native-nmi-bezier-controls` only when present;
- OWASYS preview is hidden only when that explicit native-control class exists;
- no persistence-store change.

Owner acceptance:
1. PHP lint and `git diff --check` pass.
2. Select `nmi.security_violation` (or any cubic NMI transition) in design mode.
3. C1/C2 Bézier handles and control lines are visible and draggable.
4. Dragging a handle changes the curve and survives the existing persistence flow.
5. NMI marker persistence and red routing remain unchanged.

Assistant does not commit or push OPUS/OWASYS.