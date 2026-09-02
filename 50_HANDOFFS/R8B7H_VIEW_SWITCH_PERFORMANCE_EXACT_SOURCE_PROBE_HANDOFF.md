# R8B7H handoff — view-switch performance / exact source probe

## Status

READY FOR IMPLEMENTATION AFTER LOCAL BASELINE GATE.

## Owner evidence

R8B7G is reported functional. Fresh 2026-09-02 profiler captures show slow view changes, with representative OWASYS front requests reaching multiple seconds while SCORE rendering consumes only milliseconds.

## Confirmed code cause

`sites/owasys-front/application/default/services/FsmDiagramBuilder.php` currently calls `OwasysSourceModel::list()` in `applicationCatalogMessages()` to decide whether one exact locale catalog exists, then performs `read()` for that exact catalog. `OwasysSourceModel::list()` maps to `GET /api/v1/applications/{site_id}/sources`; the backend REST catalog maps this endpoint to `source.list`.

## R8B7H scope

Implement a secured exact-source probe/stat resource end-to-end, using generic OPUS source semantics where required:

- OPUS exact source workspace probe/stat contract and homonymous interface update if no equivalent capability already exists;
- owasys-back secured REST resource/operation/provider support;
- owasys-front `OwasysSourceModel` exact probe method;
- `FsmDiagramBuilder::applicationCatalogMessages()` replacement of full `list()` existence check;
- profiler/log coverage and strict validation.

Do not alter source-browser list behavior, EFSM definitions, layouts, translation semantics, or NO-FALLBACK policy.

## Stop gates

Before native ZIP construction, owner local OPUS HEAD and worktree cleanliness must be known exactly. Any unexpected dirty file stops delivery. Assistant updates MAESTRO_WORKSPACE directly; owner never needs to edit this workspace.

## Runtime acceptance

Re-run the same view-switch sequence with fresh front/back profiler files. `source.list` must disappear from contextual EFSM label resolution, and total view latency must materially decrease. Missing exact catalogs still render `⚠ <id>` without fallback or 500.