# OPUS CURRENT STATE

Last updated: 2026-07-16.

## Repository

- Local development repo currently used by the owner: `H:/OPUS`
- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Latest validated OPUS commit recorded here: `4082f3c3ff57c57b560c371b2b01ff1b728cffc2`

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
- build pipeline;
- 25-locale catalog completeness and syntax;
- global OPUS smoke suite.

Latest confirmed markers include:

- `OWASYS_DISTRIBUTION_PORTABILITY_SMOKE_OK`
- `OWASYS_BUILD_PIPELINE_SMOKE_OK`
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
- generated configuration, PHP runtime, CSS and JavaScript are required;
- available only for `OPUS_ENV=dev`, `local`, or `development`;
- unavailable in production even with `?profiler=1`;
- OWASYS itself does not boot the generated application profiler.

The current implementation is functional but should not yet be described as complete coverage of all possible collectors.

## Build pipeline

`Opus/Owasys/BuildPipeline.php` is smoke-validated.

Contract: `OWASYS_BUILD_PIPELINE_RESULT_V1`.

Supported modes:

- `preview`
- `build`
- `build-and-export`

It reuses `ApplicationCreator` and `ApplicationExporter`.

## Immediate functional gap

The OWASYS Build screen is still mostly descriptive and must be wired to the validated pipeline.

Next steps:

1. connect Build UI actions to preview/build/validate/export;
2. complete create -> preview -> generate -> validate -> export from OWASYS;
3. finish UI/HTTP smoke coverage for that path;
4. remove placeholder-only behavior from essential screens;
5. run final functional and visual delivery recipe.

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
- `Opus\\Model` is the official representation layer for ODBC tables, rows, fields, types, sizes, nullability and metadata.
- final heterogeneous LSTSAR target is Model-driven + ODBC-driven.
- LSTSAR validates source and transformed target independently, including length, byte size, precision and scale constraints.

## Active continuation rule

Before any new OPUS patch, read:

- `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
- `CONTEXT/HANDOFFS/OWASYS_20260716_DELIVERY_CLOSURE.md`
- `CONTEXT/PROJECTS/PROJECT_INDEX.md`
