# P117W R45B2A4BZ2 R8B6B4 — Layout companion inventory gate repair — SPEC

State: READY FOR OWNER APPLY

## Baseline

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS HEAD/master: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- R8B6B2 is already applied locally and intentionally uncommitted.
- R8B6B3 failed before write because its inventory gate rejected a legitimate persisted layout companion.

## Problem

The owner worktree contains the expected R8B6B2 source state plus:

`sites/owasys-front/config/fsm.layout.json`

as a tracked runtime layout modification. B3 required exact equality with only the R8B6B2 source inventory and rejected this legitimate runtime data.

## Required correction

B4 must preserve the B3 functional correction unchanged:

`OwasysApplicationFsmModel` uses `Opus\Fsm\Definition\FsmDefinitionValidator` instead of a hard-coded EFSM contract whitelist.

Only the applicator inventory/preservation gate changes.

## Layout companion policy

Existing paths matching:

`sites/*/config/*.fsm.layout.json`

including `fsm.layout.json` itself, may be present as tracked modifications or untracked runtime companions before application.

Every such path must:

1. be a regular file;
2. parse as JSON;
3. be excluded from the strict R8B6B2 source-inventory equality check;
4. be SHA-256 snapshotted before write;
5. remain byte-for-byte unchanged after write;
6. remain in the same tracked/untracked inventory class after write.

No layout file is created, modified, restored, deleted, staged or renamed by B4.

## Strict source gate retained

After excluding only allowed layout companions, the remaining worktree must still be exactly:

- 11 known R8B6B2 tracked source changes;
- 9 known R8B6B2 untracked source additions;
- no staged changes;
- clean B4 target `sites/owasys-front/application/fsm/models/ApplicationFsmModel.php` relative to HEAD;
- exact target HEAD blob `4ffbae0db7d30f618089d11192941231f78b27e8`.

## Functional target

One additional source path only:

`sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`

B4 imports `FsmDefinitionValidator`, requires a non-empty definition `contract`, then invokes `assertValid($definition)`. Existing site/EFSM/source/hash checks remain.

## Validation

- candidate PHP lint before write;
- target PHP lint after write;
- all 20 R8B6B2 paths unchanged;
- all pre-existing layout companions unchanged;
- exact final source inventory plus same layout companions;
- `git diff --check` PASS;
- rollback limited to `ApplicationFsmModel.php`.

## Runtime acceptance

After successful B4 application:

- Applications, Application, Data, Source/Git and Build must render their dedicated host EFSMs instead of `OWASYS_APPLICATION_EFSM_CONTRACT_INVALID`;
- existing COMMAND/EVENT handshakes remain correlated;
- Structure and Security remain unchanged;
- persisted layout data remains intact;
- no commit/push until full R8B6B acceptance matrix passes.
