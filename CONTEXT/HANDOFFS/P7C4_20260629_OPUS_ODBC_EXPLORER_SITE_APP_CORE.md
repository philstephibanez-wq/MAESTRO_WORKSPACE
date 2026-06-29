# P7C4 — 2026-06-29 — OPUS ODBC Explorer site app core

## Status

Validated in OPUS and pushed.

## OPUS references

- Repository: `philstephibanez-wq/OPUS`
- Latest OPUS commit: `7c8b609`
- Functional site app commit: `ce1c4ee`
- Tag: `OPUS_P7_ODBC_EXPLORER_SITE_APP_CORE`

## Validated scope

`P7_ODBC_EXPLORER_SITE_APP_CORE` turns `packages/opus-odbc-manager` into a real Composer-installable OPUS application package.

Validated package content:

- routes;
- controllers;
- ScoreTemplate views;
- I18N FR/EN;
- ACL config;
- navigation config;
- profiler config;
- readonly view-models;
- diagnostics/profiler instrumentation;
- dashboard, datasources, tables, table detail, preview, LSTSAR draft pages;
- no CRUD/DDL routes yet.

## Validation evidence

Observed smokes:

- `P7_ODBC_EXPLORER_SITE_APP_CORE_SMOKE_OK`
- `P7_ODBC_EXPLORER_READONLY_CORE_SMOKE_OK`
- `P7_ODBC_EXPLORER_CONTRACT_CORE_SMOKE_OK`
- `P7_MODEL_DATASOURCE_ODBC_CORE_SMOKE_OK`
- `P7_OPUS_PACKAGES_DIRECTORY_CONTRACT_CORE_SMOKE_OK`

Final OPUS local status:

```text
## master...origin/master
```

## Important user directive

Before starting LSTSAR again, explicitly stop and tell the user after ODBC CRUD + Model work is finished.

Do not silently move from ODBC CRUD/Model into LSTSAR.

## Next milestones

1. `P7_ODBC_EXPLORER_CRUD_CONTRACT_CORE`
2. `P7_ODBC_EXPLORER_CRUD_CORE`
3. `P7_ODBC_EXPLORER_CRUD_UI_CORE`
4. `P7_ODBC_MODEL_REFINEMENT_CORE`

Then pause before `P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE`.
