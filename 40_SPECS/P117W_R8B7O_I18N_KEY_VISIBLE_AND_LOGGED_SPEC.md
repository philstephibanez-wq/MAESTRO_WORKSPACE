# P117W R8B7O — I18N KEY VISIBLE + LOGGED SPEC

Status: DELIVERY CANDIDATE

## Authority

- README-FIRST.md, PATCH_DELIVERY_CONTRACT.md and CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md are authoritative.
- OPUS GitHub baseline: `ec3586496acdac83f155a248c46013e3001cbef4`.

## Fresh runtime evidence

Fresh owner runtime evidence from 2026-09-03 22:39 shows `/en-EN/applications` completes HTTP 200 while anonymous I18n warning triangles remain visible. The corresponding front log contains no `OPUS_I18N_MESSAGE_MISSING` entry for that successful request, and the profiler trace reports no I18n warning/error event.

## Root cause

`sites/owasys-front/application/default/bootstrap.php` deliberately loads the OWASYS-local class `sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php` before consumers instantiate `Opus\\I18n\\ApplicationTranslationRuntime`.

That local runtime catches `OPUS_I18N_MESSAGE_MISSING` and returns only `⚠`, thereby:

1. discarding the exact missing key from the UI;
2. swallowing the exception before the application-level error logger can observe it;
3. producing anonymous warning controls throughout Applications/Data sources/Navigation.

## R8B7O correction

The active OWASYS translation runtime keeps strict active-locale lookup and catches only `OPUS_I18N_MESSAGE_MISSING`, but now:

- returns exactly `⚠ <exact.i18n.key>`;
- emits a structured warning to the existing application log with channel `opus.i18n`, message `translation.missing`, and context fields `error_code`, `i18n_key`, `locale`, `module`;
- propagates the active `OPUS_TRACE_ID` into that log record;
- rethrows every other TranslationException unchanged.

The log filename is derived from the application site root (`owasys-front.log` for `sites/owasys-front`), preserving the established OWASYS front log location.

## Scope

Changed file only:

- `sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php`

No REST, backend, FSM, ACL, SCORE template, theme, registry model or Composer command changes.

## Acceptance

- Any unresolved SCORE I18n key visibly renders `⚠ <exact key>` rather than a lone triangle.
- The same occurrence emits a warning record in `sites/owasys-front/var/logs/owasys-front.log` containing the exact `i18n_key`, `locale`, `module`, and correlated `trace_id`.
- Existing valid translations render unchanged.
- Non-missing TranslationException failures remain failures.
- ZIP SHA-256: `baf3f173d7192ab8d24ad6fe20e7a93f0f5f50bc8e6baa578618bd53c9dc51dd`.
