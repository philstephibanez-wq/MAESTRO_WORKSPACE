# P114D1 — ASAP RefBook documentation I18N REST lang provider

## Scope

This patch belongs to the ASAP repository, not ASAP_REF_BOOK.

It adds the first ASAP-owned documentation I18N layer for RefBook reflection metadata.

## Contract

- REST URL carries language explicitly:
  - `GET /api/refbook/{lang}/snapshot`
  - `GET /api/refbook/{lang}/symbols`
  - `GET /api/refbook/{lang}/symbols/{id}`
- supported languages:
  - `fr`, `en`, `es`, `de`, `uk`, `it`, `pl`, `cs`
- missing translation is an explicit error:
  - `ASAP_REFBOOK_DOC_TRANSLATION_MISSING`
- unsupported language is an explicit error:
  - `ASAP_REFBOOK_DOC_LANG_UNSUPPORTED`
- no silent fallback to English for non-English documentation.

## Added files

- `framework/Asap/RefBook/I18n/RefBookDocumentationLocale.php`
- `framework/Asap/RefBook/I18n/RefBookDocumentationTranslationMissingException.php`
- `framework/Asap/RefBook/I18n/RefBookDocumentationI18nCatalog.php`
- `framework/Asap/RefBook/Api/LocalizedRefBookDocumentationProvider.php`
- `framework/Asap/RefBook/Api/RefBookDocumentationI18nRestRouter.php`
- `tools/smoke/p114d1_refbook_doc_i18n_rest_lang_provider_smoke.php`

## Next step

RefBook must stop translating ASAP source descriptions itself and consume the localized ASAP documentation ViewModel.
