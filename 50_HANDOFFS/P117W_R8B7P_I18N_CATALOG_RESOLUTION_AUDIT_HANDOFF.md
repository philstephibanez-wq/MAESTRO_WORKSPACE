# P117W R8B7P — I18N CATALOG RESOLUTION DELIVERY HANDOFF

Status: READY FOR OWNER PREFLIGHT / APPLY

## Authority

- OPUS audited baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md`, and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` remain authoritative.
- R8B7O/R8B7N are rejected and must not be applied.

## Delivery

Native ZIP: `R8B7P.zip`

SHA-256:
`61f4e925f8b684cae2f9d5dfb3b1d0f8ca9919baef377f34a9b400b1d68b2ced`

Complete files in archive:

1. `Opus/I18n/CatalogLoader.php`
2. `Opus/I18n/Translator.php`
3. `Opus/I18n/ApplicationTranslationRuntime.php`
4. `sites/owasys-front/application/default/bootstrap.php`
5. `sites/owasys-front/application/registry/templates/index.score`
6. `sites/owasys-front/www/asset/themes/owasys/css/theme.css`

## Required cleanup after apply

The obsolete OWASYS-local framework shadow must be removed after ZIP extraction:

`sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php`

The replacement is now the generic OPUS runtime. The bootstrap no longer preloads the local duplicate.

## Functional target

- regional default catalogs compose their explicit base-language inheritance;
- regional module requests can resolve existing base-language module catalogs such as `application/menu/local/<language>.json`;
- regional override wins over inherited base value;
- normal `menu.operation.*` dropdown labels translate instead of anonymous triangles;
- a genuinely unresolved message after full chain renders `⚠ <exact.i18n.key>`;
- same unresolved key is written to structured Logger and OPUS Profiler with locale/module and the active trace ID;
- Applications view keeps OWASYS core front/back side-by-side and generated applications in a connected row below.

## Pre-delivery checks completed

- authoritative GitHub baseline blobs verified for the generic I18n files and OWASYS bootstrap;
- four changed PHP files lint successfully in build environment;
- SCORE directive balance verified;
- ZIP member list and byte read-back verified;
- final SHA-256 verified.

## Stepwise owner state

Because local OPUS state is not currently known, the next owner action is preflight only. Expected HEAD is `ec3586496acdac83f155a248c46013e3001cbef4`. Any unexpected HEAD or dirty path is a stop condition. After a clean preflight, the next step is rooted ZIP extraction, deliberate deletion of the obsolete local runtime shadow, syntax/diff/site validation, then runtime/I18n trace validation. No commit/push occurs before runtime acceptance.
