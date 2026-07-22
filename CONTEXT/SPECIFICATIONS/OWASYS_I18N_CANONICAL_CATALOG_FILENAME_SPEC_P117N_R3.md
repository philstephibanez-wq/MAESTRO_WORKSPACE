# OWASYS P117N-R3 — CANONICAL I18N CATALOG FILENAME SPECIFICATION

## 1. Supersession

This specification supersedes P117N-R2 wherever catalog names differ.

The only valid filename contract is:

`<locale>.<extension>`

Examples:

- `bg-BG.json`;
- `fr.json`;
- `fr-BE.json`;
- `de-CH.yaml`;
- `uk-UA.xml`.

Forbidden:

- any catalog-name prefix;
- underscore filename aliases such as `fr_BE.json`;
- duplicate names for one locale and scope;
- PHP dictionaries after migration.

## 2. Structured-file pipeline

Catalog and configuration bytes are read through `Opus\File\File` and parsed through the extension-selected OPUS parser:

- `.json` -> `Opus\File\Json`;
- `.yaml` / `.yml` -> `Opus\File\Yaml`;
- `.xml` -> `Opus\File\Xml`.

`CatalogLoader` discovers only the canonical BCP47 locale value followed by the selected extension.

## 3. Application scopes

Required paths:

- `sites/owasys/application/default/local/<locale>.json`;
- `sites/owasys/application/login/local/<locale>.json`;
- `sites/owasys/application/account/local/<locale>.json`;
- `sites/owasys/application/registry/local/<locale>.json`.

All files are application runtime source files and must be versioned.

## 4. Locale matrix

Base locales, exactly 25:

`bg`, `hr`, `cs`, `da`, `nl`, `en`, `et`, `fi`, `fr`, `de`, `el`, `hu`, `ga`, `it`, `lv`, `lt`, `mt`, `pl`, `pt`, `ro`, `sk`, `sl`, `es`, `sv`, `uk`.

Regional locales, exactly 37:

`bg-BG`, `hr-HR`, `cs-CZ`, `da-DK`, `nl-NL`, `nl-BE`, `en-IE`, `en-MT`, `et-EE`, `fi-FI`, `fr-FR`, `fr-BE`, `fr-LU`, `fr-CH`, `de-DE`, `de-AT`, `de-BE`, `de-LU`, `de-CH`, `el-GR`, `el-CY`, `hu-HU`, `ga-IE`, `it-IT`, `it-CH`, `lv-LV`, `lt-LT`, `mt-MT`, `pl-PL`, `pt-PT`, `ro-RO`, `sk-SK`, `sl-SI`, `es-ES`, `sv-SE`, `sv-FI`, `uk-UA`.

Total: 62 locales.

## 5. Regional overlay contract

A regional catalog is explicit and versioned. It declares its own locale and scope and may initially contain an empty `messages` object.

Example `fr-BE.json`:

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

Runtime resolution loads the base-language catalog first, then overlays the exact regional catalog. This is an explicit locale fallback chain, not a silent language fallback.

## 6. Browser negotiation

When the route has no explicit supported locale, OWASYS resolves `Accept-Language` through `BrowserLocaleNegotiator`.

Required examples:

- `fr-BE,fr;q=0.9` -> `fr-BE`;
- `de-CH,de;q=0.9` -> `de-CH`;
- `uk-UA,uk;q=0.9` -> `uk-UA`;
- `sv-FI,sv;q=0.9` -> `sv-FI`;
- `fr-CA,fr;q=0.9` -> `fr`.

`fr-CA` is not an OWASYS locale.

An explicit unsupported locale-looking URL segment returns 404.

## 7. SCORE-only application rendering

Visible and accessibility strings are selected by SCORE i18n directives.

Forbidden application patterns:

- UI-producing `echo`;
- HTML/PHP mixed views;
- controller dictionary loading;
- translation fallback returning the key;
- pretranslated error strings in the ViewModel;
- pretranslated Registry button labels.

Controllers expose state, booleans and domain data. SCORE selects static translation keys.

## 8. FSM, i18n, ACL and SSO

The request pipeline remains:

request -> locale negotiation -> SSO identity -> deny-by-default ACL -> FSM transition -> ViewModel -> SCORE.

Locale resolution must not bypass FSM, ACL or SSO.

Auth0 proxy and bastion providers remain separate SSO-provider implementations and must not introduce application-local security fallbacks.

## 9. OPUS component contract

`CatalogLoader` remains a concrete OPUS framework class implementing its homonymous interface.

Every concrete OPUS framework class must implement a homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The P117M-R1 exhaustive contractual audit remains mandatory.

## 10. Validation gates

Before commit:

- exactly 62 canonical JSON files per scope;
- exactly 248 catalogs total;
- filenames equal the configured locale list plus `.json`;
- no catalog-name prefix;
- no underscore filename alias;
- no PHP dictionary;
- 25 complete base catalogs per scope;
- base-key parity per scope;
- 37 valid regional overlays per scope;
- runtime merge test for a regional locale;
- browser negotiation tests;
- locale name and flag resolution;
- PHP lint;
- P117M-R1 contractual audit;
- `git diff --check`;
- target-browser verification.

The 248 new catalogs must be staged with `git add -A`.
