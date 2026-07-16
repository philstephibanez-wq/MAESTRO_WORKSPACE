# OPUS CURRENT STATE

Last updated: 2026-07-16.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Latest locally validated commit: `cb2971f6abe3221a91a327fadbbd74366f641a3a`
- Owner local development repo: `H:/OPUS` only as a local detail

## Active milestone

Finish OWASYS as a portable OPUS deliverable for OPUS users.

## Validated OWASYS state

Locally validated:

- portable Windows/Linux distribution contract;
- state-first navigation and runtime FSM;
- local password authentication and SQLite registry;
- structure inspection and draft workflows;
- application creation, validation and export;
- Build pipeline and Build UI;
- mandatory generated development profiler, unavailable in production;
- Source route/state and authenticated endpoint;
- visual source editor with file tree;
- diff preview, SHA-256 lock, PHP/JSON validation and atomic save;
- Git inspection, diff, history, application-scoped staging and commit;
- Source Git visual controls;
- 25 locale catalogs;
- global suite ending with `OPUS_SMOKE_ALL_OK`.

Latest confirmed markers include:

- `OWASYS_SOURCE_EDITOR_UI_SMOKE_OK`
- `OWASYS_REPOSITORY_OPERATOR_SMOKE_OK`
- `OWASYS_SOURCE_GIT_WRITE_UI_SMOKE_OK`
- `OPUS_VALIDATE_SITE_OK: owasys`
- `OPUS_SMOKE_ALL_OK`

## Source & Git security contract

- editor roots limited to `config/`, `application/`, `www/asset/`;
- traversal, absolute paths, `.git`, secrets and auth stores rejected;
- preview before mutation;
- optimistic SHA-256 concurrency protection;
- PHP and JSON validation;
- atomic replacement;
- staging and commit restricted to the selected application subtree;
- commit message single-line and bounded;
- no arbitrary command, pull, push, reset or branch mutation.

## Current functional gap

Add real HTTP/runtime smoke coverage for Source & Git behind an authenticated session, then complete final functional and visual acceptance. HTTP server smokes remain separate from the global non-server runner.

## Locked roadmap

1. Finish OWASYS.
2. Generate the official OPUS demo using OWASYS.
3. Produce the User Book.
4. Produce the Reference Book.
5. Finalize LSTSAR.
6. Return to KB.

## Retained architecture decisions

- OPUS database-facing architecture is ODBC-only.
- `Opus\Model` is the official ODBC representation layer.
- final LSTSAR target is Model-driven + ODBC-driven.
- LSTSAR validates source and transformed target independently.