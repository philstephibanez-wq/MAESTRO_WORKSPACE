# P117W R45B2A4AG — Handoff

State: OWNER VALIDATION REQUIRED

## Purpose

Fix the A4AF runtime 500 without reverting the coherent filtered menu or typed signals.

## Required working-tree baseline

Apply after A4AF on top of the existing A4AD+A4AE working tree.

Do not revert A4AF. The menu must remain a navigation-only projection of the canonical FSM.

## Runtime failure corrected

`OWASYS_FSM_WORKFLOW_MENU_DIVERGENCE`

A4AE `FsmDiagramBuilder` incorrectly assumed every displayed full-FSM transition must also be present in the global menu. A4AF intentionally removes command/outcome/system signals from that menu.

## Correct contract after A4AG

- canonical FSM remains the single source of truth;
- full FSM transition subset used by the fixed diagram may contain navigation, command, outcome and system signals;
- global menu contains only canonical signals with `menu=true` and `type=navigation`;
- a displayed `menu=true` transition must match the menu projection exactly;
- a displayed `menu=false` transition must not appear in the menu projection;
- actionable URLs are sourced only from the current menu state and therefore remain ACL/FSM gated;
- diagram signal-type colors from A4AF remain untouched;
- diagram geometry/routing from A4AE remains untouched.

## Artifact

`opus_p117w_r45b2a4ag_diagram_menu_projection_separation.zip`

SHA-256:

`2f09fd727de59d937452dfd6ba964e9b786f6b473b5ddc18a8a7de43622ec51a`

Contains one complete final-path file:

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

File SHA-256:

`8995f78d03e1fa733652ba66a9f3c82a9ae74a9543027d6908ec3163cc9df704`

## Validation already executed

- PHP lint success;
- 26 fixed diagram edges verified against A4AF canonical FSM;
- 15 displayed navigation/menu edges;
- 11 displayed technical edges intentionally absent from menu;
- missing canonical displayed edges: 0;
- invalid menu-classified displayed edges: 0.

## Owner validation sequence

1. Extract A4AG over the current A4AF working tree.
2. Lint `FsmDiagramBuilder.php`.
3. Run `git --no-pager diff --check`.
4. Rebuild Composer autoload.
5. Restart `owasys-front`.
6. Open `/fr-FR/applications`; HTTP 500 must be gone.
7. Verify Applications and Création menus remain cleaned by A4AF and do not regain technical/outcome rows.
8. Verify diagram still displays command/outcome/system transitions with their A4AF colors.
9. Verify currently permitted navigation labels remain clickable/focusable.
10. Verify `change_app`, `logout`, Account and Password workflows remain functional.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.