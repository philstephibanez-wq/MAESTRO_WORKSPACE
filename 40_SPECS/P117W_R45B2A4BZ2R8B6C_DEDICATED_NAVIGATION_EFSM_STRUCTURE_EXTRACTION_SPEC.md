# P117W R45B2A4BZ2 R8B6C — Dedicated Navigation EFSM / Structure extraction — SPEC

State: ACTIVE — DELIVERY IN PREPARATION

## Baseline

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `d3a6cfc53e021dba0d5c2c60b9b9761b421dd76d`.
- R8B6B4 is owner runtime accepted and pushed.

## User-visible meaning of Structure

The OWASYS menu label `Structure` is the contextual development surface for the selected application's `navigation` EFSM.

It is not:

- the source tree;
- the Security EFSM;
- the global OWASYS host workflow;
- a second route registry.

Its responsibility is the application/navigation structure: navigable application contexts and the transitions that move between them. Routes are consequences/adapters of navigation signals, not the semantic authority of the states.

This follows `P117W_MICRO_EFSM_APPLICATION_SKELETON_ARCHITECTURE_SPEC.md`, whose designer mapping is `section Navigation -> Navigation EFSM`.

## Current defect

At baseline `sites/owasys-front/config/site.json` contains both:

- runtime dispatch pointer `navigation.fsm = config/fsm.json`;
- EFSM registry entry `efsms.navigation = config/fsm.json`.

Therefore Structure for selected application `owasys-front` renders the historical monolithic host FSM. That same file still carries login/account/application creation plus the remaining legacy dispatch/orchestration responsibilities.

The two notions must be separated without a big-bang dispatch rewrite.

## Target architecture

### 1. Preserve legacy dispatch authority temporarily

`site.json.navigation.fsm` remains `config/fsm.json` in this slice.

`FsmSiteLoader::processorForSiteRoot()` therefore continues driving the existing FSM-first HTTP dispatch and no currently working route is rewritten.

The historical global FSM becomes explicitly a legacy host-dispatch/orchestration machine pending later extraction. It must no longer be presented as the contextual Navigation EFSM.

### 2. Add the dedicated Navigation EFSM

Create:

`sites/owasys-front/config/navigation.fsm.json`

and register:

`site.json.efsms.navigation = config/navigation.fsm.json`.

The machine is multi-state and represents the authenticated OWASYS development navigation contexts:

- registry;
- application;
- data;
- structure;
- security;
- source;
- build.

Initial authenticated context: `registry`.

Navigation signals reuse the existing semantic names:

- `open_applications` -> registry;
- `open_application` -> application;
- `open_data` -> data;
- `open_structure` -> structure;
- `open_security` -> security;
- `open_source` -> source;
- `open_build` -> build.

Every navigation signal is applicable from every finite Navigation state and only changes the Navigation EFSM's own state.

### 3. Inter-EFSM communication authority

The dedicated Navigation EFSM becomes the unique bus identity `owasys-front/navigation`.

The legacy `config/fsm.json` processor must no longer be registered on `FsmSignalBus` as `owasys-front/navigation`.

The legacy host FSM remains read only in the coordinators only to verify that HTTP dispatch has reached the expected host context before the dedicated Navigation EFSM handshake starts.

For Registry/Application/Data/Source/Git/Build:

`legacy host dispatch state` -> verify only

then

`Navigation --COMMAND enter_<domain>_context--> Domain EFSM`

`Domain EFSM --EVENT <domain>_context_ready--> Navigation`

with the existing correlation/causation contract.

`git` remains visually under Source and maps Navigation state `source`.

### 4. Security convergence

`OwasysSecurityRuntimeCoordinator` must also use `processorForSiteRootEfsm(..., navigation)` and session key `opus.fsm.owasys-front.navigation` for the bus-side Navigation EFSM.

It may still read/restore the legacy host FSM under `opus.fsm.owasys-front` only to assert the host dispatch state `security`.

No two different source definitions may share bus identity `owasys-front/navigation` after this slice.

### 5. Structure runtime synchronization

Structure has no separate domain EFSM: Structure is the development surface of Navigation itself.

When the OWASYS host renders module `structure`, the dedicated Navigation runtime is synchronized to state `structure` before the diagram is projected.

No COMMAND to a second Structure EFSM is emitted.

