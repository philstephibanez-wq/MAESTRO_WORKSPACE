# P117W R45B2A4AZ — Handoff

State: OWNER UI VALIDATION FAILED — MENU STRUCTURE STILL INCORRECT — A4BA FOLLOW-UP

## Owner baseline

OPUS HEAD before local A4AZ application:

`726d48d417be5ef6d7248cb9f2cc7a59e8c147a9` — `opus_p117w_r45b2a4ay_guarded_fsm_transition_inspection`

A4AY is owner committed/pushed. A4AZ was applied locally for runtime validation; no owner commit/push for A4AZ is recorded yet.

## A4AZ intent

A4AZ changed only:

`sites/owasys-front/application/default/services/NavigationBuilder.php`

It connected OWASYS menu actionability to generic `FsmProcessor::inspectTransition()` and moved the ordinary global rail from Applications to the current state. Pure navigation self-loops were made passive.

## Owner runtime evidence — 2026-08-18

The owner supplied screenshots while current state was `structure` and reported that the menu was still incoherent.

Observed UI defects:

- every visible FSM state was still rendered as a dropdown, even when it was not the current state;
- non-current states with no local transition displayed an empty `Ø` dropdown;
- non-current `application_creation_failed` exposed `cancel_creation`, `return_security`, and `begin_application_creation`, despite those transitions not belonging to the current `structure` state;
- therefore A4AZ corrected transition actionability but not the menu projection structure.

The supplied front profiler trace for `GET /fr-FR/structure` shows that the canonical FSM executed `structure --open_structure [current_app_required]--> structure` successfully and ACL allowed `structure:open`. The menu defect is therefore not caused by ACL, backend REST, or a failed FSM guard.

The same trace records HTTP status `501`, because Structure currently renders the pending module. This is separate from the menu-structure defect.

## Root cause

`application/default/templates/partials/navigation.score` still renders every allowed visible state as a `<details>` element. Consequently all states receive a dropdown affordance, passive historical local transitions remain exposed for inactive states, and empty states render `Ø`.

A4AZ cannot solve that in `NavigationBuilder.php` alone.

## A4BA required correction

The menu projection contract becomes:

- all allowed visible states may remain visible as FSM state references;
- **only the current state is a dropdown**;
- only the current state exposes outgoing signals;
- inactive states have no arrow, no dropdown, no `Ø`, and no signals;
- current-state outgoing signals remain derived from the canonical FSM and A4AY guarded inspection;
- signal color remains origin user vs automatic only;
- transport GET/POST remains orthogonal;
- diagram topology remains independent and unchanged.

Owner alone applies/validates/commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
