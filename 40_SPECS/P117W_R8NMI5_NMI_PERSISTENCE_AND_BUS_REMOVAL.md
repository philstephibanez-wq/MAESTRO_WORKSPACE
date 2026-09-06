# P117W R8NMI5 — NMI persistence and bus removal

Date: 2026-09-06
Status: delivery specification

## Owner evidence

R8NMI4 runtime behavior is visually accepted for red NMI edges, anchoring, Bézier editing and movable NMI source. Reload does not preserve the moved NMI marker. The horizontal dashed NMI bus is considered semantically ambiguous and must be removed.

## Root cause

`Opus\Fsm\FsmDiagramLayoutStore::definitionMarkerSet()` currently whitelists the initial marker and finite-global-source markers only. The R8NMI4 renderer emits `markers.nmi`, but `normalizeMarkerGeometryMap()` drops it because `nmi` is not in that whitelist. The persistence defect is therefore in the generic OPUS layout-store marker contract, not in OWASYS or in the SVG drag effect.

## Required behavior

1. A canonical NMI marker exists in the layout store if the FSM definition contains at least one transition with `interrupt=nmi` and `from=*`.
2. `markers.nmi = {x,y}` is accepted, normalized, written and reloaded under `OPUS_FSM_DIAGRAM_LAYOUT_V4`.
3. The NMI marker remains non-semantic presentation geometry; the canonical FSM definition remains the semantic source of truth.
4. The horizontal dashed NMI source bus is removed. Only the NMI marker and its real transition edges remain visible.
5. Existing initial-marker, finite-global-source, state, signal-card and transition persistence must not regress.
6. R8NMI4 red edges, arrow heads, anchoring, draggable Bézier controls and movable NMI source remain intact.

## Delivery

Native differential ZIP applied by the owner to `H:\OPUS`. The store update must be guarded against baseline mismatch and the final OPUS worktree must contain no delivery helper after application.