# P117W R45B2A4AI — Canonical workflow FSM rebuild

Status: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED
Date: 2026-08-17

## Owner correction

A4AH is rejected. The direct reduced menu exposed the deeper defect: OWASYS was modeling a small page/module graph instead of the complete finite workflow required by the owner.

Mandatory owner semantics remain:

- `Applications -> create_app -> ...creation workflow... -> Application created` must be explicit;
- `logout -> login` must apply from every applicable authenticated state;
- state-specific submenus must remain;
- diagram geometry remains fixed and the current state changes highlight only;
- cyan remains reserved for a currently permitted actionable transition.

## Audited delivery baseline

OPUS source baseline used for the direct differential ZIP:

`316769d4a04a986aacedf0540c878d35b716e719`

Commit: `opus_p117w_r45b2a4ah_direct_fsm_state_menu_restore`

The A4AH source still had the root defects identified in this specification:

- principal `fsm.json` modeled only 11 states while carrying many more workflow signals/transitions;
- creation `basics`, `security`, `review` were owned by a separate `creation.wizard.fsm.json`;
- `application_created` was an outcome signal collapsing directly to `data`;
- ordinary global navigation/logout was duplicated across finite states;
- the diagram depended on a hand-selected state/edge list;
- A4AH had removed the state/signal submenu projection.

## A4AI delivered canonical model

The delivered principal OWASYS FSM contains 16 explicit states, 50 typed signals and 55 canonical transitions.

State categories are explicit:

- `system`: 1;
- `screen`: 9;
- `workflow`: 4;
- `result`: 2.

Canonical state inventory:

1. `login`
2. `registry`
3. `creation_basics`
4. `creation_security`
5. `creation_review`
6. `application_creating`
7. `application_creation_failed`
8. `application_created`
9. `data`
10. `structure`
11. `security`
12. `workflows`
13. `source`
14. `build`
15. `account`
16. `password`

The creation branch is now one persisted principal FSM workflow:

`registry --create_new_app--> creation_basics`

`creation_basics --continue_security--> creation_security`

`creation_security --continue_review--> creation_review`

`creation_review --begin_application_creation--> application_creating`

`application_creating --application_created--> application_created`

or

`application_creating --application_creation_failed--> application_creation_failed`

Failure recovery is canonical:

- retry: `application_creation_failed --begin_application_creation--> application_creating`;
- edit security: `application_creation_failed --return_security--> creation_security`;
- cancel: `application_creation_failed --cancel_creation--> registry`.

`creation.wizard.fsm.json` therefore becomes obsolete and must be deleted when applying the ZIP. Keeping it would retain duplicate state ownership and violate A4AI.

## Generic OPUS finite global-transition contract

`Opus/Fsm/FsmProcessor.php` now supports ordinary finite global transitions with:

- `scope: "global"`;
- explicit finite `from_states`;
- concrete runtime source-state profiling;
- validation against unknown states and ambiguous overlap;
- exact state-local transition precedence over a matching global transition;
- NMI remaining distinct and preemptive.

Resolution contract:

1. NMI exact interrupt when applicable;
2. exact current-state local transition;
3. exact finite global transition;
4. current-state `__any__` / `__default` fallback.

No ordinary `from:"*"` navigation shortcut is introduced.

OWASYS uses finite global transitions for the universal navigation families, including `change_app`, section navigation, Account/Password navigation and `logout`.

## Menu contract delivered

The menu is again a direct FSM projection:

- all 16 canonical states are navigation items in canonical order;
- each state owns its local signal submenu;
- local workflow commands/outcomes remain visible as FSM relations even when they cannot safely be represented as GET links;
- only real route-backed currently permitted navigation transitions become clickable/cyan;
- global navigation is collected once on a global rail instead of repeated under every state;
- native `<details name="owasys-fsm-navigation">` exclusive autocollapse is restored;
- global and local actionability remains filtered through canonical transition applicability plus ACL/availability.

