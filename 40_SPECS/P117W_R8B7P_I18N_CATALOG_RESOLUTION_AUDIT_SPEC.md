# P117W R8B7P — I18N CATALOG RESOLUTION + DIAGNOSTIC + TOPOLOGY SPEC

Status: DELIVERY CANDIDATE — OWNER APPLY/VALIDATE PENDING

## Authority

- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md`, and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` are authoritative.
- OPUS source authority audited directly from GitHub.
- Audited OPUS baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- R8B7P supersedes R8B7O/R8B7N and all earlier unaccepted I18n presentation candidates.

## Root cause fixed

1. OPUS regional catalogs are modeled as overlays (`inherits: <base>`) but `Opus/I18n/CatalogLoader.php` V4 loaded only the exact active-locale file.
2. OWASYS exposes regional locales while `application/menu/local` stores operation translations at base-language level only, making `menu.operation.*` structurally unreachable for a regional active locale.
3. OWASYS locally shadowed the generic `Opus\I18n\ApplicationTranslationRuntime` and converted a missing translation into an anonymous `⚠`, destroying the exact key and preventing generic framework diagnostics.
4. Missing-I18n defects were not duplicated with the exact key into both structured Logger and OPUS Profiler.

## Generic OPUS correction

`Opus/I18n/CatalogLoader.php` becomes V5 and resolves catalog composition deterministically:

- exact active-locale catalog first;
- explicit `inherits` recursively in the same scope/directory;
- cycle detection;
- inherited-locale language validation;
- inherited scope validation through the normal structured catalog loader boundary;
- base-language resolution when a regional module catalog does not exist;
- parent messages merged first, child/regional overlay wins;
- final composed catalog exposed under the active regional locale so `CatalogStack` locale invariants remain valid;
- File / StructuredFileLoader remain the only catalog I/O boundary.

`Opus/I18n/ApplicationTranslationRuntime.php` becomes V3. Only a genuine `OPUS_I18N_MESSAGE_MISSING` after the complete catalog chain is evaluated is converted to the canonical visible diagnostic:

`⚠ <exact.i18n.key>`

Other `TranslationException` failures propagate unchanged.

The generic runtime accepts optional OPUS Logger/Profiler collaborators. On a genuine unresolved message it emits the same context to both:

- structured Logger warning: channel `i18n`, message `message.missing`;
- OPUS Profiler warning event: category `i18n`, name `message.missing`.

Required context:

- `error_code = OPUS_I18N_MESSAGE_MISSING`;
- exact `i18n_key`;
- active `locale`;
- active `module`;
- active `trace_id`.

The Profiler event is attached to the current SCORE parent span when available. The existing generic WebProfiler I18n panel already consumes `i18n` events.

## OWASYS integration / cleanup

`sites/owasys-front/application/default/bootstrap.php` no longer preloads the OWASYS-local duplicate `ApplicationTranslationRuntime`.

`sites/owasys-front/application/default/services/ScorePageRenderer.php` binds the existing OWASYS structured log and active OPUS Profiler to each generic `ApplicationTranslationRuntime`. It no longer relabels non-missing `TranslationException` failures as missing messages.

The obsolete local framework shadow is intentionally not contained in the differential ZIP and must be removed by the owner after ZIP extraction:

`sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php`

## Applications presentation carried forward

The target presentation remains:

- one OWASYS topology;
- `owasys-front` + `owasys-back` are the CORE and render side-by-side on desktop;
- Composer-generated applications render in a distinct connected row below;
- no generated application ID is hard-coded;
- discovery/Singleton/SQLite/event diagnostic panels and raw registry metadata do not dominate the main Applications workspace.

## Changed complete files in native ZIP

1. `Opus/I18n/CatalogLoader.php`
2. `Opus/I18n/ApplicationTranslationRuntime.php`
3. `sites/owasys-front/application/default/bootstrap.php`
4. `sites/owasys-front/application/default/services/ScorePageRenderer.php`
5. `sites/owasys-front/application/registry/templates/index.score`
6. `sites/owasys-front/www/asset/themes/owasys/css/theme.css`

Owner cleanup removes one obsolete file after extraction:

- `sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php`

## Baseline blobs verified from GitHub

- `Opus/I18n/CatalogLoader.php`: `dd54709c65a340fc97dd8cea9fa7c564e9594686`
- `Opus/I18n/ApplicationTranslationRuntime.php`: `61fb1682731331f2dffbe82451ae5c2162828771`
- `sites/owasys-front/application/default/bootstrap.php`: `050f76893890cd642dc060bc4ff11c740bb6f552`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`: `61dd9c746524b15bf67f788f11665829d7880092`
- topology SCORE baseline: `77de59c341bb62c0dc294dff949a4203795aa655`
- theme baseline: `3916533c66b6fadf2914f037c8651682964e7790`

## Delivery

Native ZIP: `R8B7P.zip`

SHA-256:
`933fee5e50c44c11be65e202a4b26646b77d7213f3f777c75a154372276510b9`

The archive contains exactly the six complete changed files listed above at their final repository paths.

## Validation completed before delivery

- four changed PHP files pass `php -l` in the build environment;
- isolated catalog-composition fixture passes: regional `de-DE -> de` inheritance, child-over-parent precedence, regional module request resolving base `menu/de`, missing key behavior, and inheritance-cycle rejection;
- isolated diagnostic fixture passes: visible `⚠ missing.key`, exact key duplicated to Logger and Profiler, locale/module/trace ID preserved, parent span preserved, non-missing translation failures rethrown;
- SCORE structural balance: 21 `if` / 21 `endif`, 2 `foreach` / 2 `endforeach`;
- create/clear/select/delete form contracts remain present in the carried Applications SCORE;
- archive member list and byte-for-byte read-back verified;
- archive SHA-256 verified after creation.

## Owner acceptance gates

The candidate is not accepted until owner validation proves on the actual repository/runtime:

- required baseline/worktree gate passes;
- obsolete local runtime shadow is removed after extraction;
- `git diff --check` passes;
- all four changed PHP files lint;
- `composer opus:validate-site -- owasys-front` passes;
- runtime operation dropdowns resolve normally in supported regional locales;
- a genuinely absent controlled key renders `⚠ <exact key>`;
- the same controlled missing key appears in Logger and Profiler with matching locale/module/trace ID;
- `/applications` renders front/back side-by-side as OWASYS CORE and generated applications in the connected row below;
- create/select/clear/delete workflows remain functional;
- no unexpected runtime regression occurs.
