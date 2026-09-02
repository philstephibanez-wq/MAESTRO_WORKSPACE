# R8B7H handoff — view-switch performance / exact source probe

## Status

NATIVE ZIP PREPARED AFTER CLEAN LOCAL BASELINE GATE — OWNER APPLY/STATIC VALIDATION PENDING.

## Owner evidence

R8B7G is functional. Fresh 2026-09-02 profiler captures show slow view changes, with representative OWASYS front requests reaching multiple seconds while SCORE rendering consumes only milliseconds.

The mandatory baseline gate passed on 2026-09-02: local OPUS `HEAD` and `origin/master` are both `f17c063671ff3387645b32d0149d84d4741d7cc8`; branch is clean and `git status --porcelain=v1 -uall` is empty.

## Confirmed code cause

`sites/owasys-front/application/default/services/FsmDiagramBuilder.php` calls `OwasysSourceModel::list()` in `applicationCatalogMessages()` to decide whether one exact locale catalog exists, then performs `read()` for that exact catalog. `OwasysSourceModel::list()` maps to `GET /api/v1/applications/{site_id}/sources`; the backend REST catalog maps this endpoint to `source.list`.

The generic `SiteSourceWorkspace` and `SiteSourceInspector` baseline expose list/read operations but no exact existence probe, so no existing generic primitive can replace the recursive list without framework evolution.

## R8B7H implementation

The prepared differential introduces a generic exact source probe and wires it end-to-end:

- `Opus/Application/Source/SiteSourceProbeInterface.php`;
- `Opus/Application/Source/SiteSourceProbe.php`;
- owasys-back source command provider support for `owasys:source:probe`;
- secured REST resource `GET /api/v1/applications/{site_id}/source-probes/{*path}`;
- REST operation `source.probe` → Composer script `owasys:source-probe`;
- owasys-front `OwasysSourceModel::probe()`;
- `FsmDiagramBuilder::applicationCatalogMessages()` exact probe replacing full source listing.

The probe is read-only, preserves source ACL read authorization, validates application ownership and exact source paths, and is instrumented through Logger/Profiler as `source.probe`. Absence is an explicit `exists=false` result, while malformed/forbidden requests remain errors. Source contents are not logged or profiled.

NO-FALLBACK remains unchanged. Missing exact catalog returns no catalog messages and therefore preserves visible `⚠ <id>` labels. Source-browser listing, EFSM definitions, persisted layouts and SCORE rendering are unchanged.

## Construction validation

All prepared PHP files pass `php -l`. All modified JSON files parse successfully. REST/resource catalogs are synchronized, route and operation keys are unique, and the chain REST → operation catalog → Composer alias → application provider is complete. `applicationCatalogMessages()` contains no `source.list()` call and performs exact probe plus conditional exact read.

This is construction evidence only; no local OPUS mutation or runtime success is claimed yet.

## Next owner gate

Apply the native R8B7H ZIP to the already validated clean baseline, regenerate Composer autoload metadata, run syntax/JSON/diff checks, and return the complete output. Any unexpected diff or validation failure is a stop condition.

## Runtime acceptance after static gate

Re-run the same view-switch sequence with fresh front/back profiler files. `source.list` must disappear from contextual EFSM label resolution, `source.probe` must be correlated front/back, and total view latency must materially decrease. Existing exact catalogs must retain correct labels; missing exact catalogs must still render `⚠ <id>` without fallback or 500.
