# P117W R45B2A4BM — Persisted right-drag signal cards

## Status

OWNER APPLIED/PUSHED — SUPERSEDED BY A4BN

## Committed owner baseline

OPUS commit:

`333cf1ad2003aa9dd43d64e543210e9559e5187e` — `opus_p117w_r45b2a4bm_persisted_right_drag_signal_cards`

Menu work remains frozen.

## Owner runtime result

A4BM established manual right-button positioning of state nodes and complete transition signal cards (signal + guards + effects + scope), with no-reload persistence and anchored transition handling.

Owner runtime inspection then exposed the next presentation gap: the white initial pseudo-state/begin point remained fixed because it was not part of either draggable registry and had no persisted layout entry.

That gap is treated by A4BN. A4BM remains the committed baseline for A4BN.

## A4BM contract retained by A4BN

- state right-drag remains presentation-only;
- signal-card right-drag remains presentation-only;
- local transition endpoints remain validated against source/target state boundaries;
- stale local edge geometry self-heals;
- global/self signal cards retain independent presentation coordinates;
- left-click signal actionability remains unchanged;
- no `window.location.reload()`;
- asynchronous repeated saves retain CSRF rotation;
- no menu file changes;
- no `sites/owasys-back` changes.

## Layout contract

A4BM introduced `OPUS_FSM_DIAGRAM_LAYOUT_V3`, persisting state coordinates and independently movable signal-card coordinates without duplicating FSM semantics.

A4BN supersedes the companion schema with V4 solely to add the initial pseudo-state marker coordinate while retaining all V3 geometry.

## Historical artifact

`opus_p117w_r45b2a4bm_persisted_right_drag_signal_cards.zip`

SHA-256:

`920e50129e6e5754d0385140c05f7afac16387370b8277b92b4aa4f76676d012`

Changed framework files:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Fsm/FsmDiagramLayoutStore.php`

A4BM is not the current delivery. Continue with P117W R45B2A4BN.
