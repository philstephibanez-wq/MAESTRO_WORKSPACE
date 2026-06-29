# P7C1 — 2026-06-29 — OPUS ODBC Model + Explorer handoff

## Scope

This handoff records the validated OPUS ODBC/Model/Explorer direction inside the global `MAESTRO_WORKSPACE`.

OPUS is one sub-project of the workspace. OPUS is not the workspace.

## Validated OPUS milestones since previous workspace handoff

- `P7_SCORETEMPLATE_CONTRACT_FINAL`
- `P7_API_REST_SSO_SECURITY_CORE`
- `P7_LSTSAR_CONTRACT_CORE`
- `P7_LSTSAR_API_INTEGRATION_CORE`
- `P7_MODEL_DATASOURCE_ODBC_CORE`
- `P7_ODBC_EXPLORER_CONTRACT_CORE`

## Latest OPUS status

- OPUS repository: `philstephibanez-wq/OPUS`
- Local OPUS root: `H:/OPUS`
- OPUS branch: `master`
- Latest functional OPUS code commit: `e12b1dd`
- Latest OPUS workspace-status-only commit in OPUS repo: `506280f`
- Latest validated OPUS tag: `OPUS_P7_ODBC_EXPLORER_CONTRACT_CORE`

## Runtime decision

The local active PHP runtime for OPUS is UwAmp PHP:

```text
H:\UwAmp\bin\php\php-8.5.6\php.exe
```

Observed runtime:

- x86 / 32-bit;
- thread-safe;
- `odbc` enabled;
- `PDO_ODBC` enabled.

Because this PHP is x86, local ODBC runtime must use 32-bit ODBC drivers/DSN while this runtime remains x86.

## Architecture decisions

- OPUS database access is ODBC-only.
- All database-facing OPUS classes must pass through `Opus\Database\Odbc`.
- No official direct MySQL/PostgreSQL/SQLite/PDO-specific/mysqli-facing database classes should be added outside the ODBC boundary.
- OPUS Model is the representation layer for ODBC tables, rows, fields, types, sizes, nullability and metadata.
- LSTSAR final architecture must be Model-driven + ODBC-driven.
- The existing array/schema LSTSAR core is not final for heterogeneous BDD ingestion/storage until aligned with Model + ODBC.
- OPUS ODBC Explorer is the official Adminer/phpMyAdmin-like surface for OPUS database administration through ODBC + Model + LSTSAR.
- OPUS ODBC Explorer must become a real OPUS site/application, not only service classes.

## ODBC Explorer target

The target is an OPUS admin/dev site with:

- OPUS routes;
- controllers;
- ScoreTemplate `.score` templates;
- I18N;
- SSO/ACL;
- diagnostics;
- profiler;
- logs;
- navigation;
- admin/dev-only access.

Functional parity target:

- list drivers and DSN;
- test connections;
- list catalogs/schemas/tables;
- inspect columns;
- preview rows;
- generate TableModel;
- generate LSTSAR drafts;
- read-only SQL console;
- import/export;
- guarded CRUD;
- guarded DDL/schema builder.

Destructive operations require guards: dry-run where applicable, confirmation, non-empty predicates and audit-oriented design.

## Next milestones

1. `P7_ODBC_EXPLORER_READONLY_CORE`
   - implement real read-only ODBC explorer capabilities: drivers/DSN inventory, connection test, list tables, inspect columns, preview rows, generate TableModel and LSTSAR draft.

2. `P7_ODBC_EXPLORER_SITE_APP_CORE`
   - create ODBC Explorer as a true OPUS site/application with routes, controllers, ScoreTemplate views, I18N, SSO/ACL and navigation.

3. `P7_ODBC_EXPLORER_CRUD_CORE`
   - guarded insert/update/delete through Model validation and explicit confirmation.

4. `P7_ODBC_SCHEMA_BUILDER_CORE`
   - Model-to-DDL dry-run, guarded DDL execution and driver capability checks.

5. `P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE`
   - align LSTSAR with OPUS Model + ODBC for heterogeneous database table ingestion and storage.

## Resume instruction for a new chat

Read in this order:

1. `README.md`
2. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
3. `CONTEXT/DECISIONS/DECISION_20260629_OPUS_ODBC_ONLY_MODEL_EXPLORER_SITE.md`
4. `CONTEXT/HANDOFFS/P7C1_20260629_OPUS_ODBC_MODEL_EXPLORER.md`
5. `CONTEXT/PROJECTS/PROJECT_INDEX.md`
6. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

Then resume with `P7_ODBC_EXPLORER_READONLY_CORE` unless the user explicitly changes priority.
