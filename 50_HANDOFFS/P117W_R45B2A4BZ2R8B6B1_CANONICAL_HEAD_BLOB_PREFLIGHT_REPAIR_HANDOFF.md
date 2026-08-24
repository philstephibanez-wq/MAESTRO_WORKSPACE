# P117W R45B2A4BZ2 R8B6B1 — Canonical HEAD blob preflight repair — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob revalidated in this work cycle: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- R8B6B failed before any write; owner final `git status --short` and `git diff --check` were empty.
- owasys-front, owasys-back and essai external site validation all passed after the failed R8B6B preflight.
- R8B6B1 specification: `40_SPECS/P117W_R45B2A4BZ2R8B6B1_CANONICAL_HEAD_BLOB_PREFLIGHT_REPAIR_SPEC.md`.

## Failure treated

R8B6B emitted `BASELINE_BLOB_INVALID` for `OwasysFsmLayoutCommandProvider.php` while printing actual object id `5a9f7150867d783a9e92fb7a7d7c51b306d8c65e`.

Fresh GitHub inspection at the same accepted HEAD confirms that exact path has canonical blob `5a9f7150867d783a9e92fb7a7d7c51b306d8c65e`.

Therefore R8B6B1 changes the verifier boundary only. It does not alter OPUS functional source payload to satisfy a false preflight rejection.

## Verifier repair

R8B6B used a helper based on `git hash-object -- <worktree path>` plus `hash_equals()`.

R8B6B1 verifies the canonical tree object directly:

`git rev-parse --verify HEAD:<path>`

and requires a lowercase 40-hex object id that strictly equals the frozen expected blob id.

The runner still requires the exact HEAD and an empty worktree/index before checking per-path blobs.

## Functional payload identity

The following encoded payload sections were compared between the failed R8B6B runner and R8B6B1 and are byte-identical:

- `existingBlobs`;
- `patches`;
- `expectedModified`;
- `expectedNew`;
- `specialCounts`;
- `newFiles`.

Therefore the intended OPUS mutation remains exactly the R8B6B 20-path multi-state host EFSM delivery. No additional OPUS source file is introduced by this runner repair.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6b1_canonical_head_blob_preflight_repair.zip`;
- ZIP SHA-256: `2b30fc693ad737ff3f35cccb8e806d51b2dbd8fe704da502e4401c3c8d9a8fc4`;
- ZIP contains exactly `apply_a4bz2r8b6b1.php`;
- applicator size: `130705` bytes;
- applicator SHA-256: `2bae70ba89b1e56def13d1bca9a6739bf757edad1c761b4c8015a02d527ff8eb`;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- extracted applicator PHP lint: PASS;
- encoded functional payload identity with R8B6B: PASS;
- no internal Composer invocation.

## Expected success markers

- `P117W_R45B2A4BZ2R8B6B1_PREFLIGHT_BEGIN`;
- `P117W_R45B2A4BZ2R8B6B1_PREFLIGHT_OK`;
- `P117W_R45B2A4BZ2R8B6B1_REPO_CHANGES_VERIFIED`;
- `baseline_head=56d4293f21f0a049cfe7cbe968916896de47dc41`;
- `baseline_blob_source=HEAD_tree`;
- `changed_paths=20`;
- `host_context_efsms=registry,application,data,source,git,build`;
- `communication=navigation>command>context>event>navigation`;
- `runtime_state_projection=persisted`;
- `host_designer_acl=owasys:modify`;
- `selected_app_designer_acl=fsm:update`;
- `backend_system_mutation_acl=owasys:modify`;
- `composer_validation=external_terminal`;
- `P117W_R45B2A4BZ2R8B6B1_APPLIED`.

## Owner validation sequence

Apply from a temporary directory outside `H:\OPUS`; do not retry the R8B6B ZIP.

After applicator success, run external Composer validation for owasys-front, owasys-back and essai, then `git status --short` and `git diff --check`.

Do not commit/push OPUS until the full runtime acceptance matrix from R8B6B passes: six host EFSM views, persisted runtime-current-state projection, real COMMAND/EVENT network traces, Source/Git/Build operations, Structure/Security preservation, admin host DESIGN, developer system-mutation denial and R8B5D4 VIEW geometry preservation.
