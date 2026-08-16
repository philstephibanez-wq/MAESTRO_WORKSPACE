# P117W R45B2A4AC — FSM actionable cyan + overlap-free labels

State: OWNER VALIDATION REQUIRED

## Baseline

Accepted OPUS baseline:

`0ce2dfa9a1c7175ac39f93b2ee017ed6e40643ac` — A4Z fixed classic FSM.

Owner working tree also contains:

- A4AA signal hitbox/focus CSS;
- A4AB current-state semantic action mapping.

A4AB functional behavior is owner-validated for `change_app` and `logout` and must not regress.

## Owner feedback — 2026-08-16

Owner validates `change_app` and `logout` but reports:

1. cyan curves can appear without a corresponding actionable/focused label;
2. transition labels/paths still overlap around dense branches and returns.

## Root causes

### Cyan ambiguity

OWASYS `fsm-native.css` maps both:

- actionable signal labels to `var(--ow-accent)`;
- generic FSM return edges through `--opus-fsm-return: var(--ow-accent)`.

Therefore a passive backward/return edge can appear cyan even when it has no link. Cyan is visually ambiguous.

### Classic-layout overlaps

`OPUS_FSM_Diagram` A4W/A4Z only activates source-lane routing when `compactLayout === true`. A4Z deliberately uses the non-compact classic layout, so dense forward fan-outs still share central routing space.

Additional collision sources:

- same-rank vertical transitions are routed above the upper node, colliding with self-loops;
- backward return labels use pair-local spread only;
- transition label boxes are emitted without global label/node collision reservation.

## A4AC correction

### Generic OPUS renderer

`Opus/Fsm/Diagram.class.php`:

- extends lane-aware source routing to non-compact forward fan-outs;
- increases classic rank/row separation moderately;
- uses source/target ports for classic forward/backward routing;
- routes same-rank vertical transitions around the ranked column instead of over the upper state;
- adds target-aware separation to backward returns;
- reserves every transition label rectangle before rendering;
- collision reservation checks both earlier transition labels and all state-node rectangles;
- deterministic X/Y nudging is used only for visual label placement; transition semantics/topology remain unchanged;
- actionable rendered transitions receive class `actionable`;
- actionable SVG anchors receive explicit `role=link`, `tabindex=0`, `focusable=true`;
- renderer routing fingerprint becomes `lane-aware-v3`.

### OWASYS theme

`sites/owasys-front/www/asset/css/fsm-native.css`:

- `--opus-fsm-return` is no longer cyan; passive return edges use the muted theme token;
- cyan is reserved for `.fsm-transition.actionable` and its signal label;
- actionable path and label are both cyan at rest;
- hover/focus/focus-visible increase path/label-box emphasis with cyan halo;
- passive edges never advertise actionability through cyan alone.

### Runtime interaction

A4AB `FsmDiagramBuilder.php` is included intact apart from revision attestation. Current-state semantic action mapping remains:

- runtime actionability comes only from Menu=FSM/NavigationBuilder;
- fixed displayed representative is selected by `signal + target`;
- exact current-source representative is preferred;
- no fabricated route and no ACL bypass.

### Cache bust

`ScorePageRenderer.php` updates only the `fsm-native.css` query revision to `p117w-r45b2a4ac`, so normal restart/reload receives the new stylesheet without relying on an old A4T cache key.

## Direct differential artifact

`opus_p117w_r45b2a4ac_fsm_actionable_cyan_no_overlap.zip`

SHA-256:

`627185acaa0e09200ce54b122d21ec731212e4fccc7162985fdb61797ded88f7`

Complete final-path files only:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/www/asset/css/fsm-native.css`

File SHA-256:

- `Diagram.class.php`: `7a44d518c94965a2b9594e09d5e95a9299dee00ac6aed3c21b648109631e678e`
- `FsmDiagramBuilder.php`: `a5e233e8feb7ced670e625bcb4a3e554cc85037dd0c9ea648d39d8bac1a255e5`
- `ScorePageRenderer.php`: `65953d6c8873eb48410ddc5fffde297cc952e1eb7383d837db89d339072df917`
- `fsm-native.css`: `d60dd7391632d00b00174e604f361e0add536e78572cd89821b56848e6abf699`

## Pre-delivery validation actually executed

PHP lint:

- `Diagram.class.php`: success;
- `FsmDiagramBuilder.php`: success;
- `ScorePageRenderer.php`: success.

Synthetic A4Z-topology renderer smoke:

- states: 10;
- displayed transitions/labels: 29;
- label-label overlaps: 0;
- label-node overlaps: 0;
- actionable transition groups: 10;
- rendered signal links: 10;
- explicit focusable links: 10;
- actionable group/link count mismatch: 0;
- routing fingerprint `lane-aware-v3`: present.

## Owner acceptance

After extraction/restart on `/fr-FR/applications`:

1. A4Z fixed topology remains recognizable and stable;
2. current state remains highlight-only;
3. A4AB `change_app` and `logout` remain operational;
4. cyan paths always correspond to a currently actionable cyan label;
5. passive return paths are muted, not cyan;
6. keyboard Tab lands only on real actionable signal links and produces visible cyan focus;
7. dense labels no longer overlap each other;
8. transition labels do not cover state boxes;
9. dense forward fan-outs and same-rank returns are visibly more separated;
10. menu autocollapse remains unchanged.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.