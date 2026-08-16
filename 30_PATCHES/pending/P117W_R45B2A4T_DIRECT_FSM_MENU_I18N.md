# P117W R45B2A4T — Direct FSM menu I18n replacement

State: OWNER VALIDATION REQUIRED

## Evidence and root area

The owner-provided OWASYS logs dated 2026-08-16 show the same correlated trace on front and back:

- `owasys-front` receives `GET /fr-FR/applications` and ends with `OPUS_I18N_MESSAGE_MISSING`;
- `owasys-back` receives the correlated `GET /api/v1/applications`, runs `owasys:registry-sync`, and returns HTTP 200 successfully.

The supplied profiler shows the failure after routing/FSM/REST/ACL have succeeded and before the first normal SCORE page render. The remaining failure surface is therefore the front pre-render I18n normalization used by Menu = FSM.

At OPUS HEAD `c5122e03b40f6f483e325e7f0192984dd089c093`, `OwasysScorePageRenderer::normalizeI18nViewData()` receives the active page translator and uses it for active state text, every menu-state label and every signal-target label. With Menu = FSM, this is not a valid ownership model because one menu contains states from multiple modules.

## Delivery correction

A4T deliberately removes one-shot patcher ambiguity for this target. The differential ZIP contains exactly one complete tracked file at its final path:

- `sites/owasys-front/application/default/services/ScorePageRenderer.php`

The file was linted successfully with PHP before ZIP creation.

## Functional contract

A4T keeps the current Menu = FSM model unchanged and imposes I18n ownership as follows:

- active state title -> active state module runtime;
- active state summary -> active state module runtime;
- each menu state label -> that state module runtime;
- each signal destination label -> target state module runtime;
- SCORE body/layout rendering -> active page module runtime, unchanged;
- per-request module runtimes are cached;
- no module-local string is copied into `default`;
- no silent fallback is introduced.

If a key still cannot resolve, A4T converts the opaque translation failure into a contextual front error:

`OWASYS_SCORE_FSM_I18N_MESSAGE_MISSING:<state>:<module>:<locale>:<role>:<key>`

This preserves fail-closed behavior while making the next missing contract directly actionable.

## Runtime attestation

The successful response adds:

`X-Owasys-Fsm-I18n-Revision: P117W_R45B2A4T`

The view data also exposes `diagnostics.fsm_i18n_revision = P117W_R45B2A4T` and the FSM CSS cache key becomes `p117w-r45b2a4t`.

## Artifact

`opus_p117w_r45b2a4t_direct_fsm_menu_i18n.zip`

ZIP SHA-256:

`d4d0ae057b3b2366563bb701c98c3edd6f696bac0ea69362f5be364ae45ba7e6`

Contained file SHA-256:

`310d210e309c3eb2dc7525a23ea1cf0afcf8d4264def2d1ab0ab8debbaadf259`

## Validation gates

1. Extract the ZIP directly into `H:\OPUS`.
2. `git status --short` must show `ScorePageRenderer.php` modified immediately; there is no apply script.
3. `php -l sites\owasys-front\application\default\services\ScorePageRenderer.php` must pass.
4. Run `composer dump-autoload -o`.
5. Restart `owasys-front`.
6. Validate `/fr-FR/applications` first.
7. On success, verify response header `X-Owasys-Fsm-I18n-Revision: P117W_R45B2A4T`.
8. Validate at least one additional selectable locale.
9. Validate Menu = FSM remains unchanged: state = menu context; outgoing signals = submenu actions; no direct state command; diagram uses the same FSM projection.
10. Owner commits/pushes OPUS only after validation.

The assistant does not commit or push OPUS/OWASYS.