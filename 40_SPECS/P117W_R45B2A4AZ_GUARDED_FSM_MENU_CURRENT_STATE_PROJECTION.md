# P117W R45B2A4AZ — Guarded FSM Menu Current-State Projection

## Baseline

OPUS owner HEAD:

`726d48d417be5ef6d7248cb9f2cc7a59e8c147a9` — A4AY guarded transition inspection.

## Cause

A4AY added the generic non-mutating guard decision, but OWASYS `NavigationBuilder` still computed actionability locally and hosted ordinary global transitions under Applications/registry. Therefore applying A4AY produced no visible UI change and the current `data` state still presented an inefficient `open_data -> data` navigation loop.

## Contract

A4AZ makes Menu = FSM consume `FsmProcessor::inspectTransition()` for the currently applicable transition. Runtime-declared guards therefore participate in visible actionability.

Ordinary global transitions applicable to the current state are projected once under the current state, not under Applications.

A pure navigation self-loop with no actions and no runtime operations remains visible as a canonical FSM fact but is not offered as a useful menu action. This is a projection rule, not a REST rule and not a signal-color rule.

Signal color remains exclusively `origin=user|automatic` per A4AW.

ACL/current-application target availability remains authoritative in this step and is combined with the generic FSM guard decision. A later migration can move ACL/business readiness to explicit canonical guard handlers without changing the projection API.

## Expected visible result from `data`

With an authenticated identity and a selected application, the current `data` submenu must host the applicable global development signals. `open_data -> data` is passive as a pure current-state navigation, while transitions such as `open_structure`, `open_security`, `open_workflows`, `open_source` and `open_build` are actionable when their target is allowed/available and FSM guards pass.

The diagram consumes the same navigation actionability through the existing A4AW projection path; no HTTP method controls color.

## Delivery

Exactly one complete file:

`sites/owasys-front/application/default/services/NavigationBuilder.php`

Base blob:

`412a51d7fca717b431d772333646e64bc668f984`

Delivered blob:

`6995b099c7940e782441b7f9527cef2f8996c85d`

Artifact:

`opus_p117w_r45b2a4az_guarded_fsm_menu_current_state_projection.zip`

SHA-256:

`566d1a8c7c3de9196aa8eb972d36e1d8764a69065258b1accd28495abe9f2c7f`

## Static/smoke validation

- PHP lint OK;
- no trailing whitespace;
- smoke `A4AZ_SMOKE_OK`;
- global host is current state;
- pure `open_data -> data` remains FSM-enabled but menu-passive with projection reason `current_state`;
- guarded target transition becomes passive when `current_app_required` fails;
- failed guard is exposed in projection data;
- allowed `open_structure` receives its canonical localized route;
- no FSM topology, REST route, ACL policy, SCORE template, color, backend or profiler lifecycle change.
