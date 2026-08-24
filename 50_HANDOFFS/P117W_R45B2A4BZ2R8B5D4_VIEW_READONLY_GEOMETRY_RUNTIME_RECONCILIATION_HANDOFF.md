# P117W R45B2A4BZ2 R8B5D4 — VIEW read-only geometry runtime reconciliation — HANDOFF

State: BUILD IN PROGRESS — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source of truth

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- Renderer target blob: `255ce381932be8796f6a80d1a09228c001255d80`.
- Contextual builder blob: `0f17ee29537603b09911fe0f7acd7fb136b46128`.
- D3 is runtime rejected/superseded.

## Contract

`VIEW = DESIGN - modification capability`.

R8B5D4 changes generic `Opus/Fsm/Diagram.class.php` only. It decouples geometry reconciliation from writability while leaving drag, CSRF and persistence POST writable-only.

## Non-regression boundary

The delivery must not modify or restore CSS, ScorePageRenderer, layout companions, REST/back/Composer, ACL, SecurityContext/SignalBus or EFSM definitions. Existing local R8B5D3 presentation changes and layout geometry are preserved byte-for-byte.

## Artifact

Pending final build/replay/hash publication in this handoff before delivery.
