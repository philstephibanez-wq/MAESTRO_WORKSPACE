# P7C3 — 2026-06-29 — OPUS ODBC Explorer readonly core

## Status

Validated in OPUS and pushed.

## OPUS references

- Repository: `philstephibanez-wq/OPUS`
- Latest OPUS commit: `d40300d`
- Functional readonly commit: `5b8e04b`
- Tag: `OPUS_P7_ODBC_EXPLORER_READONLY_CORE`

## Validated scope

`P7_ODBC_EXPLORER_READONLY_CORE` adds the safe ODBC Explorer foundation before CRUD and DDL.

Validated capabilities:

- datasource overview;
- readonly mode marker;
- table/view inventory;
- qualified table references;
- table type tracking;
- table inspection;
- column inspection;
- TableModel generation;
- preview limit enforcement;
- preview rows through ModelRecord-oriented flow;
- LSTSAR draft generation;
- ODBC-only boundary checks;
- unknown table rejection.

## Validation evidence

Observed smokes:

- `P7_ODBC_EXPLORER_READONLY_CORE_SMOKE_OK`
- `P7_ODBC_EXPLORER_CONTRACT_CORE_SMOKE_OK`
- `P7_MODEL_DATASOURCE_ODBC_CORE_SMOKE_OK`
- `P7_OPUS_PACKAGES_DIRECTORY_CONTRACT_CORE_SMOKE_OK`

Final OPUS local status:

```text
## master...origin/master
```

## Architecture note

Readonly is only a foundation milestone. ODBC Manager final target is not readonly.

CRUD and DDL must be added later as guarded milestones because ODBC is heterogeneous and destructive operations require driver capabilities, ACL, confirmation, predicates and audit-oriented design.

## Next milestones

1. `P7_ODBC_EXPLORER_SITE_APP_CORE`
2. `P7_ODBC_EXPLORER_CRUD_CORE`
3. `P7_ODBC_SCHEMA_BUILDER_CORE`
4. `P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE`

## Pending package note

Add LogAndPlay portal as Composer-installable OPUS package later:

```text
packages/logandplay-portal/
```
