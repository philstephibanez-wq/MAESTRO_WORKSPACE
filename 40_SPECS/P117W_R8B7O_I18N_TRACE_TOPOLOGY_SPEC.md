# P117W R8B7O — I18N TRACE + APPLICATION TOPOLOGY SPEC

Status: DELIVERY CANDIDATE

## Authority

- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` are authoritative.
- OPUS baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- R8B7O supersedes R8B7N/R8B7M/R8B7L/R8B7K.

## Root causes

1. OWASYS currently shadows the framework `Opus\\I18n\\ApplicationTranslationRuntime` with an OWASYS-local class that converts `OPUS_I18N_MESSAGE_MISSING` to a lone `⚠`; this destroys the exact missing-key identity in the rendered UI.
2. Historical OWASYS logs record `OPUS_I18N_MESSAGE_MISSING` and `trace_id` but omit the exact missing key.
3. Missing-I18n defects must be duplicated into the OPUS Profiler and structured application logs under the same trace identity.
4. The Applications topology must show OWASYS core (`owasys-front` + `owasys-back`) side-by-side and generated applications in a distinct connected group below.
5. Discovery/Singleton/SQLite/recent-event diagnostic cards and raw registry metadata must not dominate the primary Applications workspace.

## I18n presentation contract

For `OPUS_I18N_MESSAGE_MISSING` only, the visible value is exactly:

`⚠ <exact.i18n.key>`

The key is diagnostic identity and must remain exact, visible, untranslated and adjacent to the warning symbol. Other translation failures remain exceptions.

## I18n observability contract

For each missing key in OWASYS runtime, emit:

- structured log channel `opus.i18n`, message `translation.missing`;
- OPUS Profiler category `i18n`, event `translation.missing`;
- context containing `error_code=OPUS_I18N_MESSAGE_MISSING`, `i18n_key`, `locale`, `module`, `path`;
- current `OPUS_TRACE_ID` when valid.

The Profiler diagnostic uses the same trace ID and the existing runtime profiler journal so it is available in the OPUS trace view. No secret/user credential is recorded.

## Generic framework behavior

`Opus/I18n/ApplicationTranslationRuntime.php` adopts the canonical visible missing-key marker so OPUS applications do not reduce missing messages to anonymous warnings.

The existing OWASYS-local runtime remains the current OWASYS wiring boundary for this delivery and adds the required logger/profiler duplication. This is a bounded compatibility bridge; it uses OPUS `Logger` and `Profiler`, not custom logging/profiling formats.

## Applications topology

- one OWASYS root;
- core row: protected/system applications including `owasys-front` and `owasys-back`, side-by-side on desktop;
- generated applications in a separate connected row below;
- no generated application ID is hard-coded;
- existing `entry.deletable` remains the discriminator.

## UI compaction

The primary Applications workspace omits the discovery audit, Singleton audit, SQLite runtime and recent-events cards. Raw technical registry metadata is removed from the primary cards.

## Changed files

1. `Opus/I18n/ApplicationTranslationRuntime.php`
2. `sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php`
3. `sites/owasys-front/application/registry/templates/index.score`
4. `sites/owasys-front/www/asset/themes/owasys/css/theme.css`

No REST, Composer command, FSM, ACL/SSO or owasys-back change.

## Delivery

Native ZIP: `R8B7O.zip`

SHA-256: `37cb538bfe206a48be29073c3afbbad46dcbca4406a713e97ca3affbb6a3b27a`

## Pre-delivery validation

- both changed PHP files pass `php -l` under PHP 8.4.23;
- SCORE structure: 21 `if` / 21 `endif`, 2 `foreach` / 2 `endforeach`;
- ZIP contains exactly the four complete final files listed above;
- ZIP read-back matches generated file bytes;
- SHA-256 verified after creation.

## Owner acceptance

After apply:

- `git diff --check` passes;
- both changed PHP files pass `php -l`;
- `composer opus:validate-site -- owasys-front` passes;
- `/applications` shows front/back side-by-side as core and generated apps below in the connected OWASYS topology;
- normal labels are translated through I18n;
- any actually missing key displays `⚠ <exact key>`;
- the same missing key is visible in `owasys-front.log` and the OPUS Profiler trace with `i18n_key`, locale, module, path and correlated trace ID;
- create/select/clear/delete behavior remains functional.
