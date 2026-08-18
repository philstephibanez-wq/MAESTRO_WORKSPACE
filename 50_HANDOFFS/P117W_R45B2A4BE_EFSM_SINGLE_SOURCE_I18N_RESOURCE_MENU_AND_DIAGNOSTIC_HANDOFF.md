# P117W R45B2A4BE — Handoff

State: OWNER RUNTIME PARTIALLY VALIDATED — SUPERSEDED BY A4BF RUNTIME PROJECTION FOLLOW-UP

## Owner baseline

OPUS GitHub HEAD remains:

`0f1356ee479336202518b253836f5a48bdc098af` — `opus_p117w_r45b2a4bb_application_fsm_resource_surface`.

A4BE is applied locally by the owner but is not owner committed/pushed at the time of this handoff update.

## Owner-fixed architecture

The owner explicitly established the following invariants:

- the normal OWASYS developer/admin interface is the menu;
- the EFSM diagram is a diagnostic/test interface, not the privileged operational UI;
- the menu is forbidden from having any source other than the canonical EFSM;
- top-level menu entries are EFSM resource-navigation projections;
- resource submenus are EFSM CRUD/domain-operation projections only;
- `open_*` navigation signals never appear as CRUD submenu entries;
- menu wording is human I18n;
- EFSM diagram wording uses canonical technical state/signal keys;
- EFSM transitions visibly expose guards/conditions and actions/effects;
- menu clicks and diagnostic signal clicks execute the same canonical EFSM signal and guards/actions.

## A4BE runtime evidence

Owner screenshot on `/fr-FR/application` with current app `essai2` confirms the main architecture is now visually close to an IDE:

- resource-oriented menu is present;
- human I18n CRUD/domain wording is present in submenus;
- technical `open_*` signals are not used as submenu wording;
- technical EFSM diagram remains visible for diagnostic inspection;
- EFSM transition labels expose technical signal/guard/effect semantics.

Owner explicitly states that the remaining contract is runtime gating:

> menus and submenus have the same constraints as the EFSM: transitions authorized from the current state and conditional signals validated.

Owner also requests native auto-collapse because multiple resource submenus can currently remain open at once.

## Residual A4BE defect

A4BE still projected failed command guards as passive/disabled submenu entries. This is not the required operational runtime projection.

A4BE also reduced current-app context inside `NavigationBuilder` to a boolean presence fact and a synthetic `current_app = {present:true}` value. That is insufficient for future guards whose result depends on actual application identity/type/capability/context.

Therefore A4BE is superseded for menu runtime projection by A4BF.

## A4BE canonical resource operation intents

Applications:
`create_application`, `list_applications`, `update_application`, `delete_application`.

Application:
`read_current_application`, `update_current_application`, `delete_current_application`.

Data:
`create_data`, `read_data`, `update_data`, `delete_data`.

Structure:
`create_structure`, `read_structure`, `update_structure`, `delete_structure`.

Security:
`create_security`, `read_security`, `update_security`, `delete_security`.

FSM:
`create_fsm`, `read_fsm`, `update_fsm`, `delete_fsm`.

Sources:
`create_source`, `read_source`, `update_source`, `delete_source`.

Build:
`read_build`, `update_build`, `validate_build`, `run_build`, `export_build`.

These remain canonical EFSM operation intents. Missing real domain persistence is separate subsequent work through REST/back/Composer.

## A4BE artifact

`opus_p117w_r45b2a4be_efsm_single_source_i18n_resource_menu_diagnostic.zip`

SHA-256:

`0623d2283c1592ce57113d828edd10b3f4741b9d81962d13611f4833ba9567d1`

Exactly 68 complete files.

## A4BF follow-up contract

A4BF must enforce:

`current EFSM state + canonical signal + actual runtime context + all guards true -> menu projection`.

If the exact transition is absent or any guard fails, the corresponding operational menu/submenu entry is not projected. The diagnostic EFSM still shows that transition and its conditions so the developer can understand why it is unavailable.

The same rule applies to top-level resource navigation and CRUD/domain operation submenus.

Resource submenu auto-collapse must use native UI semantics and must not introduce a second workflow/controller model.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
