# P117W R45B2A4AF — FSM navigation visibility

State: OWNER VALIDATION REQUIRED

## Baseline

Continuation after A4AD Account/Password semantic split and A4AE traceable FSM routing.

A4AD remains the semantic baseline for distinct `account` and `password` FSM states.
A4AE remains the graphical baseline.

## Owner feedback — 2026-08-17

Owner reports that the `Compte` top-level menu now exposes development workflow signals such as `open_creation`, `open_data`, `open_structure`, etc., and states that this disrupts the OWASYS development workflow.

## Root cause

Two independent projection errors were present:

1. A4AD explicitly set `navigation.visible=true` on the new `account` and `password` states even though these are system/account states, not top-level development workflow states.
2. `OwasysNavigationBuilder` did not read `navigation.visible` at all. Consequently FSM states already marked `navigation.visible=false` (for example `creation`) could still be emitted as top-level menu entries.

The canonical FSM itself must retain system and auxiliary states because they remain real transition targets and are required by the fixed diagram and runtime actionability. Therefore the correction must not delete states or duplicate navigation in a parallel registry.

## A4AF correction

### Canonical FSM

`sites/owasys-front/config/fsm.json` explicitly classifies top-level development workflow states through `navigation.visible`.

Visible, ordered top-level workflow states:

1. `registry` — Applications
2. `data` — Sources de données
3. `structure` — Structure
4. `security` — Sécurité
5. `workflows` — Workflows
6. `source` — Sources et Git
7. `build` — Construction et validation

Hidden top-level states:

- `login`
- `account`
- `password`
- `creation`

These hidden states remain full FSM states and their transitions are unchanged.

### NavigationBuilder

`sites/owasys-front/application/default/services/NavigationBuilder.php` now projects every FSM state into navigation data, but exposes a boolean `visible` derived exclusively from `state.navigation.visible`.

Contract:

- hidden states remain in projection data;
- hidden states can remain valid transition sources/targets;
- actionability remains derived from the current FSM state, ACL, target availability and `OPUS_SIGNAL_ROUTES_V2`;
- only presentation of top-level state entries is filtered;
- no parallel state/menu registry is introduced.

This also preserves FsmDiagramBuilder access to account/password/login/creation state and transition metadata.

### SCORE menu

`sites/owasys-front/application/default/templates/partials/navigation.score` renders a top-level `<details>` entry only when:

- `item.visible` is true; and
- `item.allowed` is true.

Native exclusive autocollapse remains unchanged.

## Direct artifact

`opus_p117w_r45b2a4af_fsm_navigation_visibility.zip`

SHA-256:

`368d959635cbafc33bbed32c72e900c3042c6c42c1dc07b644a31e859fe1ed08`

Complete final-path files only:

- `sites/owasys-front/application/default/services/NavigationBuilder.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/config/fsm.json`

## Pre-delivery validation actually executed

- `NavigationBuilder.php`: PHP lint success;
- `fsm.json`: JSON decode success;
- effective top-level order: `registry,data,structure,security,workflows,source,build`;
- hidden states: `account,creation,login,password`;
- canonical `registry --open_account--> account` transition still exists;
- canonical `account --open_password_change--> password` transition still exists;
- canonical `registry --create_new_app--> creation` transition still exists;
- SCORE checks `item.visible` before rendering a top-level state.

## Owner acceptance

After extraction/restart:

1. top bar contains only Applications, Sources de données, Structure, Sécurité, Workflows, Sources et Git, Construction et validation;
2. Compte is no longer a top-level development workflow state;
3. Changer le mot de passe is no longer a top-level development workflow state;
4. Connexion is not shown in the authenticated development workflow menu;
5. Création remains an auxiliary FSM state and is not a top-level menu entry;
6. header Compte still opens the canonical account state;
7. Account page can still open Password;
8. diagram still contains account/password/login/creation and their real transitions;
9. A4AE routing/cyan/focus/autocollapse behavior does not regress;
10. Menu = FSM remains true: visibility itself is read from FSM metadata.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.
