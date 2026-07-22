# MAESTRO_WORKSPACE HANDOFF — OWASYS P117N-R5

Date: 2026-07-22
Status: differential ZIP prepared and statically/synthetically validated
Source OPUS head: `e0c157273b498cb93529fcd2b1ee834c1668a270` (`p117n hs`)
Supersedes: P117N-R3 locale selector matrix and P117N-R4 route-only handoff where they conflict with this document.

## Objective

Remove redundant language/region duplicates from the OWASYS locale selector while preserving regional catalog inheritance and browser negotiation.

The selector must not display both `fr` and `fr-FR`, both `de` and `de-DE`, or equivalent duplicate pairs.

## Final locale policy

The application selector exposes only the 37 regional locales covering EU member-state variants, Switzerland and Ukraine.

The 25 base-language catalogs remain versioned technical inheritance parents. They are not selectable locales and are not displayed.

Examples:

- selectable `fr-FR` is displayed as `Français`;
- selectable `fr-BE` is displayed as `Français (Belgique)`;
- selectable `fr-CH` is displayed as `Français (Suisse)`;
- selectable `de-DE` is displayed as `Deutsch`;
- selectable `de-AT` is displayed as `Deutsch (Österreich)`;
- selectable `de-CH` is displayed as `Deutsch (Schweiz)`.

## Bare-language defaults

A bare language code is an explicit alias for its configured primary regional locale:

- `fr` -> `fr-FR`;
- `de` -> `de-DE`;
- `en` -> `en-IE`;
- `nl` -> `nl-NL`;
- `sv` -> `sv-SE`;
- `uk` -> `uk-UA`.

The complete 25-language mapping is stored in `sites/owasys/config/site.json` under `i18n.language_defaults`.

The first configured locale for each language must equal that language's configured default. This keeps `BrowserLocaleNegotiator` deterministic without introducing an application-local translation engine.

## Explicit unsupported regional tags

An explicit regional URL tag is accepted only when it is configured exactly.

Examples:

- `/fr-BE/applications` -> accepted;
- `/fr-CH/applications` -> accepted;
- `/fr/applications` -> canonicalized to `fr-FR`;
- `/fr-CA/applications` -> unsupported locale, not an alias for `fr-FR`.

Browser negotiation remains more permissive: a browser preference `fr-CA,fr;q=0.9` resolves to the supported language default `fr-FR`.

## Catalog structure

The runtime still owns 248 canonical JSON catalogs:

- 25 base catalogs plus 37 regional overlays;
- four scopes: `default`, `login`, `account`, `registry`;
- filenames strictly `<locale>.json`;
- no `asap.` prefix;
- no PHP dictionaries.

Regional runtime resolution remains explicit:

`fr.json` -> overlay `fr-FR.json`.

The base catalog is hidden from the selector, not deleted.

## Routing and security

P117N-R4 locale-independent signal routing remains active. Paths continue to resolve to FSM events; there is no controller or template bypass.

The request pipeline remains:

request -> locale resolution -> SSO identity -> deny-by-default ACL -> FSM event/transition -> ViewModel -> SCORE.

No Auth0 secret, bastion bypass or local authentication fallback is introduced.

## Structured file boundary

`site.json`, routes, FSM, ACL, SSO and i18n catalogs remain read through `Opus\File\File` and `StructuredFileLoader`, then parsed by JSON, YAML/YML or XML parser according to extension.

The corrected controller contains no direct `file_get_contents()` configuration read.

## OPUS component contract

P117N-R5 adds no concrete OPUS framework class. The P117M-R1 exhaustive contract audit remains mandatory.

Any future concrete framework class must implement a homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

## Delivery

The ZIP is cumulative for P117N-R3/R4/R5 runtime corrections and contains the 248 canonical catalogs, locale assets, canonical `CatalogLoader`, route V2 configuration, SCORE runtime corrections, selector policy and maintenance audit.

No direct write is made to the OPUS repository. Runtime changes are delivered only as a differential ZIP.

## Validation performed

- PHP lint for every PHP file in the ZIP;
- 248 JSON catalogs parsed;
- 62 catalog files per scope;
- 37 selectable regional locales;
- 25 hidden base catalogs;
- exact language-default mapping;
- synthetic explicit alias tests (`fr`, `de`, `en`);
- synthetic exact regional tests (`fr-BE`, `de-CH`, `uk-UA`);
- rejection of explicit `fr-CA` as an OWASYS route locale;
- browser negotiation fallback from `fr-CA` to `fr-FR`;
- non-duplicated default labels;
- route V2 and FSM/ACL static checks.

Browser execution on the target Windows environment remains required after installation.
