# DECISION 2026-06-29 — OPUS ODBC-only, Model-driven database layer, ODBC Explorer site

## Status

Accepted.

## Context

OPUS is one sub-project inside `MAESTRO_WORKSPACE`. The workspace is the global coordination source for decisions, handoffs and cross-project state; OPUS is not the workspace.

The OPUS P7 line has moved beyond the earlier ACL/LSTSAR skeleton state. The current validated OPUS database direction is:

- database access through ODBC only;
- OPUS Model as the representation layer for database tables, fields, rows, types, sizes, nullability and metadata;
- LSTSAR final target as Model-driven and ODBC-driven for heterogeneous database ingestion/storage;
- OPUS ODBC Explorer as an Adminer/phpMyAdmin-like administration surface for ODBC + Model + LSTSAR;
- OPUS ODBC Explorer must become a true OPUS site/application, not only utility classes.

## Decision

OPUS database-facing architecture is ODBC-only.

All database-facing OPUS classes must use the official boundary:

```text
Opus\Database\Odbc
```

OPUS must not add official direct MySQL, PostgreSQL, SQLite, PDO-specific or mysqli-facing database classes outside this ODBC boundary.

`Opus\Model` is the official object representation layer for ODBC-sourced tables and rows.

`Opus\OdbcExplorer` is the official future database administration surface. It must target Adminer/phpMyAdmin-style parity through OPUS concepts:

- ODBC driver/DSN inventory;
- connection tests;
- catalog/schema/table browsing;
- column inspection;
- row preview;
- SQL console with guards;
- import/export;
- guarded CRUD;
- guarded DDL/schema builder;
- TableModel generation;
- LSTSAR draft generation.

The ODBC Explorer must be implemented as a real OPUS site/application:

- OPUS routes;
- OPUS controllers;
- ScoreTemplate `.score` views;
- I18N;
- SSO/ACL;
- diagnostics;
- profiler;
- logs;
- admin/dev-only access, not public anonymous access.

## Consequences

- `P7_MODEL_DATASOURCE_ODBC_CORE` is the validated Model + ODBC base.
- `P7_ODBC_EXPLORER_CONTRACT_CORE` is the validated ODBC Explorer contract base.
- The existing array/schema LSTSAR core is not the final heterogeneous BDD architecture until aligned with Model + ODBC.
- Future LSTSAR work must become `P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE` or equivalent.
- Destructive database actions require explicit guards, dry-run where applicable, non-empty predicates, confirmation and audit-oriented design.

## Current OPUS references

- OPUS latest functional code commit at decision time: `e12b1dd`.
- OPUS workspace-only status refresh commit in OPUS repo: `506280f`.
- OPUS tags:
  - `OPUS_P7_MODEL_DATASOURCE_ODBC_CORE`
  - `OPUS_P7_ODBC_EXPLORER_CONTRACT_CORE`
  - `OPUS_P7_LSTSAR_API_INTEGRATION_CORE`
  - `OPUS_P7_LSTSAR_CONTRACT_CORE`
  - `OPUS_P7_API_REST_SSO_SECURITY_CORE`
  - `OPUS_P7_SCORETEMPLATE_FINAL`
