# P117W R45B2A4BZ2 R8B6B2 — Expected blob gate repair — HANDOFF

State: OWNER APPLIED — RUNTIME PARTIAL — PROJECTION FAILURE SUPERSEDED BY R8B6B3

## Source gate

- README-FIRST blob at delivery: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- R8B6B and R8B6B1 failed before write and are superseded.
- R8B6B2 successfully produced the six host EFSM sources and runtime communication locally; OPUS was not committed/pushed before runtime acceptance.

## Runtime evidence received 2026-08-25

OWASYS-front logs prove successful inter-EFSM COMMAND/EVENT handshakes before projection:

- `navigation -> registry -> navigation`, context state `browsing`;
- `navigation -> source -> navigation`, context state `browsing`;
- `navigation -> build -> navigation`, context state `ready`;
- `navigation -> data -> navigation`, context state `ready`;
- `navigation -> application -> navigation`, context state `selected`.

Correlation and causation IDs are present and matched.

Structure and Security requests complete successfully in the same run.

OWASYS-back logs prove secured REST/Composer reads of the new EFSM files return HTTP 200.

## Runtime failure

After successful host handshakes, Applications, Source, Build, Data and Application rendering fail in OWASYS-front with:

`OWASYS_APPLICATION_EFSM_CONTRACT_INVALID`

at:

`sites/owasys-front/application/fsm/models/ApplicationFsmModel.php:91`.

This file was not part of R8B6B2.

Fresh source inspection shows that `OwasysApplicationFsmModel::snapshot()` hard-codes a closed whitelist of four historic FSM contract names. R8B6B2 host definitions use the valid new contract `OWASYS_HOST_CONTEXT_FSM_V1`, so the generic projection rejects them after their runtime has already executed successfully.

## Architectural disposition

Do not add `OWASYS_HOST_CONTEXT_FSM_V1` as another local whitelist entry. The projection must use the existing generic OPUS `Opus\Fsm\Definition\FsmDefinitionValidator` and keep only ownership/context checks (`site_id`, `efsm_id`, source, hash) locally.

This correction is R8B6B3.

## R8B6B2 artifact history

- ZIP: `opus_p117w_r45b2a4bz2r8b6b2_expected_blob_gate_repair.zip`;
- ZIP SHA-256: `18ab92512c2365a14ba87d0644906ed9b2e2ae86a2021c6ce31123d338673f04`;
- applicator SHA-256: `2d935c99d9c68dc1fb43d4f5b432ecad19ce8b92302274270629f2afaa409eaa`.

R8B6B2 local changes must be preserved and must not be restored before applying R8B6B3.
