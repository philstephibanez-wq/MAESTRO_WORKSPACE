# OPUS CURRENT STATE

Last updated: 2026-06-29.

## Repository

- Local repo: H:/OPUS
- Remote: philstephibanez-wq/OPUS
- Branch: master
- Latest functional OPUS code commit: e12b1dd
- Latest OPUS workspace-status-only commit in OPUS repo: 506280f
- Latest validated tag: OPUS_P7_ODBC_EXPLORER_CONTRACT_CORE

## Current validated milestone

`P7_ODBC_EXPLORER_CONTRACT_CORE` is smoke-validated, pushed and tagged in OPUS.

Correction: OPUS is a sub-project of MAESTRO_WORKSPACE. OPUS is not the workspace.

## ScoreTemplate ownership

ScoreTemplate and `.score` belong to OPUS.

Do not describe ScoreTemplate as an ASAP component in the current architecture.

## Database and Model state

OPUS database-facing architecture is ODBC-only.

Validated base:

- `Opus\Database\Odbc\OdbcDataSourceConfig`
- `Opus\Database\Odbc\OdbcColumn`
- `Opus\Database\Odbc\OdbcConnectionInterface`
- `Opus\Database\Odbc\NativeOdbcConnection`
- `Opus\Database\Odbc\OdbcTableInspector`
- `Opus\Model\ModelField`
- `Opus\Model\TableModel`
- `Opus\Model\ModelRecord`
- `Opus\Model\Adapter\OdbcModelAdapter`

Runtime evidence:

- PHP `odbc`: enabled.
- PHP `PDO_ODBC`: enabled.
- Active local PHP: `H:/UwAmp/bin/php/php-8.5.6/php.exe`.
- Active PHP architecture: x86 / 32-bit.
- Local ODBC work must use 32-bit drivers while this PHP remains x86.

Rules:

- all database-facing OPUS classes must use `Opus\Database\Odbc`;
- OPUS must not add official direct MySQL, PostgreSQL, SQLite, PDO-specific or mysqli-facing database classes outside the ODBC boundary;
- `Opus\Model` is the official representation layer for ODBC tables, rows, fields, types, lengths, nullability and metadata.

## LSTSAR state

Validated so far:

- `P7_LSTSAR_CONTRACT_CORE`
- `P7_LSTSAR_API_INTEGRATION_CORE`

Correction: the current array/schema LSTSAR core is not the final heterogeneous database LSTSAR architecture.

Final target: ODBC to Model to LSTSAR to ODBC.

## ODBC Explorer state

`P7_ODBC_EXPLORER_CONTRACT_CORE` is validated.

ODBC Explorer target:

- Adminer/phpMyAdmin-like OPUS database administration surface;
- ODBC + Model + LSTSAR integration;
- drivers and DSN;
- connection tests;
- catalogs, schemas and tables;
- column inspection;
- row preview;
- SQL console;
- import/export;
- guarded CRUD;
- guarded DDL/schema builder;
- TableModel generation;
- LSTSAR draft generation.

ODBC Explorer must become a true OPUS site/application:

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

## Validated milestones

- `P7_SCORETEMPLATE_CONTRACT_FINAL`
- `P7_API_REST_SSO_SECURITY_CORE`
- `P7_LSTSAR_CONTRACT_CORE`
- `P7_LSTSAR_API_INTEGRATION_CORE`
- `P7_MODEL_DATASOURCE_ODBC_CORE`
- `P7_ODBC_EXPLORER_CONTRACT_CORE`

## Validation evidence

Recent validations passed:

- `P7_ODBC_EXPLORER_CONTRACT_CORE_SMOKE_OK`
- `P7_MODEL_DATASOURCE_ODBC_CORE_SMOKE_OK`
- `P7_LSTSAR_API_INTEGRATION_CORE_SMOKE_OK`
- `P7_LSTSAR_CONTRACT_CORE_SMOKE_OK`

Final local OPUS status observed after tag: `## master...origin/master`.

## Next milestone

`P7_ODBC_EXPLORER_READONLY_CORE`.

Expected scope:

- driver/DSN inventory where available;
- connection test;
- table listing;
- column inspection;
- preview rows;
- TableModel generation;
- LSTSAR draft generation.

## Later milestones

1. `P7_ODBC_EXPLORER_SITE_APP_CORE`.
2. `P7_ODBC_EXPLORER_CRUD_CORE`.
3. `P7_ODBC_SCHEMA_BUILDER_CORE`.
4. `P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE`.

## Active continuation rule

Before any new OPUS patch, read:

- CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- CONTEXT/DECISIONS/DECISION_20260629_OPUS_ODBC_ONLY_MODEL_EXPLORER_SITE.md
- CONTEXT/HANDOFFS/P7C1_20260629_OPUS_ODBC_MODEL_EXPLORER.md
- CONTEXT/PROJECTS/PROJECT_INDEX.md
