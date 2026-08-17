# P117W R45B2A4AV — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Owner baseline

Remote OPUS owner baseline remains:

`ec133bd9c9e7f5e01177e88c5bb62133e9a72e48` — `opus_p117w_r45b2a4as_runtime_failure_lifecycle_finalization`

Owner has A4AT and A4AU applied locally for runtime validation. A4AV has no file overlap with either delivery.

## Runtime evidence received

Owner report on 2026-08-18:

- Creation `Annuler` button works after A4AU;
- Menu = FSM visible relation `cancel_creation -> Applications` does not work;
- owner reports not observing the signal through the FSM behavior.

## Canonical FSM evidence

`cancel_creation` is already present in `sites/owasys-front/config/fsm.json` as type `command`.

The canonical local transitions are:

- `t_creation_basics_cancel`: `creation_basics -> registry`;
- `t_creation_security_cancel`: `creation_security -> registry`;
- `t_creation_review_cancel`: `creation_review -> registry`;
- `t_creation_failure_cancel`: `application_creation_failed -> registry`.

A4AV does not alter this topology.

`OwasysFsmDiagramBuilder` already projects local non-self FSM transitions and labels them with the canonical signal id. Therefore no diagram topology patch is required.

## Root cause

Current `OwasysNavigationBuilder` deliberately makes only navigation-type signals with mapped GET routes actionable. Command signals are displayed as FSM facts but remain passive.

Current `navigation.score` renders passive signals as `<span aria-disabled="true">`.

The obvious `/applications` link would be semantically wrong because that GET route resolves to the global signal `change_app`, not `cancel_creation`.

## A4AV implementation

### HTTP signal binding

`config/routes.json` retains contract `OPUS_SIGNAL_ROUTES_V2` and adds the optional additive section:

- route `applications/new`;
- POST action `cancel-creation`;
- canonical signal `cancel_creation`.

### NavigationBuilder

The builder now reads GET and POST bindings together through StructuredFileLoader.

A POST binding is accepted only when:

- the bound signal exists in the canonical FSM registry;
- its type is `command`;
- the bound route is a known canonical route;
- the action token is valid and unambiguous;
- for a projected transition, the binding route exactly equals the source state's route.

For the current source state, target ACL/availability must also pass.

GET link eligibility remains in `actionable`; menu GET-or-POST eligibility is exposed separately as `menu_actionable`. This deliberately prevents the existing diagram builder from turning a POST command into an SVG GET hyperlink.

### SCORE menu

For a menu-actionable POST command, `navigation.score` emits:

- `method=post`;
- canonical localized source-state action URL;
- submit field `owasys_action`;
- exact configured value `cancel-creation`.

No arbitrary signal name is accepted from the browser and no generic execute-signal endpoint is introduced.

Existing GET navigation anchors remain unchanged.

### CSS

`fsm-native.css` preserves the complete pre-A4AV content and adds a final compact styling block for the POST form/button.

The first 11703 bytes reproduce exact Git blob:

`3514a5cc0853be04f305305abef64cb21954a467`.

## Delivery

Artifact:

`opus_p117w_r45b2a4av_fsm_menu_post_command_dispatch.zip`

SHA-256:

`5828a8db8641699422ffced603c1331c1f612b1896370b01e8092df0c250375b`

Exactly four complete files:

1. `sites/owasys-front/config/routes.json`
2. `sites/owasys-front/application/default/services/NavigationBuilder.php`
3. `sites/owasys-front/application/default/templates/partials/navigation.score`
4. `sites/owasys-front/www/asset/css/fsm-native.css`

No patcher. No deletion. No `fsm.json`. No `FsmDiagramBuilder.php`. No controller/backend file.

## Pre-delivery validation

- `NavigationBuilder.php`: PHP lint OK;
- `routes.json`: strict JSON parse OK;
- no trailing whitespace in delivered files;
- `routes.json` with `post_actions` removed reconstructs exact owner blob `e5a02a21db06ac8248a088f9b94de76cd0da0d57`;
- pre-A4AV CSS prefix reconstructs exact owner blob `3514a5cc0853be04f305305abef64cb21954a467`;
- static contract smoke confirms POST form, configured request field/value and GET-only `actionable` separation;
- ZIP contains exactly the four listed files.

## Owner acceptance

1. Enter Creation Basics.
2. Open the active `Application` FSM menu.
3. `cancel_creation -> Applications` is visibly actionable, unlike unrelated unbound command signals.
4. Click it with application id/profile empty: no browser constraint-validation popup is allowed.
5. Request executes the canonical `cancel_creation` transition and lands on Applications through the A4AT 303.
6. Profiler/FSM evidence identifies `cancel_creation`, not `change_app`, for that transition.
7. Diagram still contains the canonical amber `cancel_creation` transition and its fixed topology is unchanged.
8. `continue_security` and other form-data-dependent command signals remain passive in the menu.
9. For the 303, A4AT invariants remain: `request.completed`, `http.response.sent=303`, persisted front trace, no false `score.response.rendered`.
10. No FSM/REST/ACL/SSO/session/SCORE/profiler regression.

A4Z/A4AN/A4AO/A4AP fixed FSM/UI invariants remain mandatory.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
