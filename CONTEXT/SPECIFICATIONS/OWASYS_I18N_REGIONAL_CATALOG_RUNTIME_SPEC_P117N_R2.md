# OWASYS P117N-R2 — REGIONAL I18N CATALOG RUNTIME SPECIFICATION

## 1. Purpose

This specification corrects the P117N catalog-delivery defect and defines the OWASYS locale matrix, catalog ownership, browser negotiation and structured-file runtime rules.

## 2. Runtime catalogs are source files

OWASYS i18n catalogs are application-owned runtime source files. They are not disposable migration artifacts, local cache files or generated deployment state.

Every required catalog must be present in the differential ZIP and versioned in the OPUS repository after application.

Deleting PHP catalogs is permitted only when the replacement JSON catalogs are already present and validated.

## 3. Catalog scopes

Required scopes:

- `default`;
- `login`;
- `account`;
- `registry`.

Required paths:

- `sites/owasys/application/default/local/asap.<locale>.json`;
- `sites/owasys/application/login/local/asap.<locale>.json`;
- `sites/owasys/application/account/local/asap.<locale>.json`;
- `sites/owasys/application/registry/local/asap.<locale>.json`.

No PHP catalog is allowed after migration.

## 4. JSON catalog contract

Base catalog document:

```json
{
  "contract": "OPUS_I18N_CATALOG_V2",
  "locale": "fr",
  "scope": "default",
  "messages": {},
  "plurals": {},
  "grammatical": {}
}
```

Regional overlay document:

```json
{
  "contract": "OPUS_I18N_CATALOG_V2",
  "locale": "fr-BE",
  "scope": "default",
  "inherits": "fr",
  "messages": {},
  "plurals": {},
  "grammatical": {}
}
```

`inherits` documents the intended base language. Runtime inheritance is implemented by the canonical `Locale::fallbackChain()` and `CatalogLoader` merge order; it is not a silent fallback.

## 5. Locale matrix

### 5.1 Base locales

Exactly 25 base locales are required:

`bg`, `hr`, `cs`, `da`, `nl`, `en`, `et`, `fi`, `fr`, `de`, `el`, `hu`, `ga`, `it`, `lv`, `lt`, `mt`, `pl`, `pt`, `ro`, `sk`, `sl`, `es`, `sv`, `uk`.

### 5.2 Regional locales

Exactly 37 regional locales are required:

`bg-BG`, `hr-HR`, `cs-CZ`, `da-DK`, `nl-NL`, `nl-BE`, `en-IE`, `en-MT`, `et-EE`, `fi-FI`, `fr-FR`, `fr-BE`, `fr-LU`, `fr-CH`, `de-DE`, `de-AT`, `de-BE`, `de-LU`, `de-CH`, `el-GR`, `el-CY`, `hu-HU`, `ga-IE`, `it-IT`, `it-CH`, `lv-LV`, `lt-LT`, `mt-MT`, `pl-PL`, `pt-PT`, `ro-RO`, `sk-SK`, `sl-SI`, `es-ES`, `sv-SE`, `sv-FI`, `uk-UA`.

Total: 62 configured locales.

This matrix preserves the established 24 official EU languages plus Ukrainian and adds country-specific variants for EU member states, Switzerland and Ukraine. Switzerland is represented by `de-CH`, `fr-CH` and `it-CH`, consistent with the existing OPUS language set.

`fr-CA` is not part of the OWASYS matrix.

## 6. Regional overlay behavior

For `fr-BE`, catalog resolution is:

1. load `fr` base catalog;
2. overlay `fr-BE` catalog.

The same rule applies to every regional locale. A regional overlay may initially contain no messages. It remains mandatory and versioned so that future country-specific vocabulary can be added without changing routing or configuration.

A regional locale with no base catalog is invalid for this matrix.

## 7. Browser negotiation

When no explicit supported locale appears in the route, OWASYS negotiates `Accept-Language` using `BrowserLocaleNegotiator`.

Required behavior:

- exact supported regional locale first;
- supported parent locale next;
- configured same-language locale next;
- explicit application default last;
- respect `q` weights;
- ignore `q=0`;
- wildcard selects explicit application default;
- no silent English fallback;
- no translation-key fallback.

An explicit URL segment that syntactically looks like a regional locale but is unsupported returns 404.

## 8. Native names and flags

Every configured locale must resolve to:

- a non-empty native display name;
- an existing SVG flag asset.

Base locales retain their established language-country flags. Regional locales use the corresponding country flag.

The locale selector remains SCORE-rendered and must support scrolling for the 62-entry matrix.

## 9. Structured-file boundary

Configuration and catalog bytes are read through `Opus\File\File` and parsed through `StructuredFileLoader`.

Parser selection remains extension-driven:

- JSON -> `Opus\File\Json`;
- YAML/YML -> `Opus\File\Yaml`;
- XML -> `Opus\File\Xml`.

Corrected OWASYS controller and SCORE renderer code must not call `file_get_contents()` for site, routes or FSM configuration.

## 10. SCORE-only visible errors

Controllers expose state and booleans, not translated visible error strings.

Required ViewModel flags include:

- `auth.error_required_credentials`;
- `auth.error_invalid_credentials`;
- `auth.error_password_mismatch`;
- `auth.error_password_too_short`;
- `auth.error_current_password_invalid`;
- `auth.error_password_unchanged`;
- `auth.error_runtime_user_missing`;
- Registry error booleans already defined by P117N.

SCORE templates select the corresponding static `[[ i18n: ... ]]` directive.

Forbidden:

- `{{ auth.error }}`;
- `{{ registry.error }}`;
- `{{ entry.button_label }}`;
- UI-producing `echo`;
- mixed HTML/PHP views;
- `loadMessages()`;
- `viewLabels()`;
- `return $key` translation fallback.

## 11. FSM, ACL and SSO

The request pipeline remains:

request -> locale negotiation -> SSO identity -> deny-by-default ACL -> FSM transition -> ViewModel -> SCORE.

Locale selection does not bypass authentication, authorization or FSM state resolution.

Auth0 proxy and bastion implementations remain separate SSO-provider work. They must not be implemented as OWASYS-local authentication fallbacks and must not store secrets in Git.

## 12. OPUS component contract

P117N-R2 adds no new concrete OPUS framework class.

Any future concrete framework class must implement a homonymous interface extending all four markers:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The exhaustive P117M-R1 audit remains a release gate.

## 13. Required validation

Before commit:

- 62 locales in `site.json` in canonical order;
- 62 JSON catalogs in each scope;
- 248 JSON catalogs total;
- 25 complete base catalogs per scope;
- strict base-key parity per scope;
- 37 valid regional overlays per scope;
- successful construction of module-aware translation runtime for all 62 locales;
- browser negotiation tests for Belgium, Switzerland, Ukraine, Finland Swedish and unsupported `fr-CA` fallback to `fr`;
- all locale names and flags resolvable;
- no PHP catalogs;
- no direct file read in corrected application configuration consumers;
- no controller-side visible error translation;
- PHP lint;
- P117M-R1 component-contract audit;
- `git diff --check`;
- browser verification on the target Windows runtime.

## 14. Git staging rule

The 248 catalogs are new untracked runtime files. The user must stage them with `git add -A`, not only `git add -u`. A commit that contains PHP catalog deletions without the replacement JSON files is invalid.
