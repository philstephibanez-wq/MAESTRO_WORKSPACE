# P117W R45B2A4S — Handoff

State: OWNER VALIDATION REQUIRED

## Why A4S exists

R45B2A4R did not reach OPUS source modification. Its runner had a parse error caused by an unbalanced nowdoc closing marker. R45B2A4S is a clean reissue; do not reuse A4R.

## Artifact

- `opus_p117w_r45b2a4s_cross_module_menu_i18n.zip`
- SHA-256 `6d77de97478795bf8c835fbd9b18aa8e5569d8b34c04cd9f23633839e7927f07`

## Owner sequence

1. Keep R45B2A4Q changes present; they may still be uncommitted.
2. Extract A4S into `H:\OPUS`.
3. Run `php tools\apply_p117w_r45b2a4s_cross_module_menu_i18n.php`.
4. Runner must report A4Q call sites `4/4` and complete every state/locale I18n proof before writing.
5. Lint `sites\owasys-front\application\default\services\ScorePageRenderer.php`.
6. Run `composer dump-autoload -o`.
7. Restart `composer opus:dev-server -- owasys-front`.
8. Validate `/fr-FR/applications` first.
9. Validate at least one additional selectable locale.
10. Validate Menu = FSM remains: state = menu/context, outgoing signals = submenu/actions, no direct state transition command, diagram uses same FSM projection.
11. Delete the one-shot runner before OPUS commit.
12. Owner commits/pushes OPUS only after validation.

## Expected runner proof

- `OPUS_P117W_R45B2A4S_APPLY_OK`
- `ROOT_CAUSE=CROSS_MODULE_MENU_LABELS_USED_ACTIVE_MODULE_I18N`
- `MENU_STATE_I18N=STATE_MODULE_RUNTIME`
- `SIGNAL_TARGET_I18N=TARGET_STATE_MODULE_RUNTIME`
- `ACTIVE_PAGE_I18N=UNCHANGED_ACTIVE_MODULE_RUNTIME`
- `FSM_MENU=UNCHANGED_MENU_EQUALS_FSM`
- `I18N_STATE_LABEL_PROOFS=<N>/<N>`
- `A4Q_CALLSITES=4/4`

Do not mark complete before owner runtime validation and OPUS commit/push.