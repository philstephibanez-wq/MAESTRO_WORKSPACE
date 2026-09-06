# P117W R8NMI9 handoff

Date: 2026-09-06

Owner runtime evidence after R8NMI8:
- NMI red rendering: retained;
- NMI marker movement/persistence: retained;
- Bézier handles visible: yes;
- Bézier handles draggable: no.

R8NMI9 changes only `Opus/Fsm/Diagram.class.php` relative to R8NMI8.

Implementation:
- direct pointerdown binding on C1/C2;
- MutationObserver binds handles injected dynamically by OWASYS after selection;
- pointermove and pointerup/pointercancel handled at window scope;
- existing OPUS geometry snapshot and persistence path retained.

Acceptance:
1. PHP lint and JS syntax pass.
2. Select an NMI transition.
3. Drag C1 and C2; curve must update continuously.
4. Release outside or inside SVG; persistence must complete.
5. Reload; authored cubic geometry must remain.
6. No regression of NMI marker persistence or red rendering.

Assistant does not commit or push OPUS/OWASYS. Owner validates, commits and pushes after acceptance.