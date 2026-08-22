# P117W R45B2A4BZ2R8A — Developer handler source authority handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Exact OPUS baseline

`9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`

## Artifact

`opus_p117w_r45b2a4bz2r8a_developer_handler_source_authority.zip`

ZIP SHA-256:

`c20cdcba7c60d652d1a08a293ca6d8cc644413b009e519077d94dc9368f1a244`

Applicator SHA-256:

`602934e6540ac4174eff29d2d23181cb132d29b90b0432feb85bc31669ff115c`

The ZIP contains exactly one differential applicator: `apply_a4bz2r8a.php`.

The assistant does not commit/push OPUS/OWASYS.

## Delivered architecture

R8A establishes a real PHP source authority for developer-programmed EFSM GUARD/ACTION handlers before enabling graphical source editing.

- generic `FsmHandlerSourceEditor` + homonymous mandatory OPUS interface;
- application-owned `FsmDeveloperHandlers.php` containing the existing 6 application guards and 8 application actions as real managed PHP callables;
- runtime guard/action wrappers delegate to those actual callables;
- `acl:` guard namespace remains dynamic/reserved;
- handler catalog correlates actual runtime registrations with managed source/code/SHA-256;
- secured handler mutation path uses `PUT /api/v1/applications/{site_id}/fsm/handlers`;
- backend command `owasys:fsm:handler-write` is allow-listed and persists through generic `SiteSourceWorkspace` optimistic locking/atomic write;
- no `eval`;
- no backend JavaScript/Node;
- designer catalog GET-equivalent POST no longer consumes the one-use mutation CSRF token;
- mutation responses return the next usable designer CSRF token and current frontend JS adopts it.

The GUARD/ACTION Create/Edit toolbar controls remain intentionally disabled in R8A. R8B enables the graphical source authoring surface on top of this verified write pipeline.

## Exact changed paths

Exactly 17:

- `Opus/Fsm/Definition/FsmHandlerSourceEditor.php`
- `Opus/Fsm/Definition/FsmHandlerSourceEditorInterface.php`
- `composer.json`
- `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`
- `sites/owasys-back/config/backend.operations.json`
- `sites/owasys-back/config/backend.resources.json`
- `sites/owasys-back/config/backend.rest.json`
- `sites/owasys-back/config/composer.commands.json`
- `sites/owasys-front/application/default/bootstrap.php`
- `sites/owasys-front/application/default/services/FsmActionHandlers.php`
- `sites/owasys-front/application/default/services/FsmDesignerGateway.php`
- `sites/owasys-front/application/default/services/FsmDeveloperHandlers.php`
- `sites/owasys-front/application/default/services/FsmGuardHandlers.php`
- `sites/owasys-front/application/default/services/FsmHandlerCatalog.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/config/rest.resources.json`
- `sites/owasys-front/www/asset/js/fsm-designer.js`

## Pre-delivery verification performed

### Final artifact

- final applicator `php -l`: OK;
- ZIP contains exactly one file (`apply_a4bz2r8a.php`);
- applicator extracted from ZIP and linted again: OK.

### Generic source editor

- all six prepared PHP sources linted;
- initial managed source parsed as 6 GUARD + 8 ACTION handlers;
- `guard dev_check` creation parsed and increased GUARD catalog to 7;
- update of that handler parsed successfully;
- deliberately invalid PHP rejected with `OPUS_EFSM_HANDLER_SOURCE_PHP_INVALID`.

### Transactional applicator fixture

A clean Git fixture reproducing every transformation/anchor was used. The test applicator was byte-identical to the final applicator except for the fixture baseline SHA and fixture expected Git blob SHA values.

- complete application: success;
- marker `P117W_R45B2A4BZ2R8A_APPLIED` emitted;
- exactly 17 changed paths verified by applicator;
- all ten generated/changed PHP sources passed the applicator's `php -l` checks;
- all six JSON files parsed;
- transformed frontend JavaScript passed `node --check`;
- generic managed catalog on the resulting real managed source was 6 guards + 8 actions;
- in-memory managed handler create probe passed;
- second application refused with exit code 20;
- forced final changed-path verification failure caused rollback to a clean Git status.

### Runtime wrapper test

The resulting managed source and wrappers were loaded with bounded test doubles for runtime dependencies:

- `OwasysFsmGuardHandlers` returned all six managed application guards plus a dynamic `acl:foo:read` guard;
- managed `always` guard executed and returned true;
- dynamic ACL guard executed through the security adapter;
- `OwasysFsmActionHandlers` exposed exactly eight managed actions;
- `start_session` executed the real migrated developer-programmed callable and returned the expected session payload.

## Expected applicator markers

`P117W_R45B2A4BZ2R8A_APPLIED`

- `baseline=9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`
- `handler_source=real_php_managed_regions`
- `handler_execution=developer_programmed_callables`
- `handler_authoring=rest_back_composer_source_write`
- `catalog_authority=runtime_registration_plus_managed_source`
- `designer_csrf=rotated_after_mutation`
- `guard_acl_namespace=reserved_dynamic`
- `ui_handler_editor=pending_r8b`
- `changed_files=17`

## Owner validation

After application:

1. run Composer optimized autoload;
2. validate `owasys-front` and `owasys-back`;
3. run PHP lint on the generic editor/interface, managed developer handler source, wrappers, catalog, gateway and backend FSM provider;
4. run `node --check` on frontend `fsm-designer.js`;
5. verify the normal top menu still has no `FSM` destination;
6. open the developer EFSM designer and verify existing STATE/TRANSITION selection/binding still works;
7. inspect `git status --short`: exactly 17 paths;
8. only then owner commits/pushes OPUS.

## Next slice

R8B enables GUARD/ACTION Create/Edit in the graphical designer, displays the actual managed PHP source, writes it through the R8A secured pipeline, refreshes the catalog after mutation, and permits transition binding to the newly programmed handler.