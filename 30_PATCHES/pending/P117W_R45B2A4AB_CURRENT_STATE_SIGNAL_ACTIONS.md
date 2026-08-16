# P117W R45B2A4AB — Current-state signal actions on fixed FSM

State: OWNER VALIDATION REQUIRED

## Baseline

OPUS accepted baseline:

`0ce2dfa9a1c7175ac39f93b2ee017ed6e40643ac` — A4Z classic fixed FSM + native menu autocollapse.

Owner-applied but not yet committed continuation:

A4AA signal focus/hitbox CSS on `sites/owasys-front/www/asset/css/fsm-native.css`.

A4AB must be applied on top of that working tree and does not overwrite A4AA CSS.

## Owner requirement

The fixed diagram must remain geometrically stable, but every signal label must execute the transition that is currently permitted by the runtime FSM.

Example:

- the fixed graph displays one representative `build --logout--> login` edge;
- when runtime state is `registry`, canonical FSM still contains `registry --logout--> login`;
- because logout is permitted from the current state, the fixed `logout` label must be clickable;
- its URL must be the current-state Menu=FSM URL, never the representative edge's source-state URL.

This applies generically to `logout`, `change_app`, `open_*` and any other displayed `signal + target` pair that is actionable from the current state.

## Root cause

`OwasysNavigationBuilder` correctly marks only transitions whose `from === currentState` as actionable and gives those transitions a route URL.

A4Z `OwasysFsmDiagramBuilder` then keyed diagram links by exact displayed transition ID. Since the graph is intentionally fixed and representative, its displayed source may differ from the runtime current source. The action URL is therefore lost even though an equivalent current-state transition is allowed.

## A4AB correction

A4AB changes only:

`sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

The diagram topology, state order, current-state highlight, initial-state root and A4AA CSS are unchanged.

New interaction projection:

1. collect only Menu=FSM signals from the current state whose `actionable === true`;
2. key those current actions by semantic `signal + target`;
3. collect displayed fixed-graph representatives by the same semantic key;
4. for each currently actionable semantic key, make exactly one displayed representative label interactive;
5. prefer a displayed edge whose `from` equals the current runtime state;
6. if the current state's exact edge is not drawn in the fixed graph, use the first fixed representative for that same `signal + target`;
7. use only the URL already produced by `NavigationBuilder` for the current state;
8. never fabricate a route, never bypass ACL/availability, and never make a passive current-state signal interactive.

This keeps the diagram fixed while interaction remains runtime-correct.

## Direct differential artifact

`opus_p117w_r45b2a4ab_current_state_signal_actions.zip`

SHA-256:

`c6fbbc154e2234aa34097c55e36aa6655fec93148aaf61fcd5fddd8d8aad0fae`

Contains exactly one complete final-path file:

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

File SHA-256:

`42da48932c583192c35c16b38053d29f952cfd7151711119c4a96a4f8347460d`

## Pre-delivery validation actually executed

- `php -l FsmDiagramBuilder_A4AB.php`: success;
- direct ZIP contains exactly the one expected complete final-path PHP file;
- synthetic smoke test validates:
  - current `registry` action `logout -> login` maps onto displayed representative `t_logout__from__build` with `/fr-FR/logout`;
  - current `registry` `change_app -> registry` maps onto one displayed fixed `change_app` representative;
  - when current state has an exact displayed representative, that representative is preferred;
  - duplicate clickable representatives for one semantic current action are not created.

Smoke result:

`A4AB_SMOKE_OK logout=global change_app=global exact-source-preferred duplicate-links=0`

## Owner acceptance

1. A4Z graph geometry remains identical.
2. A4Z autocollapse remains identical.
3. A4AA cyan hitbox/focus styling remains present.
4. On Applications/registry, `logout` is cyan/clickable and reaches the canonical logout route.
5. `change_app` is clickable whenever current-state Menu=FSM marks it actionable.
6. `open_*` labels become clickable whenever the corresponding same `signal + target` transition is actionable from the current state.
7. labels for signals not actionable from the current state remain passive.
8. only one fixed representative is clickable for a given current semantic action.
9. activation still enters the normal route -> FSM signal -> guards/actions flow.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.