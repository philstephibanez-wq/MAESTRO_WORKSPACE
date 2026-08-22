# P117W R45B2A4BZ2R8B — Graphical PHP GUARD/ACTION authoring handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Exact owner-side layering baseline

Apply directly on the current uncommitted OPUS working tree:

- HEAD: `9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`;
- R8A applied;
- R8A1R1 applied;
- exactly 17 R8A paths visible before R8B;
- repaired `FsmGuardHandlers.php` SHA-256: `e7c03e31c351f2d895222057bad57f92e8ba726b120517e55676f463991f69a4`.

Do not push R8A/R8A1R1 before applying R8B.

## Artifact

`opus_p117w_r45b2a4bz2r8b_graphical_php_handler_authoring.zip`

ZIP SHA-256:

`ea3a53f0f52050c7f1378438cc9cdd540f8cc277d5cf8dc1ecb76e76444e6baa`

Applicator SHA-256:

`54fbb06605a478a944d21c5938c1cb19319f33c6e26f0bd77094be669d74b489`

The ZIP contains exactly one differential applicator: `apply_a4bz2r8b.php`.

The assistant does not commit/push OPUS/OWASYS.

## Delivered behavior

R8B activates graphical developer source authoring for real EFSM handlers.

### GUARD

- Create opens a PHP callable source editor with the real guard callback signature.
- Edit loads the exact managed PHP source from the runtime/source catalog.
- `acl:*` dynamic guards remain visible but cannot be edited as developer-owned source.

### ACTION

- Create opens a PHP callable source editor with the real action callback signature.
- Edit loads the exact managed PHP source.

### After mutation

The browser sends the R8A handler-source request through the existing secured front -> REST -> back -> Composer pipeline, validates `OWASYS_EFSM_HANDLER_WRITE_RESULT_V1`, adopts the rotated CSRF token, reloads the actual handler catalog, and exposes the newly programmed handler immediately to transition binding.

No `eval` and no backend JavaScript are introduced.

## Exact R8B file scope

Exactly four files are modified by R8B itself:

- `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`;
- `sites/owasys-front/www/asset/css/fsm-native.css`;
- `sites/owasys-front/www/asset/js/fsm-designer.js`.

Because renderer and JS were already modified by R8A, the total owner working-tree path count becomes exactly 19.

## Applicator preflight

R8B refuses unless it sees the exact expected 17-path R8A working tree and exact R8A1R1 repaired guard SHA. It also verifies the canonical R7R2 template/CSS blobs and exact normalized R8A JavaScript baseline before writing.

## Verification performed before delivery

- final applicator `php -l`: OK;
- final ZIP contains exactly `apply_a4bz2r8b.php`;
- extracted applicator is byte-identical and `php -l`: OK;
- exact post-R8A JavaScript was reconstructed from the R7 embedded source plus the R8A transformations;
- R8B final JavaScript: `node --check` OK;
- exact R7R2 template baseline was reconstructed and its Git blob matched `15c9b056c0663c0f5449c174b6aa7bf1e14143aa`;
- exact R8A JavaScript normalized Git blob matched `71473fd0c598d8e49c45c11d37b31a9a24920e98`;
- transactional Git fixture representing the 17-path R8A stack: application success;
- resulting path count: exactly 19;
- resulting template contains all four GUARD/ACTION author controls and one real source editor;
- resulting JS contains the exact R8A request field names and `OWASYS_EFSM_HANDLER_WRITE_RESULT_V1` response contract;
- static transport parity against the R8A gateway/provider applicator: OK;
- resulting ScorePageRenderer revision/cache-bust markers: OK;
- second application refused with exit code 20 and no further file changes.

The assistant cannot run the owner's live `H:\OPUS` runtime; live boot and end-to-end REST/Composer behavior remain owner acceptance gates.

## Expected applicator markers

`P117W_R45B2A4BZ2R8B_APPLIED`

- `baseline_head=9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`
- `requires=r8a+r8a1r1_uncommitted_worktree`
- `handler_authoring=graphical_real_php_create_update`
- `handler_transport=front_rest_back_composer`
- `handler_catalog=refresh_after_write`
- `dynamic_acl=read_only_reserved_namespace`
- `transition_binding=new_handler_immediately_available`
- `changed_files_total=19`

## Owner validation

After application:

1. lint/validate both sites;
2. restart both OWASYS dev servers;
3. verify `/fr-FR` boots normally before opening designer;
4. verify no normal `FSM` menu destination exists;
5. open the EFSM designer;
6. create one temporary developer GUARD and verify it appears immediately in the transition GUARD catalog;
7. edit that GUARD and verify the exact PHP source is reloaded;
8. create/edit an ACTION similarly;
9. verify dynamic `acl:*` guards are not editable;
10. inspect front/back logs and correlated profiler events for the handler write;
11. verify `git status --short` has exactly 19 paths;
12. only after successful runtime validation may the owner commit/push the whole R8A + R8A1R1 + R8B stack.
