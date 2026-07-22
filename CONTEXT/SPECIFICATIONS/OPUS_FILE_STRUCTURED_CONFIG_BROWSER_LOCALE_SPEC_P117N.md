# OPUS P117N — FILE, STRUCTURED CONFIGURATION AND BROWSER LOCALE SPECIFICATION

## 1. Scope

This specification governs generic OPUS structured-file access and application internationalization. It applies to OPUS framework components and OPUS applications including OWASYS.

## 2. Canonical File boundary

`Opus\File\File` is the canonical singleton for local files.

Required behavior:

- bounded binary-safe reads;
- explicit unreadable/missing/oversized errors;
- atomic same-directory replacement;
- deletion through the File abstraction;
- deterministic file matching;
- no silent fallback.

Application and framework configuration consumers must not call `file_get_contents()` directly.

## 3. Parser separation

Reading bytes and parsing structured data are separate responsibilities.

Canonical parsers:

- `Opus\File\Json` for JSON;
- `Opus\File\Yaml` for YAML/YML;
- `Opus\File\Xml` for XML;
- `Opus\File\StructuredFileLoader` for extension-based parser selection.

The developer selects JSON, YAML or XML by selecting the configuration file extension. Unsupported extensions fail explicitly.

### 3.1 JSON

JSON parsing uses exception mode and requires an array root.

### 3.2 YAML

The built-in YAML parser is a safe configuration subset supporting mappings, sequences, indentation, quoted strings, booleans, null, numbers and JSON-compatible inline structures.

Forbidden constructs include executable tags, aliases, anchors, merge keys and block scalars.

### 3.3 XML

XML parsing requires PHP DOM. Parsing uses `LIBXML_NONET`. DTD and ENTITY declarations are forbidden. Configuration XML is converted to an array model; i18n catalogs use a dedicated `<catalog>` structure.

## 4. OPUS component contracts

Each new concrete OPUS class must implement its homonymous interface. The interface must extend all four mandatory markers:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

No concrete framework class may bypass this requirement.

## 5. Locale model

`Opus\I18n\Locale` accepts locale tags with hyphens or underscores and normalizes them to canonical BCP 47-style representation.

Examples:

- `fr` -> `fr`;
- `fr_CA` -> `fr-CA`;
- `pt_br` -> `pt-BR`;
- `zh_hant_tw` -> `zh-Hant-TW`.

The locale model exposes language, optional script, optional region, parent locale and a deterministic fallback chain.

## 6. Browser locale negotiation

`Opus\I18n\BrowserLocaleNegotiator` parses `Accept-Language`, including quality factors and declaration order.

Resolution order:

1. exact supported locale;
2. supported parent locale;
3. configured default when it has the requested language;
4. first supported locale with the requested language;
5. explicit application default.

Wildcard selects the explicit application default. Entries with `q=0` are ignored. Invalid language tags do not become application locales.

Applications must use browser negotiation only when no explicit supported locale exists in the route. An unsupported locale-looking URL segment is a 404 and must not silently become a route.

## 7. Catalog formats and names

Supported i18n catalog extensions:

- `.json`;
- `.yaml`;
- `.yml`;
- `.xml`.

Supported names include:

- `<locale>.<extension>`;
- `asap.<locale>.<extension>`.

Both hyphen and underscore locale spellings may be discovered, but the declared locale must normalize to the expected locale. More than one matching catalog for the same locale and scope is an explicit ambiguity error.

## 8. Catalog fallback

Catalog loading proceeds from the least specific locale to the most specific locale and overlays entries deterministically.

Example for `fr-CA`:

1. load `fr` when present;
2. overlay `fr-CA` when present.

A required catalog with no file in its fallback chain fails. There is no implicit English fallback. A missing translation key fails through the strict translation engine; it is never returned as visible fallback text.

## 9. Application catalog ownership

Every application has one required common catalog and optional module catalogs:

- `application/default/local` — common presentation vocabulary;
- `application/<fsm-module>/local` — module-specific vocabulary.

The FSM state module determines the module catalog loaded for the request. `application/default` is not a functional module.

OWASYS scope allocation:

- default — brand, common navigation, locale selector and shared context labels;
- login — authentication form and login errors;
- account — password-change form and errors;
- registry — Applications page and Registry events/errors.

## 10. SCORE rendering

Visible and accessibility strings are resolved through SCORE i18n directives. Controllers and ViewModel builders must not pretranslate display strings when a finite SCORE branch can select the key.

Forbidden patterns include:

- PHP/HTML mixed views;
- UI-producing `echo`;
- `return $key` translation fallback;
- callable dictionaries in the ViewModel;
- pretranslated Registry button labels and Registry error messages.

## 11. OWASYS default locale behavior

OWASYS declares 24 official EU languages plus Ukrainian. Its `site.json` defines:

- browser as the default locale source;
- `fr` as the explicit fallback locale;
- JSON as the selected application catalog format;
- JSON, YAML, YML and XML as framework-supported formats;
- regional variants enabled;
- silent fallback disabled.

Regional locales may be added to the supported locale list. The flag asset remains keyed by base language unless an application-specific regional flag policy is introduced explicitly.

## 12. FSM, ACL and SSO

Locale resolution does not bypass authentication or authorization. The request pipeline remains:

request -> locale resolution -> SSO identity -> ACL decision -> FSM transition -> ViewModel -> SCORE.

OWASYS configuration reads controlled by this milestone use the OPUS structured File boundary for site configuration, ACL, SSO, Registry seed/site discovery and i18n catalogs.

Auth0 proxy and bastion provider implementations are outside this i18n/File milestone. They must be added behind OPUS SSO provider interfaces without weakening ACL or FSM gates and without storing credentials in Git.

## 13. Migration and transaction

The OWASYS migration utility:

- reads the 25 legacy PHP dictionaries only as migration sources;
- separates default/login/account/registry ownership;
- validates key parity before writing;
- generates 100 ASAP JSON catalogs;
- patches the legacy RuntimeController translation path;
- audits the result after writes;
- restores all touched files if the write or audit phase fails.

Legacy PHP dictionaries are deleted only after the successful audit, using separately supplied CMD commands.

## 14. Validation gates

Required installation gates:

- Composer autoload regeneration;
- migration apply;
- migration audit;
- P117M exhaustive OPUS component-contract audit;
- PHP lint for framework and OWASYS application PHP;
- `git diff --check`;
- browser verification of locale negotiation and the Applications page.
