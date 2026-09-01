# R8B6U — Application I18N locale-chain resolution

## Scope

R8B6U corrects the OWASYS contextual EFSM label lookup used on pages such as Navigation and Security when the selected application's regional locale catalog does not physically exist.

## Baseline

OPUS `master` baseline: `57e79e6b4a6eb5733ce62b1ebf483c350064507a` (`opus_r8b6s5_full_site_i18n_missing_marker`).

The replacement `FsmDiagramBuilder.php` is derived exactly from Git blob `092909fd4cf52e65ca76fdc52ee1330d4bb191dd` at that baseline; integrity reconstruction must reproduce this blob before R8B6U changes are applied.

## Proven failure

A request for `/en-IE/security` successfully completes the Navigation and Security EFSM synchronization, then the frontend requests the selected application source `application/default/local/en-IE.json`. When that exact source file is absent, the strict source REST boundary correctly raises `OPUS_SITE_SOURCE_FILE_INVALID`, which is currently propagated as HTTP 500.

The source boundary MUST remain exact and strict. R8B6U MUST NOT weaken `SiteSourceWorkspace::read()` or make a direct source resource silently return another path.

## Contract

1. Contextual EFSM visible labels MUST resolve application I18N catalogs through the canonical OPUS locale family chain, not by assuming the exact regional file exists.
2. For `en-IE`, the valid chain is `en` then `en-IE`, matching `Opus\I18n\Locale::fallbackChain()` and the merge semantics of `CatalogLoader`.
3. Available parent catalogs are loaded first and more-specific catalogs override them.
4. Missing regional catalogs are not errors when a parent catalog is available.
5. No fallback to French or to the OWASYS default locale is permitted.
6. If no catalog in the locale family exists, or if a visible label key remains absent after merging, the visible value is exactly `⚠`.
7. Technical identifiers (state IDs, transition IDs, signal IDs, resource paths) are never translated or replaced by fallback labels.
8. Catalog files that do exist remain strictly validated for catalog contract, declared locale and messages structure.
9. Source listing truncation MUST NOT be interpreted as proof that a catalog is absent.
10. Direct source browsing/reading remains exact-path semantics.

## Implementation direction

The repair belongs at the contextual EFSM label resolver/caller. It uses the secured application source listing to establish which catalog paths exist, then reads only existing candidates from `Locale::fallbackChain()`. The generic source workspace remains unchanged.

State and transition labels share one merged catalog message map per contextual EFSM rendering; this avoids duplicate listing and duplicate catalog reads.

## Acceptance

- `/en-IE/navigation` and `/en-IE/security` do not issue a direct read for a non-existent `en-IE.json` when only `en.json` exists.
- Base catalog labels are visible for `en-IE` when provided by `en.json`.
- A present `en-IE.json` overrides `en.json` keys.
- Missing keys remain `⚠`.
- No French fallback occurs.
- Existing exact source REST semantics remain unchanged.
