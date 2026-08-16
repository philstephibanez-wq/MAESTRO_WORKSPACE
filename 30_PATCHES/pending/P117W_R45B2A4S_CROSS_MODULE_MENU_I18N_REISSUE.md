# P117W R45B2A4S — Cross-module FSM menu I18n reissue

State: OWNER VALIDATION REQUIRED

## Context

R45B2A4R targeted the correct root cause but its one-shot runner was syntactically invalid because a `<<<'NEW'` nowdoc was closed with `OLD,`. It failed before any tracked OPUS/OWASYS write.

R45B2A4S reissues the same architectural correction against OPUS HEAD `c5122e03b40f6f483e325e7f0192984dd089c093` and explicitly accepts R45B2A4Q already applied but not committed.

## Root cause

`Menu = FSM` projects states from several OWASYS modules into one menu. `OwasysScorePageRenderer::normalizeI18nViewData()` translated all state labels and signal target labels through the active page module runtime.

Example on `/applications`:

- active page module: `registry`;
- FSM state `creation`: label key `creation.title`;
- `creation.title` belongs to the `creation` catalog, not `default + registry`;
- translating it with the registry runtime raises `OPUS_I18N_MESSAGE_MISSING`.

## Correction contract

Tracked target:

- `sites/owasys-front/application/default/services/ScorePageRenderer.php`

Required behavior:

- active page title/summary remain on the active module runtime;
- each menu state label is translated with `ApplicationTranslationRuntime` for that state's own module;
- each signal target label is translated with the target state's module runtime;
- module runtimes are cached for the request;
- no module-local strings are copied into `default`;
- no change to `Menu = FSM`, routes/signals, ACL, SCORE composition or NMI semantics.

## Validation gates

Before tracked write the runner must:

1. prove R45B2A4Q constructor migration: 4/4 `OwasysNavigationBuilder` call sites, zero stale one-argument call;
2. verify the exact `ScorePageRenderer.php` base blob;
3. lint the patched candidate;
4. load `site.json` and `fsm.json` through `StructuredFileLoader`;
5. resolve every FSM state label through its own module runtime for every selectable locale;
6. refuse application if any state/module/locale translation is missing.

The runner itself was validated before ZIP creation with `php -l`, and all nowdoc/heredoc markers were checked balanced.

## Artifact

`opus_p117w_r45b2a4s_cross_module_menu_i18n.zip`

SHA-256: `6d77de97478795bf8c835fbd9b18aa8e5569d8b34c04cd9f23633839e7927f07`

The assistant does not commit or push OPUS/OWASYS.