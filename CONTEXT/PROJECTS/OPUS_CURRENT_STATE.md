# OPUS CURRENT STATE

Last updated: 2026-07-16.

## Repository

- Local owner repo: `H:/OPUS`
- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Latest locally validated commit: `1c948b186e975d0319237849cc6ea730c9dede3f`

The owner Windows path and UwAmp stack are development details only.

## Active milestone

Finish OWASYS as a portable OPUS deliverable for OPUS users.

## Validated OWASYS state

- portable distribution contract;
- navigation FSM and runtime context;
- registry and application inspection;
- structure drafts;
- application creation, validation and export;
- Build pipeline and UI;
- Source state and authenticated endpoint;
- visual application file editor;
- Git inspection;
- application-scoped Git staging and commit;
- mandatory generated dev profiler;
- 25 locale catalogs;
- global suite green.

Latest markers:

- `OWASYS_BUILD_UI_SMOKE_OK`
- `OWASYS_SOURCE_GIT_CORE_SMOKE_OK`
- `OWASYS_SOURCE_UI_SMOKE_OK`
- `OWASYS_SOURCE_EDITOR_UI_SMOKE_OK`
- `OWASYS_REPOSITORY_OPERATOR_SMOKE_OK`
- `OPUS_VALIDATE_SITE_OK: owasys`
- `OPUS_SMOKE_ALL_OK`

## Source & Git contracts

Implemented services:

- `Opus/Owasys/RepositoryInspector.php`
- `Opus/Owasys/ApplicationFileEditor.php`
- `Opus/Owasys/RepositoryOperator.php`

Security:

- no arbitrary commands;
- no pull, push, reset or branch mutation;
- stage and commit only the selected application subtree;
- bounded single-line commit message;
- editable files restricted to `config/`, `application/`, `www/asset/`;
- traversal, absolute paths, `.git`, secrets and auth stores rejected;
- preview, PHP/JSON validation, SHA-256 lock and atomic replacement.

## Immediate continuation

1. add visual Stage and Commit controls to Source & Git;
2. display staged files and commit result;
3. add dedicated UI smoke and global integration;
4. finish HTTP/visual closure recipe.

## Distribution and profiler

OWASYS is portable on supported Windows/Linux OPUS environments. `OPUS_ENV` controls dev/prod. The generated profiler is mandatory, automatic and unavailable in production.

## I18N

Exactly 25 locale catalogs: the 24 official EU languages plus Ukrainian. Completeness and syntax are validated; native professional linguistic review remains pending.

## Locked roadmap

1. Finish OWASYS.
2. Generate official demo.
3. User Book.
4. Reference Book.
5. LSTSAR.
6. KB.

## Retained architecture

- OPUS database access is ODBC-only.
- `Opus\Model` is the official representation layer.
- LSTSAR final target is Model-driven + ODBC-driven with independent source/target validation.
