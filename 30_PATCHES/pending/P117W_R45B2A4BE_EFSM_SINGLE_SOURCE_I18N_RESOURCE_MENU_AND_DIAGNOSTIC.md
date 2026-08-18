# P117W R45B2A4BE — EFSM single source, I18n resource menu and diagnostic diagram

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Owner baseline

OPUS GitHub HEAD:

`0f1356ee479336202518b253836f5a48bdc098af` — `opus_p117w_r45b2a4bb_application_fsm_resource_surface`.

A4BC and A4BD were not owner committed/pushed when A4BE was prepared. A4BE is therefore cumulative over A4BB and can safely replace local A4BC/A4BD extraction.

## Governing architecture

### One source of truth

The canonical OWASYS EFSM is the sole source of truth for both operational menu and diagnostic graph.

Forbidden:

- template-defined workflow actions;
- a second CRUD/menu catalog independent from the EFSM;
- menu actions without a canonical EFSM signal and applicable transition;
- navigation signals exposed as resource CRUD operations.

Required projection:

`canonical EFSM -> human I18n developer/admin menu`

and independently:

`canonical EFSM -> technical interactive diagnostic diagram`.

### Menu contract

The menu is the privileged OWASYS developer/admin UI.

Top-level resource domains after an application is selected:

- Applications;
- Application;
- Sources de données;
- Structure;
- Sécurité;
- FSM;
- Sources et Git;
- Construction et validation.

OWASYS operator account/password/logout remain user chrome, not selected-application resource domains.

Each resource submenu is generated only from canonical EFSM user command signals assigned to that resource/state. Menu labels are resolved from the signal `label_key` through I18n. Technical signal IDs are not displayed as normal menu wording.

Navigation signals such as `open_data`, `open_structure`, `open_security`, `open_fsm`, `open_source`, `open_build` produce top-level navigation only and never resource submenu entries.

### Diagnostic EFSM contract

The diagram is not the privileged operational interface. It is a developer diagnostic/test view.

It displays technical canonical identifiers and EFSM semantics:

`signal [guards] / actions or runtime effects`.

User-originated executable signals remain clickable in development diagnostics. Clicking a diagnostic signal and selecting the equivalent menu operation must execute the same canonical signal through the same guard/action path.

### EFSM conditions

ACL and runtime preconditions are transition guards. A menu item may be visible but disabled when its transition is not enabled. The reason must remain an EFSM guard failure, not a template-side business decision.

A4BE introduces pure ACL guard handlers for canonical guards of the form:

`acl:<resource>:<operation>`.

## A4BE canonical resource operations

The EFSM now declares menu command signals for resource operation intents.

Applications:

- `create_application`
- `list_applications`
- `update_application`
- `delete_application`

Current application:

- `read_current_application`
- `update_current_application`
- `delete_current_application`

Data:

- `create_data`
- `read_data`
- `update_data`
- `delete_data`

Structure:

- `create_structure`
- `read_structure`
- `update_structure`
- `delete_structure`

Security:

- `create_security`
- `read_security`
- `update_security`
- `delete_security`

Application FSM:

- `create_fsm`
- `read_fsm`
- `update_fsm`
- `delete_fsm`

Sources:

- `create_source`
- `read_source`
- `update_source`
- `delete_source`

Build:

- `read_build`
- `update_build`
- `validate_build`
- `run_build`
- `export_build`

These are canonical EFSM operation intents. Where a complete business persistence implementation does not yet exist, A4BE does not pretend otherwise: the signal/guard/menu contract is established first, and the domain backend implementation remains subsequent work.

## Execution boundary

A4BE adds one secured frontend EFSM menu/test gateway. It accepts only canonical menu user-command signals, validates CSRF, restores the canonical FSM session, evaluates the same guards used by runtime/menu inspection, applies the exact transition, dispatches its declared actions, persists the FSM snapshot and redirects to the target resource with the operation context.

The gateway does not create a second workflow model.

## Generic OPUS diagram reuse

Generic OPUS `Diagram.class.php` already knows how to render semantic EFSM transition labels containing signal, guards and effects. OWASYS previously replaced those labels with signal-only text. A4BE removes that override; no generic OPUS renderer fork is added.

## Files

Artifact contains exactly 68 complete files at final paths.

Main implementation files include:

- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/config/routes.json`
- `sites/owasys-front/config/routes.localized.json`
- `sites/owasys-front/config/acl.json`
- `sites/owasys-front/application/default/services/FsmGuardHandlers.php`
- `sites/owasys-front/application/default/services/FsmMenuSignalGateway.php`
- `sites/owasys-front/application/default/services/NavigationBuilder.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- affected runtime/controller/bootstrap files required to execute the same canonical guards;
- 25 application-resource locale catalogs;
- 25 menu-operation locale catalogs;
- application resource SCORE surface;
- FSM menu CSS.

No `owasys-back` file is changed by A4BE.

## Artifact

`opus_p117w_r45b2a4be_efsm_single_source_i18n_resource_menu_diagnostic.zip`

SHA-256:

`0623d2283c1592ce57113d828edd10b3f4741b9d81962d13611f4833ba9567d1`

## Pre-delivery validation

Validated locally before delivery:

- exactly 68 files in ZIP;
- PHP syntax validation passes for changed PHP files;
- JSON parsing passes;
- no trailing whitespace;
- static contract smoke: `FINAL_STATIC_OK`;
- menu projection smoke: `A4BE_SMOKE_OK`;
- real `FsmProcessor` guard/transition smoke: `A4BE_REAL_FSM_PROCESSOR_OK`;
- generic EFSM diagram semantic-label smoke: `A4BE_GENERIC_DIAGRAM_EFSM_LABEL_OK`.

## Owner runtime acceptance

1. Apply A4BE over the current local OPUS tree; A4BE is cumulative over owner A4BB.
2. Select an application.
3. Confirm the resource menu is generated as Applications / Application / Data / Structure / Security / FSM / Source / Build subject to EFSM guards/ACL.
4. Open Data and confirm its submenu contains human I18n CRUD wording, not `open_*` navigation signals.
5. Confirm technical operation IDs remain available as EFSM signal metadata but are not normal menu labels.
6. Inspect the diagnostic EFSM and confirm transitions display technical signal IDs plus guards/conditions and actions/effects.
7. Confirm a guard-disabled operation is visible as disabled and carries the guard failure rather than disappearing due to independent UI business logic.
8. Confirm menu invocation and diagnostic-diagram invocation of the same user signal traverse the same canonical EFSM transition path.
9. Confirm no regression in selected-application FSM surface, profiler, source workflow, security workflow or signal-origin coloring.

## Next work

Implement remaining domain business CRUD persistence/resource APIs behind the canonical A4BE operation signals, resource by resource, through the required `front -> secured REST -> back -> Composer` flow. The EFSM/menu contract must not be bypassed while those implementations are added.
