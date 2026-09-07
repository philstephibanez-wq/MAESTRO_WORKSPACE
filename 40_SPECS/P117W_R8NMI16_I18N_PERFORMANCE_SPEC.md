# P117W R8NMI16 — I18N / PERFORMANCE SPEC

Date: 2026-09-07
Status: ACTIVE

## Authority

This tranche is defined from current GitHub master sources only, under README-FIRST.md and the native ZIP stepwise workflow contract.

## Accepted prior target

R8NMI15 targets the backend layout-authority mismatch for inherited host NMI geometry. Runtime acceptance remains owner-controlled and must not be claimed without returned evidence.

## Open defects

1. Exact-locale FSM labels can still expose the visible missing-translation marker when a required key is absent.
2. FsmDiagramBuilder contains visible hard-coded French description text, which violates the application I18N requirement.
3. `applicationCatalogMessages()` performs a complete `OwasysSourceModel::list()` of the selected application only to determine whether one exact locale catalog exists, then performs a second REST source read. This is a likely request-amplification/performance defect.
4. Current OPUS master `sites/owasys-front/config/rest.resources.json` does not contain `source.stat`; no implementation may assume that uncommitted/local route exists.

## Cause-first implementation requirements

- Preserve exact active-locale semantics: do not introduce implicit parent/base/host fallback.
- Resolve visible UI description strings through the existing OPUS I18N path rather than hard-coded language.
- Remove the full source-tree listing from the FSM-label hot path using an existing authoritative capability if one already exists in current GitHub sources; otherwise propose the generic OPUS/REST capability before a local shortcut.
- Keep Profiler instrumentation measurable and do not invent performance gains.
- Do not mutate OPUS/OWASYS on GitHub; delivery is a native differential ZIP to the owner.

## Delivery

Short native ZIP, complete files only at final repository-relative paths, SHA-256 verified. Owner applies with CMD from `%USERPROFILE%\Downloads` into `H:\OPUS` and validates one workflow gate at a time.
