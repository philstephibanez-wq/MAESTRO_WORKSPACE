# P117W R45B2A4AV — FSM Menu POST Command Dispatch

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Observed runtime defect

After A4AU, the Creation `Annuler` button works, but the Menu = FSM entry `cancel_creation -> Applications` remains passive/non-clickable.

The canonical FSM is not missing the signal. `config/fsm.json` already declares `cancel_creation` as a command and contains local transitions to `registry` from:

- `creation_basics`;
- `creation_security`;
- `creation_review`;
- `application_creation_failed`.

## Root cause

`OwasysNavigationBuilder` projects every local FSM relation into the submenu but only marks a relation actionable when it is a `navigation` signal with a GET route from `config/routes.json`.

`navigation.score` consequently renders `cancel_creation` as a passive `<span>`.

A direct link to `/applications` is not a valid fix: canonical GET route `applications` resolves to the distinct global FSM signal `change_app`. Such a link would display `cancel_creation` while executing `change_app`, violating Menu = FSM.

## Contract decision

Keep responsibilities separated:

- `fsm.json` remains the canonical FSM topology and is unchanged;
- `routes.json` owns HTTP-to-signal transport binding;
- the existing command handler remains `CreationController` and no arbitrary signal-dispatch endpoint is introduced.

`OPUS_SIGNAL_ROUTES_V2` gains an additive optional `post_actions` section. A binding is route + submitted action -> canonical FSM signal.

A4AV binding:

`POST applications/new` + `owasys_action=cancel-creation` -> `cancel_creation`.

## Navigation projection

`OwasysNavigationBuilder` loads GET and POST bindings in one StructuredFileLoader read.

A local command is menu-actionable only when all conditions hold:

1. its signal has an explicit POST binding;
2. the bound signal is declared as FSM type `command`;
3. the binding route exactly equals the source state's canonical route;
4. the source is the current FSM state;
5. the target state is ACL-allowed and available.

Unbound commands, outcomes and system signals remain passive FSM facts.

GET navigation behavior is unchanged.

The builder exposes separate semantics:

- `actionable`: GET transition hyperlink eligibility, retained for the FSM diagram projection;
- `menu_actionable`: GET or contract-bound POST menu eligibility;
- `is_post`, request field/value for the SCORE menu form.

This separation ensures the diagram does not forge a GET hyperlink for a POST command.

## SCORE menu

For a menu-actionable POST command, `navigation.score` emits a SCORE-owned HTML form posting to the canonical localized source-state route with the exact configured action value.

No JavaScript is introduced.

The existing GET anchors and passive spans remain unchanged.

## Visual non-regression

`fsm-native.css` receives only a compact reset for the POST command form/button so generic submit-button styling does not alter the accepted Menu = FSM geometry.

The pre-A4AV CSS prefix remains byte-identical to Git blob `3514a5cc0853be04f305305abef64cb21954a467`.

## Files

1. `sites/owasys-front/config/routes.json`
2. `sites/owasys-front/application/default/services/NavigationBuilder.php`
3. `sites/owasys-front/application/default/templates/partials/navigation.score`
4. `sites/owasys-front/www/asset/css/fsm-native.css`

No `fsm.json` change. No diagram-builder change. No controller change. No backend change.

## Required behavior

From an active creation state, clicking the menu signal `cancel_creation` must:

1. issue POST to the localized `applications/new` route;
2. submit `owasys_action=cancel-creation`;
3. execute `CreationController`'s existing canonical `cancel_creation` transition;
4. reach `registry` / Applications;
5. preserve the A4AT 303 completion lifecycle.

`continue_security`, `return_basics`, `continue_review`, `return_security` and `begin_application_creation` remain passive menu facts because no standalone menu POST contract exists for them.
