# P117W R45B2A4BH — Compact global-scope vertical EFSM

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline / dependency

Owner GitHub OPUS HEAD remains:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

Owner runtime evidence shows A4BE, A4BF and A4BG applied locally. A4BH is a small differential over A4BG. Menu work remains frozen and no menu template/service is changed.

## Owner requirement

The diagnostic EFSM must remain vertical, technical and interactive, but must use workspace efficiently:

- width is intrinsic and may grow only up to the page maximum;
- page width is not mandatory when a narrower diagram is sufficient;
- height is free but must be compact, with no arbitrary large blank bands;
- signal, guards and actions/effects remain on distinct lines and with distinct visual colors;
- global transitions must not explode into long rails or fake representative state-to-state edges;
- local state-to-state workflow relations must remain visually primary.

## Root cause addressed

A4BG used generous fixed vertical rank spacing and side-lane offsets. More importantly, `OwasysFsmDiagramBuilder` converted finite `scope=global` transitions to representative local edges and expanded `logout` from every source state.

That produced both visual noise and a misleading geometry: a global transition does not originate from one arbitrary representative state.

## A4BH generic OPUS behavior

`OPUS_FSM_Diagram` now preserves finite global transition metadata:

- `scope=global`;
- canonical `from_states`;
- canonical target state;
- signal / guards / actions / runtime operations;
- signal origin and type.

In vertical mode, a global transition is rendered once as a compact technical cartouche attached to its target state. The cartouche contains:

```text
signal
[guard]
[guard]
/ effect
global
```

The small `global` marker is diagnostic metadata, not I18n.

The short connector terminates on the target state. The complete canonical source-state set remains available in the transition metadata/title rather than being expanded into multiple long state edges.

## Compact vertical layout

Vertical rows are no longer separated by a fixed 520-unit rank gap.

Layout is calculated from actual content:

- compact state node size;
- global cartouche stack size beside each target state;
- row-specific width;
- row-specific height;
- bounded rank gap;
- bounded local return rail spacing.

States sharing a rank remain ordered by canonical `state.diagram` hints. Global cards sit beside their target node, so they consume only the local row height/width they require.

Long local returns use a bounded left-side rail band. The previous alternating far-left/far-right corridors are removed for vertical mode.

## Width contract

Vertical SVG CSS becomes:

- intrinsic `width:auto`;
- `max-width:100%`;
- `height:auto`.

OWASYS canvas centers the SVG and no longer forces a `max-content` card wider than necessary.

Therefore:

- a narrow EFSM remains narrow;
- a wide EFSM may use the full page;
- an EFSM wider than the page is scaled down to the page maximum;
- the page never forces unused horizontal width into the diagram.

## Builder correction

`OwasysFsmDiagramBuilder` no longer:

- expands `logout` from every applicable source;
- selects an arbitrary representative source for a finite global transition.

Each canonical global transition is passed once with `from=@global`, `scope=global` and its filtered canonical `from_states` set. This is presentation metadata only; the EFSM definition remains the source of truth.

Current-state diagnostic actions still attach to the same canonical transition ID, so clickable testing continues through the existing EFSM execution path.

## Files

Exactly 3 complete files:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/www/asset/css/fsm-native.css`

No menu template, NavigationBuilder, route, ACL or FSM definition is modified.

## Artifact

`opus_p117w_r45b2a4bh_compact_global_scope_vertical_efsm.zip`

SHA-256:

`281bdf91b9971f06ff28af102f180983066fbe5af379bd2168891ea44073fd66`

## Validation

Full-definition stress render using the current 17-state / 89-transition OWASYS EFSM (NMI excluded from the ordinary transition render) produced:

- 88 rendered transitions;
- all finite global transitions rendered once as target-attached global cards;
- SVG approximately `1998.5 × 2709` units;
- previous A4BG stress height was approximately `5227` units;
- transition-label boxes: 88;
- transition-label overlaps: 0;
- out-of-viewBox transition boxes: 0;
- out-of-viewBox state nodes: 0;
- PHP lint: 2/2 OK;
- ZIP complete-file count: 3;
- no trailing whitespace.

The stress dimensions are not a fixed contract; they demonstrate that height is now content-driven rather than padded.

## Owner runtime acceptance

1. Apply A4BH over the local A4BG tree.
2. Restart only `owasys-front` if required.
3. Ignore the menu for this validation; it is intentionally untouched.
4. Confirm the diagram no longer forces full page width when unnecessary.
5. Confirm vertical whitespace is substantially reduced.
6. Confirm global signals such as `logout`, `open_applications`, CRUD resource signals, etc. appear once as compact `global` cards adjacent to their target state rather than as page-height rails.
7. Confirm local workflow state-to-state edges remain visible and readable.
8. Confirm signal / guard / effect lines and colors remain distinct.
9. Confirm current actionable diagnostic signals remain clickable through the same EFSM path.
10. Continue geometry refinement only if runtime readability still fails; do not reopen menu work.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
