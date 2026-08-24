# P117W R45B2A4BZ2 R8B6A — OWASYS-front host context micro-EFSM fanout — SPEC

State: REJECTED — DO NOT APPLY

## Historical source gate

- README-FIRST blob used for R8B6A: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline used for R8B6A: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- Accepted predecessor: R8B5D4.

## Rejection

R8B6A is retained only as historical evidence. Its delivered artifact must not be applied.

The defect is architectural, not an applicator failure: R8B6A created one-state host context EFSMs whose only semantic activity was an enter-context self-loop. That would separate diagram source authority from `config/fsm.json`, but would not model the actual Registry/Application/Data/Source/Git/Build workflows already present in OWASYS.

It would therefore risk presenting an apparent EFSM fanout while the real operation lifecycle remained represented only by the global navigation FSM.

## Superseding rule

R8B6B supersedes R8B6A and must:

1. use autonomous multi-state host EFSMs derived from real current OWASYS operations;
2. keep Navigation as the top routing/orchestration FSM while progressively moving contextual runtime lifecycle into the host EFSMs;
3. use the generic `Opus\Fsm\FsmSignalBus` for inter-EFSM COMMAND/EVENT communication;
4. persist and render the real current host EFSM state rather than always rendering `initial_state`;
5. split Git into its own `git` EFSM while Source remains its own `source` EFSM;
6. preserve Structure and Security selected-application authority;
7. enforce system-application EFSM mutation authorization both in owasys-front and owasys-back, not only in UI projection.

## Preserved historical artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6a_host_context_efsm_fanout.zip`;
- ZIP SHA-256: `1740f3a60daf4643f4e5e806b96d6026b609f7ffb94a099e1e9ed05ed87141e6`;
- applicator: `apply_a4bz2r8b6a.php`;
- applicator SHA-256: `e14c353774bf21a38087b42f4271b8294b3b135fa110934a0a2a31fff67896e6`.

These values are retained for traceability only. They are explicitly non-authoritative for deployment.

## Successor

See `40_SPECS/P117W_R45B2A4BZ2R8B6B_MULTI_STATE_HOST_EFSM_RUNTIME_SPEC.md`.
