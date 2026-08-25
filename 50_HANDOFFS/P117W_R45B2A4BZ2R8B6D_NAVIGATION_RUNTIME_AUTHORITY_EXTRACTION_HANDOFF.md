# P117W R45B2A4BZ2 R8B6D — Navigation runtime authority extraction — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `d30893de2a89cccda0c2702b4d2e5440cd7cb202`.
- R8B6C is owner runtime accepted and pushed at `d30893de2a89cccda0c2702b4d2e5440cd7cb202`.
- R8B6C handoff reconciled to the actual owner commit before this delivery.
- Spec: `40_SPECS/P117W_R45B2A4BZ2R8B6D_NAVIGATION_RUNTIME_AUTHORITY_EXTRACTION_SPEC.md`.

## Why no visible diff after R8B6C

R8B6C created and rendered the dedicated `config/navigation.fsm.json`, but its `OwasysNavigationRuntime::synchronize()` still restored the legacy global `opus.fsm.owasys-front` session and required its current state before changing the dedicated Navigation EFSM. Therefore source ownership changed, but runtime authority was still chained to the old global FSM.

## R8B6D correction

R8B6D removes that legacy state-authority dependency.

`OwasysNavigationRuntime` now uses only:

- `FsmSiteLoader::processorForSiteRootEfsm(..., 'navigation')`;
- `FsmSessionStore('opus.fsm.owasys-front.navigation')`;
- `owasys-front/navigation` as SignalBus identity.

Existing caller inputs remain compatible; `structure` is normalized to the canonical Navigation state `navigation`.

`config/fsm.json` is deliberately preserved as HTTP dispatch FSM because remaining legacy operations have not all been extracted yet. This slice does not pretend that the global dispatch FSM is removable.

## Exact source surface

Modified only:

- `sites/owasys-front/application/default/services/NavigationRuntime.php` — baseline blob `e2247a0142cb57815ebd4c7ec8b6473ea3eae0e8`;
- `sites/owasys-front/application/default/services/NavigationRuntimeInterface.php` — baseline blob `234ff7966854f5dbcd5589a85bd4000baf4b7a5a`.

No backend, config, SCORE, CSS, JS, generated-site or layout source change.

## Delivery safety

Applicator requires exact HEAD `d30893de2a89cccda0c2702b4d2e5440cd7cb202` and no staged changes.

Only pre-existing runtime layout companions are allowed to be dirty. They are JSON-validated and SHA-256 snapshotted before write, then verified byte-identical afterward.

Both target HEAD blobs are checked canonically. Candidate and final PHP lint are mandatory. Final inventory and `git diff --check` are mandatory. Rollback is limited to the two targets.

## Replay evidence

Replay used byte-exact source files whose Git blobs were verified to equal the two current OPUS HEAD blobs. A tracked modified `sites/owasys-front/config/fsm.layout.json` companion was included.

Result:

- preflight PASS;
- candidate lint PASS;
- apply PASS;
- layout preservation PASS;
- final inventory PASS;
- `git diff --check` PASS;
- no remaining `LEGACY_SESSION_KEY`;
- no remaining call to `FsmSiteLoader::processorForSiteRoot(` in NavigationRuntime;
- no remaining `legacy_state` / `$legacyState` runtime dependency;
- authority marker `dedicated-navigation-efsm` present.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6d_navigation_runtime_authority_extraction.zip`;
- ZIP SHA-256: `c4e67c2ddbb63b94293a6b9dea1637cd9b6298ab19709ea0ddc22311f5e0e898`;
- ZIP contains exactly `apply_a4bz2r8b6d.php`;
- ZIP size: `3876` bytes;
- applicator SHA-256: `c31589acfb0b88ad8245fb385a64b813e3d3616cb8f055ab3be23755b65cadf3`;
- applicator size: `12750` bytes;
- applicator PHP lint PASS;
- ZIP re-extraction byte comparison PASS;
- extracted applicator PHP lint PASS.

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

Apply only from HEAD `d30893de...`. Do not restore or reapply R8B6C.

Then run external Composer validation for `owasys-front`, `owasys-back`, and `essai`, plus `git status --short` and `git diff --check`.

Runtime acceptance must cover Applications, Application, Data, Navigation, Security, Source/Git and Build. Existing COMMAND/EVENT correlations must remain. Navigation must still render `config/navigation.fsm.json`, but its runtime no longer depends on the global session.

Do not commit/push until these gates pass.
