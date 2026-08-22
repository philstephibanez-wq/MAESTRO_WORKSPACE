# P117W R45B2A4BZ2R8B2 — Actual graphical PHP GUARD/ACTION authoring handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Exact baseline

OPUS HEAD/master:

`707b1acce1c05dda9751b4b04979b68dc5b2f1f0`

Message:

`opus_p117w_r45b2a4bz2r8b1_actual_r8b_boot_repair`

The owner has pushed R8B1 and supplied a normal rendered OWASYS applications page after the boot repair.

## Artifact

`opus_p117w_r45b2a4bz2r8b2_actual_graphical_handler_authoring.zip`

ZIP SHA-256:

`3160068c579429a54e60f2b83e3be2b55c9b6f16780b9e74ded49e26e9e228f9`

Applicator SHA-256:

`02e0c6ab8d63175b1dba54e195618957e48718bdc5920f313beedc8fd9ae51fe`

Contents:

- `apply_a4bz2r8b2.php`

The assistant does not commit/push OPUS or OWASYS.

## Why this slice exists

The actual R8B commit landed the handler source infrastructure but did not land the graphical authoring UI described by the earlier R8B handoff.

The current template still has disabled GUARD/ACTION authoring buttons, the current JavaScript has no source-editor workflow, and the current CSS has no source-editor surface. R8B also accidentally added three zero-byte root files named `certutil`, `findstr`, and `git`.

R8B2 treats those actual landing defects.

## R8B2 changes

Modified:

- `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`;
- `sites/owasys-front/www/asset/css/fsm-native.css`;
- `sites/owasys-front/www/asset/js/fsm-designer.js`.

Deleted:

- `certutil`;
- `findstr`;
- `git`.

Total changed paths: 7.

## Runtime semantics

GUARD/ACTION Create/Edit use the already-landed R8A/R8B source authority.

Managed catalog fields retained by the browser now include `managed`, `code`, `handler_sha256`, and `source_sha256`.

Create uses real PHP callable skeletons matching the current runtime signatures. Update only exposes managed source handlers. Dynamic ACL guards remain non-editable.

Mutation request fields are exactly the already-landed gateway contract:

- `owasys_fsm_designer_handler=1`;
- `csrf_token`;
- `handler_kind`;
- `handler_id`;
- `handler_mode`;
- `handler_code`.

The browser requires `OWASYS_EFSM_HANDLER_WRITE_RESULT_V1`, adopts the rotated CSRF token, reloads the real catalog and makes the newly programmed handler available to transition binding.

## Safety/preflight

Applicator is bound to exact HEAD `707b1acc...` and a clean working tree.

It checks the audited Git blobs for renderer/template/CSS/JS, the committed R8B1 guard repair, and all three zero-byte accidental files before making any change.

Transformations are staged before writes and write/delete failure restores original bytes.

## Verification performed before delivery

- final applicator `php -l`: OK;
- ZIP contains exactly the applicator;
- deterministic clean Git fixture exercised the complete applicator transaction;
- resulting fixture changed exactly seven paths: four modified plus three deleted;
- transformed JavaScript passed `node --check`;
- transformed renderer passed `php -l`;
- expected handler-write contract/request field markers were verified in the transformed JavaScript;
- delete scope was verified to be exactly `certutil`, `findstr`, `git`.

The connector-only private OPUS checkout is not materialized in the assistant container, so live SCORE rendering and the real front -> REST -> back -> Composer execution remain owner acceptance gates. The applicator itself verifies the exact audited Git blobs before applying to the owner checkout.

## Expected applicator markers

`P117W_R45B2A4BZ2R8B2_APPLIED`

- `baseline_head=707b1acce1c05dda9751b4b04979b68dc5b2f1f0`
- `handler_authoring=graphical_real_php_create_update`
- `handler_transport=front_rest_back_composer`
- `handler_catalog=managed_code_preserved_and_refreshed`
- `dynamic_acl=read_only_reserved_namespace`
- `transition_binding=new_handler_immediately_available`
- `repository_hygiene=certutil_findstr_git_removed`
- `changed_paths=7`

## Owner validation order

1. apply R8B2;
2. lint renderer and JavaScript;
3. regenerate optimized Composer autoload;
4. validate both sites;
5. inspect `git status --short` for exactly seven paths;
6. restart front/back;
7. verify normal applications page;
8. open Conception;
9. create/edit a temporary GUARD and ACTION;
10. verify immediate transition binding and correlated logs/profiler;
11. only then commit/push.