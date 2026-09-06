# P117W R8NMI4 handoff

Date: 2026-09-06

Owner feedback driving this increment:
- NMI arrows preferred red;
- Bézier handles were not visible as required;
- NMI source must be movable.

Authoritative OPUS baseline reviewed from GitHub: `Opus/Fsm/Diagram.class.php` on master, with R8NMI3 applied only through the owner workflow.

R8NMI4 delivery scope is one complete framework file: `Opus/Fsm/Diagram.class.php`.

Acceptance evidence required from owner after extraction:
1. `php -l Opus\Fsm\Diagram.class.php` passes.
2. `git diff --check -- Opus/Fsm/Diagram.class.php` passes.
3. NMI edge and arrow head are red.
4. NMI Bézier controls C1/C2 are visible and draggable in writable design mode.
5. Right-drag of the NMI marker moves the NMI source and keeps all NMI edges attached.
6. Reload preserves NMI marker position and authored curve geometry.
7. Return full command output and runtime evidence before commit/push.

Assistant does not commit or push OPUS/OWASYS. Owner validates, commits and pushes after acceptance.
