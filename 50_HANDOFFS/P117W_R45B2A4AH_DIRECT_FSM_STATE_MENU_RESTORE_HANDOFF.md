# P117W R45B2A4AH — Handoff

State: OWNER VALIDATION REQUIRED

## Purpose

Restore the coherent direct OWASYS development menu that existed before A4M, while keeping all later FSM, diagram, typed-signal and Account/Password corrections.

## Required baseline

Apply over current OPUS HEAD containing A4AG (`e166474b5ab5ae7628a3b96bb382e19ccc03357a`).

A4AH does not replace the A4AG diagram.

## Root correction

A4M changed the former direct horizontal state bar into one `<details>` dropdown per state, each listing outgoing navigation signals. Because OWASYS has global `open_*` transitions from most states, the result is repeated near-identical dropdowns.

A4AH restores one visible menu entry per canonical `navigation.visible=true` development state.

Unlike the old pre-A4M implementation, the visible URL is not taken directly from `state.route`: it is resolved from the exact current-state FSM transition and its `OPUS_SIGNAL_ROUTES_V2` mapping. Menu remains FSM-driven.

## Visible global development states

- Applications
- Sources de données
- Structure
- Sécurité
- Workflows
- Sources et Git
- Construction et validation

Hidden from the global development bar but retained in the FSM:

- Connexion
- Compte
- Changer le mot de passe
- Création d’une application

Account/Password remain accessible through their dedicated header/account workflow. Creation remains an Applications workflow action.

## Artifact

`opus_p117w_r45b2a4ah_direct_fsm_state_menu_restore.zip`

SHA-256:

`cd66880fe19ff4fa4bae0e4142289dd0cfdf3350b755c016aa7386f9dc271208`

Files:

- `sites/owasys-front/application/default/services/NavigationBuilder.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/config/fsm.json`

## Validation already executed

- NavigationBuilder PHP lint success;
- no `<details>` remains in navigation SCORE;
- current-state direct FSM target resolution smoke tested for registry, creation, data, account and password;
- app-dependent states disabled when no current app exists;
- direct visible links use exact current-state FSM signals (`change_app`, `open_data`, `open_structure`, `open_security`, `open_workflows`, `open_source`, `open_build`);
- A4AG fixed diagram smoke still renders 26 transitions with the new builder projection.

## Owner validation sequence

1. Extract A4AH at `H:\OPUS`.
2. Lint NavigationBuilder.
3. Run `git --no-pager diff --check`.
4. Rebuild Composer autoload.
5. Restart `owasys-front`.
6. Open `/fr-FR/applications`.
7. Confirm there are no dropdowns/scrollbars in the main development menu.
8. Confirm only the seven development states are present.
9. With no selected application, confirm Sources de données / Structure / Sécurité / Workflows / Sources et Git / Construction are disabled.
10. Select an application and confirm these become direct links.
11. Confirm Applications uses the FSM `change_app` action.
12. Confirm header Account and Account -> Password still work.
13. Confirm the FSM diagram remains visually unchanged and keeps typed signal colors.
14. Confirm logout remains functional.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.