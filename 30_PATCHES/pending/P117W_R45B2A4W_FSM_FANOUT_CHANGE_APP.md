# P117W R45B2A4W — Direct FSM fan-out + functional change_app

State: OWNER APPLIED — PARTIALLY VALIDATED — SUPERSEDED FOR DIAGRAM UX BY R45B2A4X

## Owner-applied baseline

OPUS commit:

`fcffa3c16c75126208a480382f9efb36be170110` — `opus_p117w_r45b2a4w_direct_fsm_fanout_change_app`.

The owner applied and committed the A4W direct artifact. Runtime screenshots confirm the diagram renders and signal separation is improved compared with A4T.

## Retained A4W behavior

A4W remains the canonical basis for:

- generic native OPUS SVG fan-out/lane routing;
- bounded signal-label hitboxes;
- all ten canonical `change_app` transitions carrying existing FSM action `clear_current_app`;
- target state `registry` unchanged;
- Menu = FSM unchanged.

## Remaining UX defect exposed by owner validation

The diagram is still dynamically rooted on the current state because `OwasysFsmDiagramBuilder` projects only the current state plus direct targets and passes the current state as `layoutRoot`.

This violates the newly clarified workflow requirement:

- diagram geometry must be fixed;
- diagram starts at canonical `initial_state` (`login` / Connexion);
- current state never changes layout/order;
- current state is highlighted only;
- displayed workflow edges remain real canonical FSM transitions;
- no parallel route/state registry.

The horizontal FSM menu also needs native autocollapse so open signal lists do not mask the diagram.

## Supersession scope

R45B2A4X supersedes A4W only for OWASYS diagram projection/menu UX. It does not revert the A4W generic renderer or `change_app` FSM action.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.