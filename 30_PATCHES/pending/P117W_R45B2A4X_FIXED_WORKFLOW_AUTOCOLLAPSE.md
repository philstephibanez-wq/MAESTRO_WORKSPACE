# P117W R45B2A4X — Fixed logical FSM workflow + native menu autocollapse

State: OWNER VALIDATION REQUIRED

## Baseline

Required OPUS HEAD:

`fcffa3c16c75126208a480382f9efb36be170110` — `opus_p117w_r45b2a4w_direct_fsm_fanout_change_app`.

A4X retains A4W generic `OPUS_FSM_Diagram` lane routing and the ten canonical `change_app -> clear_current_app` actions.

## Root cause

`OwasysFsmDiagramBuilder` still implemented an active-state graph:

- only the current state and its direct menu targets were projected;
- `currentState` was passed as `layoutRoot`;
- diagram state order/geometry therefore changed with navigation.

This is not a logical workflow view. The current state is runtime position in the workflow, not the workflow origin.

The FSM menu also forced the active `<details>` open, allowing large signal panels to obscure the diagram and permitting multiple independently-open menus.

## Fixed workflow contract

The diagram is now a stable deterministic projection of the same canonical `OWASYS_NAVIGATION_FSM_V1`:

1. first state is always canonical `initial_state` (`login` / Connexion);
2. remaining allowed states follow the already-sorted FSM menu order;
3. current state never changes order or layout root;
4. current state is passed only as renderer `currentState` for highlighting;
5. consecutive workflow states are connected by one deterministic representative transition selected from real canonical transitions only;
6. preferred representative signals are semantic business-flow transitions (`login_success`, `create_new_app`, `application_created`, etc.) before generic `open_*` navigation transitions;
7. no invented edge, state, route or second registry;
8. Menu = FSM remains source of labels, ACL availability and actionable URLs;
9. A4W native SVG renderer remains unchanged.

For current OWASYS FSM/menu order, the stable workflow resolves to:

`login -> registry -> creation -> data -> structure -> security -> workflows -> source -> build -> account`

with representative canonical signals:

- `login_success`
- `create_new_app`
- `application_created`
- `open_structure`
- `open_security`
- `open_workflows`
- `open_source`
- `open_build`
- `open_account`

## Native menu autocollapse

`navigation.score` uses the native HTML `<details name="owasys-fsm-navigation">` exclusive group.

- no JavaScript;
- no forced `open` on current state;
- menus start collapsed after navigation/page load;
- opening one state menu closes another open state menu in supporting browsers;
- active state remains visually identified by existing `is-active` / `aria-current` state;
- signal actionability semantics remain unchanged.

## Direct differential artifact

`opus_p117w_r45b2a4x_fixed_workflow_autocollapse.zip`

SHA-256:

`f19f82be8e16abc3f297eaf23a98d6ec81301cf560aec4fba99ac67208ae269d`

Complete final-path files only:

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`

File SHA-256:

- `FsmDiagramBuilder.php`: `54348cb880fd2b2298ecab40fd07c499de77fd0109d1f3b8de59e8972539bd37`
- `navigation.score`: `e26533576487649d79aa48ebc067de7c64fd8cdcb3243df8e909709ffaa9acb8`
- `fsm-diagram.score`: `695822961a4e36330319dacc7affdb458ad74f4e5bd48c0e306cd8f8a86f9a2d`

## Pre-delivery validation actually executed

- `php -l FsmDiagramBuilder.php`: success;
- direct ZIP contains exactly 3 expected final-path files;
- no patcher/apply script;
- no JavaScript introduced;
- navigation template contains native exclusive `<details name=...>` group;
- active-state forced `open` removed;
- workflow pair proof against A4W canonical FSM succeeds for all 9 consecutive pairs;
- every representative edge is an existing canonical FSM transition.

## Owner acceptance

After extraction/restart:

1. diagram begins at Connexion/login on every authenticated page;
2. navigating between states does not reorder/re-root diagram;
3. only current-state visual highlight changes;
4. stable main workflow is readable left-to-right;
5. opening another menu autocollapses the previously open menu;
6. menus are collapsed after page navigation;
7. active state styling remains visible while collapsed;
8. Menu = FSM, ACL, A4T I18n and A4W change_app actions remain intact.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.