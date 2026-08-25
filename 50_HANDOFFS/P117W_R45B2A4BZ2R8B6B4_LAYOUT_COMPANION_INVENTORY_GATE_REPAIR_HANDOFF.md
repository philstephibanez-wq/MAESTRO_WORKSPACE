# P117W R45B2A4BZ2 R8B6B4 — Layout companion inventory gate repair — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST revalidated immediately before delivery: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS HEAD/master revalidated immediately before delivery: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- R8B6B2 remains applied locally and uncommitted.
- R8B6B3 owner preflight failed before write and is superseded.
- Spec: `40_SPECS/P117W_R45B2A4BZ2R8B6B4_LAYOUT_COMPANION_INVENTORY_GATE_REPAIR_SPEC.md`.

## B3 failure treated

The owner worktree contained the exact R8B6B2 source state plus the legitimate runtime layout modification:

`sites/owasys-front/config/fsm.layout.json`

B3 rejected it as an unexpected tracked source path. No B3 write occurred.

## B4 correction

The B3 functional source correction is unchanged:

`sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`

moves from a hard-coded historic contract whitelist to generic `Opus\Fsm\Definition\FsmDefinitionValidator` structural validation, while preserving non-empty contract, site, EFSM, source-path and hash checks.

B4 changes only the applicator inventory model. Existing paths matching `sites/*/config/*.fsm.layout.json` are treated as legitimate runtime companions. They may be tracked modifications or untracked files, are parsed as JSON, SHA-256 snapshotted, and must be byte-identical and remain in the same inventory class after application.

No layout companion is written by B4.

## Replay validation

Synthetic replay used the exact R8B6B2 dirty-state shape and a clean B3 target.

Replay A: one tracked modified `fsm.layout.json` companion.

- preflight: PASS;
- preserved layouts: 1;
- B3 functional transformation: PASS;
- target PHP lint: PASS;
- all pre-existing paths unchanged: PASS;
- final inventory: 22 worktree paths = 21 functional + 1 preserved layout;
- `git diff --check`: PASS.

Replay B: same tracked layout plus one untracked `source.fsm.layout.json` companion.

- preflight: PASS;
- preserved layouts: 2;
- final inventory: 23 worktree paths = 21 functional + 2 preserved layouts;
- `git diff --check`: PASS.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6b4_layout_companion_inventory_gate_repair.zip`;
- ZIP SHA-256: `fe08b286df6c03fafc16d2fcc5fecb936889a1de188e7ca9de82f6aeeed87be6`;
- ZIP contains exactly `apply_a4bz2r8b6b4.php`;
- applicator size: `11542` bytes;
- applicator SHA-256: `4087c74300976ab54107a8c59580abdd64858a0b9141a9b2c951b74d742154a6`;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- extracted applicator PHP lint: PASS;
- no internal Composer invocation.

## Expected markers for current owner state

- `P117W_R45B2A4BZ2R8B6B4_PREFLIGHT_BEGIN`;
- `P117W_R45B2A4BZ2R8B6B4_PREFLIGHT_OK`;
- `r8b6b2_state=preserved`;
- `projection_validator=Opus\Fsm\Definition\FsmDefinitionValidator`;
- `layout_companion_gate=sites/*/config/*.fsm.layout.json`;
- `preserved_layout_paths=1`;
- `P117W_R45B2A4BZ2R8B6B4_REPO_CHANGES_VERIFIED`;
- `preexisting_r8b6b2_paths=20`;
- `additional_changed_paths=1`;
- `functional_changed_paths=21`;
- `total_worktree_paths=22`;
- `hardcoded_contract_whitelist=removed`;
- `r8b6b2_byte_preservation=verified`;
- `P117W_R45B2A4BZ2R8B6B4_APPLIED`.

If additional legitimate layout companions exist when owner applies, `preserved_layout_paths` and `total_worktree_paths` increase accordingly; all non-layout source inventory remains strict.

## Owner validation

Do not restore R8B6B2 and do not restore/delete `fsm.layout.json`.

After B4 application run external site validation for `owasys-front`, `owasys-back`, and `essai`, then `git status --short` and `git diff --check`.

Then repeat runtime navigation through Applications, Application, Data, Source/Git and Build. Existing correlated COMMAND/EVENT handshakes must remain, and the host views must render the dedicated EFSMs instead of failing on `OWASYS_APPLICATION_EFSM_CONTRACT_INVALID`.

Structure/Security and persisted layout geometry must remain unchanged. Do not commit/push OPUS until full runtime acceptance passes.
