# P117W R45B2A4BZ2 R8B5D3 — Stable VIEW/DESIGN origin repair — HANDOFF

State: OWNER RUNTIME REJECTED — SUPERSEDED BY R8B5D4

## Source of truth

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- R8B5D3 artifact remains historical and must not be reused as the active correction.

## Runtime evidence

Owner comparison of the same `owasys-front / security` EFSM in VIEW and DESIGN shows:

- STATE geometry is effectively the same;
- DESIGN renders the SIGNAL transition paths/arrows and label leaders correctly;
- VIEW renders several of those arrows/leaders incorrectly.

The runtime conclusion is therefore: persistence/readback works, but VIEW and DESIGN still differ in transition presentation.

## Corrected root cause

Current generic OPUS `OPUS_FSM_Diagram::renderHtml()` appends `layoutInteractionScript()` only for writable diagrams. The same script also performs read-time `repairLocalTransition()` and label/marker reconciliation before installing editing handlers.

DESIGN receives this reconciliation because it is writable. VIEW does not.

## Supersession contract

R8B5D4 must implement the generic invariant:

`VIEW = DESIGN - modification capability`

The same persisted graph and the same geometry reconciliation are used in both modes. Only right-button drag, CSRF and persistence POST behavior remain writable-only.

R8B5D4 must not modify or restore:

- R8B5D3 local CSS/cache-buster changes if present;
- any `*.fsm.layout.json` file;
- REST/back/Composer persistence flow;
- ACL or Security runtime;
- working DESIGN drag/persistence behavior.

The only intended source target is generic `Opus/Fsm/Diagram.class.php`.
