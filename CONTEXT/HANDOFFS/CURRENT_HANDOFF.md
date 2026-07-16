# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart without relying on hidden conversation memory.

## Active handoff

Read first:

`CONTEXT/HANDOFFS/OWASYS_20260716_DELIVERY_CLOSURE.md`

## Active priority

Finish OWASYS as a portable OPUS deliverable for OPUS users.

Immediate path:

1. expose the validated Source + Git core through an OWASYS Source screen;
2. provide file tree, secure read, edit, diff preview and controlled save;
3. show Git repository state, branch, HEAD, changes and recent history in read-only mode;
4. complete UI and HTTP smoke coverage;
5. remove remaining placeholder-only behavior from essential screens;
6. run final functional and visual delivery recipe.

Do not divert into peripheral framework work before OWASYS closure.

## Current source of truth

- OPUS code and OPUS-owned sites: `philstephibanez-wq/OPUS`
- OPUS branch: `master`
- Latest locally validated OPUS commit recorded here: `25ed28df48d97d6c99a1e2990d739fc4e104cc4d`
- Workspace context: `philstephibanez-wq/MAESTRO_WORKSPACE`

Current local development root used by the owner: `H:/OPUS`. This is not a distribution requirement.

## OWASYS product contract

OWASYS is a user-facing OPUS deliverable, portable across supported Windows and Linux environments.

- no hard dependency on `H:/OPUS`, UwAmp, one HP computer, or one Linux server;
- runtime installation root resolution;
- dev/prod determined by `OPUS_ENV`, not machine identity;
- state-first OPUS architecture;
- no generated `src`, `public`, or `resources` roots.

Distribution contract: `sites/owasys/config/distribution.json` (`OWASYS_DISTRIBUTION_V1`).

## Build path state

The OWASYS Build screen is now wired to the validated `BuildPipeline`.

Available modes:

- `preview`
- `build`
- `build-and-export`

Validated markers include:

- `OWASYS_BUILD_PIPELINE_SMOKE_OK`
- `OWASYS_BUILD_UI_SMOKE_OK`

## Source + Git core state

Validated services:

- `Opus/Owasys/RepositoryInspector.php`
- `Opus/Owasys/ApplicationFileEditor.php`

Current contract:

- Git inspection is read-only;
- no free-form Git command execution;
- branch, HEAD, clean/dirty state, recent history and diff are available;
- editable scope is restricted to `config/`, `application/` and `www/asset/` inside the selected application;
- absolute paths, traversal, `.git`, secrets and authentication stores are rejected;
- preview does not mutate disk;
- SHA-256 optimistic locking prevents stale overwrites;
- PHP and JSON are validated before atomic replacement.

Validated marker:

- `OWASYS_SOURCE_GIT_CORE_SMOKE_OK`

The Source UI is not yet wired. This is the next exact implementation step.

## Generated profiler contract

The profiler is mandatory in every OWASYS-generated application and unavailable in production.

- generated automatically;
- not selectable;
- `profiler: false` rejected;
- active only for `OPUS_ENV=dev`, `local`, or `development`;
- production stays disabled even with `?profiler=1`;
- OWASYS itself does not boot this generated profiler.

## Latest validation state

Locally validated by the owner after pulling OPUS commit `25ed28d`:

- `OWASYS_DISTRIBUTION_PORTABILITY_SMOKE_OK`
- `OWASYS_BUILD_PIPELINE_SMOKE_OK`
- `OWASYS_BUILD_UI_SMOKE_OK`
- `OWASYS_SOURCE_GIT_CORE_SMOKE_OK`
- `OWASYS_GENERATED_PROFILER_SMOKE_OK`
- `OWASYS_APPLICATION_CREATOR_SMOKE_OK`
- `OWASYS_APPLICATION_EXPORTER_SMOKE_OK`
- `OPUS_VALIDATE_SITE_OK: owasys`
- `OPUS_SMOKE_ALL_OK`

Separate HTTP smokes remain listed by the runner:

- `OWASYS_STRUCTURE_DRAFT_APPLY_UI_HTTP_SMOKE_SEPARATE`
- `OWASYS_RUNTIME_FSM_HTTP_SMOKE_SEPARATE`

## Locked roadmap

1. Finish OWASYS.
2. Generate the official demo through OWASYS.
3. Produce the User Book.
4. Produce the Reference Book.
5. Finalize LSTSAR.
6. Return to KB.

ODBC/Model/LSTSAR decisions remain valid but are not the immediate workstream.

## Permanent rules

NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
REUSE EXISTING OPUS BRICKS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
ASAP BEHAVIOR MUST BE EVOLVED, NOT DEGRADED.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

OPUS is a sub-project inside MAESTRO_WORKSPACE. OPUS is not the workspace.

## Read order

1. `README.md`
2. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
3. `CONTEXT/HANDOFFS/OWASYS_20260716_DELIVERY_CLOSURE.md`
4. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
5. `CONTEXT/PROJECTS/PROJECT_INDEX.md`
6. ODBC/LSTSAR decisions only when that later workstream resumes.
