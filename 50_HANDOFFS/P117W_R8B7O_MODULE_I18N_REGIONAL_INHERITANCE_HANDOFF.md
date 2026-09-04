# P117W R8B7O — MODULE I18N REGIONAL INHERITANCE HANDOFF

Status: READY FOR OWNER APPLY / VALIDATE

## Authority

- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md`, `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` authoritative.
- OPUS remote baseline used to build the differential: `ec3586496acdac83f155a248c46013e3001cbef4`.
- R8B7O complements R8B7N; it does not replace the already observed diagnostic behavior.

## Fresh evidence interpreted

The owner runtime evidence on 2026-09-04 shows that diagnostics now expose the exact missing keys in the UI and that the front logger/profiler records `error_code`, `i18n_key`, `locale`, `module` and correlated `trace_id`.

Example missing keys observed for `en-EN`: `menu.operation.create`, `menu.operation.read`, `menu.operation.update`, `menu.operation.delete`, `menu.operation.validate`, `menu.operation.run`, `menu.operation.export`.

The authoritative GitHub base module catalog `sites/owasys-front/application/menu/local/en.json` already contains translations for those keys. The root cause is therefore module-catalog resolution, not missing English translation content.

## Delivery

Native ZIP: `R8B7O.zip`

SHA-256:
`f70e919a790effdc0ee8a7274d08fb706b76c3361cfddc5bee4d9a625762fed9`

Complete file in archive:

- `Opus/I18n/CatalogLoader.php`

## Intended result

- exact regional catalog remains first choice;
- required/global catalogs stay exact-locale only;
- optional module catalogs can inherit their translated base-language file when no exact regional file exists;
- active locale identity remains regional in the resulting `Catalog`;
- direct `loadFile()` remains strict;
- existing missing-key UI/log/profiler diagnostics remain available for genuinely absent keys.

## Owner step

Apply only after verifying the current local state. R8B7O touches only `Opus/I18n/CatalogLoader.php`, so it is intentionally isolated from the current SCORE/theme/Translator work.

Run the supplied CMD block in the chat. Stop on unexpected HEAD, an unexpected pre-existing modification to `Opus/I18n/CatalogLoader.php`, SHA mismatch, archive mismatch, lint failure, site validation failure or runtime regression.

## Runtime acceptance

Reload an `en-EN` page containing module operation menus. The `menu.operation.*` labels must render as normal translated English text, not `⚠ menu.operation.*`.

Then inspect the fresh front log/profiler only if a warning remains: any genuine missing key must still include exact `i18n_key`, locale, module and trace correlation.

No commit/push before runtime acceptance.
