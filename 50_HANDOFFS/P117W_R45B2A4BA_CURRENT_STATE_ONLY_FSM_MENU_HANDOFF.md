# P117W R45B2A4BA — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline and prerequisite

Owner OPUS HEAD:

`726d48d417be5ef6d7248cb9f2cc7a59e8c147a9` — A4AY.

A4AZ is currently applied locally for owner runtime validation and is required before A4BA. No A4AZ owner commit/push is recorded yet.

## Runtime evidence received

Owner screenshots with current state `Structure` show the menu still violating FSM semantics:

- inactive `Création impossible` opens a dropdown containing `cancel_creation`, `return_security`, `begin_application_creation`;
- inactive `Sécurité`, `Workflows`, `Construction et validation`, `Compte`, etc. open empty `Ø` dropdowns;
- every visible state still displays a dropdown arrow.

Front profiler trace for `GET /fr-FR/structure` confirms:

- canonical current state `structure`;
- signal `open_structure`;
- transition `g_open_structure`;
- guard `current_app_required = allowed`;
- ACL `structure:open = allowed`;
- request completed.

The trace also reports status 501 because Structure currently uses the pending screen. That is separate from menu projection.

## Root cause

A4AZ fixed the actionability provider in `NavigationBuilder.php`, but `navigation.score` still rendered every visible/allowed state as a `<details>` menu. Therefore inactive-state transition definitions were still exposed and empty dropdowns were generated.

## A4BA correction

Only the current state is now an expandable FSM menu.

Inactive states remain visible as static canonical state references so the user keeps global FSM context, but they have:

- no dropdown arrow;
- no click/hover menu affordance;
- no signal panel;
- no `Ø` placeholder;
- no inactive-state transitions.

The current state keeps the outgoing global/local signal rendering provided by A4AZ, including guarded enabled/denied state from A4AY inspection and existing exact GET/POST bindings.

## Files

Exactly three complete files:

1. `sites/owasys-front/application/default/templates/partials/navigation.score`
2. `sites/owasys-front/www/asset/css/fsm-native.css`
3. `sites/owasys-front/application/default/services/ScorePageRenderer.php`

No FSM config/topology, controller, REST, backend, ACL policy, session, source, Git, Composer, or JavaScript change.

## Delivery

Artifact:

`opus_p117w_r45b2a4ba_current_state_only_fsm_menu.zip`

SHA-256:

`05c10cbb14cf2b5ff368b9619069c04abdff84c23a216d676a6ea9efe75f7a6a`

## Validation completed before delivery

- PHP lint ScorePageRenderer: OK;
- SCORE structural token balance: OK;
- current-state `<details>` branch: present;
- inactive state static-reference branch: present;
- CSS removes inactive arrow/pointer behavior;
- stylesheet cache key: A4BA;
- no trailing whitespace;
- ZIP exactly three complete files plus directories.

## Owner runtime acceptance

1. Keep A4AZ applied, then apply A4BA.
2. Relaunch `owasys-front`.
3. Enter/select an app and navigate to Structure.
4. Confirm **Structure alone** has a dropdown arrow.
5. Confirm inactive states are labels only and cannot open.
6. Confirm there is no `Ø` under inactive states.
7. Open Structure and confirm it contains only transitions outgoing from current state according to the A4AZ guarded projection.
8. Confirm pure `open_structure -> Structure` remains passive if shown.
9. Navigate to another allowed state and confirm the dropdown moves with the current state.
10. Confirm diagram topology/actionability and signal-origin colors remain unchanged.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
