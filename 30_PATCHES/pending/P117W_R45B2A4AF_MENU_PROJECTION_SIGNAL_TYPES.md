# P117W R45B2A4AF — Menu projection + typed FSM signals

State: RUNTIME REGRESSION — SUPERSEDED BY R45B2A4AG

## Baseline

Continuation after A4AD Account/Password semantic split and A4AE traceable diagram routing.

The canonical rule remains: FSM is the source of truth; navigation is only a user-navigation projection of that FSM.

## Owner feedback — 2026-08-17

The owner reports that the previously coherent OWASYS navigation menu has become polluted with duplicate/technical signals. Screenshots show examples:

- `create_new_app -> Création d’une application` alongside `open_creation -> Création d’une application`;
- `select_app -> Sources de données` alongside `open_data -> Sources de données`;
- `cancel_creation -> Applications` alongside `change_app -> Applications`;
- outcome/failure signals such as `application_deleted`, `registry_action_failed`, `application_creation_failed` exposed as menu rows.

The owner also requests different visual colors for signal types.

## Root cause

`OwasysNavigationBuilder` iterated every concrete FSM transition and appended every signal to the source-state submenu, even when that signal had no GET route and was a business command, outcome or system event.

This violated the builder's user-navigation contract: GET navigation URLs are sourced from `OPUS_SIGNAL_ROUTES_V2`, but non-routed transitions were still projected as passive menu items.

The duplicate targets were therefore not duplicate FSM transitions. They were distinct semantic transitions incorrectly mixed into the same user-navigation projection.

Examples:

- `create_new_app` is a business command; `open_creation` is navigation;
- `select_app` is a business command; `open_data` is navigation;
- `cancel_creation` is an in-page command; `change_app` is navigation;
- `application_created`, `application_deleted`, `*_failed` are outcomes, not menu entries.

## A4AF correction

### Canonical signal metadata

`sites/owasys-front/config/fsm.json` keeps every existing signal and transition but enriches each signal-registry entry with:

- `type`: `navigation`, `command`, `outcome` or `system`;
- `menu`: explicit boolean declaring whether that signal belongs in the global state-menu projection.

No transition is removed and no workflow behavior is changed.

Signal counts:

- navigation: 16;
- command: 10;
- outcome: 17;
- system: 2.

The global menu projection is explicitly limited to:

- `open_account`;
- `open_password_change`;
- `change_app`;
- `open_creation`;
- `open_structure`;
- `open_data`;
- `open_workflows`;
- `open_security`;
- `open_source`;
- `open_build`;
- `logout`.

Resource-local navigation (`open_source_file`, locale/profiler controls, initial `open_login`) remains in the FSM but is not projected into the global state menu.

### NavigationBuilder

`sites/owasys-front/application/default/services/NavigationBuilder.php` now:

- validates the canonical signal registry;
- projects only signals whose registry entry has `menu=true`;
- requires every menu signal to be `type=navigation`;
- requires every menu signal to have an `OPUS_SIGNAL_ROUTES_V2` route;
- leaves command/outcome/system signals entirely in the FSM, diagram and profiler;
- preserves current-state-only actionability and ACL/availability checks;
- emits `signal_type` metadata for SCORE.

### SCORE menu

`navigation.score` keeps native `<details name="owasys-fsm-navigation">` autocollapse and adds only signal-type class/data metadata. No JavaScript is introduced.

### Generic OPUS diagram signal types

`Opus/Fsm/Diagram.class.php` is evolved generically:

- canonical signal-registry type metadata is propagated to projected transition arrays;
- rendered transition groups receive `signal-type-navigation`, `signal-type-command`, `signal-type-outcome` or `signal-type-system`;
- no application-specific signal names are hard-coded in the generic renderer;
- A4AE routing geometry is otherwise unchanged.

### OWASYS visual palette

`fsm-native.css` maps types to distinct colors:

- navigation: cyan;
- command: amber;
- outcome: violet;
- system: rose.

Passive transitions retain reduced opacity. Actionable user-navigation transitions retain full-strength cyan, hitbox, hover/focus fill and halo.

## Direct artifact

`opus_p117w_r45b2a4af_menu_projection_signal_types.zip`

SHA-256:

`30cdd2ec09ddc2d5556f6fa392b8557e21867907e6bd8eff903e2daebe77e635`

Contains exactly six complete final-path files:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/application/default/services/NavigationBuilder.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/www/asset/css/fsm-native.css`

## Pre-delivery validation executed

- PHP lint success: `Diagram.class.php`;
- PHP lint success: `NavigationBuilder.php`;
- PHP lint success: `ScorePageRenderer.php`;
- `fsm.json` JSON decode success;
- all 45 canonical signals classified;
- all 11 global menu signals are type `navigation`;
- every global menu signal has a route;
- simulated menu projections for `registry`, `creation`, `account`, and `password`: zero duplicate target states;
- business commands/outcomes absent from menu projection while remaining in FSM.

## Runtime regression discovered after owner extraction

Opening `/fr-FR/applications` fails with HTTP 500:

`OWASYS_FSM_WORKFLOW_MENU_DIVERGENCE`

Root cause: A4AF correctly narrows `NavigationBuilder` to `menu=true`, but A4AE `FsmDiagramBuilder` still assumes that every transition displayed in the full FSM diagram must also have an entry in the user menu projection. Technical commands/outcomes are intentionally absent from the A4AF menu, so this assertion is invalid.

The A4AF menu/type model remains correct. Do not roll it back. The compatibility defect is corrected by R45B2A4AG, which separates full FSM diagram validation from menu-only action validation.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.