# P117W R45B2A4BA — Current-state-only FSM menu

Status: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

Owner OPUS HEAD:

`726d48d417be5ef6d7248cb9f2cc7a59e8c147a9` — A4AY.

A4AZ is applied locally for validation and is a prerequisite because it supplies guarded current-state actionability in `NavigationBuilder.php`.

## Owner evidence

While current state is `structure`, screenshots show:

- inactive `application_creation_failed` still exposes its local transitions;
- inactive `security`, `workflows`, `build`, `account`, etc. open empty `Ø` dropdowns;
- every visible state has a dropdown affordance although only one state is current.

Profiler evidence confirms the request reached canonical FSM state `structure` and guard `current_app_required` passed. The UI defect is projection-only.

## Root cause

`sites/owasys-front/application/default/templates/partials/navigation.score` renders every visible/allowed state as `<details>`. The template therefore presents inactive-state transition definitions as if they were current menu choices and invents empty dropdowns for states with no local signal list.

## Contract

Menu = FSM means:

1. all allowed/visible canonical states may remain visible as state references;
2. only the **current state** owns an expandable signal menu;
3. only outgoing transitions from the current state are rendered in that menu;
4. inactive states expose no dropdown, no arrow, no `Ø`, no historical local transitions;
5. current-state actionability continues to come from A4AY `FsmProcessor::inspectTransition()` via A4AZ;
6. passive current-state transitions may remain visible when they are genuine canonical FSM facts;
7. signal semantic color remains `origin=user|automatic` only;
8. HTTP transport remains independent of FSM semantics;
9. no FSM topology change.

## Implementation

Exactly three complete OWASYS front files:

1. `sites/owasys-front/application/default/templates/partials/navigation.score`
   - menu contract becomes `OWASYS_FSM_MENU_V7`;
   - current state renders as `<details>`;
   - inactive states render as static state references;
   - current-state outgoing global/local signals retain existing GET/POST/passive rendering.

2. `sites/owasys-front/www/asset/css/fsm-native.css`
   - inactive state references have no dropdown arrow and no pointer/hover affordance.

3. `sites/owasys-front/application/default/services/ScorePageRenderer.php`
   - FSM stylesheet cache key advances to A4BA.

No controller, REST, backend, ACL policy, FSM config, diagram topology, or JavaScript change.

## Delivery

Artifact:

`opus_p117w_r45b2a4ba_current_state_only_fsm_menu.zip`

SHA-256:

`05c10cbb14cf2b5ff368b9619069c04abdff84c23a216d676a6ea9efe75f7a6a`

## Static validation

- `ScorePageRenderer.php` lint OK;
- SCORE `if/endif` and `foreach/endforeach` token counts balanced;
- exactly one `<details>` and one `<summary>` rendering branch in the template source;
- inactive reference branch present;
- CSS removes arrow from inactive references;
- no trailing whitespace;
- ZIP contains exactly the three complete files plus directory entries.

## Owner acceptance

With current state `structure`:

- Structure alone has a dropdown arrow;
- Security, Workflows, Sources de données, Build, Account, Creation impossible, etc. are static references only;
- opening an inactive state is impossible because it is not a dropdown;
- no inactive state displays `Ø`;
- Structure dropdown contains only current-state outgoing FSM signals from the guarded A4AZ projection;
- signal colors remain user vs automatic;
- diagram remains unchanged.
