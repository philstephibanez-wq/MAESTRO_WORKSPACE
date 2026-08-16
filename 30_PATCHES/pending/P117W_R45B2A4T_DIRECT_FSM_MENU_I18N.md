# P117W R45B2A4T — Direct FSM menu I18n replacement

State: OWNER VALIDATED — BASELINE FOR A4U

## Owner validation

Owner validation on 2026-08-16 confirms that A4T clears the blocking front I18n failure on `/fr-FR/applications` and restores the functional `Menu = FSM` surface.

The resulting UI proves:

- OWASYS front renders normally again;
- cross-module FSM/menu labels resolve in French;
- every FSM state is represented as a menu state entry;
- outgoing signals are rendered as that state's submenu;
- the native FSM diagram is visible and functional;
- current application context is visible and the selected application is `essai2` during the validation capture.

## Remaining issues moved to A4U

A4T is not the correction target for the two newly observed issues:

1. Diagram readability: multiple outgoing signals from the current state are still visually grouped/overlapping because the generic `OPUS_FSM_Diagram` compact renderer uses a single target column and only spreads lanes between transitions sharing the exact same source/target pair.
2. `change_app` on the `registry`/Applications state is rendered as an actionable signal, but its canonical transition is `registry -> registry` with no action. Since `/applications` already maps to `change_app`, clicking it on Applications reloads the same state and leaves the current application unchanged, giving no observable functional effect.

These are root-cause targets of P117W R45B2A4U.

## Validated contract retained

- Menu = FSM.
- One state = one menu entry/context.
- Outgoing signals = submenu commands for that state.
- State entries are not direct transition commands.
- Signal URLs resolve back to FSM signals.
- Diagram is another functional projection of the same FSM.
- I18n ownership remains state-module/target-module as introduced by A4T.

## Historical artifact

`opus_p117w_r45b2a4t_direct_fsm_menu_i18n.zip`

ZIP SHA-256:

`d4d0ae057b3b2366563bb701c98c3edd6f696bac0ea69362f5be364ae45ba7e6`

Contained file SHA-256:

`310d210e309c3eb2dc7525a23ea1cf0afcf8d4264def2d1ab0ab8debbaadf259`

Owner committed/pushed OPUS as commit `0313e5892abcf9788c5b2e083b98cdb224a1e453` (`opus_p117w_r45b2a4t_direct_fsm_menu_i18n`).

The assistant does not commit or push OPUS/OWASYS.