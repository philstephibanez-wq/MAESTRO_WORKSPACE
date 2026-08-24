# P117W R45B2A4BZ2 R8B5D5 — VIEW/DESIGN exact graph-origin invariance — HANDOFF

State: CLOSED — NOT APPLIED — OWNER ACCEPTED INSPECTOR OFFSET — DO NOT REUSE

## Historical artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b5d5_view_design_exact_origin_invariance.zip`;
- ZIP SHA-256: `29d0e961c5aa28f0338e05012ab078fcb24809a445c377caf570677b3bfa0b33`;
- applicator SHA-256: `6e7845aca09f998e1f26ddb99246a62722082dd3ed06876ed68f2d93f488c643`.

The artifact was built against historical baseline `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`. It was not applied before R8B5D4 itself was committed/pushed as `56d4293f21f0a049cfe7cbe968916896de47dc41`, so its preflight is stale in addition to the owner decision below.

## Owner decision — 2026-08-24

The remaining VIEW/DESIGN whole-graph horizontal offset was identified as a consequence of the DESIGN inspector reducing canvas width. The owner explicitly accepted this as non-blocking and requested continuation on the remaining views that still expose the global FSM.

Therefore:

- do not apply this ZIP;
- do not rebuild it automatically;
- do not modify accepted R8B5D4 graph reconciliation or current layout companions for cosmetic origin parity;
- resume only on explicit future owner request if exact origin parity becomes required.

## Active successor

R8B6A: dedicated communicating OWASYS-front context micro-EFSMs for the remaining global-FSM views.
