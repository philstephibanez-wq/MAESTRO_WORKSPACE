# P117W R45B2A4BZ2 R8B6C — Structure dedicated Navigation EFSM extraction — HANDOFF

State: OWNER RUNTIME ACCEPTED — PUSHED — SUPERSEDED BY R8B6D RUNTIME AUTHORITY EXTRACTION

## Source gate

- README-FIRST blob at delivery: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- Delivery baseline: `d3a6cfc53e021dba0d5c2c60b9b9761b421dd76d`.
- Owner pushed R8B6C as OPUS commit `d30893de2a89cccda0c2702b4d2e5440cd7cb202`.
- Spec: `40_SPECS/P117W_R45B2A4BZ2R8B6C_STRUCTURE_DEDICATED_NAVIGATION_EFSM_EXTRACTION_SPEC.md`.

## Root cause

Structure/Navigation was the remaining OWASYS view whose canonical contextual diagram still originated from the legacy host FSM. OPUS already distinguished host dispatch resolution from named EFSM resolution, so the dedicated Navigation source could be extracted without a framework change.

## Accepted runtime result

The pushed application now exposes:

- `site.json.navigation.fsm = config/fsm.json` for legacy HTTP dispatch still not fully extracted;
- `site.json.efsms.navigation = config/navigation.fsm.json` for the canonical Navigation VIEW/DESIGN EFSM;
- runtime session `opus.fsm.owasys-front.navigation` through `OwasysNavigationRuntime`;
- Navigation rendering from `config/navigation.fsm.json`.

Owner runtime evidence on 2026-08-25 shows `/fr-FR/structure` completing successfully and the backend reading `config/navigation.fsm.json` and the `navigation` layout through secured REST/Composer.

The owner screenshot shows `application: owasys-front`, `efsm: navigation`, `source: config/navigation.fsm.json` and the seven-state Navigation graph.

## Canonical state-name correction

The delivered handoff text previously listed the central state as `structure`. The actual pushed canonical definition uses `navigation`.

Canonical state set at OPUS commit `d30893de...`:

`registry, application, data, navigation, security, source, build`.

This correction documents the pushed source; it does not rewrite historical patch artifacts.

## Owner commit reconciliation

The actual owner commit is broader than the original two-file extraction artifact. Compare `d3a6cfc...` → `d30893de...` shows the pushed R8B6C state also contains the runtime integration required to synchronize the dedicated Navigation EFSM, including:

- `NavigationRuntime.php` and `NavigationRuntimeInterface.php`;
- `ContextRuntimeCoordinator.php`;
- `SecurityRuntimeCoordinator.php`;
- `RuntimeController.php`;
- `FsmDiagramBuilder.php`;
- localized Navigation naming and routes;
- `site.json` and `navigation.fsm.json`;
- the owner-persisted `fsm.layout.json` runtime layout.

The pushed commit, not the earlier artifact inventory, is now the OPUS source of truth.

## Remaining architectural boundary

`OwasysNavigationRuntime::synchronize()` at `d30893de...` still restores the legacy global session `opus.fsm.owasys-front` and requires its current state before moving the dedicated Navigation EFSM. Therefore the dedicated EFSM is canonical for VIEW/DESIGN and has its own session, but legacy `config/fsm.json` still participates in Navigation runtime authority.

This is why the owner correctly reports no material visible behavioral difference after extraction.

R8B6D owns the next boundary: remove the legacy-global-state dependency from `OwasysNavigationRuntime` while preserving `config/fsm.json` strictly as the HTTP dispatch FSM until the remaining legacy business transitions are extracted.
