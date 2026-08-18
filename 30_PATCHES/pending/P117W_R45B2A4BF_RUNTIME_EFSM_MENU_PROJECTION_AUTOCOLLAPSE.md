# P117W R45B2A4BF — Runtime EFSM menu projection and native auto-collapse

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

Owner GitHub OPUS HEAD remains:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

A4BE is applied locally by the owner and produced the runtime screenshot that triggered A4BF. A4BF is therefore a differential over the locally applied A4BE tree.

## Governing contract

The OWASYS developer/admin menu is the operational UI. The EFSM diagram is the technical diagnostic/test projection.

Both are derived exclusively from the same canonical EFSM.

For the operational menu, projection is runtime-only:

`current state + canonical signal + actual runtime context + exact transition + all guards enabled -> visible/actionable menu entry`.

If an exact transition is not applicable from the current state, or any guard/condition is false, that menu or submenu entry is not projected.

The diagnostic diagram remains complete and may show transitions that are currently refused, together with their guards/conditions and effects, so the developer can diagnose why they cannot execute.

No template-side business rule and no second menu/workflow catalog is allowed.

## Root causes fixed

### Passive refused commands

A4BE correctly inspected command transitions but retained refused commands in the resource submenu as passive/disabled items.

A4BF changes the operational projection so only `menu_actionable=true` command views enter `operations`.

The complete signal/global-signal views are retained for the diagnostic diagram; diagnostic visibility is therefore not reduced.

### Synthetic current application context

A4BE gave `NavigationBuilder` only a `hasCurrentApp` boolean and synthesized:

`current_app = {present:true}`.

A4BF passes the actual current application object from RuntimeController, CreationController, SourceController and SecurityController into NavigationBuilder.

EFSM inspection therefore receives the actual current application context and can support guards that depend on application identity/type/capability instead of presence only.

### Native auto-collapse

Each resource operation submenu is a native `<details>` control in one exclusive group:

`name="owasys-efsm-resource-operations"`.

The active resource submenu is opened on server render. Opening another resource submenu closes the previously open one natively. No JavaScript state machine and no parallel workflow controller is introduced.

## Operational behavior

With an admin identity and current app, all command transitions whose guards pass can appear under their resource domains.

With a viewer/read-only identity, e.g. Data, only `read_data` is projected if `acl:data:open` passes; `create_data`, `update_data` and `delete_data` are absent when their ACL guards fail.

The same rule applies to Application, Structure, Security, FSM, Sources and Build.

Top-level resource navigation remains projected from enabled global navigation transitions only.

## Files

A4BF contains exactly 6 complete files at final paths:

- `sites/owasys-front/application/default/controllers/RuntimeController.php`
- `sites/owasys-front/application/default/services/NavigationBuilder.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/application/creation/controllers/CreationController.php`
- `sites/owasys-front/application/source/controllers/SourceController.php`
- `sites/owasys-front/application/security/controllers/SecurityController.php`

No backend file, no JavaScript and no CSS change is required.

## Artifact

`opus_p117w_r45b2a4bf_runtime_efsm_menu_projection_autocollapse.zip`

SHA-256:

`a65ef0156fd3cc0c44d6d2f186cd3f450151856ad347b99703dee9ca77cf7dad`

## Pre-delivery validation

- PHP syntax: 5/5 changed PHP files OK;
- differential against A4BE: exactly 6 changed files;
- template contract version: `OWASYS_EFSM_MENU_V2`;
- native exclusive details group present;
- passive/disabled command rendering removed from operational submenu;
- actual current app passed into all four NavigationBuilder call paths;
- static EFSM/ACL smoke: admin receives full guarded resource operations, viewer receives only guard-authorized reads;
- smoke marker: `A4BF_STATIC_SMOKE_OK`.

## Owner runtime acceptance

1. Apply A4BF over the already applied A4BE tree.
2. Reload `/fr-FR/application` with current app.
3. Confirm only one CRUD submenu can remain open at a time.
4. Confirm the active resource submenu opens after navigation to that resource.
5. With admin, verify all currently enabled EFSM operations remain visible.
6. With a restricted/viewer identity, verify write operations whose ACL guards fail are absent from the operational menu rather than shown as passive entries.
7. Confirm the EFSM diagnostic diagram still shows refused transitions and their guards/effects.
8. Confirm no `open_*` navigation signal appears as CRUD submenu wording.
9. Confirm menu action and diagram action still traverse the same canonical EFSM signal/guard execution path.

## Next work

After runtime validation, continue with real resource CRUD implementations behind the canonical EFSM operation signals, preserving the required flow:

`owasys-front -> secured REST -> owasys-back -> Composer -> response -> owasys-front`.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
