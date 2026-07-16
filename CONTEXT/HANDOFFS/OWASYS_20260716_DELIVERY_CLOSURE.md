# OWASYS DELIVERY CLOSURE HANDOFF

Last updated: 2026-07-16.

## Source of truth

- OPUS: `philstephibanez-wq/OPUS`, branch `master`
- Latest locally validated OPUS commit: `cb2971f6abe3221a91a327fadbbd74366f641a3a`
- Workspace: `philstephibanez-wq/MAESTRO_WORKSPACE`
- `H:/OPUS` is a local development detail only

## Binding product contract

OWASYS is a portable OPUS deliverable for OPUS users on supported Windows and Linux environments.

- runtime installation root resolution;
- no dependency on UwAmp, one PC or one server;
- dev/prod driven by `OPUS_ENV`;
- state-first OPUS architecture;
- no generated `src`, `public` or `resources` roots.

## Validated Build path

- `BuildPipeline` modes: `preview`, `build`, `build-and-export`;
- authenticated Build endpoint and visual UI;
- application validation and ZIP export;
- mandatory generated profiler, development only, unavailable in production.

## Validated Source & Git path

Implemented and locally green:

- Source route/state/view;
- authenticated `source-action.php` endpoint;
- editable file tree;
- secure read and visual editing;
- diff preview required before save;
- SHA-256 optimistic lock;
- PHP and JSON validation;
- atomic replacement;
- repository status, branch, HEAD, history and diff;
- application-scoped staging and commit;
- visual stage/commit controls with confirmation.

Security boundaries:

- editable roots: `config/`, `application/`, `www/asset/`;
- traversal, absolute paths, `.git`, secrets and authentication stores rejected;
- no free-form Git command;
- no pull, push, reset or branch mutation;
- commit message required, one line, maximum 200 characters;
- staging and commit restricted to the selected application subtree.

Validated markers include:

- `OWASYS_SOURCE_GIT_CORE_SMOKE_OK`
- `OWASYS_SOURCE_UI_SMOKE_OK`
- `OWASYS_SOURCE_EDITOR_UI_SMOKE_OK`
- `OWASYS_REPOSITORY_OPERATOR_SMOKE_OK`
- `OWASYS_SOURCE_GIT_WRITE_UI_SMOKE_OK`
- `OPUS_VALIDATE_SITE_OK: owasys`
- `OPUS_SMOKE_ALL_OK`

## Current exact gap

Complete HTTP/runtime coverage for Source & Git behind a real authenticated session. HTTP server smokes remain separate from the non-server global runner.

Do not expand Git capabilities before HTTP/runtime closure and final visual acceptance.

## Locked roadmap

1. Finish OWASYS.
2. Generate the official OPUS demo through OWASYS.
3. Produce the User Book.
4. Produce the Reference Book.
5. Finalize LSTSAR.
6. Return to KB.

## Retained LSTSAR contract

LSTSAR means Load / Secure / Transform / Store / Audit / Restore. It remains Model-driven + ODBC-driven and validates source and transformed target independently, including length, byte-size, precision and scale constraints.

## I18N

Exactly 25 catalogs are present: `bg, hr, cs, da, nl, en, et, fi, fr, de, el, hu, ga, it, lv, lt, mt, pl, pt, ro, sk, sl, es, sv, uk`.

Catalog completeness and PHP syntax are validated; professional native linguistic review remains pending.

## Recovery commands

```cmd
cd /d H:\OPUS
git pull
php tools\smoke_owasys_source_editor_ui.php
php tools\smoke_owasys_source_git_write_ui.php
php tools\smoke_all_opus.php
```

## Permanent rules

- NO CONTRACT, NO PATCH.
- NO SOURCE OF TRUTH, NO PATCH.
- NO BRICOLAGE DELIVERY.
- NO FALLBACK SILENCIEUX.
- REUSE EXISTING OPUS BRICKS.
- WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
- SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.