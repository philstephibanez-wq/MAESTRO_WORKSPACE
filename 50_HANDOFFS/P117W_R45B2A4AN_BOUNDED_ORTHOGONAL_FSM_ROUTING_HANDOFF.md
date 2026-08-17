# P117W R45B2A4AN — Handoff

State: OWNER VALIDATED — COMMITTED IN OPUS

## Baseline and owner validation

A4AN was applied and visually validated by the owner, then committed in OPUS as:

`5e8e5d2287e6c9720d61bf7cab7ae604c4811dee`

Owner browser result: substantially improved diagram. The bounded orthogonal rail approach is accepted as the new geometry baseline, including the merged visual logout rails.

## Accepted correction

A4AN corrected the blocking geometry defect where the classic renderer could emit long `outer-forward` / `outer-return` paths outside the SVG viewBox.

Reproduced pre-A4AN geometry:

- SVG viewBox: `3856 x 1256`;
- outer paths before A4AN: Y `76..1464`.

A4AN introduced generic OPUS component `FsmDiagramGeometryNormalizer` and bounded those outer paths with deterministic orthogonal rails while preserving transition ids, semantic endpoints, actionability, state order, current-state highlight and signal typing.

The 21 external transition instances were reduced to 8 shared visual rail families. Repeated global families such as `logout` share a rail while every source connection remains present. The actionable current-state label remains the visible/clickable owner of the shared family.

## Delivered artifact

`opus_p117w_r45b2a4an_bounded_orthogonal_fsm_routing.zip`

SHA-256:

`e85c5c043f5b50f13fc370d31f6f7f6b77daade78af90b3d6d4c4986cae92ff5`

Five complete files were delivered. No patcher and no deletion.

## Follow-up findings accepted for A4AO

A4AN is the accepted baseline, but the owner requests a further presentation pass:

1. reduce vertical height again;
2. fit the diagram to available width without horizontal scrolling if possible;
3. signal labels must not be bold;
4. mouse-wheel vertical scrolling over the FSM must scroll the OWASYS page normally.

The wheel issue is traced to the A4AN canvas remaining an `overflow-y:auto` scroll container with `overscroll-behavior:contain`, which can trap vertical wheel chaining while the pointer is over the diagram.

A4AO owns these follow-up presentation changes.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
