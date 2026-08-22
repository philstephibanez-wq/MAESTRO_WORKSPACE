# P117W R45B2A4BZ2R8B2 — Actual graphical PHP GUARD/ACTION authoring

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Baseline

Exact OPUS baseline:

`707b1acce1c05dda9751b4b04979b68dc5b2f1f0`

`opus_p117w_r45b2a4bz2r8b1_actual_r8b_boot_repair`

R8B1 is owner-committed/pushed and the owner supplied a rendered OWASYS applications page after the boot repair.

## Cause treated

The original R8B handoff claimed graphical GUARD/ACTION authoring, but the actual R8B Git landing did not contain that UI.

Current baseline facts:

- `fsm-diagram.score` is still the R7R2 surface with GUARD/ACTION Create/Edit disabled;
- `fsm-native.css` is unchanged from the previous designer shell;
- `fsm-designer.js` contains the R8A handler catalog and CSRF rotation but no PHP source editor/write workflow;
- the secured handler-write pipeline already exists in `FsmDesignerGateway` and `OwasysFsmDraftCommandProvider`;
- managed catalog entries already expose the exact PHP callable source, managed/dynamic ownership and hashes;
- R8B accidentally committed three zero-byte root files: `certutil`, `findstr`, `git`.

R8B2 completes the missing UI against the existing secured pipeline instead of creating a second write path.

## Delivered behavior

### GUARD source authoring

In EFSM design mode:

- GUARD Create opens a real PHP callable source editor;
- GUARD Edit opens only developer-managed GUARD handlers;
- dynamic `acl:*` guards remain visible to transition binding but are excluded from source editing;
- new GUARD IDs beginning with `acl:` are rejected client-side and remain rejected server-side.

### ACTION source authoring

- ACTION Create opens a real PHP callable source editor;
- ACTION Edit loads the exact managed PHP callable source;
- default skeleton uses the real `FsmActionDispatcher` callback signature.

### Trusted write flow

The browser submits only handler kind/id/mode/code plus CSRF to the existing front gateway.

The authoritative source hash remains server-derived from the trusted handler catalog.

Write flow remains:

`owasys-front -> secured REST -> owasys-back -> allow-listed Composer -> SiteSourceWorkspace -> FsmDeveloperHandlers.php`

No direct browser filesystem write, no `eval`, and no backend JavaScript are introduced.

### Post-write behavior

After a successful `OWASYS_EFSM_HANDLER_WRITE_RESULT_V1` response:

- the rotated CSRF token is adopted;
- the real handler catalog is reloaded;
- managed source/hash metadata are refreshed;
- the newly programmed handler becomes immediately available to transition GUARD/ACTION binding.

### Repository hygiene

Delete the accidental tracked zero-byte root files:

- `certutil`;
- `findstr`;
- `git`.

## Differential scope

Exactly seven paths change relative to `707b1acc...`:

Modified:

- `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`;
- `sites/owasys-front/www/asset/css/fsm-native.css`;
- `sites/owasys-front/www/asset/js/fsm-designer.js`.

Deleted:

- `certutil`;
- `findstr`;
- `git`.

No backend file changes in this slice.

## Applicator preflight

The applicator refuses unless:

- HEAD is exactly `707b1acce1c05dda9751b4b04979b68dc5b2f1f0`;
- the working tree is clean;
- renderer/template/CSS/JS Git blob IDs match the audited baseline;
- R8B1 `FsmGuardHandlers.php` blob matches the committed repair;
- the three accidental root files are still the exact empty Git blobs.

All transformations are staged in memory before any write. A failed transformation writes nothing. A write/delete failure triggers restoration of all original bytes.

## Acceptance

Owner validation must verify:

1. both sites validate;
2. normal `/fr-FR/applications` still renders;
3. Conception opens design mode;
4. GUARD Create/Edit and ACTION Create/Edit are enabled after catalog load;
5. editing a managed handler shows its actual PHP callable;
6. `acl:*` cannot be source-edited;
7. creating a temporary GUARD succeeds through front/back/Composer and it immediately appears in transition binding;
8. the equivalent ACTION flow succeeds;
9. fresh front/back logs and Profiler show the correlated handler write;
10. `git status --short` shows exactly the four modified UI paths and three deleted accidental root files before commit.

No push before these runtime checks pass.