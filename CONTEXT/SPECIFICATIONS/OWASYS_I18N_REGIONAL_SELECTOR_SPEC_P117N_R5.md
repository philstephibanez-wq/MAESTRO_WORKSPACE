# OWASYS P117N-R5 — REGIONAL-ONLY LOCALE SELECTOR SPECIFICATION

## 1. Normative status

This specification is normative for the OWASYS locale selector and supersedes P117N-R3/R4 statements that expose base locales as selectable entries.

## 2. Separation of selectable locales and catalog parents

OWASYS distinguishes:

- selectable regional locales;
- hidden base-language catalog parents.

A base catalog such as `fr.json` exists only to provide shared French messages. It is not an option in the locale selector.

A selectable locale such as `fr-FR` loads:

1. `fr.json`;
2. `fr-FR.json`.

This is explicit catalog inheritance, not a silent language fallback.

## 3. Selector matrix

Exactly 37 locales are selectable:

`bg-BG`, `hr-HR`, `cs-CZ`, `da-DK`, `nl-NL`, `nl-BE`, `en-IE`, `en-MT`, `et-EE`, `fi-FI`, `fr-FR`, `fr-BE`, `fr-LU`, `fr-CH`, `de-DE`, `de-AT`, `de-BE`, `de-LU`, `de-CH`, `el-GR`, `el-CY`, `hu-HU`, `ga-IE`, `it-IT`, `it-CH`, `lv-LV`, `lt-LT`, `mt-MT`, `pl-PL`, `pt-PT`, `ro-RO`, `sk-SK`, `sl-SI`, `es-ES`, `sv-SE`, `sv-FI`, `uk-UA`.

No regionless locale may occur in `site.json.locales`.

## 4. Hidden base catalogs

Exactly 25 regionless base catalogs remain required in every scope:

`bg`, `hr`, `cs`, `da`, `nl`, `en`, `et`, `fi`, `fr`, `de`, `el`, `hu`, `ga`, `it`, `lv`, `lt`, `mt`, `pl`, `pt`, `ro`, `sk`, `sl`, `es`, `sv`, `uk`.

They are declared in `i18n.catalog_base_locales` and `i18n.catalog_base_locales_visible` must be `false`.

## 5. Language-default mapping

`i18n.language_defaults` is mandatory and contains exactly:

- `bg` -> `bg-BG`;
- `hr` -> `hr-HR`;
- `cs` -> `cs-CZ`;
- `da` -> `da-DK`;
- `nl` -> `nl-NL`;
- `en` -> `en-IE`;
- `et` -> `et-EE`;
- `fi` -> `fi-FI`;
- `fr` -> `fr-FR`;
- `de` -> `de-DE`;
- `el` -> `el-GR`;
- `hu` -> `hu-HU`;
- `ga` -> `ga-IE`;
- `it` -> `it-IT`;
- `lv` -> `lv-LV`;
- `lt` -> `lt-LT`;
- `mt` -> `mt-MT`;
- `pl` -> `pl-PL`;
- `pt` -> `pt-PT`;
- `ro` -> `ro-RO`;
- `sk` -> `sk-SK`;
- `sl` -> `sl-SI`;
- `es` -> `es-ES`;
- `sv` -> `sv-SE`;
- `uk` -> `uk-UA`.

The first configured regional locale of each language must equal this mapping.

## 6. Default locale

The application default and explicit fallback locale are both `fr-FR`.

A browser or URL requesting bare `fr` resolves to `fr-FR`.

## 7. URL locale resolution

URL locale resolution is stricter than browser negotiation.

Accepted URL locale forms:

- exact configured regional locale;
- bare configured language alias resolved through `language_defaults`.

Rejected URL locale forms:

- unsupported explicit regional locale;
- unsupported script/region combination;
- locale outside the configured matrix.

Therefore:

- `/fr/applications` -> locale `fr-FR`;
- `/fr-FR/applications` -> locale `fr-FR`;
- `/fr-BE/applications` -> locale `fr-BE`;
- `/fr-CA/applications` -> HTTP 404 unsupported locale.

## 8. Browser negotiation

When no locale segment exists, `BrowserLocaleNegotiator` processes `Accept-Language` against the 37 selectable locales.

Examples:

- `fr` -> `fr-FR`;
- `de` -> `de-DE`;
- `en` -> `en-IE`;
- `fr-BE,fr;q=0.9` -> `fr-BE`;
- `fr-CA,fr;q=0.9` -> `fr-FR`;
- `sv-FI,sv;q=0.9` -> `sv-FI`.

This negotiated same-language resolution is allowed because no unsupported regional locale is written into the application URL.

## 9. Selector labels

The primary regional locale for each language uses the unqualified language label:

- `fr-FR` -> `Français`;
- `de-DE` -> `Deutsch`;
- `en-IE` -> `English`;
- `nl-NL` -> `Nederlands`;
- `sv-SE` -> `Svenska`.

Additional country variants use a native country qualifier:

- `fr-BE` -> `Français (Belgique)`;
- `fr-CH` -> `Français (Suisse)`;
- `de-AT` -> `Deutsch (Österreich)`;
- `de-CH` -> `Deutsch (Schweiz)`;
- `nl-BE` -> `Nederlands (België)`;
- `sv-FI` -> `Svenska (Finland)`.

A selector must never display both a regionless base entry and its primary regional entry.

## 10. Catalog filenames

The only valid catalog names are:

- `<locale>.json`;
- `<locale>.yaml`;
- `<locale>.yml`;
- `<locale>.xml`.

OWASYS currently selects JSON. Prefixes such as `asap.` are forbidden.

## 11. Required catalog inventory

Each of the four scopes contains:

- 25 hidden base catalogs;
- 37 regional overlays;
- 62 files total.

Across `default`, `login`, `account` and `registry`, the required total is 248 catalogs.

## 12. Configuration boundary

All application configuration is read through `Opus\File\File` and `StructuredFileLoader`. Parser selection is extension-driven through OPUS JSON, YAML/YML or XML parser classes.

Direct `file_get_contents()` reads in corrected OWASYS configuration consumers are forbidden.

## 13. FSM, i18n, ACL and SSO

The pipeline remains:

request -> locale resolution -> SSO -> ACL deny-by-default -> FSM event and transition -> ViewModel -> SCORE.

Locale aliases do not bypass route-to-signal mapping, FSM transitions, authentication or authorization.

All visible labels and errors remain SCORE/i18n driven. No UI-producing `echo` or HTML/PHP mixed view is allowed.

## 14. OPUS contracts

P117N-R5 adds no concrete framework class.

Every future concrete OPUS framework class must implement a homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The P117M-R1 exhaustive audit remains a mandatory release gate.

## 15. Validation gates

Required gates:

- exactly 37 selectable regional locales;
- no base locale in the selector configuration;
- exact 25-entry language-default mapping;
- default locale `fr-FR`;
- 248 canonical catalogs;
- no `asap.*` catalog;
- no PHP dictionary;
- base-key parity per scope;
- valid regional inheritance overlays;
- non-duplicated primary labels;
- explicit bare-language URL mapping;
- rejection of explicit unsupported regional URL tags;
- browser negotiation tests;
- route V2, FSM and ACL checks;
- PHP lint;
- P117M-R1 component-contract audit;
- `git diff --check`;
- target-browser verification.
