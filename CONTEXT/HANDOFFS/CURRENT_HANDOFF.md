# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart from this file without relying on hidden conversation memory.

## Permanent rules

NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
REUSE EXISTING OPUS BRICKS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
ASAP BEHAVIOR MUST BE EVOLVED, NOT DEGRADED.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

OPUS is a general-purpose applicative web framework. REST is a generic OPUS framework brick, not a private API for one engine.

Critical correction: OPUS is only one sub-project inside MAESTRO_WORKSPACE. OPUS is not the workspace.

## Current OPUS state

OPUS root: H:\OPUS
OPUS GitHub: philstephibanez-wq/OPUS
Workspace root: H:\MAESTRO_WORKSPACE
Workspace repo: philstephibanez-wq/MAESTRO_WORKSPACE
OPUS branch: master
Latest functional OPUS code commit: e12b1dd
Latest OPUS workspace-status-only commit in OPUS repo: 506280f
Latest validated OPUS tag: OPUS_P7_ODBC_EXPLORER_CONTRACT_CORE

## Current OPUS architecture decisions

ScoreTemplate / `.score` is OPUS, not ASAP.

OPUS database-facing architecture is ODBC-only.

- all database-facing OPUS classes must use `Opus\Database\Odbc`;
- no official direct MySQL/PostgreSQL/SQLite/PDO-specific/mysqli-facing OPUS database class outside the ODBC boundary;
- `Opus\Model` is the official representation of ODBC tables, rows, fields, types, lengths, nullability and metadata;
- ODBC Explorer is the future Adminer/phpMyAdmin-like OPUS administration surface for ODBC + Model + LSTSAR;
- ODBC Explorer must be implemented as a real OPUS site/application with routes, controllers, ScoreTemplate views, I18N, SSO/ACL, diagnostics, profiler and logs;
- ODBC Explorer is not a public anonymous site;
- destructive CRUD and DDL operations require guards, dry-run where applicable, non-empty predicates, confirmation and audit-oriented design.

LSTSAR final target is Model-driven + ODBC-driven. The existing array/schema LSTSAR core is not the final heterogeneous database architecture until aligned with Model + ODBC.

## Read first

- CONTEXT/DECISIONS/DECISION_20260629_OPUS_ODBC_ONLY_MODEL_EXPLORER_SITE.md
- CONTEXT/HANDOFFS/P7C1_20260629_OPUS_ODBC_MODEL_EXPLORER.md
- CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
- CONTEXT/PROJECTS/PROJECT_INDEX.md

## Latest validations already passed

- `P7_SCORETEMPLATE_CONTRACT_FINAL`
- `P7_API_REST_SSO_SECURITY_CORE`
- `P7_LSTSAR_CONTRACT_CORE`
- `P7_LSTSAR_API_INTEGRATION_CORE`
- `P7_MODEL_DATASOURCE_ODBC_CORE`
- `P7_ODBC_EXPLORER_CONTRACT_CORE`

## Next milestone

P7_ODBC_EXPLORER_READONLY_CORE.

Target:

- real read-only ODBC explorer capabilities;
- drivers/DSN inventory where available;
- connection test;
- table listing;
- column inspection;
- row preview;
- TableModel generation;
- LSTSAR draft generation.

## Later milestones

1. P7_ODBC_EXPLORER_SITE_APP_CORE.
2. P7_ODBC_EXPLORER_CRUD_CORE.
3. P7_ODBC_SCHEMA_BUILDER_CORE.
4. P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE.

## Repository write policy

MAESTRO_WORKSPACE: assistant may write directly to GitHub for contracts, ADRs, handoffs and project context updates.
OPUS: no direct assistant write/commit/push for code; local runners only, then user validates and commits/pushes.
All repositories: no direct mutation outside explicitly authorized scope.

## Current source-of-truth rule

OPUS code and OPUS-owned sites: philstephibanez-wq/OPUS
Workspace context: philstephibanez-wq/MAESTRO_WORKSPACE
No direct work on removed roots: H:\OPUS_REF_BOOK, H:\LOGANDPLAY.ORG
