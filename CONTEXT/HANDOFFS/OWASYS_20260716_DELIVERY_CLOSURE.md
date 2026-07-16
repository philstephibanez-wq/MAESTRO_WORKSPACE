# OWASYS DELIVERY CLOSURE HANDOFF

Last updated: 2026-07-16.

## Purpose

Canonical recovery card for finishing OWASYS as a portable OPUS deliverable for OPUS users.

## Source of truth

- OPUS repository: `philstephibanez-wq/OPUS`
- Branch: `master`
- Latest locally validated OPUS commit: `1c948b186e975d0319237849cc6ea730c9dede3f`
- Local owner development root: `H:/OPUS` only as a development detail
- Workspace repository: `philstephibanez-wq/MAESTRO_WORKSPACE`

## Binding product contract

OWASYS is delivered to OPUS users and is portable across supported Windows and Linux environments.

- no dependency on one machine, UwAmp, `H:/OPUS` or one server;
- installation root resolved at runtime;
- dev/prod driven by `OPUS_ENV`;
- OPUS state-first architecture;
- no generated `src`, `public` or `resources` roots.

Distribution contract: `sites/owasys/config/distribution.json`, `OWASYS_DISTRIBUTION_V1`.

## Generated profiler

Every generated application receives the profiler automatically. It is mandatory, not selectable, active only in dev/local/development and unavailable in production, including with `?profiler=1`. Do not overclaim complete collector coverage.

## Build path

Implemented and validated:

- `Opus/Owasys/BuildPipeline.php`;
- `sites/owasys/www/build-action.php`;
- Build UI;
- modes `preview`, `build`, `build-and-export`;
- validated generation and ZIP export.

## Source & Git path

Implemented and validated:

- state-first route `/source`;
- authenticated `source-action.php`;
- `RepositoryInspector` for read-only status, branch, HEAD, history and diff;
- `ApplicationFileEditor` for file tree, secure read, preview, PHP/JSON validation, SHA-256 locking and atomic write;
- visual Source editor with required diff preview and explicit save confirmation;
- `RepositoryOperator` for application-scoped staging and commit.

### Security boundary

- no arbitrary Git command;
- no pull, push, reset or branch mutation;
- Git staging and commit restricted to the selected application subtree;
- commit message required, single line, maximum 200 characters;
- editor restricted to `config/`, `application/` and `www/asset/`;
- absolute paths, traversal, `.git`, secrets and authentication stores rejected;
- preview does not mutate disk;
- writes are atomic and concurrency-protected.

## Latest validation state

The owner locally validated commit `1c948b1` successfully.

Confirmed markers include:

- `OWASYS_DISTRIBUTION_PORTABILITY_SMOKE_OK`
- `OWASYS_BUILD_PIPELINE_SMOKE_OK`
- `OWASYS_BUILD_UI_SMOKE_OK`
- `OWASYS_SOURCE_GIT_CORE_SMOKE_OK`
- `OWASYS_SOURCE_UI_SMOKE_OK`
- `OWASYS_SOURCE_EDITOR_UI_SMOKE_OK`
- `OWASYS_REPOSITORY_OPERATOR_SMOKE_OK`
- `OWASYS_GENERATED_PROFILER_SMOKE_OK`
- `OPUS_VALIDATE_SITE_OK: owasys`
- `OPUS_SMOKE_ALL_OK`

Separate HTTP smokes:

- `OWASYS_STRUCTURE_DRAFT_APPLY_UI_HTTP_SMOKE_SEPARATE`
- `OWASYS_RUNTIME_FSM_HTTP_SMOKE_SEPARATE`

## Immediate next work

1. add visual controls for application-scoped stage and commit;
2. display staged files and commit result;
3. retain confirmation and security boundaries;
4. add dedicated UI smoke and global integration;
5. continue final OWASYS closure and visual recipe.

## Locked roadmap

1. Finish OWASYS.
2. Generate the official OPUS demo through OWASYS.
3. Produce the User Book.
4. Produce the Reference Book.
5. Finalize LSTSAR.
6. Return to KB.

## Retained LSTSAR contract

Load / Secure / Transform / Store / Audit / Restore. Source and transformed target are validated independently, including type, length, byte size, precision and scale. Final heterogeneous target remains Model-driven + ODBC-driven.

## I18N

Exactly 25 catalogs: 24 official EU languages plus Ukrainian. Completeness and syntax are validated; professional native linguistic review remains pending.

## Recovery commands

```cmd
cd /d H:\OPUS
git pull
php tools\smoke_owasys_repository_operator.php
php tools\smoke_all_opus.php
```

## Permanent delivery rules

- NO CONTRACT, NO PATCH.
- NO SOURCE OF TRUTH, NO PATCH.
- NO BRICOLAGE DELIVERY.
- NO FALLBACK SILENCIEUX.
- REUSE EXISTING OPUS BRICKS.
- WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
- SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.
- Copy/paste command blocks contain executable commands only.
