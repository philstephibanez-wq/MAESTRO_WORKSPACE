# P117W R8B7N — GENERIC I18N DIAGNOSTIC + APPLICATION TOPOLOGY SPEC

Status: DELIVERY CANDIDATE

## Authority

- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` are authoritative.
- OPUS GitHub baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- R8B7N supersedes R8B7M and the earlier R8B7K/R8B7L presentation candidates.

## Root causes

1. Missing I18n presentation must never expose an anonymous warning triangle. The exact unresolved key must be visible next to the warning indicator.
2. This behavior is generic OPUS I18n behavior and must not be implemented as an OWASYS-only visual workaround.
3. The Applications topology must represent the real architecture: OWASYS core = `owasys-front` + `owasys-back`, side-by-side on desktop; generated applications are outputs managed by OWASYS and appear in a distinct connected row below.
4. Developer audit/runtime panels and raw technical registry metadata must not dominate the primary Applications workspace.

## Generic OPUS I18n rule

`Opus\\I18n\\Translator` remains the framework translation service. When and only when catalog lookup raises `OPUS_I18N_MESSAGE_MISSING`, the translator returns the canonical visible diagnostic:

`⚠ <exact.i18n.key>`

The exact key is diagnostic data and is not translated, shortened or hidden. Other `TranslationException` failures are rethrown and are not converted into a missing-key warning.

This fallback is a diagnostic safety net. It does not relax the primary requirement that expected UI labels resolve to real translations in every supported locale.

## Applications I18n

The Applications SCORE view uses existing translated keys from the default/registry locale chains and does not introduce literal French/English presentation labels. Application names/identifiers are runtime/business data and remain untranslated.

The candidate deliberately avoids the newer registry delete-specific keys whose coverage is not homogeneous across locale families; it reuses already-established translated keys for the delete control while preserving the delete workflow.

## Applications topology

One continuous OWASYS topology is rendered:

- OWASYS root;
- core row: protected/system applications, including `owasys-front` and `owasys-back`, side-by-side on desktop;
- generated row below, visually connected to the same OWASYS topology.

No generated application ID such as `essai` is hard-coded. Existing `entry.deletable` remains the runtime discriminator.

## UI compaction

The main Applications state no longer renders the discovery audit, Singleton audit, SQLite runtime or recent-events panels. Per-application Singleton diagnostic badges and raw technical metadata are also removed from the primary view.

## Functional preservation

The existing controller/ACL-owned workflows remain:

- create application;
- clear current context;
- select application;
- delete generated application when ACL and `entry.deletable` permit it.

No changes to REST, Composer command contracts, FSM semantics, ACL/SSO, registry controller/model or owasys-back.

## Changed files

1. `Opus/I18n/Translator.php`
2. `sites/owasys-front/application/registry/templates/index.score`
3. `sites/owasys-front/www/asset/themes/owasys/css/theme.css`

## Baseline checks

- `Opus/I18n/Translator.php` baseline blob: `acb762d474c7ea4acc1a598595893bdb0bb9f54a`.
- `sites/owasys-front/application/registry/templates/index.score` baseline blob: `77de59c341bb62c0dc294dff949a4203795aa655`.
- `sites/owasys-front/www/asset/themes/owasys/css/theme.css` baseline blob: `3916533c66b6fadf2914f037c8651682964e7790`.

## Delivery

Native ZIP: `R8B7N.zip`

SHA-256:
`ba19399ccbd4b49d6397d043dcede126d489e8b621ef151783a850c53bd5a319`

The archive contains exactly the three complete changed files listed above at their final repository paths.

## Validation completed before owner delivery

- Translator baseline reconstructed byte-for-byte and matched its Git blob.
- Theme baseline prefix matched its Git blob before scoped topology CSS was appended.
- `php -l Opus/I18n/Translator.php`: pass in the build environment.
- SCORE structure: 21 `if` / 21 `endif`, 2 `foreach` / 2 `endforeach`.
- Archive read-back and member list: pass.
- Archive SHA-256 verified after creation.

## Owner acceptance gates

After apply:

- `git diff --check` passes;
- `php -l Opus\\I18n\\Translator.php` passes;
- `composer opus:validate-site -- owasys-front` passes;
- `/applications` renders the required topology;
- supported-language switching shows translated UI labels;
- a deliberately unresolved SCORE I18n key, if exercised in a controlled validation, renders `⚠ <exact key>` rather than a lone triangle;
- create/select/clear/delete remain functional.
