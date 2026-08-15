# P117W R45B2A4R — Cross-module FSM menu I18n

State: OWNER VALIDATION REQUIRED

## Root cause

After R45B2A4M/R45B2A4N, `Menu = FSM` projects every FSM state into the principal menu. `OwasysScorePageRenderer::normalizeI18nViewData()` still translated every state label and every signal target label through the active page module runtime only.

On `/applications`, the active module is `registry`. The `creation` state uses `navigation.label = creation.title`; `creation.title` belongs to the `creation` module catalog, not `default + registry`. The first cross-module state therefore raises `OPUS_I18N_MESSAGE_MISSING`.

The same architectural defect also applies to `login/auth.sign_in`, `account/auth.change_password`, and any future state whose label belongs to its own module.

## Correction contract

- Keep active page title/summary on the active module I18n runtime.
- Translate each menu state label using `ApplicationTranslationRuntime` for that state module.
- Translate each signal target label using `ApplicationTranslationRuntime` for the target state module.
- Cache module runtimes for the request.
- Do not duplicate module-local strings into the global catalog as a workaround.
- Do not alter `Menu = FSM`, signal routing, FSM transitions, ACL, SCORE composition or NMI semantics.

## Validation gate

The patch runner validates every FSM state label through its own module runtime for every selectable locale from `site.json`. Application is refused if any state/module/locale label cannot resolve.

Expected proof:

- `ROOT_CAUSE=CROSS_MODULE_MENU_LABELS_USED_ACTIVE_MODULE_I18N`
- `MENU_STATE_I18N=STATE_MODULE_RUNTIME`
- `SIGNAL_TARGET_I18N=TARGET_STATE_MODULE_RUNTIME`
- `I18N_STATE_LABEL_PROOFS=<N>/<N>`
- `A4Q_CALLSITES=4/4`

## Artifact

`opus_p117w_r45b2a4r_cross_module_menu_i18n.zip`

SHA-256: `4359ae62234abfa43f4429b49966a889ea94455882cdd75a59791cfea2c59bfe`

Target tracked file:

- `sites/owasys-front/application/default/services/ScorePageRenderer.php`

The assistant does not commit or push OPUS/OWASYS.