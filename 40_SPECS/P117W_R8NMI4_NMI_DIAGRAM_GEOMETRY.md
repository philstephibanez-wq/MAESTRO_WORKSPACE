# P117W R8NMI4 — NMI diagram geometry

Date: 2026-09-06
Status: delivery specification

## Scope

Generic OPUS FSM diagram behavior for non-maskable interrupts (`interrupt=nmi`, `from=*`). No OWASYS-only semantic workaround is permitted.

## Required behavior

1. NMI transitions are visually distinct in red, including edge, label/leader and arrow head.
2. Every NMI edge starts on the visible NMI source boundary and remains attached to its target state boundary.
3. NMI cubic Bézier control handles are available whenever layout persistence is writable; the controls do not depend on the OWASYS inspector selection overlay.
4. The NMI source marker itself is movable using the same persisted diagram-marker mechanism as the initial marker and finite-global sources.
5. Moving the NMI marker reroutes all automatic NMI transitions immediately and translates the source endpoint/control of manually authored NMI Bézier curves.
6. Moving a target state reroutes/reanchors its NMI transition.
7. NMI marker coordinates and transition geometry survive persistence/reload.
8. Existing local, self-loop and finite-global transition behavior must not regress.

## Delivery

Native differential ZIP containing only complete changed files at final repository paths, applied by the owner to `H:\OPUS`.
