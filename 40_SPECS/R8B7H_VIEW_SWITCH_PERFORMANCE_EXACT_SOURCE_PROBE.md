# R8B7H — View-switch performance / exact source probe

## Baseline

OPUS/OWASYS baseline re-gated by owner on 2026-09-02: local `HEAD` and `origin/master` are both `f17c063671ff3387645b32d0149d84d4741d7cc8` (R8B7G), worktree clean and no untracked files.

## Evidence

Fresh front/back profiler captures supplied 2026-09-02 show multi-second OWASYS front view changes while SCORE rendering itself is only a few milliseconds. A representative `/en-EN/security` request takes about 3.83 s. Before SCORE renders, the frontend performs a serial REST chain including security snapshot where applicable, multiple exact source reads, a complete `source.list`, and an EFSM layout read.

The current `OwasysFsmDiagramBuilder::applicationCatalogMessages()` performs `OwasysSourceModel::list($applicationId, $identity)` solely to determine whether the single exact catalog `application/default/local/<locale>.json` exists. It then separately performs an exact source read. This converts one exact-resource existence question into a full source-tree enumeration on every contextual EFSM page.

## Root cause

The exact-locale / NO-FALLBACK correction is semantically correct, but catalog existence is currently implemented through a full secured source listing. The profiler shows that this list operation is a dominant avoidable cost on view switches.

## Contract

1. NO FALLBACK remains absolute.
2. Do not cache or infer a different locale/source/application.
3. Do not restore parent-language or host-source substitution.
4. Replace full source enumeration for catalog existence by a secured exact-resource probe/stat contract.
5. Prefer a generic OPUS source-workspace capability when not already present; expose it through OWASYS back REST and consume it through `OwasysSourceModel`.
6. The probe must distinguish exactly: exists file / absent file / invalid request or server failure. Absence must not become HTTP 500 in the front designer.
7. `FsmDiagramBuilder` must perform at most an exact probe plus exact read for the active locale catalog, never `source.list` for label lookup.
8. Source browser behavior may retain full listing where a list is actually the requested resource.
9. Preserve ACL, SSO, request signing, logging, profiler correlation, application ownership, exact source path validation, and REST resource semantics.
10. No FSM definition or persisted layout geometry changes.

## Prepared implementation

R8B7H is prepared from the clean authoritative baseline `f17c063671ff3387645b32d0149d84d4741d7cc8` as a native differential ZIP. The generic framework capability is implemented as `Opus\Application\Source\SiteSourceProbe` with homonymous `SiteSourceProbeInterface`, satisfying the OPUS framework component interface contract. The probe performs an exact bounded source-path existence check without recursive enumeration and emits Logger/Profiler observation under `source.probe` without source contents.

OWASYS exposure is end-to-end:

- secured REST resource `GET /api/v1/applications/{site_id}/source-probes/{*path}`;
- REST operation `source.probe` mapped to Composer script `owasys:source-probe`;
- application command `owasys:source:probe` in the owasys-back source provider;
- ACL action remains `source/read` for the read-only probe;
- `OwasysSourceModel::probe()` validates `OPUS_SITE_SOURCE_PROBE_V1`;
- `FsmDiagramBuilder::applicationCatalogMessages()` computes the exact active-locale catalog path, performs one exact probe, returns no messages when absent, and performs the existing exact read only when present.

The source-browser listing path is unchanged. No cache, fallback, EFSM definition, layout geometry or SCORE rendering change is included.

## Static construction checks

Before ZIP creation, all changed PHP files pass `php -l`; all changed JSON files parse successfully; REST resource/operation names are unique and fully wired; `backend.rest.json` and `backend.resources.json` expose the same resource set; `source.probe` is present through REST → operation catalog → Composer alias → provider; and `applicationCatalogMessages()` contains no `source.list()` call.

These checks are construction evidence only. Local owner application and runtime acceptance remain pending.

## Acceptance

- Front profiler on ordinary contextual EFSM view switches contains no `source.list` caused by `applicationCatalogMessages()`.
- Existing exact catalog: exact probe then exact read, correct labels.
- Missing exact catalog: no fallback, no 500, visible `⚠ <id>` labels.
- No cross-application source substitution.
- SCORE rendering remains unchanged.
- `git diff --check` clean and compliance audit does not regress.

## Follow-up

After eliminating this full-list bottleneck, re-profile the same view sequence. Any remaining repeated exact reads or REST overhead are optimized only from measured evidence, not by speculative caching.
