# P117W R45B2A4AG — Diagram / menu projection separation

State: OWNER VALIDATION REQUIRED

## Baseline

A4AD Account/Password split + A4AE traceable fixed diagram + A4AF coherent filtered menu and typed signals.

A4AF must remain in place. Its menu filtering and signal-type registry are correct.

## Owner runtime feedback — 2026-08-17

After applying A4AF, `/fr-FR/applications` returns HTTP 500:

`OWASYS_FSM_WORKFLOW_MENU_DIVERGENCE`

## Root cause

A4AF correctly changes the global menu from a projection of every FSM transition to a projection only of explicit user-navigation signals (`menu=true`, `type=navigation`).

However, A4AE `OwasysFsmDiagramBuilder` still builds the full semantic FSM diagram and, for every displayed transition, requires a corresponding entry in `$menuSignalByTransition`.

That invariant is now wrong:

- navigation transitions belong to both the canonical FSM and the menu projection;
- command/outcome/system transitions belong to the canonical FSM and diagram/profiler, but intentionally do not belong to the global menu.

The first technical transition encountered therefore triggers `OWASYS_FSM_WORKFLOW_MENU_DIVERGENCE` even though the FSM and menu are individually correct.

## A4AG correction

`sites/owasys-front/application/default/services/FsmDiagramBuilder.php` only.

The builder now reads canonical signal-registry metadata from `fsm.json` and validates each displayed edge according to its signal declaration:

- if `signal.menu === true`, the exact transition must be present in the menu projection with matching signal and target;
- if `signal.menu === false`, the transition must not be present in the menu projection;
- every displayed transition still has to exist exactly in the canonical FSM;
- every displayed signal still has to exist in the canonical signal registry;
- all technical command/outcome/system transitions remain in the fixed diagram;
- actionable links are still resolved exclusively from current-state menu entries, so no ACL/FSM bypass is introduced;
- A4AB universal semantic action mapping for `change_app`, `logout`, and other currently permitted navigation signals remains unchanged;
- A4AE fixed geometry and A4AF signal-type coloring remain unchanged.

This explicitly separates two valid projections of one source FSM:

1. full semantic FSM projection -> diagram/profiler;
2. user navigation projection -> menu/actionable links.

## Direct artifact

`opus_p117w_r45b2a4ag_diagram_menu_projection_separation.zip`

SHA-256:

`2f09fd727de59d937452dfd6ba964e9b786f6b473b5ddc18a8a7de43622ec51a`

Contains exactly one complete final-path file:

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

File SHA-256:

`8995f78d03e1fa733652ba66a9f3c82a9ae74a9543027d6908ec3163cc9df704`

## Validation executed

- PHP lint: success;
- fixed projection has 26 displayed canonical edges;
- displayed menu-classified edges: 15;
- displayed technical edges: 11;
- missing canonical displayed edges: 0;
- invalid menu-classified displayed edges: 0;
- all displayed technical signals remain in the canonical FSM while being validly absent from the global menu.

Representative technical signals validated as diagram-only:

`login_success`, `login_failed`, `password_change_required`, `password_changed`, `password_change_failed`, `registry_action_failed`, `create_new_app`, `select_app`, `application_creation_failed`, `application_created`, `cancel_creation`.

## Owner acceptance

1. `/fr-FR/applications` renders instead of HTTP 500.
2. A4AF global menu remains filtered and coherent; technical commands/outcomes do not reappear.
3. A4AF signal colors remain visible in the diagram.
4. Command/outcome/system edges remain visible in the diagram even though absent from the menu.
5. Navigation edges that are currently permitted remain clickable/focusable.
6. `change_app` and `logout` remain usable through A4AB current-state semantic action mapping.
7. A4AD Account/Password split remains intact.
8. A4AE geometry/routing remains intact.
9. No menu transition is silently accepted when its canonical `menu=true` transition is missing or mismatched.
10. No technical `menu=false` transition is allowed to leak into the menu projection.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.