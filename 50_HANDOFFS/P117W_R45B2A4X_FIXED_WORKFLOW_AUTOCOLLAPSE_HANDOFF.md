# P117W R45B2A4X — Handoff

State: OWNER VALIDATION REQUIRED

## Baseline

OPUS HEAD:

`fcffa3c16c75126208a480382f9efb36be170110` — `opus_p117w_r45b2a4w_direct_fsm_fanout_change_app`.

A4W is owner-applied. Its generic SVG lane routing and 10/10 `change_app -> clear_current_app` FSM actions remain baseline behavior.

## A4X root correction

The OWASYS diagram must represent the stable logical workflow, not rebuild itself around the current page.

A4X changes only the OWASYS projection/menu templates:

- `FsmDiagramBuilder.php` now anchors the projection on canonical `initial_state`;
- current state is supplied only for visual highlighting;
- state order is fixed: initial state first, then already-sorted allowed menu states;
- each consecutive workflow state is joined by one deterministic representative transition that exists in the canonical FSM;
- no invented route/state registry;
- generic `OPUS_FSM_Diagram` remains untouched.

Current stable workflow proof:

`Connexion/login -> Applications/registry -> Création -> Sources de données/data -> Structure -> Sécurité -> Workflows -> Sources et Git/source -> Construction/build -> Compte/account`

Representative signals are selected from actual FSM transitions, preferring semantic business transitions over generic `open_*` transitions.

## Menu autocollapse

`navigation.score` now uses native exclusive HTML details grouping:

`name="owasys-fsm-navigation"`

The active state is no longer forced open. Menus start collapsed after navigation; opening one closes the previously open sibling in supporting browsers. No JavaScript is added.

## Direct artifact

`opus_p117w_r45b2a4x_fixed_workflow_autocollapse.zip`

SHA-256:

`f19f82be8e16abc3f297eaf23a98d6ec81301cf560aec4fba99ac67208ae269d`

Files:

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`

No patcher and no one-shot apply tool.

## Pre-delivery facts

`FsmDiagramBuilder.php` PHP lint succeeded.

Static gates confirm:

- native menu `details name` exclusive group present;
- forced active `open` absent;
- no JavaScript introduced;
- A4X revision marker present;
- all 9 workflow neighbor pairs have at least one real canonical transition in A4W FSM;
- deterministic representative selection resolves to real transition IDs/signals.

## Owner CMD sequence

Only executable commands belong in command blocks. Extract the direct ZIP, inspect Git status, lint the PHP file, run diff check, rebuild optimized autoload and restart owasys-front.

## Runtime acceptance

1. Connexion/login remains the first workflow state on every page.
2. State positions do not move when navigating.
3. Current state only changes highlight.
4. Diagram reads as a stable logical workflow rather than an active-state fan-out.
5. Menu panels are collapsed on load/navigation.
6. At most one menu panel is open at a time through native `<details name>` behavior.
7. A4W lane rendering, Menu = FSM, A4T I18n and FSM `change_app` actions remain intact.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.