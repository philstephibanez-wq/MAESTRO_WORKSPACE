# P117W R8NMI5 handoff

Date: 2026-09-06

Owner feedback after R8NMI4:
- red NMI edges: accepted;
- NMI anchoring: accepted;
- Bézier handles: accepted;
- movable NMI source: accepted;
- NMI position persistence after reload: failing;
- horizontal dashed NMI bus: remove.

Authoritative OPUS source review identified the persistence cause in `Opus/Fsm/FsmDiagramLayoutStore.php`: `definitionMarkerSet()` does not recognize the `nmi` marker, so marker normalization discards `markers.nmi` before persistence.

R8NMI5 scope:
1. retain the R8NMI4 complete `Opus/Fsm/Diagram.class.php`, minus the obsolete horizontal NMI bus;
2. extend the generic OPUS layout-store marker whitelist so a canonical NMI definition (`interrupt=nmi`, `from=*`) authorizes marker id `nmi`;
3. guard the layout-store mutation against an unexpected Git blob baseline;
4. leave no delivery helper in the OPUS source root after application.

Acceptance evidence required from owner:
1. PHP lint passes for Diagram and FsmDiagramLayoutStore.
2. `git diff --check` passes.
3. Move NMI, release, reload: NMI remains at the persisted position.
4. NMI arrows and manual Bézier curves remain attached after reload.
5. Horizontal dashed NMI bus is absent.
6. Initial and finite-global markers still persist normally.
7. Return complete command output and runtime evidence before commit/push.

Assistant does not commit or push OPUS/OWASYS. Owner validates, commits and pushes after acceptance.