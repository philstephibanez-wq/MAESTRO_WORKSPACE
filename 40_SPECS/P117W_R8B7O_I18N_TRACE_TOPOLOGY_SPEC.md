# P117W R8B7O — I18N TRACE + APPLICATION TOPOLOGY SPEC

Status: REJECTED — SUPERSEDED BY R8B7P

R8B7O is retained for traceability only and MUST NOT be applied.

The diagnosis was incomplete: removing the OWASYS-local missing-message marker and adding diagnostics would improve observability, but would not repair the systematic menu translation failure.

Fresh exhaustive source audit on OPUS GitHub baseline `ec3586496acdac83f155a248c46013e3001cbef4` established the deeper root cause:

1. `config/site.json` declares regional overlays and base-language inheritance (`regional_overlay_policy`, `language_defaults`, `catalog_base_locales`).
2. Regional catalogs themselves declare `inherits`, e.g. `de-DE.json` -> `de`.
3. Generic `Opus/I18n/CatalogLoader.php` loads only the exact active locale file and does not resolve `inherits` or a base-language parent.
4. OWASYS exposes regional locales only.
5. `application/menu/local` contains base-language catalogs only, while the menu runtime is instantiated with a regional active locale.
6. Consequently the menu operation keys cannot resolve for any selectable regional locale through the current runtime path.
7. The OWASYS-local `Opus\I18n\ApplicationTranslationRuntime` then converts each missing key into a lone `⚠`, hiding the key and preventing the existing exception context from reaching structured diagnostics.

Active exhaustive audit/specification:

`40_SPECS/P117W_R8B7P_I18N_CATALOG_RESOLUTION_AUDIT_SPEC.md`
