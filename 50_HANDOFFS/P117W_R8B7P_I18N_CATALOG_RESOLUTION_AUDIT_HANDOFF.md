# P117W R8B7P — I18N CATALOG RESOLUTION DELIVERY HANDOFF

Status: READY FOR OWNER PREFLIGHT / APPLY

## Authority

- OPUS audited baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md`, and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` remain authoritative.
- R8B7O/R8B7N are rejected and must not be applied.

## Delivery

Native ZIP: `R8B7P.zip`

SHA-256:
`933fee5e50c44c11be65e202a4b26646b77d7213f3f777c75a154372276510b9`

Complete files in archive:

1. `Opus/I18n/CatalogLoader.php`
2. `Opus/I18n/ApplicationTranslationRuntime.php`
3. `sites/owasys-front/application/default/bootstrap.php`
4. `sites/owasys-front/application/default/services/ScorePageRenderer.php`
5. `sites/owasys-front/application/registry/templates/index.score`
6. `sites/owasys-front/www/asset/themes/owasys/css/theme.css`

## Required cleanup after apply

The obsolete OWASYS-local framework shadow must be removed after ZIP extraction:

`sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php`

The generic OPUS runtime becomes authoritative. Bootstrap no longer preloads the local duplicate.

## Functional target

- regional default catalogs compose explicit base-language inheritance;
- regional module requests resolve existing base-language module catalogs such as `application/menu/local/<language>.json`;
- regional override wins over inherited base value;
- normal `menu.operation.*` dropdown labels translate instead of anonymous triangles;
- a genuinely unresolved message after the complete chain renders `⚠ <exact.i18n.key>`;
- the same unresolved key is emitted to structured Logger and OPUS Profiler with `error_code`, exact `i18n_key`, locale, module and active trace ID;
- the Profiler I18n panel receives the warning through the generic `i18n` category;
- Applications view keeps OWASYS CORE front/back side-by-side and generated applications in a connected row below.

## Pre-delivery checks completed

- authoritative GitHub baseline blobs verified for all four modified PHP sources and the Applications presentation baselines;
- four changed PHP files lint successfully in the build environment;
- catalog resolver fixture passed exact regional inheritance, base-module resolution, child override, missing-key and cycle gates;
- diagnostic fixture passed visible key + Logger + Profiler duplication with trace context and non-missing error propagation;
- SCORE directive balance verified: 21/21 `if`, 2/2 `foreach`;
- ZIP member list and byte read-back verified;
- final ZIP SHA-256 verified: `933fee5e50c44c11be65e202a4b26646b77d7213f3f777c75a154372276510b9`.

## Stepwise owner state

Local OPUS state is not known after the previous uncommitted presentation attempts. Therefore the next owner action is the contractual preflight and archive verification only.

Expected HEAD: `ec3586496acdac83f155a248c46013e3001cbef4`.

Any unexpected HEAD or dirty path other than a known superseded Applications presentation file is a stop condition. After the preflight passes, the next owner step is rooted extraction to `H:\OPUS`, deliberate deletion of the obsolete local runtime shadow, syntax/diff/site validation, then runtime/I18n trace validation. No commit/push occurs before runtime acceptance.
