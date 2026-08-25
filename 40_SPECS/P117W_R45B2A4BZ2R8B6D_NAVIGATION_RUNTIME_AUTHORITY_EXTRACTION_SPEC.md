# P117W R45B2A4BZ2 R8B6D — Navigation runtime authority extraction — SPEC

State: ACTIVE — DELIVERY BUILD IN PROGRESS

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

This leaves the new Navigation machine dependent on the old global machine and makes the extraction largely invisible at runtime.

## Target architecture

The dedicated Navigation EFSM becomes the sole state authority for Navigation/context SignalBus coordination:

- definition: `config/navigation.fsm.json`;
- session: `opus.fsm.owasys-front.navigation`;
- bus identity: `owasys-front/navigation`.

`config/fsm.json` remains temporarily as the HTTP dispatch FSM only. R8B6D must not point `site.json.navigation.fsm` to `config/navigation.fsm.json`, because legacy login/account/creation/deletion and other not-yet-extracted transitions still require the dispatch FSM.

## Required behavioral change

`OwasysNavigationRuntime::synchronize(inputState)` must:

- normalize existing caller input (`structure` maps to canonical `navigation`; all other context state names map 1:1);
- load only `FsmSiteLoader::processorForSiteRootEfsm(..., 'navigation')`;
- restore only `opus.fsm.owasys-front.navigation`;
- transition the dedicated Navigation EFSM directly when its state differs from the requested canonical target;
- persist only the dedicated Navigation session;
- register that same processor on `FsmSignalBus`;
- never load `FsmSiteLoader::processorForSiteRoot()`;
- never restore `opus.fsm.owasys-front`;
- never compare against the legacy global current state.

The public method name `synchronize()` remains for this slice to avoid an unrelated call-site refactor. Its parameter terminology becomes `requestedState` rather than `legacyState`.

## Exact OPUS surface

Modified only:

1. `sites/owasys-front/application/default/services/NavigationRuntime.php`
   - baseline blob `e2247a0142cb57815ebd4c7ec8b6473ea3eae0e8`;
2. `sites/owasys-front/application/default/services/NavigationRuntimeInterface.php`
   - baseline blob `234ff7966854f5dbcd5589a85bd4000baf4b7a5a`.

No change to:

- `config/fsm.json`;
- `config/navigation.fsm.json`;
- `site.json`;
- Context/Security coordinator call sites;
- back application;
- generated applications;
- SCORE/CSS/JS;
- persisted layout files.

## Runtime invariants

After R8B6D:

- opening Applications/Application/Data/Navigation/Security/Source-Git/Build continues to select the expected Navigation state;
- existing COMMAND/EVENT handshakes remain correlated;
- Navigation VIEW/DESIGN still renders `config/navigation.fsm.json`;
- current-state highlighting is sourced from the dedicated Navigation session;
- deleting or resetting only the legacy `opus.fsm.owasys-front` session must no longer be required for Navigation/context runtime coordination;
- dispatch behavior remains unchanged because `site.json.navigation.fsm` remains `config/fsm.json`.

## Delivery gates

Applicator must require exact HEAD `d30893de2a89cccda0c2702b4d2e5440cd7cb202`, no staged changes, and no dirty source paths except pre-existing runtime layout companions matching `sites/*/config/fsm.layout.json` or `sites/*/config/*.fsm.layout.json`.

All pre-existing layout companions must be SHA-256 snapshotted and remain byte-identical.

The applicator must verify exact baseline blobs for the two modified files, unique transformation anchors, candidate PHP lint before write, PHP lint after write, exact final inventory, `git diff --check`, unchanged HEAD, and rollback limited to the two targets.

External Composer validation remains owner-side.
