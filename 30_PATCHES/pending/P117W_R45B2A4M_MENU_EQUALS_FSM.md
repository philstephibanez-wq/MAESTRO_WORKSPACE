# P117W R45B2A4M — MENU = FSM

State: OWNER VALIDATION REQUIRED

## Base audited

- OPUS master: `2c45610fe33aff1f12d263837272e042d467f523`
- Base delivery: `opus_p117w_r45b2a4l_fsm_theme_tokens`
- Artifact: `opus_p117w_r45b2a4m_menu_equals_fsm.zip`
- SHA-256: `18177ac11b86a7ee328c259234fb109bf0dbe8ad5fbaeb70611255aed534dd51`

## Root cause

OWASYS still exposed two distinct UI structures:

1. a horizontal navigation list of FSM states;
2. a separate current-state signal control strip / diagram projection.

This violates the owner contract that the menu itself is the FSM projection.

## Contract

`Menu = FSM`:

- one projected FSM state = one main menu entry;
- every outgoing transition signal of that state = one submenu entry under that state;
- a state entry is context only and never performs a transition;
- only a signal belonging to the current state and mapped by `OPUS_SIGNAL_ROUTES_V2` is an actionable GET control;
- non-current or non-GET signals remain visible as passive FSM semantics and cannot be fired through a false link;
- NMI remains out-of-band and is never represented as a state menu entry;
- ACL, current-application availability and locale are applied once to the menu projection;
- the diagram consumes the exact normalized menu projection and must not own a second navigation registry;
- signal labels on the SVG may be clickable only when the corresponding menu signal is actionable;
- state nodes remain passive.

## Files

- `sites/owasys-front/application/default/services/NavigationBuilder.php`
- `sites/owasys-front/application/default/controllers/RuntimeController.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
- `sites/owasys-front/www/asset/css/fsm-native.css`

## Expected UI

The top navigation is no longer a list of direct state links. Each state is a menu group. Expanding a state reveals its outgoing signals. The current state's valid GET signals are clickable; other signals are passive. The diagram below is generated from the same state/signal projection and highlights the current state.

## Validation gate

The runner must report:

- `FSM_MENU=STATE_ENTRIES`
- `FSM_SUBMENU=OUTGOING_SIGNALS`
- `FSM_STATE_CLICK=DISABLED`
- `FSM_SIGNAL_CLICK=CURRENT_STATE_GET_ONLY`
- `FSM_DIAGRAM=SAME_MENU_PROJECTION`
- `FSM_NMI=OUT_OF_BAND`
- `GIT_REQUIRED_DIFFS=7/7`

No OPUS/OWASYS commit or push is performed by the assistant.