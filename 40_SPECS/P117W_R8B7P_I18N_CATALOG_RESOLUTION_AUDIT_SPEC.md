# P117W R8B7P — I18N CATALOG RESOLUTION + DIAGNOSTIC + TOPOLOGY SPEC

Status: DELIVERY CANDIDATE — OWNER APPLY/VALIDATE PENDING

## Authority

- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md`, and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` are authoritative.
- OPUS source authority audited directly from GitHub.
- Audited OPUS baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- R8B7P supersedes R8B7O/R8B7N and all earlier unaccepted I18n presentation candidates.

## Root cause fixed

1. OPUS regional catalogs are modeled as overlays (`inherits: <base>`) but `CatalogLoader` previously loaded only the exact active locale.
2. OWASYS exposes regional locales while `application/menu/local` stores operation translations at base-language level only, making `menu.operation.*` structurally unreachable.
3. OWASYS locally shadowed the generic `Opus\I18n\ApplicationTranslationRuntime` and converted a missing translation into an anonymous `⚠`, destroying the exact key.
4. Missing-I18n diagnostics were not duplicated with the exact key into both structured Logger and OPUS Profiler.

## Generic OPUS correction

`Opus/I18n/CatalogLoader.php` becomes V5 and resolves catalog composition deterministically:

- exact active-locale catalog first;
- explicit `inherits` recursively in the same scope/directory;
- cycle detection;
- inherited-locale language validation;
- inherited scope validation through the normal catalog loader;
- base-language resolution when a regional module catalog does not exist;
- parent messages merged first, child/regional overlay wins;
- final composed catalog is exposed under the active regional locale so `CatalogStack` invariants remain valid.

`Opus/I18n/Translator.php` becomes V3. Only a genuine `OPUS_I18N_MESSAGE_MISSING` after the complete catalog chain has been evaluated is converted into the canonical visible diagnostic:

`⚠ <exact.i18n.key>`

Other translation failures still propagate.

`Opus/I18n/ApplicationTranslationRuntime.php` becomes V3 and installs the missing-message reporter. Under the OWASYS runtime context the same unresolved key is duplicated to:

- structured Logger event `i18n / message.missing` with `error_code`, exact `i18n_key`, `locale`, `module`, `trace_id`;
- OPUS Profiler warning event `i18n.message.missing` under the same `trace_id`.

## OWASYS cleanup

`sites/owasys-front/application/default/bootstrap.php` no longer preloads the OWASYS-local duplicate `ApplicationTranslationRuntime`. It publishes the existing OWASYS log/profiler storage locations to the generic runtime diagnostic boundary.

The obsolete local shadow file is intentionally not part of the ZIP and must be deleted by the owner after ZIP extraction:

`sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php`

## Applications presentation carried forward

The accepted target presentation remains:

- one OWASYS topology;
- `owasys-front` + `owasys-back` are the CORE and render side-by-side on desktop;
- Composer-generated applications render in a distinct connected row below;
- no generated application ID is hard-coded;
- discovery/Singleton/SQLite/event diagnostic panels and raw registry metadata do not dominate the main Applications workspace.

## Changed complete files in native ZIP

1. `Opus/I18n/CatalogLoader.php`
2. `Opus/I18n/Translator.php`
3. `Opus/I18n/ApplicationTranslationRuntime.php`
4. `sites/owasys-front/application/default/bootstrap.php`
5. `sites/owasys-front/application/registry/templates/index.score`
6. `sites/owasys-front/www/asset/themes/owasys/css/theme.css`

Owner cleanup removes one obsolete file after extraction:

- `sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php`

## Baseline blobs verified from GitHub

- `Opus/I18n/CatalogLoader.php`: `dd54709c65a340fc97dd8cea9fa7c564e9594686`
- `Opus/I18n/Translator.php`: `acb762d474c7ea4acc1a598595893bdb0bb9f54a`
- `Opus/I18n/ApplicationTranslationRuntime.php`: `61fb1682731331f2dffbe82451ae5c2162828771`
- `sites/owasys-front/application/default/bootstrap.php`: `050f76893890cd642dc060bc4ff11c740bb6f552`
- topology SCORE baseline: `77de59c341bb62c0dc294dff949a4203795aa655`
- theme baseline: `3916533c66b6fadf2914f037c8651682964e7790`

## Delivery

Native ZIP: `R8B7P.zip`

SHA-256:
`61f4e925f8b684cae2f9d5dfb3b1d0f8ca9919baef377f34a9b400b1d68b2ced`

Archive contains exactly the six complete files listed above at their final repository paths.

## Validation completed before delivery

- four changed PHP files pass `php -l` in the build environment;
- SCORE structural balance: 21 `if` / 21 `endif`, 2 `foreach` / 2 `endforeach`;
- archive member list/read-back verified;
- archive SHA-256 verified after creation;
- generic resolver source path checked against representative authoritative catalogs: `de-DE -> de` default overlay and regional `de-DE` -> base `menu/de` module resolution;
- exact-key UI fallback and Logger/Profiler structured fields are present in the built generic runtime.

## Owner acceptance gates

The candidate is not accepted until owner validation proves on the actual repository/runtime:

- required baseline/worktree gate passes;
- obsolete local runtime shadow is removed after extraction;
- `git diff --check` passes;
- all changed PHP files lint;
- `composer opus:validate-site -- owasys-front` passes;
- runtime operation dropdowns resolve normally in supported regional locales;
- a genuinely absent controlled key renders `⚠ <exact key>`;
- the same controlled missing key is present in Logger and Profiler with matching locale/module/trace ID;
- create/select/clear/delete workflows remain functional;
- no unexpected runtime regression occurs.
