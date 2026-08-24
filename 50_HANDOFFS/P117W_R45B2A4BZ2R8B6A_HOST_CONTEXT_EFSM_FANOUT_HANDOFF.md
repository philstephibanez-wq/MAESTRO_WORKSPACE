# P117W R45B2A4BZ2 R8B6A — OWASYS-front host context micro-EFSM fanout — HANDOFF

State: REJECTED — NEVER APPLY

## Historical source of truth

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- R8B5D4 remains the accepted OPUS predecessor.

## Owner/architecture decision

R8B6A is rejected before owner application. No OPUS commit was created from it.

Reason: its five host context EFSMs were one-state machines with enter-context self-loops. That established presentation authority but did not represent the real contextual workflows. Registry, Source/Git and Build already have meaningful signals and operation lifecycles in the current runtime; a one-state fanout would therefore be an architectural façade rather than the requested FSM decomposition.

## Historical artifact retained

- ZIP: `opus_p117w_r45b2a4bz2r8b6a_host_context_efsm_fanout.zip`;
- ZIP SHA-256: `1740f3a60daf4643f4e5e806b96d6026b609f7ffb94a099e1e9ed05ed87141e6`;
- applicator: `apply_a4bz2r8b6a.php`;
- applicator SHA-256: `e14c353774bf21a38087b42f4271b8294b3b135fa110934a0a2a31fff67896e6`.

The artifact is preserved only for audit/history and is explicitly forbidden for application.

## Successor

R8B6B replaces R8B6A with:

- six host EFSMs: `registry`, `application`, `data`, `source`, `git`, `build`;
- real multi-state definitions;
- persisted current-state projection;
- actual Navigation↔Context COMMAND/EVENT handshake through `FsmSignalBus`;
- runtime lifecycle recording around real Registry, Source/Git and Build operations;
- Git separated from Source as its own EFSM;
- system EFSM mutation authorization enforced in both owasys-front and owasys-back;
- Structure and Security behavior preserved.

See `40_SPECS/P117W_R45B2A4BZ2R8B6B_MULTI_STATE_HOST_EFSM_RUNTIME_SPEC.md`.
