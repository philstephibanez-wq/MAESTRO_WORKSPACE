# P117W R8NMI7 handoff

Date: 2026-09-06

Owner runtime evidence after R8NMI6:
- NMI arrows, marker movement and persistence are acceptable;
- Bézier handles are visible;
- handles are reported unusable.

Authoritative cause review:
- `OPUS_FSM_Diagram` currently accepts only left-button pointerdown for Bézier drag;
- all other persisted layout objects use right-button drag;
- no separate OWASYS Bézier drag implementation exists in `fsm-designer.js`.

R8NMI7 delivery scope:
- complete `Opus/Fsm/Diagram.class.php` only;
- allow C1/C2 drag with either button 0 or button 2;
- retain existing persistence and geometry code unchanged.

Acceptance evidence required from owner:
1. PHP lint passes.
2. `git diff --check` passes.
3. Select an NMI transition so C1/C2 are visible.
4. Drag C1 with left mouse button and verify curve deformation.
5. Drag C2 with right mouse button and verify curve deformation without context menu.
6. Reload and verify the authored cubic geometry persists.
7. Return full command output/runtime evidence before commit/push.

Assistant does not commit or push OPUS/OWASYS. Owner validates, commits and pushes after acceptance.
