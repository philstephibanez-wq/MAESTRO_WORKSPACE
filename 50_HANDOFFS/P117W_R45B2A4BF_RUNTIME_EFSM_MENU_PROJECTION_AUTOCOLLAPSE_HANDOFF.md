# P117W R45B2A4BF — Handoff

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline and dependency

Owner GitHub OPUS HEAD is still:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

Owner has applied A4BE locally and supplied runtime evidence from `/fr-FR/application`. A4BF is intentionally a small differential over that A4BE local tree, not a cumulative replacement for A4BE.

## Owner runtime evidence

A4BE now visually behaves like an IDE: resource domains are top-level menu entries, human I18n CRUD/domain operations appear below them, and the EFSM diagnostic remains visible with technical transition semantics.

Residual defects observed/clarified by owner:

- multiple resource submenus can remain open simultaneously;
- operational menu/submenus must obey exactly the same EFSM current-state/guard conditions as execution;
- the menu is the privileged developer/admin UI, while the diagram remains diagnostic.

## A4BF correction

### Runtime-only menu projection

A4BF projects an operational submenu operation only when the exact canonical EFSM transition inspection reports it enabled and actionable.

Refused guard transitions are no longer rendered as passive operational commands.

The diagnostic diagram remains complete because `signals` / `global_signals` continue carrying the full inspected transition views, including refused transitions and guard results.

### Actual application context

`NavigationBuilder` now receives the real current application object instead of a boolean and synthetic `{present:true}` placeholder.

Affected call paths:

- RuntimeController;
- CreationController;
- SourceController;
- SecurityController.

This makes current runtime EFSM guard inspection compatible with conditions based on application facts, not merely current-app presence.

### Native auto-collapse

Resource operation dropdowns use one native HTML `<details name="owasys-efsm-resource-operations">` group.

The active resource opens on server render. Opening another dropdown automatically closes the previous one. No JavaScript and no independent menu state machine are introduced.

## Artifact

`opus_p117w_r45b2a4bf_runtime_efsm_menu_projection_autocollapse.zip`

SHA-256:

`a65ef0156fd3cc0c44d6d2f186cd3f450151856ad347b99703dee9ca77cf7dad`

Exactly 6 complete files.

## Validation performed

- PHP lint: 5/5 OK;
- exact differential versus A4BE: 6 files;
- actual `current_app` context present in NavigationBuilder;
- only `menu_actionable=true` commands enter operational `operations` projection;
- no passive command branch remains in SCORE menu template;
- native `<details name=...>` exclusive group present;
- active resource `open` server projection present;
- EFSM/ACL static smoke demonstrates:
  - admin: full currently guard-enabled CRUD/domain operations;
  - viewer: read-only projections, write operations excluded;
- `A4BF_STATIC_SMOKE_OK`.

## Owner acceptance

Apply over A4BE, then verify:

1. one submenu maximum open at a time;
2. active resource submenu automatically open after navigation;
3. admin receives the enabled CRUD/domain operations;
4. restricted identity does not see operations whose EFSM guards fail;
5. diagnostic EFSM still shows those refused transitions/guards;
6. no navigation `open_*` signal leaks into CRUD wording;
7. menu and diagnostic test action still use the same canonical EFSM transition execution path.

## Next delivery

After owner runtime validation, proceed to the real business CRUD layer behind the canonical EFSM commands, resource by resource, through:

`owasys-front -> secured REST -> owasys-back -> Composer -> response -> owasys-front`.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
