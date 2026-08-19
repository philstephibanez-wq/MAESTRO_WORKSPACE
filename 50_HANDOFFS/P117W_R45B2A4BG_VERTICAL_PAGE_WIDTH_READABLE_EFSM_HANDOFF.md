# P117W R45B2A4BG — Handoff

State: OWNER RUNTIME REJECTED — SUPERSEDED BY A4BH

## Baseline / dependency

Owner GitHub OPUS HEAD remains:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

Owner runtime evidence confirms A4BE, A4BF and A4BG are applied locally. Menu work remains explicitly frozen. A4BG is diagram-only.

## Owner runtime evidence

A4BG correctly changed the diagnostic to a vertical EFSM and separated signal / guards / effects, but the runtime result is rejected on geometry/readability.

Observed defects from owner screenshots:

- extreme unused vertical space between ranked states;
- forced page-width behavior even when the graph does not need the full width;
- numerous very long vertical side rails dominating the page;
- repeated `logout` rails from many source states;
- global EFSM transitions visually projected from invented representative source states, producing misleading and noisy long edges;
- useful local workflow relations become visually secondary to the global rails.

Owner clarified the width rule:

- page width is a maximum available width, not a mandatory diagram width;
- the diagram should consume only the width it needs and shrink to the page maximum when necessary;
- vertical height remains free, but must be compact and purposeful rather than padded.

## Root cause

The A4BG generic vertical renderer used deliberately large fixed values (`rankGap`, horizontal margins and outer-lane offsets). More importantly, `OwasysFsmDiagramBuilder` converted every finite `scope=global` transition to an arbitrary representative state-to-state edge; `logout` was expanded from every applicable source state. This projection is the main source of the side-rail explosion.

A finite global EFSM transition is not semantically a transition from one arbitrary representative state. The visual projection therefore needs first-class global-scope treatment.

## Supersession

A4BH replaces the A4BG geometry policy while retaining:

- vertical top-to-bottom state flow;
- canonical technical keys;
- distinct signal / guard / effect lines and colors;
- signal-origin color semantics;
- diagnostic clickability;
- no menu changes.

A4BH groups each finite global transition once beside its target state and preserves its canonical `from_states` metadata instead of creating long representative rails.

## Historical A4BG artifact

`opus_p117w_r45b2a4bg_vertical_page_width_readable_efsm.zip`

SHA-256:

`c4b43c0d21856ccc02fec02cedf77b56ce68e19e5b026a2a168855fa6528e1e9`

Exactly 3 complete files.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
