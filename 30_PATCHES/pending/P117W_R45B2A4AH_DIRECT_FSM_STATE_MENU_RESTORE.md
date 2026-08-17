# P117W R45B2A4AH — Direct FSM state menu restore

State: OWNER VALIDATION REQUIRED

## Baseline

A4AD Account/Password semantic split + A4AE traceable fixed diagram + A4AF typed signals + A4AG diagram/menu projection separation.

The A4AG diagram is retained unchanged.

## Owner feedback — 2026-08-17

Owner reports that the fixed FSM diagram is now acceptable but the global menu is "du grand n'importe quoi". Runtime screenshots show each top-level state implemented as a `<details>` dropdown containing almost the same global `open_*`, `change_app`, account/password navigation list.

## Root cause

The regression was introduced by P117W R45B2A4M `menu_equals_fsm`.

Immediately before A4M (`2c45610fe33aff1f12d263837272e042d467f523`):

- `navigation.score` rendered a direct horizontal state bar with `<a class="ow-global-nav-link">`;
- `NavigationBuilder` respected `state.navigation.visible`;
- hidden workflow/system states were not rendered as global menu entries.

A4M changed the UI contract to:

- every state becomes a `<details>` entry;
- every outgoing FSM navigation signal becomes a submenu row;
- state entries themselves no longer navigate.

Because OWASYS intentionally provides global `open_*` transitions from many states, this creates near-identical dropdowns by design. Filtering technical signals in A4AF removed noise but exposed the structural problem more clearly: the global development menu became repeated transition tables instead of a coherent state bar.

## A4AH correction

A4AH restores the direct-state global navigation presentation while preserving Menu=FSM semantics more strictly than the pre-A4M implementation.

### NavigationBuilder

`sites/owasys-front/application/default/services/NavigationBuilder.php`:

- keeps every canonical state and every `menu=true` navigation transition in the internal returned projection so A4AG `FsmDiagramBuilder` keeps its full validation/actionability source;
- adds `visible` directly from canonical `state.navigation.visible`;
- creates one direct navigation action per target state from the exact canonical transition whose source is the runtime current state;
- does not use `state.route` directly as the visible-link URL;
- visible-link URL is resolved only from the corresponding `OPUS_SIGNAL_ROUTES_V2` route for that exact current-state transition;
- throws on ambiguous direct target transitions;
- throws if a visible, allowed and available state is not reachable through an exact current-state navigation transition;
- preserves command/outcome/system exclusion from user navigation;
- preserves internal `signals` arrays for A4AG fixed-diagram link mapping.

### SCORE navigation

`sites/owasys-front/application/default/templates/partials/navigation.score`:

- removes `<details>` and all dropdown signal rows;
- renders only `item.visible=true` states;
- renders each permitted/available state as one direct `<a class="ow-global-nav-link">`;
- embeds exact `data-transition-id` and `data-signal` used to reach the state;
- disabled states remain non-clickable spans;
- no JavaScript and no dropdown/autocollapse logic remains because there is no submenu.

### Canonical visibility

`sites/owasys-front/config/fsm.json` changes presentation metadata only:

- `account.navigation.visible=false`;
- `password.navigation.visible=false`;
- existing `creation.navigation.visible=false` remains unchanged.

Account and Password remain full FSM states and remain available through the header/account workflow. They are not duplicated into the global development bar.

The visible development bar is therefore exactly:

1. Applications (`registry`)
2. Sources de données (`data`)
3. Structure
4. Sécurité
5. Workflows
6. Sources et Git
7. Construction et validation

## Diagram contract

A4AH does not modify:

- `Opus/Fsm/Diagram.class.php`;
- `FsmDiagramBuilder.php`;
- signal-type colors;
- fixed geometry;
- typed command/outcome/system rendering;
- A4AB current-state semantic action mapping.

The diagram therefore remains the complete typed FSM view, while the global development bar becomes a direct state projection.

## Direct artifact

`opus_p117w_r45b2a4ah_direct_fsm_state_menu_restore.zip`

SHA-256:

`cd66880fe19ff4fa4bae0e4142289dd0cfdf3350b755c016aa7386f9dc271208`

Contains exactly three complete final-path files:

- `sites/owasys-front/application/default/services/NavigationBuilder.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/config/fsm.json`

## Pre-delivery validation executed

- NavigationBuilder PHP lint: success;
- SCORE template contains no `<details>`;
- visible canonical states: `registry,data,structure,security,workflows,source,build` (ordered by navigation.order at runtime);
- synthetic runtime projection tested from `registry`, `creation`, `data`, `account`, and `password` states;
- without current app, app-dependent development states are disabled;
- with current app, visible development states resolve through exact current-state `open_*` transitions;
- Applications resolves through exact `change_app` transition;
- Account/Password remain internally projected but hidden from the global bar;
- A4AG fixed diagram smoke still renders 26 transitions successfully using the A4AH NavigationBuilder projection.

## Owner acceptance

1. No dropdown opens from the global development bar.
2. Global bar contains only the seven canonical development states listed above.
3. Creation, Login, Account and Password are not duplicated into the global development bar.
4. Clicking a visible state executes the exact FSM transition from the current state; no direct route bypass exists.
5. States requiring a selected application remain visibly disabled until an application is selected.
6. Account and Password workflows remain available through their dedicated header/account UI.
7. A4AG fixed diagram and typed signal colors remain unchanged.
8. `change_app`, Account/Password split and logout continue to work.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.