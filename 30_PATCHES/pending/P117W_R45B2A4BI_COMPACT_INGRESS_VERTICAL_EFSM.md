# P117W R45B2A4BI — Compact ingress vertical EFSM

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Scope

Diagram only. Menu work is frozen.

A4BI is a small differential over local A4BH.

## Runtime problem

A4BH removed fake global rails but still wastes developer workspace because global transition cards sit beside their target states. This doubles effective cell width and crowds same-rank resource states. The OWASYS vertical CSS also still forces the SVG to `width:100%`.

## Required diagnostic geometry

### Global finite transitions

Finite `scope=global` transitions have no unique local source. They are rendered once as an ingress stack immediately above their target state.

Each card retains:

- canonical signal ID;
- guards on dedicated lines;
- action/effect on a dedicated line;
- `global` scope badge;
- clickable diagnostic action where applicable;
- canonical `from_states` in diagnostic metadata/title.

Only the lowest card in a target ingress stack draws one short arrow into the state. No synthetic page-wide source rail is introduced.

### Self loops

Local transitions whose source equals target are represented as compact cards immediately below the state, with a `self` badge. They retain signal / guards / effects but no longer consume large loop geometry around the node.

Only genuine state-to-state transitions remain routed as arcs.

### Layout

For each rank, cell width is the maximum of:

- state node width;
- widest global ingress card for the state;
- widest self-loop card for the state.

Global ingress height is reserved above the rank. Self-loop height is reserved below the rank. This makes width content-driven and shifts density into the permitted vertical direction.

### Collision model

A4BI pre-reserves deterministic global and self-loop card rectangles before routing local transition labels. Local labels therefore avoid those cards.

Vertical multi-line labels use a vertical collision rectangle based on the actual centered card width and height. The previous horizontal single-line collision approximation is not reused.

### Width contract

OWASYS vertical SVG:

- `width:auto`;
- `max-width:100%`;
- centered;
- height auto.

The diagram card uses `width:fit-content; max-width:100%` and is centered. Page width is therefore a maximum, not a forced target.

### Typography

Diagnostic hierarchy remains technical and non-I18n:

- signal: primary origin color, reduced to 11.5 px;
- guard: dedicated condition color, 9.5 px;
- effect: dedicated effect color, 9.5 px;
- scope badge: compact technical annotation.

## Artifact

`opus_p117w_r45b2a4bi_compact_ingress_vertical_efsm.zip`

SHA-256:

`cd054e2e5b5cbac07ce1f5cc3172a5bfb9b666ffbaf7c0566d355cc477c42c7d`

Exactly 3 complete files:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/www/asset/css/fsm-native.css`

No menu file.

## Validation

Representative OWASYS builder-equivalent filtered definition:

- 71 displayed transitions;
- 46 finite global cards;
- 54 scope badges including compact self cards;
- SVG approximately `1152 × 3132` units;
- transition-card overlaps: 0;
- transition-card/state overlaps: 0;
- PHP lint: 2/2 OK;
- no trailing whitespace;
- ZIP contains exactly the 3 expected files.

The increased height relative to A4BH is intentional: width and crossing density are traded for vertical diagnostic readability, as explicitly requested by the owner.

Owner alone applies, validates, commits and pushes OPUS/OWASYS.
