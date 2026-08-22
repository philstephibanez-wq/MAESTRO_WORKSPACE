# P117W R45B2A4BZ2R7R1 — Single EFSM graphics authority handoff

State: OWNER VALIDATION FAILED — SUPERSEDED BY R7R2

## Intended artifact

`opus_p117w_r45b2a4bz2r7r1_single_graphics_authority.zip`

The previous handoff claimed nine resulting OPUS/OWASYS changed paths. Real owner validation did not confirm that result.

## Real baseline after owner validation

Owner commit:

`340d195907c7743154728578c255fe6ea46b7c14`

Commit message:

`opus_p117w_r45b2a4bz2r7r1_single_graphics_authority`

GitHub comparison against R7 (`72101e0cfb77f2933284371e142d30b3d30073ad`) shows only one resulting changed path:

- `sites/owasys-front/config/fsm.layout.json`

The intended FSM/menu/routes/source corrections are not present in that baseline.

## Owner runtime evidence

The supplied front logs show:

- layout POST failure `OPUS_FSM_DIAGRAM_LAYOUT_COORDINATE_INVALID`;
- following layout POSTs repeatedly fail `OPUS_CSRF_TOKEN_INVALID`;
- `/fr-FR/fsm` still executes and fails with `OPUS_FSM_DIAGRAM_SIGNAL_ORIGIN_INVALID`.

Profiler evidence confirms `g_open_fsm` is still executed from the runtime EFSM and targets `workflows`.

## Root causes carried into R7R2

1. False FSM user destination still exists structurally in canonical state/signal/transition/route configuration.
2. Layout CSRF token is consumed before payload validation, causing a stale-token cascade after one geometry error.
3. Client drag serialization can emit invalid derived coordinates.
4. Generic signal-origin normalization returns `unspecified` for an absent origin but rejects `unspecified` on a second normalization.
5. A stale live session can still reference `workflows` after the corrected definition removes it.

## Disposition

Do not use R7R1 as a validated delivery reference. Continue only from `340d195907c7743154728578c255fe6ea46b7c14` with P117W R45B2A4BZ2R7R2.
