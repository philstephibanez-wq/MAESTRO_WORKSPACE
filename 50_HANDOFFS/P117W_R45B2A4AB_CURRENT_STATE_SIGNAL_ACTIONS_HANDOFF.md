# P117W R45B2A4AB — Handoff

State: OWNER VALIDATION REQUIRED

## Baseline

Accepted OPUS baseline:

`0ce2dfa9a1c7175ac39f93b2ee017ed6e40643ac` — A4Z.

Owner working tree additionally contains A4AA:

`M sites/owasys-front/www/asset/css/fsm-native.css`

Keep that CSS modification. A4AB adds one PHP modification and does not replace the CSS.

## Root correction

The fixed graph intentionally displays representative edges. Runtime interaction must not be keyed to the representative edge's source state.

A4AB derives currently executable actions exclusively from the current Menu=FSM state, then maps each actionable semantic `signal + target` to one fixed displayed representative.

Selection rule:

- exact displayed source == current state: prefer it;
- otherwise: use the first fixed representative of the same `signal + target`;
- action URL always comes from the current state's `NavigationBuilder` projection;
- passive current-state signals never receive a link.

This makes `logout` global wherever the FSM actually allows it without making the diagram dynamic.

## Artifact

`opus_p117w_r45b2a4ab_current_state_signal_actions.zip`

SHA-256:

`c6fbbc154e2234aa34097c55e36aa6655fec93148aaf61fcd5fddd8d8aad0fae`

Complete final-path file:

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

File SHA-256:

`42da48932c583192c35c16b38053d29f952cfd7151711119c4a96a4f8347460d`

## Validation already executed

PHP lint succeeds.

Synthetic semantic-routing smoke succeeds:

`A4AB_SMOKE_OK logout=global change_app=global exact-source-preferred duplicate-links=0`

## Owner validation target

After extraction, the working tree should contain the existing A4AA CSS modification plus the new A4AB `FsmDiagramBuilder.php` modification.

Restart `owasys-front` and verify on `/fr-FR/applications`:

- fixed A4Z geometry unchanged;
- menu autocollapse unchanged;
- A4AA cyan/focus hitbox unchanged;
- `logout` label clickable from Applications and routes through normal FSM logout handling;
- `change_app` and displayed `open_*` labels clickable only when their equivalent current-state transition is actionable;
- passive actions remain passive.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.