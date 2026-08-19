# P117W R45B2A4BH — Handoff

State: OWNER RUNTIME REJECTED — SUPERSEDED BY A4BI

## Baseline / dependency

Owner GitHub OPUS HEAD remains:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

Owner runtime evidence confirms A4BE, A4BF, A4BG and A4BH applied locally. Menu work remains frozen.

## What A4BH improved

A4BH correctly removed the huge fake page-height rails caused by exploding finite global transitions from arbitrary representative states. Each finite `scope=global` transition is represented once and canonical signal / guards / effects remain visible.

## Owner runtime evidence rejecting A4BH geometry

Screenshots supplied after A4BH show the geometry is still not acceptable as a developer diagnostic:

- global transition cards are arranged laterally beside target states;
- this inflates every state cell width and forces the resource rank to consume nearly the whole page;
- navigation cards such as `open_structure`, `open_security`, `open_fsm`, `open_source`, `open_build` visually collide with or crowd target-state columns;
- self-loop technical transitions still consume edge/label geometry around their state;
- the vertical SVG is still forced to `width:100%` by the OWASYS CSS override despite the intended intrinsic-width contract;
- signal font sizing remains too large for compact technical cards.

The owner reiterated that page width is only a maximum available width, not a target width.

## Supersession rule

A4BI replaces only the EFSM diagnostic geometry. The menu remains frozen and must not be changed.

A4BI direction:

- finite global transitions become compact ingress stacks immediately above their target state;
- same-state/self-loop diagnostic transitions become compact stacks immediately below their state;
- only real state-to-state transitions keep drawn arcs;
- global/self cards use fixed collision-free positions while local transition labels route around them;
- vertical multi-line collision boxes use their real height instead of the old horizontal single-line approximation;
- SVG uses intrinsic width with `max-width:100%`;
- diagram card uses `fit-content` capped by the page;
- technical signal/guard/effect typography is reduced while keeping three distinct semantic levels/colors.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
