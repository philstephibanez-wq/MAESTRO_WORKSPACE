# P117W R45B2A4BZ2 R8B6C — Dedicated Navigation EFSM and route projection — SPEC

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Baseline

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `d3a6cfc53e021dba0d5c2c60b9b9761b421dd76d`.
- R8B6B4 is owner runtime accepted and pushed.

## Naming decision

The public and architectural domain is **Navigation**.

`Routes` is a technical projection inside Navigation: URL mappings resolve to/from navigation signals, but routes do not own EFSM state.

The historical identifier `structure` may remain only as an explicit internal compatibility identifier while the legacy host dispatch FSM still drives HTTP dispatch. It must not remain the visible domain name or the dedicated EFSM state name.

Public target:

- menu: `Navigation` (localized);
- public localized route: `/navigation` (localized equivalents);
- dedicated EFSM id: `navigation`;
- dedicated Navigation state for the Navigation page: `navigation`.

Legacy compatibility:

- `config/fsm.json` may still contain internal host state/module/route key `structure` in this slice;
- `legacy_canonical_routes_accepted=true` continues accepting the old canonical `/structure` route;
- no new architecture or UI is allowed to call the domain Structure.

## Current defect

At baseline `sites/owasys-front/config/site.json` has both:

- `navigation.fsm = config/fsm.json` for runtime dispatch;
- `efsms.navigation = config/fsm.json` for contextual EFSM rendering.

Therefore the Navigation development surface still renders the historical monolithic host FSM instead of a dedicated Navigation EFSM.

That global file also still carries login/account/application-creation and other legacy dispatch responsibilities, so replacing the runtime dispatch pointer in one big-bang change is out of scope.

## Target architecture

### 1. Preserve legacy host dispatch temporarily

`site.json.navigation.fsm` remains `config/fsm.json`.

`FsmSiteLoader::processorForSiteRoot()` therefore continues to drive current FSM-first HTTP dispatch.

`config/fsm.json` is not modified by R8B6C.

### 2. Register a dedicated Navigation EFSM

Create:

`sites/owasys-front/config/navigation.fsm.json`

Set:

`site.json.efsms.navigation = config/navigation.fsm.json`.

The dedicated Navigation EFSM owns these states:

- `registry`;
- `application`;
- `data`;
- `navigation`;
- `security`;
- `source`;
- `build`.

Initial state: `registry`.

Navigation transitions:

- `open_applications` -> `registry`;
- `open_application` -> `application`;
- `open_data` -> `data`;
- `open_navigation` -> `navigation`;
- `open_security` -> `security`;
- `open_source` -> `source`;
- `open_build` -> `build`.

Each navigation signal is a finite global transition over all seven states, so the machine remains deterministic without a 49-edge duplicated topology.

Context-ready EVENT self-loops:

- `registry_context_ready` on `registry`;
- `application_context_ready` on `application`;
- `data_context_ready` on `data`;
- `security_context_ready` on `security`;
- `source_context_ready` on `source`;
- `git_context_ready` on `source`;
- `build_context_ready` on `build`.

### 3. One runtime authority for Navigation

Add a dedicated application service:

- `OwasysNavigationRuntimeInterface`;
- `OwasysNavigationRuntime`.

It owns the runtime processor/session for the dedicated Navigation EFSM:

`opus.fsm.owasys-front.navigation`.

Responsibilities:

1. restore the legacy host dispatch FSM only to verify that HTTP dispatch is currently in the expected legacy state;
2. restore the dedicated Navigation EFSM;
3. synchronize the dedicated state to the public navigation context;
4. register exactly this processor as bus identity `owasys-front/navigation`;
5. persist only the dedicated Navigation EFSM state.

Mapping from legacy host dispatch to dedicated Navigation:

- `registry` -> `registry`;
- `application` -> `application`;
- `data` -> `data`;
- legacy `structure` -> dedicated `navigation`;
- `security` -> `security`;
- `source` -> `source`;
- `build` -> `build`.

The pair is validated; arbitrary legacy/dedicated state combinations are forbidden.

### 4. Domain handshakes use dedicated Navigation

