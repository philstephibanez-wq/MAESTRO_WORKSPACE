# P117W R45B2A4BZ2 R8B6K — Persistable finite-global source marker — SPEC

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS exact baseline/master: `636b3cc9d98e33cfbac5dcea58a2188e4e77c8de`.
- R8B6J and its Navigation layout are owner runtime accepted and pushed.

## Remaining generic inconsistency

The shared designer persists movable states, signal cards and the legacy initial pseudo-state marker. R8B6I/J introduced a real presentation marker for each distinct finite-global source set, but that marker remained deterministic-only and could not be moved or stored.

A developer could therefore arrange states and transition cards while the shared finite-source origin remained fixed.

## Contract

R8B6K treats each distinct canonical finite `from_states` set as one non-semantic diagram marker:

- stable marker ID derived only from the ordered canonical source set;
- draggable with the existing right-button marker interaction;
- stored in the existing V4 `markers` map;
- validated by `FsmDiagramLayoutStore` against finite-global source sets present in the canonical definition;
- restored before source ports and paths are rendered;
- all transitions belonging to the marker reroute live during marker movement;
- marker coordinates and canonical transition geometry persist in the same atomic layout snapshot.

The marker stores presentation geometry only. EFSM semantics remain exclusively in `from_states`.

## Compatibility

- existing `initial` marker behavior remains;
- no layout contract/schema version change;
- old layouts without the finite-source marker self-extend;
- stale or unknown marker IDs remain filtered;
- no derived transition ID;
- no Navigation-specific implementation;
- no backend JavaScript.

## Exact surface

- `Opus/Fsm/Diagram.class.php`;
- `Opus/Fsm/FsmDiagramLayoutStore.php`.

## Acceptance

Move the finite source-set node in Conception. All seven `open_*` paths must reroute live from their distinct ports. Reload and View/Conception switching must preserve the node, states and signal cards. The layout JSON must contain exactly one `finite-global-source-*` marker for the Navigation source set.
