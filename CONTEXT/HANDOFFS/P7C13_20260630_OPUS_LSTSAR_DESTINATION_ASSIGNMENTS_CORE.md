# P7C13 — 2026-06-30 — OPUS LSTSAR destination assignments core

## Status

Validated in OPUS, pushed and tagged.

## OPUS references

- Repository: `philstephibanez-wq/OPUS`
- Latest OPUS commit: `c1216ad`
- Functional destination assignments commit: `168265a`
- Tag: `OPUS_P7_LSTSAR_DESTINATION_ASSIGNMENTS_CORE`

## Validated scope

`P7_LSTSAR_DESTINATION_ASSIGNMENTS_CORE` extends LSTSAR Transform so destination-only fields can be populated without requiring matching source fields.

Validated components:

- updated `Opus/Lstsar/03_Transform.php`
- `Opus/Lstsar/LstsarTransformHookInterface.php`
- `Opus/Lstsar/LstsarTransformHookContext.php`
- `Opus/Lstsar/LstsarTransformHookRegistry.php`
- `DOC/OPUS_LSTSAR_DESTINATION_ASSIGNMENTS_CORE.md`
- `DOC/OPUS_LSTSAR_SCRIPT_NECESSITY_AUDIT.md`
- `tools/smokes/smoke_p7_lstsar_destination_assignments_core.php`

## Destination assignment support

The Transform stage now supports destination-side assignments in addition to source-to-destination mapping.

Supported assignment families:

- constants
- metadata-derived values
- security-derived values
- source-field values
- transformed/destination-field values
- hashes
- concatenation
- named hooks through an explicit registry

## Hook policy

Hooks are intentionally named and registered. They are not arbitrary PHP from configuration.

Allowed principle:

```text
hook = deterministic computation through a registered name
```

Forbidden principle:

```text
no free PHP hook from config
no raw SQL hook
no hidden DB write from transform hook
no untracked side effect
```

## Script necessity audit

A first LSTSAR script necessity audit was added.

Current result:

- no immediate deletion was performed;
- six numbered stage files remain useful for the explicit user-facing LSTSAR architecture;
- ODBC source/destination adapters remain useful as runtime boundaries;
- in-memory ODBC adapters remain useful for deterministic dry-run/smoke/demo;
- Manager package files remain useful for the backoffice surface;
- patches/smokes remain useful for milestone validation;
- future simplification should target documentation, grouping and possible package-level organization, not blind removal.

## Validation evidence

Observed smokes:

- `P7_LSTSAR_DESTINATION_ASSIGNMENTS_CORE_SMOKE_OK`
- `P7_LSTSAR_MANAGER_DRY_RUN_INTEGRATION_CORE_SMOKE_OK`
- `P7_LSTSAR_MANAGER_PACKAGE_CORE_SMOKE_OK`
- `P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE_SMOKE_OK`
- `P7_LSTSAR_MODEL_DRIVEN_ODBC_CONTRACT_CORE_SMOKE_OK`

Final OPUS state after push/tag:

```text
## master...origin/master
```

Recent OPUS log:

```text
c1216ad (HEAD -> master, tag: OPUS_P7_LSTSAR_DESTINATION_ASSIGNMENTS_CORE, origin/master, origin/HEAD) Update workspace status for P7 LSTSAR destination assignments core
168265a P7 add LSTSAR destination assignments core
f7248b5 (tag: OPUS_P7_LSTSAR_MANAGER_DRY_RUN_INTEGRATION_CORE) Update workspace status for P7 LSTSAR Manager dry-run integration core
2a3908c P7 integrate LSTSAR Manager dry-run engine
40f1ef3 (tag: OPUS_P7_LSTSAR_MANAGER_PACKAGE_CORE) Update workspace status for P7 LSTSAR Manager package core
```

## Next milestone

```text
P7_LSTSAR_MANAGER_DASHBOARD_OPERATIONS_CORE
```

Purpose: create the visible LSTSAR Dashboard listing operations for a selected site/client, with status, source/destination summary, mapping/assignment coverage, last dry-run, last run, next planned run, archive/report links and future launch actions.
