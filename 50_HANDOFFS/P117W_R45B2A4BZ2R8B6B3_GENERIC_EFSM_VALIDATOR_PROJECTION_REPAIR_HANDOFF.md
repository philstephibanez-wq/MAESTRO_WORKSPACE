# P117W R45B2A4BZ2 R8B6B3 — Generic EFSM validator projection repair — HANDOFF

State: OWNER PREFLIGHT REJECTED — NO WRITE — SUPERSEDED BY R8B6B4

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- R8B6B2 is applied locally and intentionally uncommitted/unpushed pending runtime acceptance.
- Spec: `40_SPECS/P117W_R45B2A4BZ2R8B6B3_GENERIC_EFSM_VALIDATOR_PROJECTION_REPAIR_SPEC.md`.

## Runtime evidence behind B3

Uploaded OWASYS-front logs showed successful correlated `fsm.network` COMMAND/EVENT handshakes for registry, source, build, data and application before rendering failed with `OWASYS_APPLICATION_EFSM_CONTRACT_INVALID` from `ApplicationFsmModel.php:91`.

Uploaded OWASYS-back logs showed the corresponding secured REST/Composer source reads succeeding with HTTP 200.

## Intended correction

B3 removed the hard-coded historic EFSM contract whitelist from `OwasysApplicationFsmModel::snapshot()` and delegated structural validation to the generic OPUS `Opus\Fsm\Definition\FsmDefinitionValidator`, while preserving non-empty contract, `site_id`, `efsm_id`, source-path and hash checks.

Intended additional source path only:

`sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`

Baseline Git blob: `4ffbae0db7d30f618089d11192941231f78b27e8`.

## Owner B3 preflight result

B3 failed before `PREFLIGHT_OK` and before any write.

Actual owner worktree contained the 20 R8B6B2 paths plus one legitimate persisted runtime-layout change:

`sites/owasys-front/config/fsm.layout.json`

The B3 runner incorrectly required an exact tracked inventory containing only the 11 R8B6B2 tracked source changes and therefore emitted:

`P117W_R45B2A4BZ2R8B6B3_R8B6B2_TRACKED_INVENTORY_INVALID`

Owner validations after the failure remained PASS for `owasys-front`, `owasys-back`, and `essai`; `git diff --check` remained PASS. The B3 target was not written, as confirmed by the same `OWASYS_APPLICATION_EFSM_CONTRACT_INVALID` runtime evidence after restart.

## Root cause of B3 rejection

The B3 applicator incorrectly classified persisted `*.fsm.layout.json` runtime data as an unrelated source mutation. This conflicts with the established contextual-EFSM layout persistence contract: layout companions are legitimate owner/runtime state and must be preserved, not restored or absorbed into an unrelated source patch.

## Supersession

R8B6B4 keeps the B3 functional correction unchanged but repairs the inventory gate so existing `sites/*/config/*.fsm.layout.json` tracked or untracked companions are accepted, parsed, SHA-256 snapshotted, and verified byte-for-byte unchanged after application.

Do not retry the B3 ZIP.
