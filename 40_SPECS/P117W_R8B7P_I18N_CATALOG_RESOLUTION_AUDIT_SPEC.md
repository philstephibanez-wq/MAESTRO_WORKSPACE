# P117W R8B7P — EXHAUSTIVE I18N CATALOG RESOLUTION AUDIT SPEC

Status: AUDIT COMPLETE — IMPLEMENTATION CANDIDATE TO BUILD

## Authority

- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md`, and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` are authoritative.
- OPUS source authority audited directly from GitHub.
- Audited OPUS baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- R8B7P supersedes R8B7O/R8B7N and all earlier unaccepted I18n presentation candidates.

## Owner-observed defect

Navigation resource labels may appear translated in some locales, while operation dropdowns display only anonymous warning triangles. The owner requires:

- every normal UI label translated in every supported selectable locale;
- every genuinely unresolved I18n message rendered as `⚠ <exact.i18n.key>`;
- the same exact missing key duplicated to structured logs and OPUS Profiler under the same trace ID.

## Exhaustive source findings

### F1 — Policy and runtime implementation disagree (BLOCKER)

`sites/owasys-front/config/site.json` declares `OPUS_APPLICATION_I18N_POLICY_V4` with regional-only selectable locales, `regional_overlay_policy=explicit-empty-overlay-inherits-base-language`, `language_defaults`, `catalog_base_locales`, and `silent_fallback=false`.

The generic `Opus/I18n/CatalogLoader.php` only searches `<active-locale>.json|yaml|yml|xml` and returns that exact catalog. It does not read or resolve the catalog `inherits` field and it does not construct a regional -> base-language chain.

Therefore the declared overlay contract is not implemented by the framework runtime.

### F2 — Regional catalogs are overlays but are treated as complete catalogs (BLOCKER)

Regional catalogs such as `application/default/local/de-DE.json` explicitly declare `inherits: de` and contain only a subset of default keys. The corresponding base catalog `de.json` contains normal application/menu keys absent from the regional overlay.

Because the loader ignores `inherits`, those inherited keys are unresolved at runtime. The problem is not a missing translation in one catalog; it is a broken catalog composition model.

### F3 — Menu operation catalog is structurally unreachable for every selectable locale (BLOCKER)

`sites/owasys-front/application/menu/local` contains 25 base-language catalogs only (`bg`, `cs`, `da`, `de`, `el`, `en`, `es`, `et`, `fi`, `fr`, `ga`, `hr`, `hu`, `it`, `lt`, `lv`, `mt`, `nl`, `pl`, `pt`, `ro`, `sk`, `sl`, `sv`, `uk`).

`site.json` exposes only 38 regional locales. `OwasysLocaleRegistry` rejects base locales in the selectable set.

`OwasysScorePageRenderer` instantiates the menu translation runtime with module `menu` and the active regional locale. The generic application translation runtime asks `CatalogLoader` for an exact regional module catalog. No such files exist in `application/menu/local`, so no menu module catalog is loaded.

The canonical FSM uses `menu.operation.*` keys for all CRUD/build dropdown operations. Those keys live in the base `menu` catalogs, not the regional default catalogs.

Result: the operation labels are structurally unresolved for every selectable regional locale under the current resolver.

### F4 — The visible anonymous triangle is a second defect, not the primary defect (BLOCKER)

`sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php` declares the same FQCN as the generic framework class `Opus\I18n\ApplicationTranslationRuntime`.

`sites/owasys-front/application/default/bootstrap.php` explicitly preloads this OWASYS-local replacement before framework consumers.

The local replacement catches `OPUS_I18N_MESSAGE_MISSING` and returns only `⚠`.

Consequences:

- the exact key is destroyed in the UI;
- `ScorePageRenderer::translateStateText()` does not receive the exception and cannot preserve state/module/locale/key context;
- the missing-message condition can complete the request successfully and bypass normal error logging;
- OPUS and OWASYS have two competing implementations of the same framework FQCN.

