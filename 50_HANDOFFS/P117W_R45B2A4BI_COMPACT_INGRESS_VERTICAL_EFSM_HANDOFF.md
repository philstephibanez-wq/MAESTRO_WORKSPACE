# P117W R45B2A4BI — Handoff

State: OWNER COMMITTED/PUSHED IN OPUS — SUPERSEDED FOR LAYOUT PERSISTENCE BY A4BJ

## Owner OPUS commit

`f12de01af39d87c7eaf6783ff277e2b14cad1a07`

Commit message:

`opus_p117w_r45b2a4bi_compact_ingress_vertical_efsm`

## Accepted scope carried forward

A4BI remains the current compact vertical EFSM geometry baseline:

- finite global transitions stacked at target ingress;
- self transitions compact under their state;
- long arcs reserved for true state-to-state relationships;
- intrinsic width capped by available page width;
- technical signal / guards / effects on distinct lines and colors;
- menu work remains frozen.

## Owner follow-up after A4BI

The owner requires manual diagram layout editing while preserving EFSM semantics:

- right-button drag moves an EFSM state in DEV;
- transition arrows remain anchored to source and target while dragging;
- diagram geometry must not be persisted in OWASYS database;
- generated applications must carry their own diagram layout into their own DEV environment;
- generated application layout companion: `config/application.fsm.layout.json`;
- OWASYS front layout companion: `config/fsm.layout.json`;
- if no persisted layout exists, OPUS computes deterministic automatic geometry, persists it, rereads it, then renders the persisted geometry;
- if a persisted layout exists, persisted state positions win;
- after an EFSM schema change, existing manual positions are retained, new states are auto-positioned and merged, removed states are pruned;
- layout persistence is presentation-only and must never mutate EFSM states, signals, transitions, guards or actions.

This follow-up is implemented by P117W R45B2A4BJ.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
