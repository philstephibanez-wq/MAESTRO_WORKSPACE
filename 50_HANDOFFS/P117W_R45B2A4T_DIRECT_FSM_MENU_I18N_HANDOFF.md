# P117W R45B2A4T — Handoff

State: OWNER VALIDATED — CLOSED AS BASELINE

## Validation result

Owner validation on 2026-08-16 confirms that A4T removes the blocking `OPUS_I18N_MESSAGE_MISSING` failure and restores the OWASYS front runtime on `/fr-FR/applications`.

The validated UI shows the intended `Menu = FSM` model:

- each FSM state appears as a menu state/context;
- each state's outgoing signals appear in its submenu;
- signal-driven navigation is active;
- the native FSM diagram is displayed;
- cross-module state and target labels resolve in French.

OPUS owner commit:

`0313e5892abcf9788c5b2e083b98cdb224a1e453` — `opus_p117w_r45b2a4t_direct_fsm_menu_i18n`

## Follow-up moved to A4U

Two defects remain after successful A4T validation:

1. the diagram's outgoing signals are too tightly grouped and overlap visually;
2. `change_app` on the Applications/registry state has no observable effect because the canonical self-transition contains no action.

A4U must preserve the validated Menu=FSM/I18n model and address only those root causes.

The assistant does not commit or push OPUS/OWASYS.