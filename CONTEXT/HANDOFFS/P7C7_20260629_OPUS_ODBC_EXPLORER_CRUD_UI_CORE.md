# P7C7 — 2026-06-29 — OPUS ODBC Explorer CRUD UI core

## Status

Validated in OPUS, pushed and retagged correctly.

## OPUS references

- Repository: `philstephibanez-wq/OPUS`
- Latest OPUS commit: `b9f47d9`
- Functional CRUD UI commit: `d553994`
- Tag: `OPUS_P7_ODBC_EXPLORER_CRUD_UI_CORE`

## Important note

The tag was initially created too early on `baeadac`, which only updated `DOC/WORKSPACE_STATUS.md`.

The user then committed the actual CRUD UI files in `d553994`, fixed workspace status in `b9f47d9`, force-moved the tag, and pushed the corrected tag.

Current correct state:

```text
b9f47d9 (HEAD -> master, tag: OPUS_P7_ODBC_EXPLORER_CRUD_UI_CORE, origin/master, origin/HEAD) Fix workspace status for P7 ODBC Explorer CRUD UI core
d553994 P7 add ODBC Explorer CRUD UI core
baeadac Update workspace status for P7 ODBC Explorer CRUD UI core
cb9d3b7 (tag: OPUS_P7_ODBC_EXPLORER_CRUD_CORE) Update workspace status for P7 ODBC Explorer CRUD core
b66d2d4 P7 add ODBC Explorer CRUD core
```

## Validated scope

`P7_ODBC_EXPLORER_CRUD_UI_CORE` adds guarded CRUD UI surfaces to the Composer-installable OPUS ODBC Manager package.

Validated package changes:

- `CrudController`
- `OdbcManagerCrudViewModelFactory`
- CRUD routes for overview/forms/dry-run
- `crud.score`
- `crud-form.score`
- `crud-dry-run.score`
- ACL CRUD permissions
- navigation CRUD entry
- I18N CRUD keys
- profiler actions for CRUD UI
- smoke updates for site app now allowing CRUD routes but still forbidding DDL/SQL console routes

## Validation evidence

Observed smokes:

- `P7_ODBC_EXPLORER_CRUD_UI_CORE_SMOKE_OK`
- `P7_ODBC_EXPLORER_CRUD_CORE_SMOKE_OK`
- `P7_ODBC_EXPLORER_CRUD_CONTRACT_CORE_SMOKE_OK`
- `P7_ODBC_EXPLORER_SITE_APP_CORE_SMOKE_OK`
- `P7_ODBC_EXPLORER_READONLY_CORE_SMOKE_OK`
- `P7_MODEL_DATASOURCE_ODBC_CORE_SMOKE_OK`

Final OPUS local status:

```text
## master...origin/master
```

## Remaining before LSTSAR

Next milestone is `P7_ODBC_MODEL_REFINEMENT_CORE`.

After ODBC Model refinement, explicitly stop and tell the user before starting `P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE`.

Do not silently move from ODBC CRUD/Model into LSTSAR.