The creation menu therefore no longer jumps conceptually from Applications straight to a final page. It exposes the actual canonical states and their local transitions.

## Diagram contract delivered

`OwasysFsmDiagramBuilder` no longer owns hardcoded `LOGICAL_STATE_ORDER`, `LOGICAL_EDGES` or a parallel semantic registry.

It derives:

- state order from the canonical FSM plus presentation-only `diagram.rank/order` metadata;
- local workflow edges from canonical transitions;
- finite global transition applicability from `from_states`;
- current action links from the same navigation/FSM projection.

The root is always canonical `initial_state`; current state changes highlight only.

`logout` is expanded visibly from every one of the 16 finite states in the delivered projection smoke test, instead of displaying only one representative `build -> login` edge.

Dense technical same-state loops may be reduced algorithmically for diagram readability, but their canonical signals remain in the FSM/menu/profiler; no business workflow state is removed to make the diagram look cleaner.

## Source/Git/build lifecycle audit result

The A4AI audit distinguishes persistent FSM phase from synchronous event/result feedback instead of blindly creating a state for every signal.

Current Source/Git operations (`preview`, `write`, `stage`, `unstage`, `commit`, `restore`) execute synchronously inside one source request. Their next available operations are recalculated from the current source/Git repository state on each request; they do not create a separate persisted OWASYS front workflow phase. Their command/outcome transitions therefore remain typed local FSM signals/self-loops.

`source_conflict` is request feedback derived from optimistic-content state and is re-evaluated from the source model; it is not a durable FSM phase after a fresh request.

Build preview starts the development server synchronously and immediately redirects to the returned local preview URL. The running server lifecycle is not owned by the OWASYS front session FSM, so A4AI does not invent a persistent `preview_running` state.

Application select/delete and registry failures were audited similarly:

- successful selection already changes canonical phase to the target application screen after setting current app;
- deletion returns to registry and does not establish a distinct set of valid next operations;
- registry failures leave the same registry operation set.

Creation is different: basics/security/review/creating/created/failed materially change valid next operations and are therefore explicit states.

## Direct ZIP artifact

Artifact:

`opus_p117w_r45b2a4ai_canonical_workflow_fsm_menu.zip`

SHA-256:

`38ad0d87a8e7a33a09fb413aad01d4df4d04dfd38290a7b7f831db638f311632`

The ZIP contains exactly six complete replacement files at final repository paths:

- `Opus/Fsm/FsmProcessor.php`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/application/default/services/NavigationBuilder.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/application/creation/controllers/CreationController.php`

It is a direct differential ZIP, not a patcher.

Required removal after extraction:

`sites/owasys-front/config/creation.wizard.fsm.json`

## Pre-delivery evidence

Static checks:

- all four delivered PHP files: `php -l` OK;
- `fsm.json`: JSON decode OK;
- no trailing whitespace in payload;
- no residual `creation.wizard.fsm.json` reference in payload.

Isolated functional smokes:

- success chain: `login -> registry -> creation_basics -> creation_security -> creation_review -> application_creating -> application_created -> data -> login`;
- failure/retry chain: `application_creating -> application_creation_failed -> application_creating`;
- finite globals resolve from `login` for `change_app`, `open_creation`, `open_account`, `logout`;
- OPUS precedence smoke: local transition wins over matching global transition; NMI remains preemptive;
- menu projection: 16 state items; globals emitted once; creation submenus contain the expected local workflow signals;
- fixed diagram projection: 16 states; 16 visible logout-to-login source relations.

These are isolated source-level smokes. Browser/runtime integration on the owner's Windows checkout remains the owner validation gate.

## Owner validation gate

A4AI is not owner-validated until the ZIP is extracted on `H:\OPUS`, the obsolete secondary wizard FSM is deleted, PHP/JSON/diff checks pass, OWASYS front is restarted, and the owner validates the actual menu/diagram behavior.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
