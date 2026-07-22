# MAESTRO_WORKSPACE HANDOFF — OWASYS P117N-R3

Date: 2026-07-22
Status: differential ZIP prepared and locally validated
Source OPUS head: `e0c157273b498cb93529fcd2b1ee834c1668a270` (`p117n hs`)

## Supersession

P117N-R3 supersedes P117N-R2 for catalog naming and delivery. The only valid catalog filename is:

`<locale>.<extension>`

Examples: `fr.json`, `fr-BE.json`, `de-CH.json`, `uk-UA.json`.

No prefix, alias, underscore filename variant or double naming is permitted.

## Incident corrected

The P117N head removed the historical PHP dictionaries without versioning replacement JSON catalogs. OWASYS therefore failed with `OPUS_I18N_CATALOG_FILE_MISSING: default:fr`.

P117N-R3 ships the required runtime catalogs directly in the ZIP. They are application source files and must be staged with `git add -A`.

## Locale matrix

OWASYS declares 62 locales:

- 25 base locales: the 24 official EU languages plus Ukrainian;
- 37 regional variants for EU member states, Switzerland and Ukraine.

Regional variants:

`bg-BG`, `hr-HR`, `cs-CZ`, `da-DK`, `nl-NL`, `nl-BE`, `en-IE`, `en-MT`, `et-EE`, `fi-FI`, `fr-FR`, `fr-BE`, `fr-LU`, `fr-CH`, `de-DE`, `de-AT`, `de-BE`, `de-LU`, `de-CH`, `el-GR`, `el-CY`, `hu-HU`, `ga-IE`, `it-IT`, `it-CH`, `lv-LV`, `lt-LT`, `mt-MT`, `pl-PL`, `pt-PT`, `ro-RO`, `sk-SK`, `sl-SI`, `es-ES`, `sv-SE`, `sv-FI`, `uk-UA`.

`fr-CA` is not declared by OWASYS. It remains a negotiation test and resolves to base `fr`.

## Catalog ownership

Four application scopes are versioned:

- `application/default/local`;
- `application/login/local`;
- `application/account/local`;
- `application/registry/local`.

Each scope contains 62 JSON files, for a total of 248 catalogs.

Base catalogs contain complete translated keys. Regional files are explicit empty overlays inheriting their base language through `Locale::fallbackChain()` and deterministic `CatalogLoader` merging.

## Framework correction

`Opus\I18n\CatalogLoader` is advanced to `OPUS_I18N_CATALOG_LOADER_V4` and discovers only canonical filenames:

`<canonical BCP47 locale>.<json|yaml|yml|xml>`

It no longer searches prefixed names or underscore filename aliases. Structured data still passes through `Opus\File\File` and the selected JSON, YAML or XML parser.

The class continues to implement its homonymous contractual interface extending the four mandatory OPUS markers.

## OWASYS runtime correction

- browser locale negotiation uses `Accept-Language` when no explicit route locale exists;
- explicit unsupported regional route locales return 404;
- controller-side key fallback and PHP dictionary loading are removed;
- login, account and Registry errors are selected by SCORE from boolean ViewModel state;
- navigation labels are resolved by the strict SCORE i18n runtime;
- corrected configuration consumers use `StructuredFileLoader`, not direct file reads;
- FSM, deny-by-default ACL and SSO remain mandatory gates.

P117N-R3 does not implement Auth0 credentials or a bastion bypass. Future providers remain behind OPUS SSO contracts.

## Validation performed

- 248 canonical JSON catalogs parsed;
- exact filename set checked for each scope;
- 25 base catalogs and 37 regional overlays checked per scope;
- strict key parity checked across base languages;
- regional merge `fr` + `fr-BE` executed through `CatalogLoader`;
- browser negotiation tested for Belgium, Switzerland, Ukraine, Finland Swedish and `fr-CA` -> `fr`;
- PHP syntax validation completed for all PHP files in the differential;
- no prefixed catalog filename or PHP dictionary exists in the ZIP;
- no new concrete OPUS class was introduced.

No browser execution against the user's Windows runtime was performed during artifact generation.

## Delivery policy

No direct write was made to the OPUS repository. Runtime changes are delivered only as a differential ZIP. This handoff and the P117N-R3 specification are the direct workspace GitHub writes.
