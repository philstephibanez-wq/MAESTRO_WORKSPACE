# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat.

## Active priority

Finish OWASYS as a portable OPUS deliverable for OPUS users.

Immediate path:

1. execute the final browser-based functional and visual acceptance;
2. verify login, application selection, Source & Git editing, preview, guarded save, staging and commit;
3. confirm Build preview/build/export visually;
4. remove any remaining essential placeholder discovered during acceptance;
5. declare OWASYS closed only after that visual recipe is green.

## Source of truth

- OPUS repository: `philstephibanez-wq/OPUS`
- OPUS branch: `master`
- Latest locally validated OPUS commit: `5104168da5a845ce80baaf5a9ec1ab57a67bb449`
- Workspace repository: `philstephibanez-wq/MAESTRO_WORKSPACE`
- Owner development root: `H:/OPUS` only as a local detail

## Validated OWASYS state

Locally green:

- portable Windows/Linux distribution contract;
- Build preview, generation, validation and ZIP export;
- Source route/state and authenticated endpoint;
- visual file tree and source editor;
- diff preview before mutation;
- SHA-256 optimistic locking;
- PHP and JSON validation;
- atomic file replacement;
- Git repository status, branch, HEAD, history and diff;
- application-scoped Git staging and commit;
- mandatory generated profiler in development and unavailable in production;
- 25 locale catalogs;
- global suite ending with `OPUS_SMOKE_ALL_OK`;
- `OWASYS_SOURCE_HTTP_SMOKE_OK`;
- `OWASYS_STRUCTURE_DRAFT_APPLY_UI_HTTP_SMOKE_OK`;
- `OWASYS_RUNTIME_FSM_HTTP_SMOKE_OK`.

All known automated technical and HTTP recipes are green. The remaining gate is real browser acceptance.

## Source & Git security contract

- no arbitrary Git command;
- no pull, push, reset or branch mutation at this stage;
- stage and commit only the selected application subtree;
- commit message required, single-line and bounded;
- editor limited to `config/`, `application/` and `www/asset/`;
- absolute paths, traversal, `.git`, secrets and authentication stores rejected;
- preview before mutation;
- atomic write and concurrency protection.

## Product contract

OWASYS is a portable user-facing OPUS deliverable for supported Windows and Linux environments. It must not depend on `H:/OPUS`, UwAmp, one PC or one server. Dev/prod behavior is driven by `OPUS_ENV`.

## Locked roadmap

1. Finish OWASYS.
2. Generate the official demo through OWASYS.
3. Produce the User Book.
4. Produce the Reference Book.
5. Finalize LSTSAR.
6. Return to KB.

## Permanent rules

NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
REUSE EXISTING OPUS BRICKS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

OPUS is a sub-project inside MAESTRO_WORKSPACE. OPUS is not the workspace.
