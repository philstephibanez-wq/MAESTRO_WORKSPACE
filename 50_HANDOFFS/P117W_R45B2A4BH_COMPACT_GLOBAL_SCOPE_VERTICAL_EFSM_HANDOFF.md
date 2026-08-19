# P117W R45B2A4BH — Handoff

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline / dependency

Owner GitHub OPUS HEAD remains:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

Owner runtime evidence confirms A4BE, A4BF and A4BG applied locally. A4BH is intentionally a small differential over A4BG. Menu work remains frozen.

## Runtime evidence leading to A4BH

A4BG verticalized the EFSM and separated signal / guards / effects, but owner screenshots show the geometry remains unacceptable:

- excessive blank vertical bands;
- page width forced even when not required;
- long vertical side rails dominating the page;
- repeated `logout` rails;
- global transitions projected from arbitrary representative states.

Owner clarified that page width is a maximum, not a target width.

## A4BH correction

### Global transitions are first-class diagnostic objects

Finite `scope=global` transitions are no longer converted to fake representative local edges.

`OwasysFsmDiagramBuilder` passes each global transition once with:

- `from=@global` presentation source;
- original `scope=global`;
- filtered canonical `from_states`;
- original transition ID, target, signal, guards, actions and runtime operations.

The generic vertical renderer displays one compact global card beside the target state. `logout` is therefore no longer exploded from every state.

The global card visibly retains:

- technical signal ID;
- guard lines;
- effect/action line;
- a small `global` scope marker.

The full `from_states` set is preserved in diagnostic metadata/title.

### Compact content-driven vertical layout

A4BH replaces the fixed A4BG 520-unit rank gap with row-specific dimensions computed from actual state/global-card content.

Rows use:

- compact state nodes;
- only the global card width/height actually needed by their states;
- bounded rank separation;
- compact local self-loops;
- bounded left-side rails for genuine long local returns.

The local workflow remains top-to-bottom.

### Width contract corrected

The vertical SVG is now intrinsic width with `max-width:100%`, not forced `width:100%`.

OWASYS canvas/card no longer uses `width:max-content` for this diagram.

Result:

- narrower graph -> narrower rendered diagram;
- graph needing page width -> may use page width;
- graph wider than page -> scales down to page maximum;
- no artificial horizontal stretching.

### Signal / guard / effect readability retained

A4BG's semantic separation remains:

```text
signal
[guard]
[guard]
/ effect
```

Signal keeps origin color; guards and effects keep dedicated colors.

## Artifact

`opus_p117w_r45b2a4bh_compact_global_scope_vertical_efsm.zip`

SHA-256:

`281bdf91b9971f06ff28af102f180983066fbe5af379bd2168891ea44073fd66`

Exactly 3 complete files:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/www/asset/css/fsm-native.css`

No menu file is included.

## Validation performed

Using the current complete OWASYS EFSM for stress rendering:

- rendered transitions: 88;
- finite global transitions are represented once rather than exploded into long representative rails;
- SVG approximately `1998.5 × 2709` units;
- A4BG stress height was approximately `5227` units;
- 88 transition cartouches;
- cartouche/cartouche overlaps: 0;
- cartouches outside viewBox: 0;
- state nodes outside viewBox: 0;
- PHP lint: 2/2 OK;
- ZIP file count: 3;
- no trailing whitespace.

## Owner acceptance

1. Extract A4BH over A4BG.
2. Restart front.
3. Do not validate menu behavior in this slice; no menu work is included.
4. Check that the EFSM uses only the width it needs, capped by page width.
5. Check that the large empty vertical bands are gone.
6. Check that global operations appear as compact cards beside their target states.
7. Check that repeated page-height `logout` and other global rails are gone.
8. Check that true local state-to-state workflow transitions remain readable.
9. Check signal / guards / effects on distinct lines and colors.
10. Check clickable diagnostic actions still execute the same canonical EFSM transition.

## Next work

Continue only EFSM diagnostic geometry/readability until owner acceptance. Do not modify menu unless owner explicitly reopens that scope.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
