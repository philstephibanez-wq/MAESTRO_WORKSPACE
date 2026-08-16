# P117W R45B2A4AB — Current-state signal actions on fixed FSM

State: OWNER FUNCTIONAL VALIDATION PASSED — INCORPORATED INTO A4AC

## Baseline

OPUS accepted baseline:

`0ce2dfa9a1c7175ac39f93b2ee017ed6e40643ac` — A4Z classic fixed FSM + native menu autocollapse.

Owner working tree then received:

- A4AA signal focus/hitbox CSS;
- A4AB current-state semantic action mapping.

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

A4Z `OwasysFsmDiagramBuilder` then keyed diagram links by exact displayed transition ID. Since the graph is intentionally fixed and representative, its displayed source may differ from the runtime current source. The action URL was therefore lost even though an equivalent current-state transition was allowed.

## A4AB correction

A4AB changes:

`sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

Interaction projection:

1. collect only Menu=FSM signals from the current state whose `actionable === true`;
2. key those current actions by semantic `signal + target`;
3. collect displayed fixed-graph representatives by the same semantic key;
4. for each currently actionable semantic key, make exactly one displayed representative label interactive;
5. prefer a displayed edge whose `from` equals the current runtime state;
6. if the current state's exact edge is not drawn in the fixed graph, use the first fixed representative for that same `signal + target`;
7. use only the URL already produced by `NavigationBuilder` for the current state;
8. never fabricate a route, never bypass ACL/availability, and never make a passive current-state signal interactive.

## Artifact

`opus_p117w_r45b2a4ab_current_state_signal_actions.zip`

SHA-256:

`c6fbbc154e2234aa34097c55e36aa6655fec93148aaf61fcd5fddd8d8aad0fae`

Complete final-path file:

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

## Pre-delivery validation

- PHP lint passed;
- semantic-routing smoke passed for `logout`, `change_app`, exact-source preference and duplicate-link prevention.

## Owner runtime validation — 2026-08-16

Owner screenshot/feedback validates the functional objective:

- `change_app` is clickable and works;
- `logout` is clickable and works from Applications/registry;
- fixed A4Z geometry remains present.

Owner also reported two remaining visual/readability defects:

- some cyan curves appear without a corresponding actionable/focused label because return edges also use the cyan accent token;
- multiple transition labels/paths still overlap in the classic non-compact renderer.

These are not failures of the A4AB semantic routing. They are renderer/theme defects and are treated at the generic OPUS presentation layer in A4AC.

A4AB behavior is incorporated into A4AC so the owner can apply one direct continuation artifact without losing the validated current-state action mapping.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.