# P117W R45B2A4AV — Handoff

State: OWNER COMMITTED/PUSHED — FSM COLOR SEMANTICS FOLLOW-UP A4AW REQUIRED

## Owner baseline

A4AV is committed and pushed in OPUS by the owner:

`eb160536bb82ff04a27a181f00fd6c9696be2099` — `opus_p117w_r45b2a4av_fsm_menu_post_command_dispatch`

This commit is the owner baseline for A4AW.

## Runtime / owner evidence

Earlier owner evidence established that Creation `Annuler` works after A4AU.

A4AV closed the separate Menu = FSM dispatch defect by binding the visible `cancel_creation -> Applications` command to the exact existing creation POST action instead of forging a GET route.

No claim of complete A4AV runtime acceptance is made here beyond the owner commit/push and evidence explicitly supplied.

## Canonical FSM evidence

`cancel_creation` already exists in `sites/owasys-front/config/fsm.json` as a command signal.

The canonical local transitions remain:

- `t_creation_basics_cancel`: `creation_basics -> registry`;
- `t_creation_security_cancel`: `creation_security -> registry`;
- `t_creation_review_cancel`: `creation_review -> registry`;
- `t_creation_failure_cancel`: `application_creation_failed -> registry`.

A4AV does not alter this topology.

## Root cause closed by A4AV

Before A4AV, `OwasysNavigationBuilder` made only navigation-type signals with mapped GET routes actionable. Command signals were displayed as FSM facts but passive.

Using `/applications` as a replacement link would have been semantically false because that GET route resolves to global signal `change_app`, not `cancel_creation`.

A4AV therefore adds the exact contract-bound request:

- route `applications/new`;
- method POST;
- field `owasys_action`;
- value `cancel-creation`;
- canonical FSM signal `cancel_creation`.

No arbitrary execute-signal endpoint exists.

## Semantic correction discovered after A4AV

Owner explicitly clarified on 2026-08-18 that FSM signal color must **not** represent GET/POST, REST transport, or the functional signal type (`navigation`, `command`, `outcome`, `system`).

The required visual distinction is the **origin of the signal**:

- signal sent by a user;
- signal sent by an automatic/system process.

Therefore the former A4AV acceptance wording that described `cancel_creation` as canonically amber because it is a `command` is withdrawn.

`type` remains useful functional metadata, but visual signal color must be driven by an independent origin dimension. HTTP transport and clickability are also independent dimensions.

A4AW is the causal generic OPUS follow-up for that semantic correction and for diagram POST actionability.

## A4AV delivery record

Artifact:

`opus_p117w_r45b2a4av_fsm_menu_post_command_dispatch.zip`

SHA-256:

`5828a8db8641699422ffced603c1331c1f612b1896370b01e8092df0c250375b`

Complete files:

1. `sites/owasys-front/config/routes.json`
2. `sites/owasys-front/application/default/services/NavigationBuilder.php`
3. `sites/owasys-front/application/default/templates/partials/navigation.score`
4. `sites/owasys-front/www/asset/css/fsm-native.css`

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
