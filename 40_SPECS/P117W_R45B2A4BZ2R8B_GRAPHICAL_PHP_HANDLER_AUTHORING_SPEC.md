# P117W R45B2A4BZ2R8B — Graphical PHP GUARD/ACTION authoring

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Exact layering baseline

R8B applies on the owner's current uncommitted OPUS working tree:

- Git HEAD: `9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`;
- R8A applied;
- R8A1R1 applied;
- exactly the 17 R8A paths are present in `git status` before R8B;
- `sites/owasys-front/application/default/services/FsmGuardHandlers.php` SHA-256 must be `e7c03e31c351f2d895222057bad57f92e8ba726b120517e55676f463991f69a4`.

R8B does not require or permit pushing R8A/R8A1R1 first.

## Goal

Enable the developer to create and modify real PHP GUARD/ACTION handlers directly from the graphical EFSM designer, using the source authority and secured write pipeline introduced by R8A.

The designer is a development tool. A GUARD/ACTION created here is executable developer code, not a JSON-only symbol.

## Runtime / transport contract

Handler mutation remains:

`owasys-front -> secured REST PUT -> owasys-back -> allow-listed Composer -> SiteSourceWorkspace -> FsmDeveloperHandlers.php -> response -> owasys-front`

No JavaScript is added to `sites/owasys-back`.

## UI contract

The existing pending GUARD/ACTION toolbar groups become active:

- GUARD Create;
- GUARD Edit;
- ACTION Create;
- ACTION Edit;
- catalog selector per kind.

The inspector receives a source editor with:

- handler kind;
- mode (`create` / `update`);
- handler id;
- real PHP callable source;
- managed-source metadata;
- validate/cancel controls.

Dynamic `acl:*` guards remain visible but read-only. The `acl:` guard namespace cannot be developer-authored.

## Source authoring semantics

Creation starts from a syntactically valid callable template matching the real runtime callback signature.

Update loads the exact managed PHP callable source returned by `OwasysFsmHandlerCatalog`.

The browser sends only the developer source mutation request expected by R8A:

- `owasys_fsm_designer_handler=1`;
- `csrf_token`;
- `handler_kind`;
- `handler_id`;
- `handler_mode`;
- `handler_code`.

The frontend accepts only `OWASYS_EFSM_HANDLER_WRITE_RESULT_V1`, adopts the rotated CSRF token, reloads the real runtime/source catalog, and makes the new handler immediately selectable for transition GUARD/ACTION binding.

No `eval` is introduced.

## Differential scope

R8B changes exactly four files on top of R8A+R8A1R1:

- `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`;
- `sites/owasys-front/www/asset/css/fsm-native.css`;
- `sites/owasys-front/www/asset/js/fsm-designer.js`.

The whole working tree therefore goes from 17 to 19 changed paths because the template and CSS were clean before R8B while the renderer and JS were already part of R8A.

## Safety / preflight

The applicator refuses unless:

- HEAD is the exact R7R2 commit;
- the working-tree path set is exactly the expected 17-path R8A stack;
- R8A1R1's exact repaired guard source SHA is present;
- the clean R7R2 template and CSS blobs match their known Git blobs;
- the R8A frontend JS matches its exact normalized Git blob;
- the expected R8A renderer anchors are unique.

On any write/lint/path verification failure the four R8B target files are restored.

## Acceptance

Owner validation must demonstrate:

1. `/fr-FR` boots normally;
2. the normal menu still has no `FSM` destination;
3. EFSM designer opens;
4. GUARD Create writes a real PHP callable and refreshes the catalog;
5. GUARD Edit displays and updates the exact managed PHP source;
6. ACTION Create/Edit behaves identically;
7. `acl:*` cannot be edited as developer source;
8. a newly created handler is immediately available in transition binding;
9. both sites validate;
10. `git status --short` contains exactly 19 paths;
11. no OPUS/OWASYS push occurs until the full stack passes owner runtime validation.
