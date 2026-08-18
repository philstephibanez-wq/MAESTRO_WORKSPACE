# P117W R45B2A4AZ — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Owner baseline

OPUS HEAD:

`726d48d417be5ef6d7248cb9f2cc7a59e8c147a9` — `opus_p117w_r45b2a4ay_guarded_fsm_transition_inspection`

A4AY is owner committed/pushed.

## Owner observation

After A4AY the owner reported no visible change. This is expected because A4AY changed only generic OPUS `FsmProcessor` inspection and no OWASYS consumer.

## A4AZ change

A4AZ modifies only:

`sites/owasys-front/application/default/services/NavigationBuilder.php`

It now constructs the generic `FsmProcessor` from the canonical FSM and calls `inspectTransition(currentState, signal, context)` for currently applicable global/local transitions.

Menu actionability therefore requires the generic FSM decision to be enabled in addition to the existing canonical route and target access/availability checks.

The ordinary global rail is hosted once under the current state instead of under `registry`/Applications.

Pure navigation self-loops with no transition actions/runtime operations remain visible but are menu-passive. This prevents `data -> open_data -> data` from being offered as a useful action without forbidding normal direct-route refresh semantics.

A4AW invariants remain:

- color = signal origin user vs automatic only;
- GET/POST is transport only;
- actionability is independent from color;
- diagram and menu derive from the same canonical FSM;
- no invented transition.

## Expected owner-visible behavior

After selecting an application and arriving in `data`:

- the active Sources de données submenu hosts the applicable global FSM transitions;
- `open_data -> Sources de données` is visible but passive/current-state;
- `open_structure`, `open_security`, `open_workflows`, `open_source`, `open_build` are actionable when ACL/current-app availability and FSM guards allow them;
- the diagram receives the same A4AW actionability projection and must not make `open_data` a useful current-state action.

## Source integrity

Base owner blob:

`sites/owasys-front/application/default/services/NavigationBuilder.php` -> `412a51d7fca717b431d772333646e64bc668f984`

Delivered blob:

`6995b099c7940e782441b7f9527cef2f8996c85d`

## Delivery

Artifact:

`opus_p117w_r45b2a4az_guarded_fsm_menu_current_state_projection.zip`

SHA-256:

`566d1a8c7c3de9196aa8eb972d36e1d8764a69065258b1accd28495abe9f2c7f`

Exactly one complete file at final path. No patcher, deletion or generated report.

## Validation completed

- `php -l` OK;
- no trailing whitespace;
- smoke `A4AZ_SMOKE_OK`;
- current state owns global rail;
- current-state pure navigation is passive while the FSM transition itself remains valid;
- generic `current_app_required` guard controls projection through A4AY inspection;
- allowed peer navigation remains actionable;
- no backend/REST/ACL policy/FSM topology/SCORE/color/profiler lifecycle change.

## Owner runtime acceptance

1. Select an existing application.
2. Confirm arrival in Sources de données (`data`).
3. Open the active Sources de données FSM menu.
4. Confirm `open_data -> Sources de données` is not actionable.
5. Confirm the other allowed development destinations are present under the active state and actionable.
6. Click `open_structure` and verify state changes to Structure.
7. Verify the active-state submenu then moves with the state and does not offer `open_structure -> Structure` as a useful self-navigation.
8. Confirm signal colors still distinguish only user vs automatic origin.
9. Confirm Creation `cancel_creation` remains actionable through its exact POST binding.
10. Confirm no diagram topology regression.

Owner alone applies/validates/commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
