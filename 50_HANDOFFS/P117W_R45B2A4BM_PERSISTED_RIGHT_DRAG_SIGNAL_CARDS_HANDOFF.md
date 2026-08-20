# P117W R45B2A4BM — Handoff

State: OWNER APPLIED/PUSHED — SUPERSEDED BY A4BN

## Owner commit

`333cf1ad2003aa9dd43d64e543210e9559e5187e` — `opus_p117w_r45b2a4bm_persisted_right_drag_signal_cards`

Menu work remains frozen.

## Runtime outcome

A4BM successfully moved the FSM presentation model forward from state-only manual geometry to movable transition signal cards. The complete technical signal card is a presentation object; canonical FSM semantics remain unchanged.

The owner then reported the remaining fixed presentation object: the white initial pseudo-state/begin point cannot be moved.

Root cause: the begin marker is rendered outside both the state and signal draggable registries and A4BM V3 has no persisted marker entry or marker save action.

This is addressed by A4BN.

## Contracts carried forward

- strict local edge source/target anchoring and self-heal;
- right-button state drag;
- right-button signal-card drag;
- global/self signal-card persistence;
- no document reload;
- repeated CSRF-rotated async saves;
- left-click signal actionability unchanged;
- layout remains presentation-only;
- no menu changes;
- no `owasys-back` changes.

## Historical artifact

`opus_p117w_r45b2a4bm_persisted_right_drag_signal_cards.zip`

SHA-256:

`920e50129e6e5754d0385140c05f7afac16387370b8277b92b4aa4f76676d012`

Exactly 2 complete framework files:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Fsm/FsmDiagramLayoutStore.php`

Continue with `P117W_R45B2A4BN_PERSISTED_RIGHT_DRAG_BEGIN_MARKER_HANDOFF.md`.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
