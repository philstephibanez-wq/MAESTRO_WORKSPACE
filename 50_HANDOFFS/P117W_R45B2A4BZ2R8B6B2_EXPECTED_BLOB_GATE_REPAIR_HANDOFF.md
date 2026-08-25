# P117W R45B2A4BZ2 R8B6B2 — Expected blob gate repair — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob revalidated immediately before delivery: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master revalidated immediately before delivery: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- R8B6B failed before write.
- R8B6B1 failed before write and is superseded.
- R8B6B1 failure appendix: `50_HANDOFFS/P117W_R45B2A4BZ2R8B6B1_PREFLIGHT_FAILURE_APPENDIX.md`.
- R8B6B2 specification: `40_SPECS/P117W_R45B2A4BZ2R8B6B2_EXPECTED_BLOB_GATE_REPAIR_SPEC.md`.

## Exact failure cause

The B1 runner embedded the expected Git blob for:

`sites/owasys-back/application/fsm/services/OwasysFsmLayoutCommandProvider.php`

as the malformed 39-character value:

`5a9f7150867d783a9e92fb7a7d7c51b306d8c65`

Fresh GitHub source inspection at the exact OPUS baseline gives:

`5a9f7150867d783a9e92fb7a7d7c51b306d8c65e`

The malformed value appeared in both `existingBlobs` and the corresponding `patches[*].blob` metadata.

The prior failure message printed only the actual object id, which obscured the malformed expected value.

## R8B6B2 verifier repair

R8B6B2:

1. repairs both malformed embedded blob values;
2. validates every expected baseline object id as exactly 40 lowercase hexadecimal characters before comparison;
3. verifies the canonical object through `git rev-parse --verify HEAD:<path>`;
4. reports both expected and actual object ids on mismatch;
5. emits `expected_blob_shape=40hex` after successful preflight.

## Full baseline audit

All 11 existing target blobs in the B2 applicator were compared against freshly fetched GitHub source metadata from the accepted OPUS HEAD.

Result: 11/11 exact.

All values in `existingBlobs`: 40 hex — PASS.

All nine `patches[*].blob` metadata values: 40 hex — PASS.

## Functional payload identity

R8B6B2 does not alter the R8B6B functional evolution.

Compared with B1:

- `expectedModified`: identical decoded content;
- `expectedNew`: identical decoded content;
- `specialCounts`: identical decoded content;
- `newFiles`: identical decoded content;
- PHP replacement transformations: identical after excluding the corrected `blob` metadata;
- only verifier metadata, slice markers and diagnostics differ.

The intended mutation therefore remains the same 20 OPUS paths implementing six multi-state host EFSMs (`registry`, `application`, `data`, `source`, `git`, `build`), COMMAND/EVENT communication, persisted runtime-current-state projection and system-EFSM mutation ACL reinforcement.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6b2_expected_blob_gate_repair.zip`;
- ZIP SHA-256: `18ab92512c2365a14ba87d0644906ed9b2e2ae86a2021c6ce31123d338673f04`;
- ZIP contains exactly `apply_a4bz2r8b6b2.php`;
- applicator size: `131044` bytes;
- applicator SHA-256: `2d935c99d9c68dc1fb43d4f5b432ecad19ce8b92302274270629f2afaa409eaa`;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- extracted applicator PHP lint: PASS;
- 11/11 expected baseline blobs 40-hex and GitHub-equal: PASS;
- 9/9 patch metadata blobs 40-hex: PASS;
- functional transformation identity with B1: PASS;
- no internal Composer invocation.

## Expected success markers

- `P117W_R45B2A4BZ2R8B6B2_PREFLIGHT_BEGIN`;
- `P117W_R45B2A4BZ2R8B6B2_PREFLIGHT_OK`;
- `expected_blob_shape=40hex`;
- `P117W_R45B2A4BZ2R8B6B2_REPO_CHANGES_VERIFIED`;
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
- `P117W_R45B2A4BZ2R8B6B2_APPLIED`.

## Owner validation

Do not retry R8B6B or R8B6B1.

Apply only R8B6B2 from a temporary directory outside `H:\OPUS`.

After success run external Composer validation for owasys-front, owasys-back and essai, then `git status --short` and `git diff --check`.

Do not commit/push OPUS until the complete R8B6B runtime acceptance matrix passes: Applications/registry, Application/application, Data/data, Source/source, Git/git, Build/build, real `fsm.network` COMMAND/EVENT traces, Source/Git/Build operations, Structure/Security preservation, admin host DESIGN, developer system-mutation denial and R8B5D4 VIEW geometry preservation.
