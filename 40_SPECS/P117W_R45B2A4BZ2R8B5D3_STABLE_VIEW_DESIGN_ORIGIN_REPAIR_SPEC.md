# P117W R45B2A4BZ2 R8B5D3 — Stable VIEW/DESIGN origin repair — SPEC

State: OWNER RUNTIME REJECTED — SUPERSEDED BY R8B5D4

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- `sites/owasys-front/www/asset/css/fsm-native.css` baseline blob: `085e6a9e68b775461f18e5276e4b4c95d5b76d29`.
- `sites/owasys-front/application/default/services/ScorePageRenderer.php` baseline blob: `0512c3427a190f4a6184710372d78e21f758b39f`.

## Owner runtime result

R8B5D3 improved the VIEW/DESIGN whole-SVG placement, but owner screenshots proved that VIEW still does not render the same transition presentation as DESIGN.

STATE geometry is stable, while several SIGNAL transition paths/arrows and label leaders are wrong in VIEW and repaired in DESIGN. Therefore R8B5D3 did not satisfy the architectural invariant that diagnostic VIEW and DESIGN use the same canonical graph.

## Corrected root cause

The remaining divergence is not a storage, REST, ACL or CSS-origin defect.

`OPUS_FSM_Diagram::renderHtml()` emits `layoutInteractionScript()` only when layout persistence is writable. That script contains not only editing/persistence behavior, but also read-time geometry reconciliation:

- local edge endpoint validation;
- local edge self-healing through `repairLocalTransition()`;
- label-leader reconstruction;
- initial-marker reconciliation.

Because DESIGN is writable, that reconciliation runs there. VIEW is read-only, so the script is not emitted and the same persisted geometry is not reconciled.

## Supersession

R8B5D4 separates the two responsibilities in generic OPUS:

- geometry reconciliation: active in VIEW and DESIGN whenever persisted geometry exists;
- edit/drag/persistence: active only when `writable=true`.

R8B5D3 CSS changes are not to be reverted automatically by R8B5D4. They are outside D4's target and must remain byte-for-byte untouched if locally present.

## Retained non-goals

No R8B5D4 correction may alter:

- EFSM definitions;
- any `*.fsm.layout.json` companion;
- R8B5D REST/Composer persistence flow;
- ACL;
- SecurityContext/SignalBus;
- OWASYS backend;
- STATE/SIGNAL persisted coordinates;
- working right-button drag/persistence semantics.
