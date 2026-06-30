# P7C11 — 2026-06-30 — OPUS LSTSAR Manager package core

## Status

Validated in OPUS, pushed and tagged.

## OPUS references

- Repository: `philstephibanez-wq/OPUS`
- Latest OPUS commit: `40f1ef3`
- Functional LSTSAR Manager package commit: `9eef832`
- Tag: `OPUS_P7_LSTSAR_MANAGER_PACKAGE_CORE`

## Validated scope

`P7_LSTSAR_MANAGER_PACKAGE_CORE` creates the protected OPUS application package:

```text
packages/opus-lstsar-manager/
```

The package is the first declarative backoffice surface for LSTSAR configuration.

Validated components:

- `packages/opus-lstsar-manager/composer.json`
- `packages/opus-lstsar-manager/opus.application.json`
- `packages/opus-lstsar-manager/app/routes.php`
- `packages/opus-lstsar-manager/config/acl.php`
- `packages/opus-lstsar-manager/config/navigation.php`
- `packages/opus-lstsar-manager/config/profiler.php`
- `packages/opus-lstsar-manager/i18n/en.php`
- `packages/opus-lstsar-manager/i18n/fr.php`
- ScoreTemplate templates:
  - `dashboard.score`
  - `declarations.score`
  - `endpoint.score`
  - `mapping.score`
  - `rules.score`
  - `archive-report.score`
  - `dry-run.score`
- controllers:
  - `DashboardController`
  - `DeclarationsController`
  - `DryRunController`
- services/view/diagnostics:
  - `LstsarManagerDeclarationRepository`
  - `LstsarManagerViewModelFactory`
  - `LstsarManagerProfiler`

## Validated guarantees

- The app is Composer-installable as an OPUS application package.
- The app is protected, not anonymous, and denied by default.
- ACL is restricted to admin/developer roles.
- Routes cover dashboard, declarations, endpoint configuration, mapping, rules, archive/report and dry-run.
- Forbidden routes are absent: no direct execute, no raw SQL console, no DDL.
- I18N exists in French and English.
- Navigation exists.
- Profiler config exists and redacts sensitive fields.
- View-models are deterministic and array-based.
- Controllers are smoke-tested.
- Backoffice declaration integrates with the existing LSTSAR model-driven ODBC configuration contract.
- The previous `P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE` smoke remains green.

## Validation evidence

Observed smokes:

- `P7_LSTSAR_MANAGER_PACKAGE_CORE_SMOKE_OK`
- `P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE_SMOKE_OK`

Final OPUS state after push/tag:

```text
## master...origin/master
```

Recent OPUS log:

```text
40f1ef3 (HEAD -> master, tag: OPUS_P7_LSTSAR_MANAGER_PACKAGE_CORE, origin/master, origin/HEAD) Update workspace status for P7 LSTSAR Manager package core
9eef832 P7 add LSTSAR Manager package core
a231a61 (tag: OPUS_P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE) Update workspace status for P7 LSTSAR model-driven ODBC core
473df50 P7 add LSTSAR model-driven ODBC core
5ef51d1 (tag: OPUS_P7_LSTSAR_MODEL_DRIVEN_ODBC_CONTRACT_CORE) Update workspace status for P7 LSTSAR model-driven ODBC contract core
```

## Next possible milestone

Next possible milestone:

```text
P7_LSTSAR_MANAGER_DRY_RUN_INTEGRATION_CORE
```

Purpose: connect the manager dry-run screen to the real `LstsarModelDrivenOdbcEngine` with sample/declaration-backed input, still without direct execution.
