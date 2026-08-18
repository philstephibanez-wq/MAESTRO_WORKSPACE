# P117W R45B2A4BE — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Owner baseline

OPUS GitHub HEAD:

`0f1356ee479336202518b253836f5a48bdc098af` — `opus_p117w_r45b2a4bb_application_fsm_resource_surface`.

A4BC and A4BD are not owner committed/pushed. A4BE is cumulative over A4BB and supersedes the local menu-projection direction from A4BC/A4BD.

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

A4BE implements this contract.

## Main implementation

### Canonical EFSM

`sites/owasys-front/config/fsm.json` now carries both resource navigation and resource-operation semantics. Menu command signals have canonical metadata including `label_key`, `menu_state`, `resource` and `operation`.

ACL transition guards use canonical keys such as:

`acl:data:create`

and are evaluated by pure OWASYS EFSM guard handlers.

### Human menu

`NavigationBuilder` builds resource navigation and CRUD/domain operations only from enabled/applicable canonical EFSM signals/transitions.

`navigation.score` renders:

- human I18n resource labels;
- human I18n operation labels;
- no technical `open_*` signal as submenu wording;
- disabled operations when the canonical EFSM guard set refuses them.

The 25 `application/menu/local/*.json` catalogs translate operation label keys.

### Technical diagnostic diagram

`FsmDiagramBuilder` uses technical state IDs and no longer replaces the generic OPUS semantic EFSM transition label with signal-only text.

The generic renderer therefore exposes:

`signal [guards] / actions/effects`.

Executable user signals retain secured interactive test actions.

### Same execution path

`FsmMenuSignalGateway` is the secured POST gateway used for canonical EFSM command execution from menu and diagnostic projections. It validates CSRF and canonical signal metadata, restores the FSM session, evaluates the same guards, applies the same transition, dispatches declared actions and persists the FSM state.

No second menu/workflow state machine exists.

## Canonical resource operation intents

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

These signals establish the canonical developer/admin EFSM operation contract. A4BE does not claim that every domain persistence implementation is already complete; missing domain business CRUD remains subsequent implementation work through REST/back/Composer.

## Artifact

`opus_p117w_r45b2a4be_efsm_single_source_i18n_resource_menu_diagnostic.zip`

SHA-256:

`0623d2283c1592ce57113d828edd10b3f4741b9d81962d13611f4833ba9567d1`

Exactly 68 complete files.

No `owasys-back` file is changed.

## Validation completed before delivery

- changed PHP syntax: OK;
- JSON parse: OK;
- no trailing whitespace;
- ZIP: 68 files;
- `FINAL_STATIC_OK`;
- `A4BE_SMOKE_OK`;
- `A4BE_REAL_FSM_PROCESSOR_OK`;
- `A4BE_GENERIC_DIAGRAM_EFSM_LABEL_OK`.

The generic diagram smoke specifically validates presence of technical signal, guards and runtime effect in the rendered EFSM label.

## Owner runtime acceptance

1. Extract A4BE over the current local OPUS tree.
2. Start back and front.
3. Select an application.
4. Confirm the top menu is resource-oriented and human-readable.
5. Open `Sources de données` and confirm its submenu shows human CRUD operations (`Créer`, `Consulter`, `Modifier`, `Supprimer`) and never `open_structure`, `open_security`, `open_fsm`, etc.
6. Confirm corresponding canonical technical signals are `create_data`, `read_data`, `update_data`, `delete_data`.
7. Confirm the EFSM diagram shows those technical keys together with guards such as `current_app_required` and `acl:data:create`, plus declared effects/actions.
8. Test a user signal from the diagram and from the menu and confirm both use the same canonical transition/guard execution path.
9. With a read-only/viewer identity, confirm allowed read operations remain actionable while write operations are visible but guard-disabled.
10. Confirm no regression in signal-origin colors, FSM fixed topology, Security, Sources/Git, profiler and selected-application FSM view.

## Next delivery

After owner validates the A4BE contract at runtime, continue by implementing the missing real business CRUD behind these canonical EFSM signals, one resource domain at a time, respecting:

`owasys-front -> secured REST -> owasys-back -> Composer -> response -> owasys-front`.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
