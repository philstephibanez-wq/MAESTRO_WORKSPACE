# P117W R45B2A4AC — Handoff

State: OWNER VALIDATION REQUIRED

## Current owner working tree

Expected before A4AC extraction:

- A4AA CSS modification applied;
- A4AB `FsmDiagramBuilder.php` modification applied;
- A4AB runtime behavior already validated for `change_app` and `logout`.

A4AC contains complete final versions of both files, so extraction is deterministic and does not depend on patch anchors.

## Root target

Keep the accepted A4Z fixed classic FSM, but make its visual semantics unambiguous and readable:

- cyan means currently actionable;
- passive return edges must not look actionable;
- actionable label box is visibly focusable/clickable;
- dense labels must not overlap each other or state boxes;
- classic non-compact fan-outs need the same lane separation discipline as compact fan-outs;
- same-rank vertical edges must route around their state column.

## Artifact

`opus_p117w_r45b2a4ac_fsm_actionable_cyan_no_overlap.zip`

SHA-256:

`627185acaa0e09200ce54b122d21ec731212e4fccc7162985fdb61797ded88f7`

Files:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/www/asset/css/fsm-native.css`

## What is preserved

- A4Z fixed root = canonical `initial_state` / Connexion;
- A4Z fixed state geometry/topology contract;
- current state = highlight only;
- Menu = FSM;
- native menu autocollapse;
- A4AB current-state semantic mapping for global/representative actions such as `logout`, `change_app`, `open_*`;
- ACL/availability and route source remain NavigationBuilder only.

## Renderer changes

- non-compact multi-edge forward fan-out uses source lanes;
- same-rank vertical transitions route around their rank column;
- backward returns receive target-aware spread;
- transition labels reserve non-overlapping rectangles against earlier labels and state nodes;
- actionable transition group carries `actionable` class;
- actionable SVG anchor is explicit keyboard link;
- routing marker is `lane-aware-v3`.

## Theme changes

- passive return edge token is muted, no longer cyan;
- actionable edge + label use cyan;
- hover/focus applies stronger cyan edge/box halo;
- CSS URL cache revision becomes `p117w-r45b2a4ac`.

## Validation already executed

All three PHP files lint successfully.

Synthetic fixed-FSM smoke result:

- 29 transition label boxes;
- 0 label-label overlaps;
- 0 label-node overlaps;
- 10 actionable groups;
- 10 signal links;
- 10 explicit focusable links;
- 0 actionable/link mismatch;
- `lane-aware-v3` present.

## Owner validation target

On `/fr-FR/applications` and at least one operational state:

- verify `change_app` and `logout` still execute normally;
- verify every cyan edge has a cyan actionable label;
- verify passive return edges are muted;
- Tab through actionable labels and verify visible cyan focus box/halo;
- inspect the dense Applications/Creation/Data region for label overlap;
- inspect Structure/Security/Workflows/Source/Build branches for separation;
- verify menu autocollapse unchanged;
- verify diagram remains fixed when navigating between states.

Do not commit/push OPUS until owner visual/runtime acceptance. Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.