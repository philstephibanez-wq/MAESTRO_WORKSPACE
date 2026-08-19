# P117W R45B2A4BI — Handoff

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline / dependency

Owner GitHub OPUS HEAD remains:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

Owner has A4BE/A4BF/A4BG/A4BH applied locally. A4BI is intentionally a differential over A4BH. Menu work remains frozen.

## Runtime evidence leading to A4BI

A4BH is materially better than A4BG but owner screenshots still show poor workspace use:

- global cards crowd the side of `application`, `data`, `structure`, `security`, `workflows`, `source`, `build`;
- same-rank resource states expand to page width mainly because each state reserves a side column for global cards;
- `open_*` cards visually compete with the state nodes;
- the CSS still forces vertical SVG `width:100%`;
- multi-line technical cards are larger than needed.

## A4BI correction

### Compact target ingress

Finite global transitions are stacked immediately above their target. They no longer consume a second side column.

The stack preserves the full technical transition semantics. Only the lowest card draws one short arrow into the target state.

### Compact self transitions

Self transitions are stacked immediately below their state and carry a `self` badge. They no longer create external loop arcs and floating labels.

### Real arcs only

Drawn long arcs are reserved for actual state-to-state relationships. This makes the geometry communicate workflow instead of technical same-state/global noise.

### Correct collision geometry

Global and self cards are pre-reserved before local labels are routed. Vertical labels now use collision bounds based on their actual multi-line centered height. Local labels route around cards and states.

### Intrinsic width

The SVG and diagram card use intrinsic width capped at 100% of the available page. A narrow graph remains narrow; page width is used only if required.

### Technical readability

Signal / guards / effect remain on distinct lines and colors, with reduced diagnostic typography.

## Artifact

`opus_p117w_r45b2a4bi_compact_ingress_vertical_efsm.zip`

SHA-256:

`cd054e2e5b5cbac07ce1f5cc3172a5bfb9b666ffbaf7c0566d355cc477c42c7d`

Exactly 3 complete files:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/www/asset/css/fsm-native.css`

No menu file.

## Validation performed

- PHP lint 2/2 OK;
- representative builder-equivalent OWASYS diagnostic: 71 transitions;
- 46 global cards represented once;
- SVG approximately `1152 × 3132`;
- label/label overlaps: 0;
- label/state overlaps: 0;
- intrinsic vertical CSS confirmed (`width:auto`, `max-width:100%`);
- no trailing whitespace;
- ZIP exactly 3 files.

## Owner acceptance

1. Extract A4BI over A4BH.
2. Restart `owasys-front`.
3. Ignore menu behavior for this slice.
4. Verify the graph is no longer stretched to page width when it does not need it.
5. Verify global transition cards are stacked above their target state rather than beside it.
6. Verify self transitions appear below their state instead of as loop spaghetti.
7. Verify only true state-to-state relations retain long arcs.
8. Verify signal / guards / effects remain distinct and technical.
9. Verify clickable diagnostic cards still execute the canonical EFSM signal path.

Continue diagram-only refinement until owner acceptance. Do not reopen menu work without explicit owner instruction.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