`OwasysContextRuntimeCoordinator` must no longer register the legacy `config/fsm.json` processor as `owasys-front/navigation`.

For Registry/Application/Data/Source/Git/Build:

1. verify legacy host dispatch state;
2. synchronize dedicated Navigation state;
3. register dedicated Navigation on `FsmSignalBus`;
4. deliver existing COMMAND to the domain EFSM;
5. deliver existing `<domain>_context_ready` EVENT back to dedicated Navigation.

`git` maps to Navigation state `source`.

Correlation/causation behavior remains unchanged.

### 5. Security uses the same dedicated Navigation authority

`OwasysSecurityRuntimeCoordinator` uses `OwasysNavigationRuntime` for both the normal Security handshake and reauthentication.

The legacy host FSM is only checked for dispatch state `security`; it is never registered on the bus as Navigation.

After R8B6C there must be only one canonical runtime source behind bus identity `owasys-front/navigation`: `config/navigation.fsm.json`.

### 6. Navigation page synchronization

The legacy runtime module is still internally `structure` in this slice.

When that host module is rendered, `OwasysNavigationRuntime` verifies legacy state `structure` and synchronizes the dedicated Navigation EFSM to state `navigation`.

No separate Structure EFSM exists.

### 7. Runtime-state projection in diagrams

For application `owasys-front`, `FsmDiagramBuilder` restores the actual runtime state for:

- `navigation` from `opus.fsm.owasys-front.navigation`;
- `security` from `opus.fsm.owasys-front.security`;
- host domain EFSMs from their existing `opus.fsm.owasys-front.<efsm>` stores.

This fixes the current Security projection that can display `anonymous` although the owner session is authenticated.

For another selected application, its Navigation/Security diagram remains a source projection unless a later runtime contract exposes that application's live state.

### 8. Public menu and route projection

The legacy host FSM may keep its internal `menu.structure` key and canonical route key `structure` in this slice, but the user-visible value becomes Navigation.

All base locale catalogs configured by `catalog_base_locales` are updated so `menu.structure` displays the localized equivalent of Navigation.

`routes.localized.json.routes.structure.paths` is updated to localized Navigation paths. Therefore generated links use localized Navigation URLs while old canonical `/structure` remains accepted explicitly through the existing legacy-canonical-route policy.

For French the public route becomes:

`/fr-FR/navigation`.

No `routes.json` change is required: its legacy canonical route key remains a compatibility adapter to `open_structure` until the host dispatch FSM itself is extracted later.

## Exact source surface

Fixed modified paths:

1. `sites/owasys-front/config/site.json`
2. `sites/owasys-front/config/routes.localized.json`
3. `sites/owasys-front/application/default/bootstrap.php`
4. `sites/owasys-front/application/default/services/ContextRuntimeCoordinator.php`
5. `sites/owasys-front/application/default/controllers/RuntimeController.php`
6. `sites/owasys-front/application/security/services/SecurityRuntimeCoordinator.php`
7. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

Base-I18n modified paths:

- every base catalog `sites/owasys-front/application/default/local/<base>.json` listed in `site.json.i18n.catalog_base_locales` (25 at the baseline).

New paths:

8. `sites/owasys-front/application/default/services/NavigationRuntimeInterface.php`
9. `sites/owasys-front/application/default/services/NavigationRuntime.php`
10. `sites/owasys-front/config/navigation.fsm.json`

Expected functional worktree change count at the baseline: `35` paths = 32 modified + 3 new.

No OWASYS-back source change.
No CSS/JS change.
No `config/fsm.json` change.
No existing `*.fsm.layout.json` mutation by the applicator.

## Fixed baseline blobs

- `site.json`: `0df0e1de0f04d56509b27a382844532ad4d611b9`
- `routes.localized.json`: `2b708f2b12b03ac02627267faba87e3674aedf3f`
- `bootstrap.php`: `ee905d6a87bcf5d8b3d6ab93e03a19569a59d9a8`
- `ContextRuntimeCoordinator.php`: `2dd1888e2aa86406c3b04b7ba8c852e4d84df0da`
- `RuntimeController.php`: `67acb3f0690593bf49a45263fe5311931c6dbc16`
- `SecurityRuntimeCoordinator.php`: `2a1ddedceba209f8fa92d298497dcdeba2ae7aa3`
- `FsmDiagramBuilder.php`: `9471b1fa0f43aeb901b2b2388be617f1773d2a03`

