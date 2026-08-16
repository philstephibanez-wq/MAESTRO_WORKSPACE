# P117W R45B2A4W — Handoff

State: OWNER APPLIED — PARTIALLY VALIDATED — SUPERSEDED FOR DIAGRAM UX BY R45B2A4X

## Current OPUS baseline

`fcffa3c16c75126208a480382f9efb36be170110` — `opus_p117w_r45b2a4w_direct_fsm_fanout_change_app`.

Owner screenshots confirm A4W renders and improves outgoing signal readability.

## Retained contract

A4W remains the baseline for:

- native SVG fan-out/lane routing in `Opus/Fsm/Diagram.class.php`;
- signal hitboxes;
- 10/10 `change_app` transitions using canonical `clear_current_app` action;
- Menu = FSM;
- A4T cross-module I18n.

## Next root cause

`sites/owasys-front/application/default/services/FsmDiagramBuilder.php` still builds an active-state-only projection and passes the current state as layout root. Therefore the diagram moves/reorders with navigation instead of representing a stable application workflow.

Owner requirement now fixed:

1. fixed workflow geometry;
2. start from FSM `initial_state` (`login` / Connexion);
3. current state is highlighted only;
4. stable state order independent of page/current state;
5. logical representative edges are selected only from real canonical FSM transitions;
6. no second state/route registry;
7. native menu autocollapse, no JavaScript.

R45B2A4X implements this projection/menu UX directly and keeps A4W renderer/FSM changes intact.

Owner alone commits/pushes OPUS/OWASYS.