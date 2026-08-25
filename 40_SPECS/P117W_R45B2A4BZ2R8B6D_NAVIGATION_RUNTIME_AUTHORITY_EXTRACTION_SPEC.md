# P117W R45B2A4BZ2 R8B6D — Navigation runtime authority extraction — SPEC

State: READY — DELIVERED FOR OWNER APPLY/RUNTIME VALIDATION

## Baseline

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `d30893de2a89cccda0c2702b4d2e5440cd7cb202`.
- R8B6C owner runtime accepted and pushed.

## Problem

R8B6C extracted the canonical Navigation EFSM source and runtime session, but `OwasysNavigationRuntime::synchronize()` still uses the legacy global FSM as an authority prerequisite:

1. load `site.json.navigation.fsm` (`config/fsm.json`);
2. restore session `opus.fsm.owasys-front`;
3. require the global FSM state to equal the requested module state;
4. only then transition the dedicated `navigation` EFSM.

This leaves the new Navigation machine dependent on the old global machine and explains why the owner observes little/no visible behavioral difference after R8B6C.

## Target architecture

The dedicated Navigation EFSM becomes the sole state authority for Navigation/context SignalBus coordination:

- definition: `config/navigation.fsm.json`;
- session: `opus.fsm.owasys-front.navigation`;
- bus identity: `owasys-front/navigation`.

`config/fsm.json` remains temporarily as the HTTP dispatch FSM only. R8B6D does not point `site.json.navigation.fsm` to `config/navigation.fsm.json`, because legacy login/account/creation/deletion and other not-yet-extracted transitions still require the dispatch FSM.

## Delivered behavioral change

`OwasysNavigationRuntime::synchronize(inputState)` now:

- normalizes existing caller input (`structure` maps to canonical `navigation`; all other context state names map 1:1);
- loads only `FsmSiteLoader::processorForSiteRootEfsm(..., 'navigation')`;
- restores only `opus.fsm.owasys-front.navigation`;
- transitions the dedicated Navigation EFSM directly when its state differs from the requested canonical target;
- persists only the dedicated Navigation session;
- registers that same processor on `FsmSignalBus`;
- no longer loads `FsmSiteLoader::processorForSiteRoot()`;
- no longer restores `opus.fsm.owasys-front`;
- no longer compares against the legacy global current state.

The public method name `synchronize()` remains for this slice to avoid an unrelated call-site refactor. Its parameter terminology becomes `requestedState` rather than `legacyState`.

Transition/profiler metadata records `runtime_authority=dedicated-navigation-efsm`.

## Exact OPUS surface

Modified only:

1. `sites/owasys-front/application/default/services/NavigationRuntime.php`
   - baseline blob `e2247a0142cb57815ebd4c7ec8b6473ea3eae0e8`;
2. `sites/owasys-front/application/default/services/NavigationRuntimeInterface.php`
   - baseline blob `234ff7966854f5dbcd5589a85bd4000baf4b7a5a`.

No change to `config/fsm.json`, `config/navigation.fsm.json`, `site.json`, coordinators/call sites, backend, generated applications, SCORE/CSS/JS or persisted layouts.

## Applicator/replay gates

The applicator requires exact HEAD `d30893de2a89cccda0c2702b4d2e5440cd7cb202`, no staged changes, and no dirty source paths except pre-existing runtime layout companions matching the established layout-file forms.

Pre-existing layouts are JSON-validated, SHA-256 snapshotted and required byte-identical after apply.

Deterministic replay against byte-exact baseline copies of the two Git blobs plus a modified tracked `fsm.layout.json` companion passed:

- exact baseline blob check: PASS;
- unique transformation anchors: PASS;
- candidate PHP lint: PASS;
- post-write PHP lint: PASS;
- runtime layout preservation: PASS;
- exact final tracked/untracked inventory: PASS;
- `git diff --check`: PASS;
- scan for `LEGACY_SESSION_KEY`, `processorForSiteRoot(`, `legacy_state`, `$legacyState`: empty;
- dedicated authority marker present: PASS.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6d_navigation_runtime_authority_extraction.zip`;
- ZIP SHA-256: `c4e67c2ddbb63b94293a6b9dea1637cd9b6298ab19709ea0ddc22311f5e0e898`;
- ZIP size: `3876` bytes;
- ZIP contains exactly `apply_a4bz2r8b6d.php`;
- applicator SHA-256: `c31589acfb0b88ad8245fb385a64b813e3d3616cb8f055ab3be23755b65cadf3`;
- applicator size: `12750` bytes;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- extracted applicator PHP lint: PASS.

## Runtime acceptance

After apply:

1. Applications/Application/Data/Navigation/Security/Source-Git/Build continue to open normally.
2. Existing context COMMAND/EVENT handshakes remain correlated.
3. Navigation VIEW/DESIGN remains sourced from `config/navigation.fsm.json`.
4. Current-state highlighting follows the dedicated Navigation session.
5. Logs/profiler for a Navigation transition show `runtime_authority=dedicated-navigation-efsm`.
6. No `OWASYS_NAVIGATION_RUNTIME_LEGACY_STATE_*` failure may occur.
7. `site.json.navigation.fsm` remains `config/fsm.json` and normal HTTP dispatch remains intact.
8. Composer validation of `owasys-front`, `owasys-back`, and `essai` passes.
9. No commit/push until runtime acceptance passes.
