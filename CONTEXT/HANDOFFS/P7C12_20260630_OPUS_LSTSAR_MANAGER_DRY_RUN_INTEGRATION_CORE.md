# P7C12 — 2026-06-30 — OPUS LSTSAR Manager dry-run integration core

## Status

Validated in OPUS, pushed and tagged.

## OPUS references

- Repository: `philstephibanez-wq/OPUS`
- Latest OPUS commit: `f7248b5`
- Functional dry-run integration commit: `2a3908c`
- Tag: `OPUS_P7_LSTSAR_MANAGER_DRY_RUN_INTEGRATION_CORE`

## Validated scope

`P7_LSTSAR_MANAGER_DRY_RUN_INTEGRATION_CORE` connects the protected LSTSAR Manager dry-run screen to the real model-driven ODBC LSTSAR engine.

Validated components:

- `packages/opus-lstsar-manager/src/DryRun/LstsarManagerDryRunService.php`
- updated `packages/opus-lstsar-manager/src/Config/LstsarManagerDeclarationRepository.php`
- updated `packages/opus-lstsar-manager/src/View/LstsarManagerViewModelFactory.php`
- updated `packages/opus-lstsar-manager/src/Controller/DryRunController.php`
- updated `packages/opus-lstsar-manager/templates/dry-run.score`
- updated LSTSAR Manager manifest, ACL, profiler and I18N files
- `tools/smokes/smoke_p7_lstsar_manager_dry_run_integration_core.php`

## Validated guarantees

- The Manager dry-run preview now uses `LstsarModelDrivenOdbcEngine`.
- The integration uses in-memory ODBC source/destination boundaries for deterministic dry-run testing.
- Direct execution remains disabled.
- Raw SQL remains forbidden.
- DDL remains forbidden.
- Dry-run exposes transformed record, stage results, report and archive metadata.
- Securize rejection remains visible and validated.
- `P7_LSTSAR_MANAGER_PACKAGE_CORE` regression smoke remains green.
- `P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE` regression smoke remains green.

## Validation evidence

Observed smokes:

- `P7_LSTSAR_MANAGER_DRY_RUN_INTEGRATION_CORE_SMOKE_OK`
- `P7_LSTSAR_MANAGER_PACKAGE_CORE_SMOKE_OK`
- `P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE_SMOKE_OK`
- `P7_LSTSAR_MODEL_DRIVEN_ODBC_CONTRACT_CORE_SMOKE_OK`
- `P7_ODBC_MODEL_REFINEMENT_CORE_SMOKE_OK`
- `P7_ODBC_EXPLORER_CRUD_UI_CORE_SMOKE_OK`
- `P7_ODBC_EXPLORER_CRUD_CORE_SMOKE_OK`

Final OPUS state after push/tag:

```text
## master...origin/master
```

Recent OPUS log:

```text
f7248b5 (HEAD -> master, tag: OPUS_P7_LSTSAR_MANAGER_DRY_RUN_INTEGRATION_CORE, origin/master, origin/HEAD) Update workspace status for P7 LSTSAR Manager dry-run integration core
2a3908c P7 integrate LSTSAR Manager dry-run engine
40f1ef3 (tag: OPUS_P7_LSTSAR_MANAGER_PACKAGE_CORE) Update workspace status for P7 LSTSAR Manager package core
9eef832 P7 add LSTSAR Manager package core
a231a61 (tag: OPUS_P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE) Update workspace status for P7 LSTSAR model-driven ODBC core
```

## User dashboard requirement captured

The next LSTSAR dashboard must be site/client scoped:

```text
Site / client selected
→ list all LSTSAR operations declared for that client
→ show active/inactive state
→ show source / destination / model / mapping summary
→ show last dry-run
→ show last real run
→ show next scheduled run
→ allow guarded manual launch
→ allow scheduled launch via cron / scheduler / CLI / API trigger
→ expose run history, archive and report
```

## Next possible milestones

```text
P7_LSTSAR_MANAGER_DASHBOARD_OPERATIONS_CORE
P7_LSTSAR_SCHEDULER_CRON_TRIGGER_CONTRACT_CORE
```

Purpose:

- Dashboard operations core: list client/site-scoped LSTSAR operations and statuses.
- Scheduler/cron trigger contract: define how a declared LSTSAR can be launched by cron, CLI, OPUS scheduler, or future API trigger without bypassing ACL, audit and report contracts.
