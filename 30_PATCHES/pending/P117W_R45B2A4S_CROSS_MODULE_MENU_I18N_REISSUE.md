# P117W R45B2A4S — Cross-module FSM menu I18n reissue

State: OWNER RUNTIME VALIDATION FAILED — SUPERSEDED BY R45B2A4T

## Outcome

The owner runtime validation after the A4S attempt still produced HTTP 500 on `/fr-FR/applications` with `OPUS_I18N_MESSAGE_MISSING`.

Owner-provided correlated logs dated 2026-08-16 establish that, for the same front/back trace, `owasys-back` completes `registry.sync` successfully with HTTP 200 and `owasys-front` then fails on I18n. The failure therefore remains in the front rendering/I18n path, not in REST, Composer or registry synchronization.

The owner-provided profiler trace also shows the failure before the first normal SCORE page render. The error occurs after route/FSM/REST/ACL work has succeeded and before the page body/layout SCORE render.

A4S is therefore not accepted as the runtime correction and must not be marked complete.

## Historical intent

A4S attempted to correct the architectural defect introduced when `Menu = FSM` began projecting states from several modules into one principal menu while `OwasysScorePageRenderer::normalizeI18nViewData()` still translated cross-module labels through the active page module runtime.

Its intended rules were:

- state label -> state module I18n runtime;
- signal destination label -> target state module I18n runtime;
- active page body -> active module I18n runtime;
- no global translation duplication;
- no silent fallback.

## Historical artifact

`opus_p117w_r45b2a4s_cross_module_menu_i18n.zip`

SHA-256: `6d77de97478795bf8c835fbd9b18aa8e5569d8b34c04cd9f23633839e7927f07`

Do not reuse A4S for further validation. R45B2A4T replaces the complete tracked `ScorePageRenderer.php` directly, avoiding one-shot patcher ambiguity.

The assistant does not commit or push OPUS/OWASYS.