# P117W R45B2A4BZ2 R8B5D4 — VIEW read-only geometry runtime reconciliation — HANDOFF

State: ACCEPTED/PUSHED — INTERNAL GRAPH GEOMETRY PASS — INSPECTOR OFFSET ACCEPTED NON-BLOCKING

## Source of truth

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- Accepted OPUS commit: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- Commit message: `opus_p117w_r45b2a4bz2r8b5d4_view_readonly_geometry_runtime_reconciliation`.
- Generic renderer blob at accepted commit: `1c307116bd6da961f9afcab62b47bc1a87131c64`.

## Accepted contract

`VIEW = DESIGN - modification capability` for the graph itself.

R8B5D4 makes the existing transition/leader/initial-marker geometry reconciliation execute in VIEW and DESIGN while leaving drag, CSRF rotation and persistence POST writable-only.

## Owner runtime evidence — 2026-08-24

Comparison of the same `owasys-front / security` EFSM in VIEW and DESIGN established:

- STATE geometry is preserved;
- SIGNAL cards are preserved;
- transition paths/arrows and label leaders are correctly reconciled in VIEW;
- initial marker reconciliation is preserved;
- DESIGN remains editable and its layout persistence remains operational;
- the inspector column in DESIGN changes available viewport width and therefore produces a whole-surface horizontal visual offset relative to VIEW.

The owner explicitly classified this inspector-induced offset as **not very annoying / non-blocking** and requested continuation of functional EFSM decomposition instead of further cosmetic correction.

## Push evidence

OPUS HEAD is now `56d4293f21f0a049cfe7cbe968916896de47dc41` and contains the R8B5D4 generic renderer correction. The owner commit also contains the accepted current Security layout companion; that layout is part of the new baseline and must not be rewritten by later slices unless explicitly required.

## Successor rule

Do not reopen VIEW/DESIGN origin cosmetics while implementing the next functional slices. Preserve:

- `Opus/Fsm/Diagram.class.php` R8B5D4 behavior;
- all current `*.fsm.layout.json` companions;
- DESIGN right-button drag/persistence;
- Security and Structure contextual EFSM behavior;
- REST/back/Composer layout persistence.

The next active series is R8B6: decomposition of the remaining OWASYS-front global-FSM views into dedicated communicating micro-EFSMs.