This local shadow violates the generic-framework-first rule and must be removed after generic OPUS behavior is corrected.

### F5 — Logs and Profiler do not provide the required exact-key diagnostic (BLOCKER)

The application-level error handler records request failure metadata but does not expose a structured `i18n_key` field. `safeErrorCode()` normalizes throwable messages into an error code and therefore cannot serve as the exact-key diagnostic contract.

Required generic event contract: exact `i18n_key`, active `locale`, active `module`/scope, current `trace_id`, warning severity/status, duplicated to Logger and Profiler.

### F6 — No acceptance gate proves I18n closure across the selectable locale matrix (BLOCKER)

The repository contains a large locale matrix and module-scoped catalogs, but the shipped state demonstrates that validation did not prove that every human-facing key required by the canonical FSM/SCORE projection resolves for every selectable locale.

A valid fix therefore requires an automated exhaustive resolver validation, not visual spot checks in French/English.

### F7 — The canonical FSM is the source of human menu keys (CONFIRMED)

`config/fsm.json` defines visible resource keys `menu.applications`, `menu.application`, `menu.data`, `menu.structure`, `menu.security`, `menu.source`, `menu.build`, and operation keys `menu.operation.create`, `menu.operation.read`, `menu.operation.update`, `menu.operation.delete`, `menu.operation.list_select`, `menu.operation.validate`, `menu.operation.run`, `menu.operation.export`.

`OwasysNavigationBuilder` projects these keys but leaves translated labels empty. `OwasysScorePageRenderer` resolves them. `navigation.score` renders the precomputed labels. The translation-resolution path, not the SCORE menu markup, is therefore the root cause.

### F8 — Two navigation FSM configurations exist (REVIEW, not yet root cause)

`site.json` points `navigation.fsm` to `config/fsm.json`, while `efsms.navigation` points to `config/navigation.fsm.json`. `ScorePageRenderer::loadFsm()` consumes the former; `OwasysNavigationRuntime` consumes the latter through `FsmSiteLoader`.

This duality is recorded for architecture review. It is not currently classified as the I18n root cause because the missing menu keys are already explained deterministically by F1-F4.

## Required generic correction

The successor implementation must repair catalog resolution before diagnostics:

1. implement explicit regional-overlay inheritance generically in OPUS I18n;
2. load/compose base and regional catalogs deterministically for both default and module scopes;
3. honor explicit `inherits` metadata with cycle/locale/scope validation;
4. preserve module override precedence over default catalogs;
5. remove the OWASYS-local duplicate `ApplicationTranslationRuntime` authority;
6. expose `⚠ <exact.i18n.key>` only for genuinely unresolved messages after the complete catalog chain has been evaluated;
7. duplicate the exact unresolved key to Logger + Profiler with locale/module/trace correlation;
8. add an exhaustive validation gate across all 38 selectable locales and every human-facing FSM/SCORE key required by each module stack.

## Non-solution

Explicitly rejected: copying all base strings manually into all 38 regional files; adding individual missing keys only where screenshots show triangles; translating anonymous `⚠` placeholders; swallowing `TranslationException` in an OWASYS-local duplicate framework class; silently falling back to French or English; UI-only workarounds without fixing generic OPUS catalog composition.

## Acceptance criteria

A successor ZIP is deliverable only when source-level validation demonstrates:

- every selectable regional locale resolves all expected menu resource and operation keys through the declared catalog chain;
- regional override wins over inherited base value when present;
- inherited base value resolves when regional overlay omits a key;
- genuinely absent key remains absent after full chain and renders `⚠ <exact key>`;
- same missing key appears in Logger and Profiler with locale/module/trace ID;
- no OWASYS-local duplicate of the generic translation runtime remains active;
- all touched concrete OPUS classes remain compliant with their homonymous interfaces;
- `git diff --check`, PHP lint, I18n matrix validation, and `composer opus:validate-site -- owasys-front` pass before runtime acceptance.
