# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat.

## Active handoff

Read first: `CONTEXT/HANDOFFS/OWASYS_20260716_DELIVERY_CLOSURE.md`.

## Active priority

Finish OWASYS as a portable OPUS deliverable for OPUS users.

Immediate path:

1. expose secure Git stage/commit actions in the Source & Git screen;
2. keep Git scope limited to the selected application;
3. do not add free-form commands, pull, push, reset or branch mutation yet;
4. finish UI/HTTP coverage and remove remaining essential placeholders;
5. run the final functional and visual delivery recipe.

## Source of truth

- OPUS repository: `philstephibanez-wq/OPUS`
- OPUS branch: `master`
- Latest locally validated OPUS commit: `1c948b186e975d0319237849cc6ea730c9dede3f`
- Workspace repository: `philstephibanez-wq/MAESTRO_WORKSPACE`
- Owner development root: `H:/OPUS` only as a local detail

## Validated OWASYS state

The following paths are implemented and locally green:

- portable distribution contract;
- Build preview, generation, validation and ZIP export;
- Source state, authenticated endpoint and visual editor;
- editable file tree, secure read, diff preview and atomic save;
- SHA-256 optimistic locking;
- PHP and JSON validation;
- Git repository status, branch, HEAD, history and diff;
- application-scoped Git staging and commit through `RepositoryOperator`;
- mandatory generated profiler in development and unavailable in production;
- 25 locale catalogs;
- global suite ending with `OPUS_SMOKE_ALL_OK`.

Validated markers include:

- `OWASYS_BUILD_UI_SMOKE_OK`
- `OWASYS_SOURCE_GIT_CORE_SMOKE_OK`
- `OWASYS_SOURCE_UI_SMOKE_OK`
- `OWASYS_SOURCE_EDITOR_UI_SMOKE_OK`
- `OWASYS_REPOSITORY_OPERATOR_SMOKE_OK`
- `OPUS_VALIDATE_SITE_OK: owasys`
- `OPUS_SMOKE_ALL_OK`

Separate HTTP smokes remain listed by the runner:

- `OWASYS_STRUCTURE_DRAFT_APPLY_UI_HTTP_SMOKE_SEPARATE`
- `OWASYS_RUNTIME_FSM_HTTP_SMOKE_SEPARATE`

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