Base locale catalogs are resolved from the exact baseline HEAD tree and each must be tracked and clean relative to HEAD before transformation.

## Safety gates

Applicator must:

- require HEAD exactly `d3a6cfc53e021dba0d5c2c60b9b9761b421dd76d`;
- require no staged changes;
- require all patch targets clean relative to HEAD;
- verify the seven fixed baseline Git blobs exactly;
- derive the 25 base locale target paths from canonical `site.json` and require their HEAD objects/current files to match;
- allow outside the source patch only pre-existing `sites/*/config/*.fsm.layout.json` runtime companions;
- SHA-256 snapshot every allowed layout companion and prove byte preservation;
- require all three new paths absent;
- validate all source JSON before transformation;
- validate the candidate Navigation EFSM with deterministic state/signal/transition checks compatible with `FsmDefinitionValidator`/`FsmProcessor` finite-global rules;
- PHP-lint all candidate PHP files before write;
- write atomically;
- on post-write failure roll back only R8B6C-owned paths;
- PHP-lint/JSON-validate after write;
- prove exact Git inventory and `git diff --check`;
- invoke no Composer subprocess internally.

## Acceptance matrix

After owner application:

1. `composer opus:validate-site -- owasys-front` PASS.
2. `composer opus:validate-site -- owasys-back` PASS.
3. `composer opus:validate-site -- essai` PASS.
4. Menu label is Navigation, not Structure.
5. French menu link resolves to `/fr-FR/navigation`.
6. Legacy `/fr-FR/structure` remains accepted only as explicit route compatibility.
7. Navigation view renders `owasys-front / navigation` from `config/navigation.fsm.json` when current application is `owasys-front`.
8. Navigation view highlights dedicated runtime state `navigation` while on that page.
9. Applications -> dedicated Navigation runtime state `registry`, with existing registry COMMAND/EVENT handshake.
10. Application -> state `application`.
11. Sources de données -> state `data`.
12. Sécurité -> state `security`; Security diagram highlights actual `authenticated` runtime state for the authenticated owner session.
13. Sources et Git -> Navigation state `source`; Source/Git EFSM behavior unchanged.
14. Construction et validation -> Navigation state `build`.
15. Logger/Profiler bus events use exactly one canonical `owasys-front/navigation` runtime source.
16. `config/fsm.json` remains unchanged and continues to drive host HTTP dispatch.
17. Existing layout companions remain byte-identical unless owner deliberately changes diagram geometry after application.
18. `git diff --check` PASS.

No commit/push until the full matrix passes.

## Delivery validation

R8B6C was built against the exact baseline above and packaged as one differential applicator only.

- artifact: `opus_p117w_r45b2a4bz2r8b6c_dedicated_navigation_efsm_and_route_projection.zip`;
- ZIP SHA-256: `3ff1a96bf00e97f9071b1e4d307f2f738cb0468778da4c7c89904fbf592c8861`;
- applicator: `apply_a4bz2r8b6c.php`;
- applicator SHA-256: `c93ff5ab9965c14d2d9f5ece42ba0b3846f5b9f972b3a85ac5c50542348d1c14`;
- ZIP contains exactly one file;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- extracted applicator PHP lint: PASS;
- deterministic synthetic replay with one pre-existing tracked layout companion: PASS;
- deterministic synthetic replay with one tracked plus one untracked layout companion: PASS;
- functional inventory in both replays: 32 modified + 3 new = 35 paths;
- `config/fsm.json` byte preservation: PASS;
- layout companion byte preservation: PASS;
- candidate/post-write PHP lint: PASS in replay;
- candidate/post-write JSON validation: PASS in replay;
- `git diff --check`: PASS in replay;
- no Composer subprocess is invoked by the applicator.