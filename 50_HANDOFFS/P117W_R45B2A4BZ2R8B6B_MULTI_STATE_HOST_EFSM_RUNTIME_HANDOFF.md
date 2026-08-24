# P117W R45B2A4BZ2 R8B6B — Multi-state host EFSM runtime — HANDOFF

State: FAILED PRE-WRITE — SUPERSEDED BY R8B6B1 — DO NOT APPLY

## Owner execution evidence — 2026-08-25

The owner executed the delivered applicator from a clean `H:\OPUS` worktree.

Observed sequence:

- `P117W_R45B2A4BZ2R8B6B_PREFLIGHT_BEGIN`;
- fatal `P117W_R45B2A4BZ2R8B6B_BASELINE_BLOB_INVALID` on `sites/owasys-back/application/fsm/services/OwasysFsmLayoutCommandProvider.php`;
- the diagnostic printed actual Git object id `5a9f7150867d783a9e92fb7a7d7c51b306d8c65e`, which is also the canonical blob id recorded for that exact path at the accepted OPUS HEAD;
- no `PREFLIGHT_OK` marker was reached;
- no writes had started;
- `composer opus:validate-site -- owasys-front` PASS;
- `composer opus:validate-site -- owasys-back` PASS;
- `composer opus:validate-site -- essai` PASS;
- final `git status --short` empty;
- final `git diff --check` empty.

Therefore OPUS remained byte-state clean from Git's point of view and R8B6B was not applied.

The failure is classified as an applicator preflight-verifier defect/inconsistency, not an OPUS source defect. Because the diagnostic actual object id equals the canonical expected object id, the verifier must not use the previous worktree-object comparison path for this gate.

R8B6B is superseded by R8B6B1, which keeps the functional payload unchanged but verifies each baseline path against the canonical HEAD tree object using `git rev-parse --verify HEAD:<path>` and strict SHA comparison.

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `56d4293f21f0a049cfe7cbe968916896de47dc41` (`opus_p117w_r45b2a4bz2r8b5d4_view_readonly_geometry_runtime_reconciliation`).
- Accepted predecessor: R8B5D4.
- R8B6A rejected; R8B6B preflight failed before write.
- Functional specification remains `40_SPECS/P117W_R45B2A4BZ2R8B6B_MULTI_STATE_HOST_EFSM_RUNTIME_SPEC.md`.

## Intended functional payload retained by R8B6B1

Six autonomous OWASYS-front host EFSMs:

- `registry` -> `config/registry.fsm.json`;
- `application` -> `config/application.fsm.json`;
- `data` -> `config/data.fsm.json`;
- `source` -> `config/source.fsm.json`;
- `git` -> `config/git.fsm.json`;
- `build` -> `config/build.fsm.json`.

Runtime communication remains:

`owasys-front/navigation -> COMMAND enter_<context>_context -> owasys-front/<context> -> EVENT <context>_context_ready -> owasys-front/navigation`

The runtime state projection, Source/Git/Build lifecycle integration, admin-only system EFSM mutation rule, Structure/Security preservation, R8B5D4 renderer preservation and 20-path intended OPUS surface remain unchanged in R8B6B1.

## Failed artifact retained for traceability

- ZIP: `opus_p117w_r45b2a4bz2r8b6b_multi_state_host_efsm_runtime.zip`;
- recorded ZIP SHA-256: `c89368600f98c56fa29087fc2333d30e16d44543c546f1620f1485802f52c29c`;
- recorded applicator SHA-256: `2852c7c5c4f7bc3cd7167980fac8974bcb78840fcefceef5f5adce32a8ac5d69`.

Do not retry this artifact. Use R8B6B1 only.
