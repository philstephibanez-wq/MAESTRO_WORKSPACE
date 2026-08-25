# P117W R45B2A4BZ2 R8B6B4 — Layout companion inventory gate repair — HANDOFF

State: OWNER RUNTIME ACCEPTED — PUSHED

## Source gate

- README-FIRST at delivery: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- Delivery baseline: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- Owner accepted and pushed the cumulative R8B6B2/B3/B4 result as OPUS commit `d3a6cfc53e021dba0d5c2c60b9b9761b421dd76d` (`opus_p117w_r45b2a4bz2r8b6b4_layout_companion_inventory_gate_repair`).
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

## Owner runtime acceptance

Owner screenshots after application show dedicated contextual EFSM rendering for:

- `registry` / Applications;
- `application` / Application;
- `data` / Sources de données;
- `source` / Sources et Git;
- `build` / Construction et validation;
- Security remains on its dedicated `security` EFSM.

The prior `OWASYS_APPLICATION_EFSM_CONTRACT_INVALID` rendering failure is no longer present on those accepted views. The owner then pushed commit `d3a6cfc53e021dba0d5c2c60b9b9761b421dd76d`.

The Structure view still renders the historical global `config/fsm.json`; this was outside B4's correction and is explicitly the next extraction slice, not a B4 regression.

## Artifact history

- ZIP: `opus_p117w_r45b2a4bz2r8b6b4_layout_companion_inventory_gate_repair.zip`;
- ZIP SHA-256: `fe08b286df6c03fafc16d2fcc5fecb936889a1de188e7ca9de82f6aeeed87be6`;
- ZIP contains exactly `apply_a4bz2r8b6b4.php`;
- applicator size: `11542` bytes;
- applicator SHA-256: `4087c74300976ab54107a8c59580abdd64858a0b9141a9b2c951b74d742154a6`;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- extracted applicator PHP lint: PASS;
- no internal Composer invocation.

## Closure

R8B6B4 is closed. Do not reapply B2/B3/B4 over `d3a6cfc53e021dba0d5c2c60b9b9761b421dd76d`.

Next slice: dedicated Navigation EFSM extraction for the Structure context while preserving the legacy host dispatch FSM until its remaining orchestration responsibilities are separately extracted.