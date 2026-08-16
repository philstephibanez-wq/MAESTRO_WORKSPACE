# P117W R45B2A4AF — Handoff

State: OWNER VALIDATION REQUIRED

## Purpose

Restore the coherent OWASYS development menu without deleting or merging real FSM transitions, and add distinct visual signal types to the FSM diagram.

## Root correction

The menu must not equal the full transition/event table. It is a user-navigation projection of the canonical FSM.

A4AF therefore keeps every FSM command/outcome/system transition but projects into the global menu only signal-registry entries explicitly marked `menu=true` and `type=navigation`.

This removes the reported duplicates:

- `create_new_app` vs `open_creation`;
- `select_app` vs `open_data`;
- `cancel_creation` vs `change_app`;
- business outcomes/failures appearing as menu entries.

No real FSM transition is removed.

## Artifact

`opus_p117w_r45b2a4af_menu_projection_signal_types.zip`

SHA-256:

`30cdd2ec09ddc2d5556f6fa392b8557e21867907e6bd8eff903e2daebe77e635`

Files:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/application/default/services/NavigationBuilder.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/www/asset/css/fsm-native.css`

## Signal types

Canonical FSM signal registry now carries explicit type metadata:

- navigation — cyan;
- command — amber;
- outcome — violet;
- system — rose.

Counts: navigation 16, command 10, outcome 17, system 2.

Global menu signals are only:

`open_account`, `open_password_change`, `change_app`, `open_creation`, `open_structure`, `open_data`, `open_workflows`, `open_security`, `open_source`, `open_build`, `logout`.

## Validation already executed

- PHP lint success: `Diagram.class.php`;
- PHP lint success: `NavigationBuilder.php`;
- PHP lint success: `ScorePageRenderer.php`;
- `fsm.json` JSON decode success;
- all 45 signals classified;
- all menu signals are navigation signals;
- simulated registry/creation/account/password menus have zero duplicate target states;
- commands/outcomes remain present in the canonical FSM but are absent from the global menu projection.

## Owner validation sequence

1. Apply A4AF over the current A4AD+A4AE working tree.
2. Lint the three PHP files.
3. Run `git --no-pager diff --check`.
4. Rebuild Composer autoload.
5. Restart `owasys-front`.
6. Open Applications submenu and verify technical rows (`application_deleted`, `registry_action_failed`, `create_new_app`, `select_app`, etc.) are gone.
7. Open Création submenu and verify `cancel_creation`/`application_created`/`application_creation_failed` are not duplicated against user-navigation entries.
8. Verify navigation actions still work from the current state.
9. Verify native menu autocollapse remains functional.
10. Verify FSM diagram colors: navigation cyan, command amber, outcome violet, system rose.
11. Verify actionable navigation remains clickable and visibly focusable.
12. Verify A4AD Account/Password semantics and A4AE diagram routing did not regress.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.