# P117W R45B2A4AF — Handoff

State: RUNTIME REGRESSION — SUPERSEDED BY R45B2A4AG

## Purpose

Restore the coherent OWASYS development menu without deleting or merging real FSM transitions, and add distinct visual signal types to the FSM diagram.

## Root correction

The menu must not equal the full transition/event table. It is a user-navigation projection of the canonical FSM.

A4AF keeps every FSM command/outcome/system transition but projects into the global menu only signal-registry entries explicitly marked `menu=true` and `type=navigation`.

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

Canonical FSM signal registry carries explicit type metadata:

- navigation — cyan;
- command — amber;
- outcome — violet;
- system — rose.

Counts: navigation 16, command 10, outcome 17, system 2.

Global menu signals are only:

`open_account`, `open_password_change`, `change_app`, `open_creation`, `open_structure`, `open_data`, `open_workflows`, `open_security`, `open_source`, `open_build`, `logout`.

## Validation executed before runtime

- PHP lint success: `Diagram.class.php`;
- PHP lint success: `NavigationBuilder.php`;
- PHP lint success: `ScorePageRenderer.php`;
- `fsm.json` JSON decode success;
- all 45 signals classified;
- all menu signals are navigation signals;
- simulated registry/creation/account/password menus have zero duplicate target states;
- commands/outcomes remain present in canonical FSM but are absent from global menu projection.

## Runtime regression discovered by owner

After applying A4AF over A4AE, `/fr-FR/applications` returns HTTP 500 with:

`OWASYS_FSM_WORKFLOW_MENU_DIVERGENCE`

The A4AF menu filtering itself is intentional and remains the required design. The regression comes from A4AE `FsmDiagramBuilder`, which still requires every displayed FSM transition to exist in the now-filtered menu projection. That assumption became invalid as soon as technical signals were correctly removed from the menu.

Proceed with R45B2A4AG. Do not revert A4AF menu filtering or signal-type metadata.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.