### 6. Runtime-state projection

For application `owasys-front`, contextual rendering of local runtime EFSMs must restore their actual runtime session state:

- navigation -> `opus.fsm.owasys-front.navigation`;
- security -> `opus.fsm.owasys-front.security`;
- registry/application/data/source/git/build -> existing `opus.fsm.owasys-front.<efsm>` keys.

Therefore Structure must highlight the real Navigation state and Security must highlight the real Security state, not `initial_state` merely because those EFSMs are not classified as host-owned domain views.

For another selected application such as a generated app, its Navigation/Security diagram remains a source projection unless that application's runtime state is explicitly available through a future contract.

## Exact source surface

Expected modified tracked paths:

1. `sites/owasys-front/config/site.json`
2. `sites/owasys-front/application/default/services/ContextEfsmRegistry.php`
3. `sites/owasys-front/application/default/services/ContextRuntimeCoordinatorInterface.php`
4. `sites/owasys-front/application/default/services/ContextRuntimeCoordinator.php`
5. `sites/owasys-front/application/default/controllers/RuntimeController.php`
6. `sites/owasys-front/application/security/services/SecurityRuntimeCoordinator.php`
7. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

Expected new path:

8. `sites/owasys-front/config/navigation.fsm.json`

No OWASYS-back source change is required.

No CSS/JS change is required.

No existing `*.fsm.layout.json` is to be modified or deleted by the applicator.

## Baseline blobs

- `site.json`: `0df0e1de0f04d56509b27a382844532ad4d611b9`
- `ContextEfsmRegistry.php`: `73ade8f2516b0d221ae69047be162821940c2e14`
- `ContextRuntimeCoordinatorInterface.php`: `3f356016e281bda432559ecca505c2cd57f6ac17`
- `ContextRuntimeCoordinator.php`: `2dd1888e2aa86406c3b04b7ba8c852e4d84df0da`
- `RuntimeController.php`: `67acb3f0690593bf49a45263fe5311931c6dbc16`
- `SecurityRuntimeCoordinator.php`: `2a1ddedceba209f8fa92d298497dcdeba2ae7aa3`
- `FsmDiagramBuilder.php`: `9471b1fa0f43aeb901b2b2388be617f1773d2a03`

## Safety gates

Applicator must:

- require HEAD exactly `d3a6cfc53e021dba0d5c2c60b9b9761b421dd76d`;
- require no staged changes;
- require all seven target files clean relative to HEAD and exact baseline blobs;
- allow only pre-existing runtime layout companion changes matching `sites/*/config/*.fsm.layout.json` outside the patch surface;
- SHA-256 snapshot every allowed layout companion and prove byte preservation;
- require `navigation.fsm.json` absent before write;
- validate candidate Navigation JSON structurally before write;
- lint every candidate PHP transformation before write;
- write only the seven modified paths plus new Navigation definition;
- rollback only its own seven targets/new file on post-write failure;
- run post-write PHP lint and JSON validation;
- prove exact Git inventory and `git diff --check`;
- perform no internal Composer invocation.

## Acceptance matrix

After owner application:

1. `composer opus:validate-site -- owasys-front` PASS.
2. `composer opus:validate-site -- owasys-back` PASS.
3. `composer opus:validate-site -- essai` PASS.
4. Applications renders `registry` EFSM and handshake remains correlated.
5. Application renders `application` EFSM and handshake remains correlated.
6. Sources de données renders `data` EFSM.
7. Sources et Git renders Source/Git EFSMs without regression.
8. Construction renders `build` EFSM.
9. Sécurité renders `security` EFSM with runtime state `authenticated` for an authenticated owner session.
10. Structure renders `navigation` from `config/navigation.fsm.json`, not `config/fsm.json`.
11. Structure highlights runtime state `structure` while on the Structure route.
12. Leaving Structure for another host view changes the dedicated Navigation runtime state to the corresponding context.
13. Logger/Profiler shows all bus messages with `source_fsm`/`target_fsm` referencing exactly one canonical `owasys-front/navigation` source.
14. Legacy `config/fsm.json` still drives HTTP dispatch and is not modified in this slice.
15. Existing layout companions remain byte-identical unless the owner deliberately moves a diagram in DESIGN after application.

No commit/push until this matrix passes.