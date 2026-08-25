# P117W R45B2A4BZ2 R8B6C — Dedicated Navigation EFSM and route projection — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob revalidated during this cycle: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `d3a6cfc53e021dba0d5c2c60b9b9761b421dd76d`.
- Baseline commit: `opus_p117w_r45b2a4bz2r8b6b4_layout_companion_inventory_gate_repair`.
- R8B6B4 is owner runtime accepted and pushed.
- Specification: `40_SPECS/P117W_R45B2A4BZ2R8B6C_DEDICATED_NAVIGATION_EFSM_AND_ROUTE_PROJECTION_SPEC.md`.

## Root cause treated

At the accepted baseline, `site.json.navigation.fsm` and `site.json.efsms.navigation` both point at `config/fsm.json`.

The first pointer is still required for the legacy FSM-first HTTP dispatch lifecycle, because `config/fsm.json` still owns login/account/application-creation and other host orchestration responsibilities.

The second pointer causes the public Navigation/legacy Structure development surface to render the same monolithic global FSM. It also caused host context/security SignalBus coordinators to register the legacy processor under the semantic bus identity `owasys-front/navigation`.

R8B6C separates those responsibilities without a big-bang host-dispatch rewrite.

## Architecture delivered

### Dedicated Navigation EFSM

New canonical source:

`sites/owasys-front/config/navigation.fsm.json`

Registry pointer:

`site.json.efsms.navigation = config/navigation.fsm.json`

Legacy dispatch pointer intentionally remains:

`site.json.navigation.fsm = config/fsm.json`

Dedicated states:

- registry;
- application;
- data;
- navigation;
- security;
- source;
- build.

The seven `open_*` navigation signals use finite global transitions over exactly these seven states. Context-ready events self-loop on their owning Navigation state, including `git_context_ready` on `source`.

### Dedicated runtime authority

New services:

- `OwasysNavigationRuntimeInterface`;
- `OwasysNavigationRuntime`.

Dedicated session key:

`opus.fsm.owasys-front.navigation`

Canonical bus identity:

`owasys-front/navigation`

The service validates the current legacy dispatch state, restores the dedicated Navigation processor, synchronizes the dedicated state through a real Navigation transition when required, persists only the dedicated runtime, and registers only that processor on the SignalBus.

Legacy `structure` maps only to dedicated `navigation` as an explicit compatibility adapter.

### Context and Security communication

`OwasysContextRuntimeCoordinator` now uses `OwasysNavigationRuntime` before Registry/Application/Data/Source/Git/Build COMMAND/EVENT handshakes.

`OwasysSecurityRuntimeCoordinator` uses the same authority for Security entry and reauthentication. The legacy host FSM is no longer registered as `owasys-front/navigation`.

Existing correlation/causation behavior is preserved.

### Diagram runtime-state projection

For `owasys-front`, `FsmDiagramBuilder` now restores live runtime state for:

- Navigation from `opus.fsm.owasys-front.navigation`;
- Security from `opus.fsm.owasys-front.security`;
- existing host context EFSMs from their current stores.

Other selected applications remain source projections for Navigation/Security until a separate live-runtime contract exists for them.

### Public Navigation naming and route

The internal legacy state/module/route key `structure` remains temporarily because `config/fsm.json` remains the host dispatcher.

Its public projection is now Navigation:

- `menu.structure` becomes the localized Navigation label in all 25 base catalogs;
- `routes.localized.json.routes.structure.paths` becomes the localized Navigation path set;
- French generated route: `/fr-FR/navigation`;
- existing legacy canonical route acceptance remains enabled, so `/fr-FR/structure` is compatibility only.

## Exact functional source surface

32 modified paths:

- seven fixed source/config paths from the specification;
- 25 base locale catalogs resolved from canonical `site.json`.

Three new paths:

- `sites/owasys-front/application/default/services/NavigationRuntimeInterface.php`;
- `sites/owasys-front/application/default/services/NavigationRuntime.php`;
- `sites/owasys-front/config/navigation.fsm.json`.

Total functional paths: 35.

No OWASYS-back source change.
No CSS/JS change.
No `config/fsm.json` change.
No applicator-owned layout mutation.

