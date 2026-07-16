# OPUS CURRENT STATE

Last updated: 2026-07-16.

## Repository

- Local development repo currently used by the owner: `H:/OPUS`
- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Latest locally validated OPUS commit recorded here: `25ed28df48d97d6c99a1e2990d739fc4e104cc4d`

The local Windows path and UwAmp stack are development details only, not OPUS or OWASYS distribution requirements.

## Active milestone

Finish OWASYS as a portable OPUS deliverable for OPUS users.

Active handoff:

`CONTEXT/HANDOFFS/OWASYS_20260716_DELIVERY_CLOSURE.md`

## OWASYS validated state

Validated locally by the project owner:

- distribution portability contract;
- state-first navigation and runtime FSM;
- local password authentication;
- SQLite runtime registry;
- application inspection;
- structure draft preparation and application;
- application scaffold planning and writing;
- application creation and validation;
- mandatory generated development profiler;
- application export;
- Build pipeline and Build UI;
- secure Source + Git core;
- 25-locale catalog completeness and syntax;
- global OPUS smoke suite.

Latest confirmed markers include:

- `OWASYS_DISTRIBUTION_PORTABILITY_SMOKE_OK`
- `OWASYS_BUILD_PIPELINE_SMOKE_OK`
- `OWASYS_BUILD_UI_SMOKE_OK`
- `OWASYS_SOURCE_GIT_CORE_SMOKE_OK`
- `OWASYS_GENERATED_PROFILER_SMOKE_OK`
- `OWASYS_APPLICATION_CREATOR_SMOKE_OK`
- `OWASYS_APPLICATION_EXPORTER_SMOKE_OK`
- `OPUS_VALIDATE_SITE_OK: owasys`
- `OPUS_SMOKE_ALL_OK`

HTTP smokes still run separately from the global non-server runner:

- `OWASYS_STRUCTURE_DRAFT_APPLY_UI_HTTP_SMOKE_SEPARATE`
- `OWASYS_RUNTIME_FSM_HTTP_SMOKE_SEPARATE`

## OWASYS distribution contract

OWASYS is an OPUS user deliverable.

- Windows and Linux portability on supported OPUS environments;
- no hardcoded dependency on one machine, one local stack, or one server;
- installation root resolved at runtime;
- `OPUS_ENV` defines dev/prod behavior;
- no generated `src`, `public`, or `resources` roots;
- canonical distribution contract: `sites/owasys/config/distribution.json`;
- contract ID: `OWASYS_DISTRIBUTION_V1`.

## Generated application profiler

Every OWASYS-generated application receives the profiler automatically.

- mandatory and not selectable;
- `profiler: false` rejected;
- generated configuration, PHP runtime, CSS and JavaScript required;
- available only for `OPUS_ENV=dev`, `local`, or `development`;
- unavailable in production even with `?profiler=1`;
- OWASYS itself does not boot the generated application profiler.

The current implementation is functional but is not yet complete coverage of all possible collectors.

## Build path

Implemented and smoke-validated:

- `Opus/Owasys/BuildPipeline.php`
- `sites/owasys/www/build-action.php`
- Build UI injected by `sites/owasys/www/asset/js/owasys.js`

Contract: `OWASYS_BUILD_PIPELINE_RESULT_V1`.

Modes:

- `preview`
- `build`
- `build-and-export`

## Source + Git core

Implemented and smoke-validated:

- `Opus/Owasys/RepositoryInspector.php`
- `Opus/Owasys/ApplicationFileEditor.php`

Capabilities:

- read-only Git inspection: repository, branch, HEAD, status, recent history and diff;
- no free-form Git command execution;
- editable application files restricted to `config/`, `application/` and `www/asset/`;
- traversal, absolute paths, `.git`, secrets and auth stores rejected;
- diff preview without mutation;
- SHA-256 optimistic locking;
- PHP and JSON validation;
- atomic replacement.

## Immediate functional gap

The Source + Git core is not yet exposed through the OWASYS UI.

Next steps:

1. add Source route/state/view;
2. show editable file tree for the current application;
3. read, edit and preview diff;
4. save with SHA-256 concurrency protection;
5. show read-only Git status/history/diff;
6. add UI/HTTP smoke coverage;
7. continue removing remaining placeholder-only essential screens;
8. run final functional and visual delivery recipe.

## I18N

Exactly 25 locale catalogs are present: the 24 official EU languages plus Ukrainian.

`bg, hr, cs, da, nl, en, et, fi, fr, de, el, hu, ga, it, lv, lt, mt, pl, pt, ro, sk, sl, es, sv, uk`

Catalog completeness and syntax are smoke-validated. Native professional linguistic review remains pending.

## Locked roadmap

1. Finish OWASYS.
2. Generate the official OPUS demo using OWASYS.
3. Produce the User Book.
4. Produce the Reference Book.
5. Finalize LSTSAR.
6. Return to KB work.

## Retained ODBC / Model / LSTSAR decisions

These decisions remain valid but are not the immediate active workstream.

- OPUS database-facing architecture is ODBC-only.
- `Opus\Model` is the official representation layer for ODBC tables, rows, fields, types, sizes, nullability and metadata.
- final heterogeneous LSTSAR target is Model-driven + ODBC-driven.
- LSTSAR validates source and transformed target independently, including length, byte size, precision and scale constraints.

## Active continuation rule

Before any new OPUS patch, read:

- `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
- `CONTEXT/HANDOFFS/OWASYS_20260716_DELIVERY_CLOSURE.md`
- `CONTEXT/PROJECTS/PROJECT_INDEX.md`
