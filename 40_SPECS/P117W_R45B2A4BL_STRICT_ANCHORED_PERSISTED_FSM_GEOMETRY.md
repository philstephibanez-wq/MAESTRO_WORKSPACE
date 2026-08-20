# P117W R45B2A4BL — Strict anchored persisted FSM geometry

## Status

SUPERSEDED BY P117W R45B2A4BM

A4BL established strict local edge-anchor validation and persisted-geometry self-healing. Those invariants remain mandatory and are included in A4BM.

A4BM extends the same generic OPUS presentation-layout mechanism so transition signal cards (signal + guards + effects) can also be right-dragged and persisted independently, including global/self signal cards. The companion layout contract therefore advances from `OPUS_FSM_DIAGRAM_LAYOUT_V2` to `OPUS_FSM_DIAGRAM_LAYOUT_V3`.

Menu work remains frozen. FSM semantics remain canonical and are never duplicated into presentation layout files.

See:

- `40_SPECS/P117W_R45B2A4BM_PERSISTED_RIGHT_DRAG_SIGNAL_CARDS.md`
- `50_HANDOFFS/P117W_R45B2A4BM_PERSISTED_RIGHT_DRAG_SIGNAL_CARDS_HANDOFF.md`
