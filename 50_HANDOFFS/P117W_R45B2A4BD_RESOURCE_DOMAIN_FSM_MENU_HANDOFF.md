# P117W R45B2A4BD — Handoff

State: SUPERSEDED BY A4BE — OWNER ARCHITECTURE REJECTED

## Baseline

GitHub OPUS HEAD when A4BD was produced:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

A4BD was cumulative over A4BB and included the A4BC visibility correction.

## Why A4BD is superseded

Owner review established that A4BD still expressed the wrong developer/admin contract.

A4BD correctly stopped leaking global `open_*` navigation signals into the active resource dropdown, but it incorrectly treated the absence of already-wired CRUD backend operations as a reason to omit the CRUD submenu itself.

The owner then fixed the architectural contract:

1. **The OWASYS menu is the privileged developer/admin interface.**
2. **The EFSM diagram is a diagnostic/test interface**, used to verify OWASYS workflow and to trigger executable user signals for testing; it is not the normal operational UI.
3. **The menu must be generated exclusively from the canonical EFSM.** No parallel menu model, CRUD catalog, route catalog or template-owned workflow is allowed.
4. Top-level menu items are resource domains represented by EFSM navigation signals.
5. A resource submenu contains its EFSM CRUD/domain-operation signals only; navigation signals never appear there.
6. Menu labels are human I18n labels obtained from EFSM `label_key` metadata.
7. The EFSM diagram displays technical state/signal keys, not translated menu wording.
8. Because the machine is an EFSM, diagnostic transitions must expose their guards/conditions and actions/effects.
9. Menu execution and diagram test execution must invoke the same canonical EFSM signal and therefore the same guards/actions.
10. ACL is part of transition eligibility and must be represented/enforced as EFSM guards rather than as an independent UI workflow decision.

## Superseded A4BD artifact

`opus_p117w_r45b2a4bd_resource_domain_fsm_menu.zip`

SHA-256:

`3afb61e6524ffdb9c151972d584143b8f0b4c37c25b6da7c53409b34fa5b7e55`

Do not use A4BD as the target architecture.

## Replacement

A4BE replaces A4BD with the canonical contract:

`EFSM = single source of truth -> I18n resource menu + technical interactive diagnostic diagram`.

A4BE is intentionally cumulative over owner HEAD A4BB, so it can be applied whether or not A4BC/A4BD were extracted locally.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
