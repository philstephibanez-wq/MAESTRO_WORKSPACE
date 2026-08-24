# P117W R45B2A4BZ2 R8B5D5 — VIEW/DESIGN exact graph-origin invariance — SPEC

State: NOT REQUIRED / NOT APPLIED — OWNER ACCEPTED INSPECTOR OFFSET — SUPERSEDED BY R8B6 FUNCTIONAL WORK

## Historical source gate

- README-FIRST blob at build: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- Historical OPUS baseline: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- R8B5D5 was prepared only to remove the whole-surface horizontal offset caused by differing VIEW/DESIGN available widths.

## Owner decision — 2026-08-24

After R8B5D4, the graph-internal contract is operational: STATE, SIGNAL, transition arrows/paths, leaders and marker are reconciled in VIEW; DESIGN remains editable with working persistence. The remaining horizontal offset is caused by the DESIGN inspector reducing the available canvas width.

The owner explicitly classified that offset as non-blocking and requested no further work on it. R8B5D5 therefore must **not** be applied as part of the active development line.

## Preserved artifact

The historical R8B5D5 artifact remains recorded for traceability but is not an active target. Do not reuse it without a new explicit owner request and a fresh source gate.

## Active successor

R8B6 now owns the requested functional evolution: replace the remaining OWASYS-front global-FSM diagnostic views with dedicated communicating micro-EFSMs while preserving the accepted R8B5D4 renderer, layouts and edit/persistence behavior.
