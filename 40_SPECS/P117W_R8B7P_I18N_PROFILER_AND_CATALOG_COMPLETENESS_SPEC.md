# P117W R8B7P — I18N PROFILER + CATALOG COMPLETENESS SPEC

Status: IMPLEMENTATION / NEXT DELIVERY

## Authority

- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` are authoritative.
- OPUS GitHub baseline is `f784d099b384dc3e446be928619ef0933b0c8034` (`R8B7O`).

## Fresh runtime evidence — 2026-09-03 22:48–22:49 UTC

R8B7O materially improved diagnostics:

- missing translations are now visible in SCORE as `⚠ <exact.i18n.key>`;
- front logs now emit channel `opus.i18n`, message `translation.missing`;
- each event includes `error_code=OPUS_I18N_MESSAGE_MISSING`, exact `i18n_key`, exact `locale`, module and request `trace_id`.

Fresh `owasys-front(20260903-224943).log` contains 315 missing-I18n warning events covering 42 unique keys. Examples include `menu.operation.create`, `menu.operation.read`, `menu.operation.update`, `menu.operation.delete`, `security.workspace`, `security.dashboard`, `security.roles`, `registry.select_instruction`, `auth.sign_in`, `auth.change_password` and creation-step keys.

## Remaining defect 1 — profiler correlation is incomplete

Fresh `owasys-front(20260903-224949).jsonl` traces still report `warning: 0` even while the same request emits `opus.i18n/translation.missing` warnings to the application log. Therefore the owner-required double diagnostic is only half implemented.

Required behavior:

1. a missing I18n message emits the existing Logger warning;
2. the same missing message emits a Profiler event on the active OWASYS request trace;
3. Profiler event context includes at minimum:
   - `error_code = OPUS_I18N_MESSAGE_MISSING`;
   - `i18n_key` exact;
   - `locale` exact;
   - `module` exact;
4. event status is `warning`;
5. it is attached to the current page/request parent span where available;
6. the Web Profiler must therefore expose the same exact key and `status_counts.warning` must reflect measured missing translations.

`ApplicationTranslationRuntime` must receive the already-active `ProfilerInterface` from `OwasysScorePageRenderer`; it must not instantiate a second Profiler or write profiler JSONL directly.

## Remaining defect 2 — warnings are diagnostics, not translations

The visible key is a diagnostic safety net only. The required end state remains: normal UI labels resolve to real translated strings for every configured exact locale.

The 42 keys observed in the fresh run are the first measured catalog-completeness set. The next catalog-completeness phase must use the exact locale catalogs declared by `sites/owasys-front/config/site.json`, without silent language substitution or hidden fallback.

## Scope ordering

R8B7P first closes the Profiler/log correlation defect on the current R8B7O baseline. Catalog population follows from the measured exact-key inventory, with no removal of the diagnostic fallback.

## Non-regression

- UI keeps `⚠ <exact key>` for genuinely unresolved translations.
- Logger keeps exact `i18n_key`, locale, module and trace id.
- No REST, Composer, ACL/SSO or backend behavior changes.
- No direct profiler-store writes.
- No silent fallback.
