# P117W R45B2A4BZ2 R8B5D4 — VIEW read-only geometry runtime reconciliation — SPEC

State: OWNER RUNTIME PARTIAL PASS — GEOMETRY RECONCILIATION PASS — EXACT ORIGIN GATE FAILED — SUPERSEDED BY R8B5D5

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- Generic renderer target: `Opus/Fsm/Diagram.class.php` blob `255ce381932be8796f6a80d1a09228c001255d80`.
- Contextual caller: `sites/owasys-front/application/default/services/FsmDiagramBuilder.php` blob `0f17ee29537603b09911fe0f7acd7fb136b46128`.

Applicable architecture invariant: the same canonical graph is used in diagnostic VIEW and DESIGN; DESIGN only adds editing capability.

## R8B5D4 correction

R8B5D4 decouples geometry reconciliation from writability in generic `OPUS_FSM_Diagram`:

- persisted transition/leader/marker reconciliation executes in VIEW and DESIGN;
- VIEW returns before CSRF, persistence POST and drag handlers;
- DESIGN editing/persistence remains writable-only.

No alternate renderer or duplicate geometry model is introduced.

## Owner runtime evidence — 2026-08-24

Owner supplied two captures of the same `owasys-front / security` EFSM:

- VIEW: `/fr-FR/sécurité?operation=read`;
- DESIGN: `/fr-FR/sécurité?fsm_design=1`.

Observed result:

- STATE, SIGNAL, transition curves/arrows, leaders and initial marker now keep the same relative graph geometry;
- the remaining mismatch is a translation of the complete graph to the right in VIEW;
- image registration gives unit scale (approximately `1.000`) and a horizontal translation of about `145 px`, with no meaningful rotation;
- the remaining defect is therefore presentation origin, not FSM semantic geometry, persistence coordinates or graph scale.

R8B5D4 is consequently a partial runtime PASS but not a complete acceptance of the canonical contract `VIEW = DESIGN - modification capability`.

## Non-regression boundary carried forward

The next correction must not modify or restore:

- `Opus/Fsm/Diagram.class.php` R8B5D4 local correction;
- any `*.fsm.layout.json` companion;
- any EFSM definition;
- OWASYS REST/back/Composer source;
- ACL/security rules;
- SecurityContext/SignalBus;
- working DESIGN right-button drag/persistence semantics.

No hard-coded pixel compensation is permitted. The remaining origin defect must be removed at the responsive presentation/cascade authority that centers the diagram relative to available canvas width.

## Supersession

R8B5D5 owns the remaining exact VIEW/DESIGN origin-invariance gate.
