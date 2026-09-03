# P117W R8B7P — I18N PROFILER + CATALOG COMPLETENESS HANDOFF

Status: NEXT OWNER GATE BEFORE DELIVERY

## Baseline

OPUS remote HEAD expected: `f784d099b384dc3e446be928619ef0933b0c8034` (`R8B7O`).

## Runtime evidence accepted

R8B7O has been observed with exact missing keys visible in the UI and exact `i18n_key` values written to `owasys-front.log` under channel `opus.i18n` / event `translation.missing`.

Fresh front log inventory: 315 missing-I18n events / 42 unique keys.

Fresh front profiler evidence still reports zero warning events for requests that emitted those I18n warnings. This is the next root-cause target.

## Next delivery target

R8B7P will correlate each genuinely missing I18n message into the already-active OWASYS Profiler trace, preserving the same exact key/locale/module/trace information as the log warning. It must use the active `ProfilerInterface` passed by `OwasysScorePageRenderer`; no second profiler instance and no direct JSONL manipulation are allowed.

After profiler correlation is accepted, the measured key inventory is used to complete exact-locale catalogs. The diagnostic `⚠ <exact key>` remains as a safety net and must disappear naturally only when catalogs are complete.

## Stepwise gate

Before R8B7P ZIP is applied, verify owner local state against remote baseline. Unexpected HEAD or unrelated dirty paths are stop conditions.
