# P117W R45B2A4BZ2 R8B6I — Finite-global source-node EFSM — SPEC

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS HEAD remains `1f94204116ad4ea26df6a040ad9a37b8134fb745`.
- R8B6H working-tree target blob: `85e37727b76c4dcd9b5258009ad53c355d7841b9`.
- R8B6H is runtime rejected and must not be committed.
- R8B6I replaces the complete `Opus/Fsm/Diagram.class.php`.

## Required EFSM semantics

Horizontal finite-global transitions are represented by:

1. one explicit source-set node for each distinct canonical `from_states` set;
2. the complete state set visible inside that node;
3. one path from a dedicated source-set port to each canonical target;
4. the canonical signal card on that path;
5. the original transition ID and persistence key.

For Navigation this is one node containing the seven states and seven named paths, not 49 duplicated state edges.

## Generic constraints

Distinct finite source sets produce distinct source nodes. NMI `from=*` remains separate and unchanged. No representative source, synthetic transition ID, OWASYS-local renderer, EFSM rewrite, state-position rewrite or persistence-schema change is allowed.

## Source surface

Only `Opus/Fsm/Diagram.class.php`.

## Acceptance

The runtime diagram must visibly prove `{registry, application, data, navigation, security, source, build} -> open_* -> target`. All self-loops and persisted state coordinates must remain stable. View/Conception and reload must retain state and canonical transition-card geometry.
