# MAESTRO_WORKSPACE HANDOFF — OWASYS P117N-R2

Date: 2026-07-22
Status: differential ZIP prepared and locally validated
Source OPUS head: `e0c157273b498cb93529fcd2b1ee834c1668a270` (`p117n hs`)

## Incident

OWASYS failed with:

`OPUS_I18N_CATALOG_FILE_MISSING: default:fr`

The P117N commit removed the 25 historical PHP catalogs but did not version any generated JSON catalog. The OPUS `CatalogLoader` correctly requires the global `application/default/local` catalog and must not fall back silently.

The incident is therefore a delivery defect: required runtime catalogs were treated as migration outputs instead of application-owned versioned runtime files.

## P117N-R2 correction

The differential contains the runtime catalogs themselves. It does not depend on deleted PHP sources or on regeneration during deployment.

Catalog ownership remains:

- `application/default/local` — common UI;
- `application/login/local` — authentication;
- `application/account/local` — account/password;
- `application/registry/local` — Applications/Registry.

All catalogs use `OPUS_I18N_CATALOG_V2` JSON documents and are read through `Opus\File\File` plus `Opus\File\StructuredFileLoader` / `Opus\File\Json`.

## Locale matrix

The application now declares 62 locales:

- 25 base locales: the 24 official EU languages plus Ukrainian;
- 37 explicit regional variants for EU member states, Switzerland and Ukraine.

Regional matrix:

- `bg-BG`;
- `hr-HR`;
- `cs-CZ`;
- `da-DK`;
- `nl-NL`, `nl-BE`;
- `en-IE`, `en-MT`;
- `et-EE`;
- `fi-FI`;
- `fr-FR`, `fr-BE`, `fr-LU`, `fr-CH`;
- `de-DE`, `de-AT`, `de-BE`, `de-LU`, `de-CH`;
- `el-GR`, `el-CY`;
- `hu-HU`;
- `ga-IE`;
- `it-IT`, `it-CH`;
- `lv-LV`;
- `lt-LT`;
- `mt-MT`;
- `pl-PL`;
- `pt-PT`;
- `ro-RO`;
- `sk-SK`;
- `sl-SI`;
- `es-ES`;
- `sv-SE`, `sv-FI`;
- `uk-UA`.

`fr-CA` remains a negotiation test only and is not declared by OWASYS. A browser sending `fr-CA` resolves explicitly to base `fr`.

Each regional locale has a versioned empty overlay catalog in all four scopes. The OPUS locale fallback chain loads the complete base-language catalog first, then the exact regional overlay. This avoids duplicating translations while preserving a dedicated file for later regional vocabulary overrides.

## Browser locale negotiation

When no locale segment is present in the URL, `BrowserLocaleNegotiator` resolves `Accept-Language` against the 62 configured locales.

Examples:

- `fr-BE,fr;q=0.9` -> `fr-BE`;
- `de-CH,de;q=0.9` -> `de-CH`;
- `uk-UA,uk;q=0.9` -> `uk-UA`;
- `fr-CA,fr;q=0.9` -> `fr`;
- `sv-FI,sv;q=0.9` -> `sv-FI`.

An explicit unsupported regional segment remains a 404. There is no implicit English fallback and no key-name fallback.

## SCORE and application runtime

P117N-R2 also removes the remaining controller-side visible error translation path:

- login and account errors are represented by ViewModel booleans;
- SCORE templates select static i18n keys;
- Registry errors and Registry button labels remain SCORE-selected;
- the controller emits through `OwasysScorePageRenderer::emit()`;
- no UI-producing `echo` is introduced;
- no HTML/PHP mixed view is introduced.

`OwasysNavigationBuilder` no longer translates labels. It emits the FSM label key and the SCORE renderer resolves it through the strict OPUS translation runtime.

## Structured configuration boundary

The corrected `RuntimeController` and `ScorePageRenderer` no longer read JSON with `file_get_contents()`.

They use `StructuredFileLoader::instance()->read()` for routes, FSM and site configuration. The extension continues to select the JSON, YAML/YML or XML parser chosen by the developer.

## Flags and native labels

Regional locale labels are explicit and native, including Belgium, Luxembourg and Switzerland variants. Regional entries use country-specific flags where the existing base-language flag is insufficient. New application assets are supplied for Austria, Belgium, Switzerland, Cyprus, Czechia, Denmark, Estonia, Ireland, Luxembourg, Slovenia and Sweden.

## Component contracts

P117N-R2 adds no concrete OPUS framework class. The P117M-R1 four-marker audit remains mandatory and must report no residual change.

Every future concrete OPUS framework class must still implement its homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

## Security boundaries

FSM, i18n, deny-by-default ACL and SSO remain mandatory. This corrective milestone does not add Auth0 credentials, a bastion bypass or an application-local authentication framework.

Future Auth0 proxy or bastion providers must remain behind the OPUS SSO boundary and must not bypass FSM or ACL.

## Validation performed

- 248 JSON catalogs generated and parsed;
- 62 catalogs per application scope;
- 25 complete base-language catalogs per scope;
- 37 explicit regional overlays per scope;
- strict base-key parity;
- construction of `ApplicationTranslationRuntime` for all 62 locales and four modules;
- exact regional and base browser negotiation tests;
- locale label and flag resolution for all 62 locales;
- PHP syntax validation for all PHP files in the differential;
- no legacy PHP catalog in the differential;
- no controller `loadMessages`, `viewLabels`, key fallback or UI `echo`;
- no direct `file_get_contents()` in corrected controller/renderer.

No browser execution against the user's Windows installation was performed during artifact generation.

## Delivery policy

No direct write was made to the OPUS repository. Runtime corrections are delivered as a differential ZIP. Workspace handoff/specification are the only direct GitHub writes.
