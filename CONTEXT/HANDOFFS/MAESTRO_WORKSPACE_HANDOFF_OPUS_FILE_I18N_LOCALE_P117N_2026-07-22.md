# MAESTRO_WORKSPACE HANDOFF — OPUS / OWASYS P117N

Date: 2026-07-22
Status: differential ZIP prepared and locally validated
Source OPUS head: `959a67b16ff80230e193c46a8c5df8e058569cd9` (`P117M_R1`)

## Objective

P117N establishes the generic OPUS boundary required for structured configuration files and application internationalization:

- canonical `Opus\File\File` singleton for bounded reads, atomic writes, deletion and file matching;
- dedicated JSON, YAML and XML parsers;
- extension-driven `StructuredFileLoader`;
- BCP 47-style locale values accepting hyphens or underscores;
- browser locale negotiation from `Accept-Language`;
- regional locale support such as `fr-CA`, `fr_CA` and `zh-Hant-TW`;
- explicit locale fallback chains without implicit English or key-name fallback;
- JSON/YAML/XML i18n catalog support through the OPUS File boundary;
- global plus FSM-module application catalogs;
- migration of OWASYS legacy PHP dictionaries to module-scoped ASAP JSON documents.

## Framework contract

Every new concrete OPUS framework class has a homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The P117M exhaustive contractual audit remains an installation gate.

## File and parser boundary

Configuration consumers do not call `file_get_contents()` directly. They obtain bytes through `Opus\File\File`, then parse through the selected OPUS parser:

- `.json` -> `Opus\File\Json`;
- `.yaml` / `.yml` -> `Opus\File\Yaml`;
- `.xml` -> `Opus\File\Xml`.

`StructuredFileLoader` selects the parser from the developer-selected file extension. Multiple catalog formats for the same locale/scope are treated as ambiguity and rejected.

XML parsing requires the PHP DOM extension. DTD and ENTITY declarations are forbidden and network access is disabled. YAML is a deliberately safe configuration subset; executable tags, aliases, anchors, merge keys and block scalars are rejected.

## Locale and browser negotiation

Locale input is normalized to canonical BCP 47-style tags:

- `fr_CA` -> `fr-CA`;
- `zh_hant_tw` -> `zh-Hant-TW`.

When the URL does not contain an explicit supported locale, OWASYS negotiates the default locale from the browser `Accept-Language` header, including quality weights. Resolution order is explicit:

1. exact supported locale;
2. supported parent locale;
3. supported locale with the same language;
4. application-configured fallback locale.

There is no implicit fallback to English and no fallback returning the untranslated key.

## OWASYS i18n application boundary

OWASYS retains 24 official EU languages plus Ukrainian. Regional variants may be added to `site.json` without changing the locale engine.

Catalog ownership is split by application scope:

- `application/default/local` for common UI;
- `application/login/local` for login;
- `application/account/local` for account/password;
- `application/registry/local` for the Applications page.

The migration tool generates 100 ASAP JSON catalogs: 25 locales multiplied by 4 scopes. Key parity is checked for every scope before any write. Writes are transactional: the original controller and any pre-existing catalogs are restored if application or post-write audit fails.

The Registry SCORE template no longer consumes pretranslated error text or pretranslated button labels. Visible strings are selected by SCORE i18n directives.

## Security and runtime

FSM, deny-by-default ACL and SSO remain mandatory runtime gates. P117N migrates OWASYS-controlled site, ACL, SSO, Registry seed/discovery and i18n configuration reads to the structured File boundary.

P117N does not introduce Auth0 credentials, an Auth0 provider implementation or a bastion bypass. Those remain separate security-provider work and must use the existing OPUS SSO abstraction.

## Delivery policy

No direct write is made to the OPUS repository. Runtime changes are delivered as a differential ZIP. This handoff and its specification are the only direct GitHub writes and belong to `MAESTRO_WORKSPACE`.

## Local validation performed

- PHP syntax validation for every PHP file in the differential;
- homonymous-interface and four-marker validation for every new concrete OPUS class;
- JSON and safe YAML parsing;
- locale normalization and browser negotiation;
- base plus regional catalog overlay;
- migration of 25 legacy locales into 100 module-scoped JSON catalogs;
- key-parity audit;
- RuntimeController patch and syntax validation;
- idempotent post-migration audit.

XML source and security checks were statically validated. Runtime XML parsing was not executed in the generation container because PHP DOM was unavailable there; local Windows PHP must expose `DOMDocument` before XML is selected.
