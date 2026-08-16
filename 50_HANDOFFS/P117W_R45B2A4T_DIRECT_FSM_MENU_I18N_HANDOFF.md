# P117W R45B2A4T — Handoff

State: OWNER VALIDATION REQUIRED

## Current proven failure

Owner-provided correlated logs prove that OWASYS backend is not the blocker for `/fr-FR/applications`: the back `registry.sync` request succeeds with HTTP 200, while the correlated front trace ends with `OPUS_I18N_MESSAGE_MISSING`.

The supplied front profiler places the failure before normal page SCORE rendering. Route resolution, FSM transition, REST synchronization and ACL evaluation have already succeeded.

## Why A4T replaces A4S

A4S runtime validation did not clear the I18n failure. A4T changes the delivery mode for this target to remove any uncertainty about a patch runner or anchor application.

The artifact contains exactly one complete final-path tracked source:

`sites/owasys-front/application/default/services/ScorePageRenderer.php`

No patch script is present.

## Artifact

- `opus_p117w_r45b2a4t_direct_fsm_menu_i18n.zip`
- ZIP SHA-256 `d4d0ae057b3b2366563bb701c98c3edd6f696bac0ea69362f5be364ae45ba7e6`
- `ScorePageRenderer.php` SHA-256 `310d210e309c3eb2dc7525a23ea1cf0afcf8d4264def2d1ab0ab8debbaadf259`

The complete file was validated with `php -l` before ZIP creation.

## Behavior

- active state title and summary: active state module I18n runtime;
- menu state label: state module I18n runtime;
- signal destination label: target state module I18n runtime;
- page body/layout SCORE renderer: active page module runtime;
- cached module runtimes per request;
- no duplicated global strings;
- no silent translation fallback;
- exact contextual error on unresolved FSM text;
- success response header `X-Owasys-Fsm-I18n-Revision: P117W_R45B2A4T`.

The functional FSM contract remains unchanged: Menu = FSM; states are contexts/menu entries; outgoing signals are submenu commands; diagram is the same FSM projection.

## Owner sequence

1. Extract A4T directly into `H:\OPUS`.
2. Run `git status --short`; `sites/owasys-front/application/default/services/ScorePageRenderer.php` must be modified immediately.
3. Lint that file.
4. Run `composer dump-autoload -o`.
5. Restart `composer opus:dev-server -- owasys-front`.
6. Validate `/fr-FR/applications`.
7. Verify `X-Owasys-Fsm-I18n-Revision: P117W_R45B2A4T` on a successful response.
8. Validate another selectable locale.
9. Validate menu signal submenus and diagram signal links still represent the same FSM.
10. Owner commits/pushes OPUS only after runtime validation.

If A4T still fails, use the newly contextual error code directly; do not add fallback strings or duplicate catalog entries.

The assistant does not commit or push OPUS/OWASYS.