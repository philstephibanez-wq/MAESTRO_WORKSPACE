# P117W R45B2A4M — MENU = FSM

State: OWNER VALIDATION REQUIRED

## Base audited

- OPUS master: `2c45610fe33aff1f12d263837272e042d467f523`
- Base delivery: `opus_p117w_r45b2a4l_fsm_theme_tokens`
- Artifact: `opus_p117w_r45b2a4m_menu_equals_fsm.zip`
- SHA-256: `9f63d581ba7d7b2fcd4c5e2790d5b4ba1e00463e9e5d586d5f36cba6ed5cbd98`

## Root cause

OWASYS still exposed two distinct interaction structures:

1. a horizontal list where a state itself was a navigation link;
2. a separate current-state signal strip / diagram projection.

This violates the owner contract: the menu itself must be the FSM interaction surface.

## Contract

`Menu = FSM`:

- one FSM state = one main menu entry; state entries are context/grouping, not transition commands;
- every outgoing transition signal of that state = one submenu entry below that state;
- only a signal belonging to the current state and mapped by `OPUS_SIGNAL_ROUTES_V2` is an actionable GET control;
- non-current or non-GET signals stay visible as passive FSM semantics and cannot be fired through a false link;
- signal target labels remain I18n-driven;
- NMI remains out-of-band and is never represented as an ordinary state/menu signal;
- ACL, current-application availability and locale are applied once to the menu projection;
- the diagram consumes the active-state slice of the exact normalized menu projection; it owns no second navigation registry;
- signal labels on the SVG are clickable iff the corresponding menu signal is actionable;
- state nodes remain passive.

## Generic OPUS evolution

`OPUS_FSM_Diagram` gains a layout root separate from the canonical initial state. This allows a contextual graph to be laid out from the current state without falsifying the FSM initial-state semantics or its initial marker.

## Files

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/application/default/services/NavigationBuilder.php`
- `sites/owasys-front/application/default/controllers/RuntimeController.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
- `sites/owasys-front/www/asset/css/fsm-native.css`

## Expected UI

The top navigation is no longer a list of direct state links. Each FSM state is a menu group. Expanding it reveals the signals attached to that source state. The current state's valid GET signals are clickable; other signals are passive.

The diagram below is a functional graph of the current state and the targets of its outgoing menu signals. It is laid out from the current state and uses the same transition IDs, signals, labels and links as the menu. Changing state changes both menu context and diagram context.

## Validation gate

The runner must report:

- `FSM_MENU=STATE_ENTRIES`
- `FSM_SUBMENU=OUTGOING_SIGNALS`
- `FSM_STATE_CLICK=DISABLED`
- `FSM_SIGNAL_CLICK=CURRENT_STATE_GET_ONLY`
- `FSM_DIAGRAM=ACTIVE_STATE_SIGNAL_GRAPH`
- `FSM_DIAGRAM_SOURCE=MENU_PROJECTION`
- `FSM_LAYOUT_ROOT=CURRENT_STATE`
- `FSM_NMI=OUT_OF_BAND`
- `GIT_REQUIRED_DIFFS=8/8`

No OPUS/OWASYS commit or push is performed by the assistant.