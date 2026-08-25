# P117W R45B2A4BZ2 R8B6J — Movable finite-global transition rerouting — SPEC

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS HEAD remains `1f94204116ad4ea26df6a040ad9a37b8134fb745`.
- Required R8B6I working-file blob: `d7ebe8d4b31a062d8afcee43e5f1177d95432002`.
- R8B6I source-set logic is preserved; R8B6J replaces its complete renderer file.

## Cause

R8B6I declared every finite-global transition as anchored to its target. The editor therefore applied the target state's SVG translation to the complete transition group. Both ends moved together: the target remained attached, but the source endpoint left the fixed finite source-set node.

## Contract

For finite-global transitions:

- the source port is explicit immutable SVG metadata;
- the transition group has no state translation anchor;
- moving a target recomputes the path from the fixed source port to the target's current boundary;
- signal cards remain independently movable and persist under the canonical transition ID;
- geometry snapshots recompute the finite-global path before persistence;
- reload reconstructs source ports from canonical source groups and persisted state positions.

Local transitions, self-loops, NMI, state persistence and EFSM definitions are unchanged.

## Acceptance

Move every Navigation state in Conception. During drag, its `open_*` arrow must remain connected both to the finite source-set node and to the moving target. Save/reload must preserve state and signal-card coordinates and regenerate attached paths without derived IDs.
