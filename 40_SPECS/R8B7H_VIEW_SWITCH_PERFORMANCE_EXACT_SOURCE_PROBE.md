# R8B7H — View-switch performance / exact source probe

## Baseline

OPUS/OWASYS baseline validated by owner: R8B7G functional, derived from pushed R8B7F `6f4ed3c5e1dbd8cda3c9da2c7a459b367963227e`. Final local HEAD must be re-gated before ZIP creation.

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

## Acceptance

- Front profiler on ordinary contextual EFSM view switches contains no `source.list` caused by `applicationCatalogMessages()`.
- Existing exact catalog: exact probe then exact read, correct labels.
- Missing exact catalog: no fallback, no 500, visible `⚠ <id>` labels.
- No cross-application source substitution.
- SCORE rendering remains unchanged.
- `git diff --check` clean and compliance audit does not regress.

## Follow-up

After eliminating this full-list bottleneck, re-profile the same view sequence. Any remaining repeated exact reads or REST overhead are optimized only from measured evidence, not by speculative caching.