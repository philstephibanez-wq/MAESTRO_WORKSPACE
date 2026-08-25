# P117W R45B2A4BZ2 R8B6B3 — Generic EFSM validator projection repair — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob revalidated this cycle: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master revalidated this cycle: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- R8B6B2 is applied locally and intentionally uncommitted/unpushed pending runtime acceptance.
- R8B6B2 handoff now records runtime partial failure and preservation requirement.
- Spec: `40_SPECS/P117W_R45B2A4BZ2R8B6B3_GENERIC_EFSM_VALIDATOR_PROJECTION_REPAIR_SPEC.md`.

## Runtime evidence

Uploaded OWASYS-front logs show successful, correlated `fsm.network` COMMAND/EVENT handshakes for registry, source, build, data and application before rendering fails. Context states observed are `browsing`, `browsing`, `ready`, `ready`, and `selected` respectively.

The failure immediately after each handshake is:

`OWASYS_APPLICATION_EFSM_CONTRACT_INVALID`

from `sites/owasys-front/application/fsm/models/ApplicationFsmModel.php:91`.

Uploaded OWASYS-back logs show the corresponding secured REST/Composer source reads succeed with HTTP 200, including reads of `registry.fsm.json`, `source.fsm.json`, `build.fsm.json`, `data.fsm.json`, and `application.fsm.json`.

## Root cause and correction

Current `OwasysApplicationFsmModel::snapshot()` owns a hard-coded whitelist of four historic contract strings. The six R8B6B2 host EFSMs use `OWASYS_HOST_CONTEXT_FSM_V1`.

R8B6B3 does not extend that whitelist. It removes the closed contract taxonomy from this generic projection and delegates structural EFSM validation to the existing generic OPUS service:

`Opus\Fsm\Definition\FsmDefinitionValidator`.

The model still requires a non-empty contract and preserves existing `site_id`, `efsm_id`, source-path, hash and projection checks.

## Exact OPUS source surface

One additional modified path only:

`sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`

Baseline Git blob:

`4ffbae0db7d30f618089d11192941231f78b27e8`.

R8B6B3 does not modify any of the 20 R8B6B2 paths.

## Applicator preservation model

The runner is specifically designed for the owner state where R8B6B2 is already applied but not committed.

It requires exactly:

- 11 known R8B6B2 tracked worktree modifications;
- 9 known R8B6B2 untracked new files;
- no staged changes;
- no unrelated tracked or untracked paths;
- exact HEAD `56d4293f21f0a049cfe7cbe968916896de47dc41`;
- clean `ApplicationFsmModel.php` relative to HEAD.

It also validates `site.json.efsms`, all six host JSON contract/site/efsm identities, and presence of the context registry/coordinator classes.

All 20 pre-existing R8B6B2 paths are SHA-256 snapshotted before write and verified unchanged after write. On post-write failure only `ApplicationFsmModel.php` is rolled back.

## Replay validation

A deterministic synthetic Git replay representing the exact R8B6B2 dirty-state shape passed:

- preflight inventory gate: PASS;
- host registry/definition semantic gate: PASS;
- unique two-anchor transformation: PASS;
- candidate PHP lint before write: PASS;
- post-write PHP lint: PASS;
- 20/20 pre-existing path byte preservation: PASS;
- final inventory = 12 tracked modified + 9 untracked = 21 paths: PASS;
- `git diff --check`: PASS;
- applicator rollback boundary limited to target: verified by implementation;
- no internal Composer invocation.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6b3_generic_efsm_validator_projection_repair.zip`;
- ZIP SHA-256: `4d598eb0bb60a19361f56656935b85347759d09dbb7bd20177c786e1667ced3b`;
- ZIP contains exactly `apply_a4bz2r8b6b3.php`;
- applicator size: `10399` bytes;
- applicator SHA-256: `942dcfa61c8bb80b3646e49eb638f5d407c29ffb9effe62e1b00ea7bad5f9bd5`;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- extracted applicator PHP lint: PASS.

## Expected markers

- `P117W_R45B2A4BZ2R8B6B3_PREFLIGHT_BEGIN`;
- `P117W_R45B2A4BZ2R8B6B3_PREFLIGHT_OK`;
- `r8b6b2_state=preserved`;
- `host_definition_contract=OWASYS_HOST_CONTEXT_FSM_V1`;
- `projection_validator=Opus\Fsm\Definition\FsmDefinitionValidator`;
- `P117W_R45B2A4BZ2R8B6B3_REPO_CHANGES_VERIFIED`;
- `preexisting_r8b6b2_paths=20`;
- `additional_changed_paths=1`;
- `total_changed_paths=21`;
- `hardcoded_contract_whitelist=removed`;
- `r8b6b2_byte_preservation=verified`;
- `P117W_R45B2A4BZ2R8B6B3_APPLIED`.

## Owner validation

Do not restore R8B6B2 before applying this ZIP.

After successful application run external Composer validation for `owasys-front`, `owasys-back` and `essai`, plus `git status --short` and `git diff --check`.

Then repeat runtime navigation through Applications, Application, Data, Source/Git and Build. The previously observed handshakes must remain and the pages must now render their dedicated EFSM diagrams instead of failing on the contract gate. Structure and Security must remain unchanged.

Do not commit/push OPUS until the full R8B6B runtime acceptance matrix passes.
