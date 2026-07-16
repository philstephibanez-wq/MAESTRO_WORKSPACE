# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart without relying on hidden conversation memory.

## Active handoff

Read first:

`CONTEXT/HANDOFFS/OWASYS_20260716_DELIVERY_CLOSURE.md`

## Active priority

Finish OWASYS as a portable OPUS deliverable for OPUS users.

Immediate path:

1. wire the OWASYS Build screen to the validated `BuildPipeline`;
2. complete create -> preview -> generate -> validate -> export from the UI;
3. add/finish UI and HTTP smoke coverage;
4. remove placeholder-only behavior from essential screens;
5. run final functional and visual delivery recipe.

Do not divert into new peripheral framework work before OWASYS closure.

## Current source of truth

- OPUS code and OPUS-owned sites: `philstephibanez-wq/OPUS`
- OPUS branch: `master`
- Latest validated OPUS commit recorded here: `4082f3c3ff57c57b560c371b2b01ff1b728cffc2`
- Workspace context: `philstephibanez-wq/MAESTRO_WORKSPACE`

Current local development root used by the owner: `H:/OPUS`. This is not a distribution requirement.

## OWASYS product contract

OWASYS is a user-facing OPUS deliverable, portable across supported Windows and Linux environments.

- no hard dependency on `H:/OPUS`, UwAmp, one HP computer, or one Linux server;
- runtime installation root resolution;
- dev/prod determined by `OPUS_ENV`, not by machine identity;
- state-first OPUS architecture;
- no generated `src`, `public`, or `resources` roots.

Distribution contract: `sites/owasys/config/distribution.json` (`OWASYS_DISTRIBUTION_V1`).

## Generated profiler contract

The profiler is mandatory in every OWASYS-generated application and is unavailable in production.

- generated automatically;
- not selectable;
- `profiler: false` rejected;
- active only for `OPUS_ENV=dev`, `local`, or `development`;
- production stays disabled even with `?profiler=1`;
- OWASYS itself does not boot this generated profiler.

## Latest validation state

Validated locally by the owner after pulling OPUS commit `4082f3c`:

- `OWASYS_DISTRIBUTION_PORTABILITY_SMOKE_OK`
- `OWASYS_BUILD_PIPELINE_SMOKE_OK`
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
