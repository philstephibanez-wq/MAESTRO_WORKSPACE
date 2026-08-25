# P117W R45B2A4BZ2 R8B6D — Navigation runtime authority extraction — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `d30893de2a89cccda0c2702b4d2e5440cd7cb202`.
- R8B6C is owner runtime accepted and pushed at `d30893de2a89cccda0c2702b4d2e5440cd7cb202`.
- R8B6C handoff reconciled to the actual owner commit before this delivery.
- Spec: `40_SPECS/P117W_R45B2A4BZ2R8B6D_NAVIGATION_RUNTIME_AUTHORITY_EXTRACTION_SPEC.md`.

## Owner observation — duplicate R8B6C application

On 2026-08-25 the owner attempted to run the R8B6C applicator again from `H:\OPUS` while the worktree already contained the R8B6C Navigation extraction files.

Observed preflight failure:

`P117W_R45B2A4BZ2R8B6C_NAVIGATION_TARGET_ALREADY_EXISTS`

The failure occurred during preflight before any mutation. Therefore no additional diff from that invocation is expected. The subsequent owner checks remained valid for `owasys-front`, `owasys-back` and `essai`, and `git diff --check` returned clean.

The owner-reported worktree still displayed the R8B6C source set as modified/untracked locally. Before R8B6D is applied, the local clone must therefore prove that `HEAD` is exactly `d30893de2a89cccda0c2702b4d2e5440cd7cb202`; R8B6D intentionally refuses any other HEAD instead of guessing or layering over an ambiguous local baseline.

Do not restore or reapply R8B6C.

## Why no visible runtime-authority diff after R8B6C

R8B6C created and rendered the dedicated `config/navigation.fsm.json`, but its `OwasysNavigationRuntime::synchronize()` still restored the legacy global `opus.fsm.owasys-front` session and required its current state before changing the dedicated Navigation EFSM. Therefore source ownership changed, but runtime authority was still chained to the old global FSM.

## R8B6D correction

R8B6D removes that legacy state-authority dependency.

`OwasysNavigationRuntime` now uses only:

- `FsmSiteLoader::processorForSiteRootEfsm(..., 'navigation')`;
- `FsmSessionStore('opus.fsm.owasys-front.navigation')`;
- `owasys-front/navigation` as SignalBus identity.

Existing caller inputs remain compatible; both `structure` and `navigation` normalize to the canonical Navigation state `navigation`.

`config/fsm.json` is deliberately preserved as HTTP dispatch FSM because remaining legacy operations have not all been extracted yet. This slice does not pretend that the global dispatch FSM is removable.

## Exact source surface

Modified only:

- `sites/owasys-front/application/default/services/NavigationRuntime.php` — baseline blob `e2247a0142cb57815ebd4c7ec8b6473ea3eae0e8`;
- `sites/owasys-front/application/default/services/NavigationRuntimeInterface.php` — baseline blob `234ff7966854f5dbcd5589a85bd4000baf4b7a5a`.

No backend, config, SCORE, CSS, JS, generated-site or layout source change.

## Delivery safety

Applicator requires exact HEAD `d30893de2a89cccda0c2702b4d2e5440cd7cb202` and no staged changes.

Only pre-existing runtime layout companions are allowed to be dirty. They are JSON-validated and SHA-256 snapshotted before write, then verified byte-identical afterward.

Both target HEAD blobs are checked canonically. Unique baseline anchors are checked. Candidate and final PHP lint are mandatory. Final inventory and `git diff --check` are mandatory. Rollback is limited to the two targets.

## Replay / artifact verification

The current regenerated owner artifact was built from the two canonical OPUS HEAD source blobs recorded above.

Verification performed before delivery:

- applicator PHP lint PASS;
- ZIP contains exactly `apply_a4bz2r8b6d.php`;
- ZIP re-extraction byte comparison PASS;
- extracted applicator PHP lint PASS.

## Current artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6d_navigation_runtime_authority_extraction.zip`;
- ZIP SHA-256: `d19b024c28fc23759bb4a29489933fa0bbef8fd56115a4a16a83137b527b84f2`;
- ZIP contains exactly `apply_a4bz2r8b6d.php`;
- ZIP size: `4281` bytes;
- applicator SHA-256: `33442da78b4bbf364242ebad3f4496c31e0b9f86b73dc5ce1fbd61e00459eeb9`;
- applicator size: `16228` bytes;
- applicator PHP lint PASS;
- ZIP re-extraction byte comparison PASS;
- extracted applicator PHP lint PASS.

This current artifact supersedes the earlier transport checksum recorded for R8B6D; the semantic source slice and baseline remain R8B6D unchanged.

## Expected markers

- `P117W_R45B2A4BZ2R8B6D_PREFLIGHT_BEGIN`;
- `P117W_R45B2A4BZ2R8B6D_PREFLIGHT_OK`;
- `P117W_R45B2A4BZ2R8B6D_REPO_CHANGES_VERIFIED`;
- `changed_source_paths=2`;
- `navigation_runtime_authority=dedicated-navigation-efsm`;
- `legacy_navigation_session_dependency=removed`;
- `legacy_dispatch_fsm=preserved`;
- `signal_bus_identity=owasys-front/navigation`;
- `layout_companions=preserved-byte-for-byte`;
- `P117W_R45B2A4BZ2R8B6D_APPLIED`.

## Owner acceptance

Apply only from HEAD `d30893de2a89cccda0c2702b4d2e5440cd7cb202`. Do not restore or reapply R8B6C.

Then run external Composer validation for `owasys-front`, `owasys-back`, and `essai`, plus `git status --short` and `git diff --check`.

Runtime acceptance must cover Applications, Application, Data, Navigation, Security, Source/Git and Build. Existing COMMAND/EVENT correlations must remain. Navigation must still render `config/navigation.fsm.json`, but its runtime no longer depends on the global session.

Do not commit/push until these gates pass.


## Owner runtime result — 2026-08-25

- R8B6D was applied successfully and pushed by the owner as OPUS commit `1f94204116ad4ea26df6a040ad9a37b8134fb745`.
- Repository and structural gates passed.
- Runtime acceptance is REJECTED: the horizontal Navigation diagram still omits every finite global `open_*` relation and renders only the `*_context_ready` self-loops.
- Root cause is generic OPUS rendering, not Navigation data: after the vertical branch, `OPUS_FSM_Diagram::renderTransition()` has no horizontal `scope=global` branch; projected transitions use `from=@global`, fail the local-position lookup, and are silently returned as empty SVG.
- Next slice baseline: `1f94204116ad4ea26df6a040ad9a37b8134fb745`.
- Next slice owns a generic `Opus/Fsm/Diagram.class.php` correction. No local OWASYS workaround, no config rewrite, and no R8B6D reapply.
