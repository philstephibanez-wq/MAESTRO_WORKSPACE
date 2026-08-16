# P117W R45B2A4AE — FSM traceable routing

State: OWNER VALIDATION REQUIRED

## Baseline

A4AE applies after A4AD (`opus_p117w_r45b2a4ad_account_password_fsm_split.zip`).

A4AD owner feedback confirms the Account / Password semantic split is better, but the fixed FSM remains visually too entangled. Owner specifically reports that `cancel_creation` appears unconnected and asks to inspect overlaps.

A4AE must preserve:

- canonical A4AD FSM semantics (`account` distinct from `password`);
- Menu = FSM;
- A4AB current-state semantic action mapping;
- A4AC actionable cyan/focus behavior;
- fixed geometry independent from current state;
- native SVG / no GraphViz / no JavaScript;
- menu autocollapse.

## Root causes

### Reverse-pair overlap

`registry --create_new_app--> creation` and `creation --cancel_creation--> registry` form a true bidirectional state pair. The A4AC renderer routes opposite directions through nearly the same corridor, so the return label/path can look detached or merged with the forward edge.

### Declaration-order ports

A4AC assigns source/target ports in transition declaration order. Declaration order is semantic, not geometric; around high-degree states this causes unnecessary edge crossings.

### Floating collision-resolved labels

A4AC can move an edge label by more than 100 px to avoid label/node collisions, but emits no visual leader from the original edge anchor to the moved label. A valid signal such as `cancel_creation` can therefore look disconnected.

### Equivalent `change_app` clutter

The fixed OWASYS projection displays five equivalent representatives of the global semantic signal `change_app` (`structure/security/workflows/source/build -> registry`). A4AB already maps current-state actionability by `signal + target`, so five displayed copies are not required to keep `change_app` operational everywhere.

### Account/password side branch in main corridor

Shortest-path BFS ranking places the new A4AD password branch too close to the main application workflow. The renderer needs optional presentation-only fixed rank/order hints so a projection can keep a side branch outside the dense business corridor without modifying FSM semantics.

## A4AE correction

### Generic OPUS renderer — `Opus/Fsm/Diagram.class.php`

- routing fingerprint becomes `lane-aware-v4`;
- generic optional `stateLayoutHints` are added to `renderDefinition()`;
- hints contain visual `rank` and `order` only and never modify FSM state/transition semantics;
- source ports are sorted by target geometry and target ports by source geometry;
- opposite transitions A→B / B→A use distinct upper/lower local corridors;
- long forward side branches can use an outer corridor;
- long backward returns use outer top/bottom corridors and vertical state ports instead of cutting through forward fan-out ports;
- non-compact rank/row spacing is increased moderately;
- collision-resolved labels choose the nearest available displacement first;
- when a label is displaced by at least 18 px, the renderer emits `fsm-label-leader` from the semantic edge anchor to the label;
- no transition is fabricated and every displayed edge remains a real canonical transition.

### OWASYS projection — `FsmDiagramBuilder.php`

Presentation-only layout hints keep:

- `login` at visual rank 0;
- `registry` at rank 1;
- `account`, `creation`, `data` at rank 2 in separate vertical lanes;
- `password`, `structure`, `security`, `workflows`, `source`, `build` at rank 3 with password as the upper side branch.

The projection reduces repeated `change_app` returns to one real canonical representative:

`data --change_app--> registry`

A4AB current-state semantic action mapping remains unchanged. Therefore that single displayed label still receives the current state URL whenever `change_app + registry` is actionable from the current state.

### OWASYS theme / cache

`fsm-native.css` styles label leaders as muted dashed connectors and cyan when the corresponding transition is actionable.

`ScorePageRenderer.php` bumps only the FSM CSS query revision to `p117w-r45b2a4ae`.

## Direct differential artifact

`opus_p117w_r45b2a4ae_fsm_traceable_routing.zip`

SHA-256:

`9a06348fe770a9d27d2cc5098f7cc2f834bcf46d781ebe02347f1518724d0ad0`

Complete final-path files only:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/www/asset/css/fsm-native.css`

## Pre-delivery validation actually executed

PHP lint:

- `Diagram.class.php`: success;
- `FsmDiagramBuilder.php`: success;
- `ScorePageRenderer.php`: success.

Static gates:

- framework class still implements `OPUS_FSM_DiagramInterface`;
- routing fingerprint `lane-aware-v4` present;
- geometry-aware port ordering present;
- bidirectional / outer-forward / outer-return routing present;
- `fsm-label-leader` present;
- exactly one `change_app -> registry` representative remains in the OWASYS fixed projection;
- representative is the canonical `data -> registry` transition.

Synthetic A4AD-topology renderer smoke:

- states: 11;
- projected transitions/labels: 26 (previous projection: 30);
- label-label overlaps: 0;
- label-node overlaps: 0;
- moved labels with explicit leaders: 3;
- long outer forward branches: 1;
- long outer returns: 2;
- approximate sampled path crossings: 7, versus 42 with the previous A4AC/A4AD projection under the same synthetic topology.

The crossing count is a geometric smoke metric, not a semantic acceptance criterion; owner browser validation remains authoritative.

## Owner acceptance

After extraction/restart:

1. A4AD Account / Password separation remains correct.
2. Fixed FSM remains independent from current state.
3. `cancel_creation` is visibly traceable from its label to the `creation -> registry` edge.
4. `create_new_app` and `cancel_creation` no longer visually collapse into one indistinguishable path.
5. `change_app` appears once as a representative signal instead of five redundant returns.
6. That single `change_app` label remains clickable from every runtime state where the FSM permits `change_app -> registry`.
7. `logout` remains globally usable where permitted.
8. Account/password branch is visually separated from the main application workflow.
9. No label overlaps another label or state box.
10. Dense fan-out from Applications/Data is materially easier to trace.
11. Cyan remains reserved for currently actionable transitions.
12. Keyboard focus and menu autocollapse remain unchanged.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.