## Applicator safety

The applicator:

- requires exact HEAD `d3a6cfc53e021dba0d5c2c60b9b9761b421dd76d`;
- rejects staged changes;
- verifies seven fixed baseline blobs;
- derives/validates all 25 base locale targets from `site.json`;
- requires all functional targets clean;
- allows only pre-existing `sites/*/config/{fsm|<efsm>.fsm}.layout.json` companions outside the patch;
- snapshots every such companion by SHA-256 and byte size and proves preservation;
- requires all three new paths absent;
- structurally validates site/routes/I18n JSON candidates;
- validates the Navigation EFSM state set, signal references, finite-global source sets and `(state,signal)` determinism;
- PHP-lints every candidate PHP file before writing;
- writes atomically;
- rolls back only R8B6C-owned paths on post-write failure;
- re-lints/revalidates after writing;
- proves final tracked/untracked inventory;
- runs `git diff --check`;
- never invokes Composer internally.

## Replay validation

Two deterministic synthetic Git replays passed using the final transformation logic:

1. one pre-existing tracked runtime layout companion;
2. one tracked plus one untracked runtime layout companion.

Both passed:

- preflight;
- candidate PHP lint;
- candidate JSON/Navigation semantic validation;
- atomic write;
- post-write PHP/JSON validation;
- exact 32 modified + 3 new functional inventory;
- byte preservation of `config/fsm.json`;
- byte preservation of every runtime layout companion;
- `git diff --check`.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6c_dedicated_navigation_efsm_and_route_projection.zip`;
- ZIP SHA-256: `3ff1a96bf00e97f9071b1e4d307f2f738cb0468778da4c7c89904fbf592c8861`;
- ZIP contains exactly `apply_a4bz2r8b6c.php`;
- applicator size: `41713` bytes;
- applicator SHA-256: `c93ff5ab9965c14d2d9f5ece42ba0b3846f5b9f972b3a85ac5c50542348d1c14`;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- extracted applicator PHP lint: PASS;
- no internal Composer invocation.

## Expected success markers

- `P117W_R45B2A4BZ2R8B6C_PREFLIGHT_BEGIN`;
- `P117W_R45B2A4BZ2R8B6C_PREFLIGHT_OK`;
- `functional_changed_paths=35`;
- `legacy_dispatch_fsm=config/fsm.json`;
- `dedicated_navigation_fsm=config/navigation.fsm.json`;
- `navigation_session=opus.fsm.owasys-front.navigation`;
- `public_domain=Navigation`;
- `french_route=/fr-FR/navigation`;
- `P117W_R45B2A4BZ2R8B6C_REPO_CHANGES_VERIFIED`;
- `modified_paths=32`;
- `new_paths=3`;
- `navigation_bus_authority=config/navigation.fsm.json`;
- `legacy_structure=compatibility_only`;
- `security_runtime_projection=live`;
- `legacy_fsm_byte_preservation=verified`;
- `layout_companion_byte_preservation=verified`;
- `P117W_R45B2A4BZ2R8B6C_APPLIED`.

## Owner validation

After successful application, run external Composer validation for `owasys-front`, `owasys-back`, and `essai`, then `git status --short` and `git diff --check`.

Runtime acceptance requires:

1. menu displays Navigation, not Structure;
2. French generated URL is `/fr-FR/navigation`;
3. legacy `/fr-FR/structure` remains compatible;
4. with `owasys-front` selected, Navigation view renders `owasys-front / navigation` from `config/navigation.fsm.json` and highlights `navigation`;
5. Applications/Application/Data/Security/Source/Build synchronize the dedicated Navigation state to `registry/application/data/security/source/build` respectively;
6. existing context COMMAND/EVENT traces remain correlated;
7. Security diagram highlights live `authenticated` state for the authenticated owner session;
8. Source/Git/Build behavior remains unchanged;
9. Logger/Profiler show only the dedicated Navigation processor behind semantic identity `owasys-front/navigation`;
10. `config/fsm.json` remains unchanged;
11. any pre-existing layout companions remain unchanged unless the owner deliberately moves diagram geometry after application.

Do not commit/push OPUS until the full matrix passes.