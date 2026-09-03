# R8B7H handoff — view-switch performance / exact source stat

## Status

OWNER STATIC VALIDATION PASSED. FIRST RUNTIME ATTEMPT BLOCKED BY REST CATALOG FINGERPRINT DRIFT. CLIENT CATALOG CORRECTION APPLIED LOCALLY; FINAL RUNTIME REVALIDATION PENDING.

## Owner evidence

Baseline gate passed on 2026-09-02 with local OPUS `HEAD == origin/master == f17c063671ff3387645b32d0149d84d4741d7cc8` and a clean worktree.

The main R8B7H differential was applied and the owner returned:

- exactly the expected changed source/configuration files;
- no residual bootstrap files after cleanup;
- clean `git diff --check`;
- PHP lint success on all changed PHP files;
- valid `composer.json` with only the existing version-field warning;
- optimized Composer autoload regenerated successfully with 561 classes.

## Actual implementation

The final design uses the existing generic OPUS source workspace:

- `SiteSourceWorkspaceInterface::stat()`;
- `SiteSourceWorkspace::stat()` returning `OPUS_SITE_SOURCE_STAT_V1`;
- owasys-back `owasys:source:stat` / `owasys:source-stat`;
- REST operation `source.stat`;
- resource `GET /api/v1/applications/{site_id}/source-stats/{*path}`;
- owasys-front `OwasysSourceModel::stat()`;
- `FsmDiagramBuilder::applicationCatalogMessages()` uses exact stat plus conditional exact read and no longer uses `source.list` for contextual label existence.

NO-FALLBACK, source-browser listing, EFSM definitions, persisted layouts and SCORE rendering remain unchanged.

## Invalid direct CLI test

A direct owner invocation of `composer owasys:source-stat -- ...` returned `OWASYS_SOURCE_COMMAND_REQUEST_CONTRACT_INVALID`. This is expected for application source commands because their provider requires the secured `OPUS_REST_API_COMPOSER_COMMAND_REQUEST_V1` envelope. It is not a runtime acceptance test and is not evidence of a defect in `source.stat`.

## Runtime incident

The first real front → REST → back run failed before R8B7H performance could be measured.

Fresh owner logs show the same correlated trace reaching the back as `source.read` and failing with `OPUS_REST_API_CATALOG_MISMATCH`. The front then returned HTTP 500 and visible translations/menu labels degraded to missing-translation markers.

Root cause is deterministic: the back external catalog and inline server resources had the new `source.stat` route, while `sites/owasys-front/config/rest.resources.json` initially did not. OPUS REST fingerprints the complete normalized resource catalog and rejects every request when peer fingerprints differ.

The corrective local differential updates `sites/owasys-front/config/rest.resources.json` with the same `source.stat` resource. Owner evidence after extraction showed that file as modified and `git diff --check` clean.

## Development-server contract confirmation

The authoritative OPUS site configurations already define the canonical development bindings:

- `owasys-front`: `OPUS_DEV_SERVER_PORT=8000`;
- `owasys-back`: `OPUS_DEV_SERVER_PORT=8080`.

Therefore the canonical owner commands remain:

`composer opus:dev-server -- owasys-front`

`composer opus:dev-server -- owasys-back`

No CLI port override is part of R8B7H or R8B7I.

## Final R8B7H acceptance pending

After restarting through the canonical commands, fresh runtime evidence must confirm:

- no `OPUS_REST_API_CATALOG_MISMATCH`;
- translated menu and contextual EFSM labels restored for an existing exact locale catalog;
- no `source.list` from `applicationCatalogMessages()`;
- correlated `source.stat` followed by `source.read` only when the exact file exists;
- missing exact locale remains `⚠ <id>` without fallback or 500;
- material view-switch latency improvement versus the supplied pre-R8B7H profiler baseline.

## Next delivery R8B7I

R8B7I addresses the systemic cause exposed by this incident: OPUS validation must detect REST peer catalog fingerprint drift before runtime. The generic validator must use the site `exchange` contract and local peer configuration when both peers are present, preserve separate-deployment compatibility, and fail validation explicitly on catalog mismatch.
