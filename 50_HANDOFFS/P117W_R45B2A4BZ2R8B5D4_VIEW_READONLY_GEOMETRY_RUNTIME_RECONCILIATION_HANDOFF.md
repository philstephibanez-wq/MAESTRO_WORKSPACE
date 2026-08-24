# P117W R45B2A4BZ2 R8B5D4 — VIEW read-only geometry runtime reconciliation — HANDOFF

State: OWNER RUNTIME PARTIAL PASS — INTERNAL GEOMETRY PASS — WHOLE-GRAPH ORIGIN FAIL — SUPERSEDED BY R8B5D5

## Source of truth

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- Renderer target baseline: `Opus/Fsm/Diagram.class.php` blob `255ce381932be8796f6a80d1a09228c001255d80`.
- Contextual builder: `sites/owasys-front/application/default/services/FsmDiagramBuilder.php` blob `0f17ee29537603b09911fe0f7acd7fb136b46128`.

## Contract

`VIEW = DESIGN - modification capability`.

R8B5D4 makes the existing renderer geometry reconciliation execute in VIEW and DESIGN while leaving drag, CSRF rotation and persistence POST writable-only.

## Delivered artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b5d4_view_readonly_geometry_runtime_reconciliation.zip`;
- ZIP SHA-256: `96b426f5e34db3a3399e9eb13bface7c82d9129a5143bcb58e082459d63745db`;
- applicator: `apply_a4bz2r8b5d4.php`;
- applicator SHA-256: `c83cc1acc3dfb13b2210d13242adffb143e911563528ea00a6fcf86c7b23822a`.

## Owner runtime evidence — 2026-08-24

Two captures of the same `owasys-front / security` EFSM were compared:

- VIEW `/fr-FR/sécurité?operation=read`;
- DESIGN `/fr-FR/sécurité?fsm_design=1`.

R8B5D4 result:

- relative STATE/SIGNAL geometry is stable;
- transition paths/arrows, label leaders and initial marker are reconciled in VIEW as intended;
- DESIGN remains the editable projection;
- however the complete graph is still shifted to the right in VIEW relative to DESIGN.

Image registration shows scale approximately `1.000` and horizontal translation approximately `145 px`. This isolates the remaining failure to whole-surface origin/centering rather than FSM coordinates or scaling.

## Non-regression boundary for successor

R8B5D5 must preserve byte-for-byte:

- the local R8B5D4 `Opus/Fsm/Diagram.class.php` correction;
- every `*.fsm.layout.json` file;
- REST/back/Composer persistence flow;
- ACL/Security/SecurityContext/SignalBus;
- DESIGN right-button drag/persistence behavior;
- EFSM definitions.

No fixed pixel translation is allowed. R8B5D5 must remove the responsive centering authority so the graph origin is invariant when the DESIGN inspector changes the available canvas width.

## Supersession

R8B5D4 remains useful and must be retained, but its full runtime acceptance is closed as partial. R8B5D5 owns the final exact-origin correction.
