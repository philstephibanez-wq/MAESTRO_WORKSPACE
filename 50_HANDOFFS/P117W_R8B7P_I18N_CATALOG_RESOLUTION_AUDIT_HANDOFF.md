# P117W R8B7P — I18N CATALOG RESOLUTION AUDIT HANDOFF

Status: AUDIT COMPLETE — IMPLEMENTATION PENDING

## Authority

- OPUS audited baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md`, and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` remain authoritative.
- R8B7O/R8B7N are rejected and must not be applied.

## Deterministic root cause

OWASYS selects regional locales, while OPUS I18n currently loads only an exact-locale catalog. The repository nevertheless models regional files as overlays (`inherits: <base>`) and stores some human UI catalogs, notably `application/menu/local`, only at base-language level. The declared inheritance policy is not implemented by `Opus/I18n/CatalogLoader.php` / `ApplicationTranslationRuntime.php`.

Therefore menu operation translations are unreachable for the selectable regional locale set. The anonymous warning triangles are a downstream masking defect caused by the OWASYS-local duplicate `Opus\I18n\ApplicationTranslationRuntime`, which catches the missing-message exception and returns only `⚠`.

## Successor implementation scope

The next code candidate must be a generic OPUS I18n correction first, with OWASYS cleanup only where required to remove the duplicate runtime authority. It must include an automated matrix gate covering all 38 selectable regional locales and every expected menu resource/operation key.

Required missing-message observability after full catalog-chain resolution:

- UI: `⚠ <exact.i18n.key>`;
- structured Logger event with exact key, locale, module/scope and trace ID;
- OPUS Profiler warning with the same exact key and trace ID.

## Owner workflow state

No owner command is required for this audit itself. No R8B7P ZIP has been declared ready yet. The next ZIP must not be emitted until the generic inheritance implementation and exhaustive matrix validation are completed against the audited GitHub baseline.
