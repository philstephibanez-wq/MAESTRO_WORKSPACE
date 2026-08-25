# P117W R45B2A4BZ2 R8B6H — Horizontal finite-global EFSM rendering — SPEC

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `1f94204116ad4ea26df6a040ad9a37b8134fb745`.
- R8B6D is owner-applied and pushed at that commit.
- R8B6C and R8B6D must not be reapplied.

## Proven defect

`OPUS_FSM_Diagram::fromTransitions()` canonically represents a finite `scope=global` transition with `from=@global` and preserves `from_states`. The vertical renderer owns this semantic case. The horizontal renderer did not: it continued to the local-source lookup, found no position for `@global`, and returned an empty SVG fragment.

The Navigation EFSM data is therefore correct. The defect is generic OPUS presentation logic.

## Required correction

The horizontal renderer must render each finite global transition exactly once:

- keep the canonical transition ID;
- show the canonical signal name;
- show the finite source-set semantics;
- attach the rendered transition to its canonical target state;
- preserve `from=@global`, `scope=global`, `from_states` and target metadata;
- keep one persistence geometry entry per canonical transition;
- leave state positions, canvas persistence and EFSM definitions unchanged.

When `from_states` equals the complete rendered state set, the compact visible source-set label is `from: {all N states}`. Otherwise the declared finite state IDs remain visible.

## Forbidden regressions

- no derived transition IDs;
- no expansion to one edge per source state;
- no representative fake source;
- no page-wide rail;
- no OWASYS-local renderer;
- no Navigation configuration rewrite;
- no change to `FsmProcessor`;
- no change to persisted state-position or canvas schema.

## Exact source surface

Modified only:

- `Opus/Fsm/Diagram.class.php` — baseline blob `1c307116bd6da961f9afcab62b47bc1a87131c64`.

## Acceptance

The owner must prove:

1. PHP lint and `git diff --check` pass.
2. `owasys-front`, `owasys-back` and `essai` validate.
3. Navigation renders all seven `open_*` signals and all seven `*_context_ready` self-loops.
4. Every `open_*` card is visibly attached to its target and exposes the finite global source-set semantics.
5. Switching View/Conception and reloading preserves state positions.
6. Moving and saving a transition card persists under its canonical ID; no derived transition key appears.
7. No state/canvas geometry is changed merely by rendering finite global transitions.
