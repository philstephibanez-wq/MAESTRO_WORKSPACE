# P117W R45B2A4BZ2 R8B6B1 — Canonical HEAD blob preflight repair — SPEC

State: ACTIVE — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- R8B6B failed before any write and is superseded.
- Functional payload remains exactly the R8B6B multi-state host EFSM runtime payload.

## Runtime evidence requiring repair

R8B6B preflight printed:

`P117W_R45B2A4BZ2R8B6B_BASELINE_BLOB_INVALID:sites/owasys-back/application/fsm/services/OwasysFsmLayoutCommandProvider.php:5a9f7150867d783a9e92fb7a7d7c51b306d8c65e`

The printed actual object id equals the canonical GitHub blob id for that path at HEAD `56d4293f...`. The owner also proved the worktree remained clean before/after the failed preflight and all three requested site validations passed.

Therefore the source must not be changed to satisfy this failure. The applicator baseline verifier is the defect boundary.

## Repair

R8B6B1 changes only the delivery runner logic and marker namespace. The encoded OPUS functional payload, baseline blob map, expected modified inventory, expected new inventory, special replacement inventory and all embedded new files are byte-identical to R8B6B.

Baseline verification changes from a worktree object-hash helper to the canonical HEAD tree:

`git rev-parse --verify HEAD:<path>`

For every existing target the result must:

- be exactly one lowercase 40-hex Git object id;
- strictly equal the expected baseline blob id from the frozen source gate.

The runner still separately requires:

- exact HEAD `56d4293f21f0a049cfe7cbe968916896de47dc41`;
- empty `git status --porcelain`;
- all nine new targets absent;
- exact PHP transformation anchors;
- candidate PHP lint before writes;
- candidate JSON parse/validation before writes;
- atomic writes;
- exact 20-path modified/untracked inventory after writes;
- `git diff --check`;
- rollback of only its own writes on post-write failure;
- no internal Composer invocation.

## Functional payload

Unchanged from R8B6B:

- six host EFSMs: `registry`, `application`, `data`, `source`, `git`, `build`;
- Navigation COMMAND/EVENT handshake over generic `Opus\Fsm\FsmSignalBus`;
- persisted runtime-current-state diagram projection;
- real Registry/Source/Git/Build lifecycle integration;
- `git` separated from `source` as an autonomous EFSM;
- host/system DESIGN forced to `owasys-front` and protected by `owasys:modify`;
- backend semantic/handler/layout system mutations additionally require `owasys:modify`;
- Structure selected-app `navigation` and Security selected-app `security` remain unchanged;
- R8B5D4 renderer and all existing layout companions remain unchanged.

## Intended OPUS surface after successful application

Exactly the same 20 paths as R8B6B: 11 modified + 9 new.

No additional OPUS source path is introduced by R8B6B1.

## Delivery identity

The ZIP and applicator use a new `R8B6B1` filename/marker namespace so an earlier downloaded `R8B6B` artifact cannot be reused accidentally or through download caching.

## Owner acceptance

First require applicator success markers through `P117W_R45B2A4BZ2R8B6B1_APPLIED`, then run external Composer site validation and the full R8B6B runtime acceptance matrix. No OPUS commit/push before runtime acceptance.
