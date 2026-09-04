# P117W R8B7O — MODULE I18N REGIONAL INHERITANCE SPEC

Status: DELIVERY CANDIDATE

## Authority

- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` are authoritative.
- OPUS GitHub baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- R8B7O complements the diagnostic/topology work of R8B7N; it addresses the remaining translation-resolution root cause exposed by the owner runtime evidence.

## Runtime evidence

Fresh owner screenshots show exact missing-I18n diagnostics such as `menu.operation.create`, `menu.operation.read`, `menu.operation.update`, `menu.operation.delete`, `menu.operation.validate`, `menu.operation.run` and `menu.operation.export` while the active locale is `en-EN`.

Fresh front logs and profiler traces already carry the exact missing key, active locale, module and `trace_id`, so the diagnostic requirement is functioning. The remaining defect is that the translated module catalog is not being selected.

GitHub baseline evidence:

- `sites/owasys-front/application/menu/local/en.json` already contains the English translations for the missing `menu.operation.*` keys.
- `Opus/I18n/CatalogLoader.php` resolves only `<exact-locale>.<ext>`; for active `en-EN`, optional module catalog lookup therefore misses `menu/local/en.json` and returns no module catalog.
- Required/global catalogs must remain exact-locale only.

## Root cause

Optional module catalogs are stored by base language (`en.json`, `fr.json`, `de.json`, etc.) while the active public locale is regional (`en-EN`, `fr-FR`, `de-DE`, etc.). `CatalogLoader` V4 performs exact-only lookup for every catalog, so `ApplicationTranslationRuntime` silently omits an otherwise valid translated module catalog whenever no exact regional module file exists.

The UI then correctly exposes `⚠ <exact key>` and the logger/profiler correctly record the missing key, but the translation should never have been missing.

## Generic OPUS correction

Evolve `Opus\\I18n\\CatalogLoader` to V5:

1. exact regional catalog always wins;
2. required/global catalogs remain exact-locale only;
3. optional module catalogs may resolve the base-language catalog only when no exact regional catalog exists;
4. the loaded base-language catalog is rebound to the active regional `Locale` so `CatalogStack` retains one canonical active locale;
5. direct `loadFile()` remains strict and does not accept locale substitution;
6. ambiguity across structured formats remains a blocking exception.

Examples:

- active `en-EN`, optional module `menu`: `en-EN.*` absent -> resolve `en.*`;
- active `fr-BE`, optional module `source`: `fr-BE.*` absent -> resolve `fr.*`;
- active `en-EN`, required/global default catalog: `en-EN.*` remains mandatory; no fallback to `en.*`;
- if an exact regional optional module catalog exists, it is used and the base file is ignored.

## Scope

Changed file only:

- `Opus/I18n/CatalogLoader.php`

No change to OWASYS SCORE, REST, backend, FSM, ACL/SSO, logger, profiler, route configuration or locale catalogs.

## Baseline and delivery

Authoritative baseline blob:

`Opus/I18n/CatalogLoader.php` = `dd54709c65a340fc97dd8cea9fa7c564e9594686`

Native ZIP:

`R8B7O.zip`

SHA-256:

`f70e919a790effdc0ee8a7274d08fb706b76c3361cfddc5bee4d9a625762fed9`

The ZIP contains exactly one complete file at its final path.

## Pre-delivery validation

- baseline reconstructed byte-for-byte and Git blob matched;
- patched PHP lint passed;
- archive member list/read-back passed;
- archive SHA-256 verified after creation;
- correction is generic OPUS and does not introduce application-local fallback code.

## Owner acceptance

After apply:

- `git diff --check` passes;
- `php -l Opus\\I18n\\CatalogLoader.php` passes;
- `composer opus:validate-site -- owasys-front` passes;
- reloading `en-EN` menus resolves the existing `menu.operation.*` translations from the English module catalog instead of showing `⚠` diagnostics;
- other regional locales continue to resolve exact global catalogs and base-language optional module catalogs;
- no regression to the existing I18n logger/profiler key + locale + module + trace_id diagnostics when a genuinely unknown key is requested.
