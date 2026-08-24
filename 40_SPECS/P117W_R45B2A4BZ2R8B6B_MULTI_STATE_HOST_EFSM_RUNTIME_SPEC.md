# P117W R45B2A4BZ2 R8B6B — Multi-state host EFSM runtime — SPEC

State: ACTIVE — BUILD/OWNER RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- Accepted predecessor: R8B5D4.
- R8B6A is rejected and must never be applied.

## Cause

The current OWASYS global navigation FSM owns routing and also contains contextual operation signals for Registry, Source/Git and Build. R8B6A attempted to fan out diagram authority using one-state context EFSMs. That would not model the real runtime lifecycle and is rejected.

R8B6B introduces autonomous host EFSMs with meaningful state topology while keeping Navigation as the top routing/orchestration FSM during this migration slice.

## Host EFSM registry

`sites/owasys-front/config/site.json.efsms` gains:

- `registry` -> `config/registry.fsm.json`;
- `application` -> `config/application.fsm.json`;
- `data` -> `config/data.fsm.json`;
- `source` -> `config/source.fsm.json`;
- `git` -> `config/git.fsm.json`;
- `build` -> `config/build.fsm.json`.

Existing `navigation` and `security` registrations remain unchanged.

## Context authority

A single `OwasysContextEfsmRegistry` maps presentation/runtime context:

- Registry page -> host `owasys-front/registry`;
- Application page -> host `owasys-front/application`;
- Data page -> host `owasys-front/data`;
- Source page -> host `owasys-front/source`;
- Source page with Git workspace active -> host `owasys-front/git`;
- Build page -> host `owasys-front/build`;
- Structure page -> selected application `navigation`;
- Security page -> selected application `security`.

The same registry is consumed by diagram projection and designer authorization so no divergent literal map is allowed.

## Multi-state machines

### Registry

States:

- `browsing`;
- `selecting`;
- `deleting`;
- `failed`.

Runtime signals include context entry plus real selection/deletion request and outcome lifecycle.

### Application

States:

- `unselected`;
- `selected`.

Context entry moves the host machine into the selected application context and subsequent entries preserve it. No fictional update/delete execution is introduced in this slice.

### Data

States:

- `detached`;
- `ready`.

The current repository has no Data business controller. R8B6B therefore models only the truthful contextual lifecycle and does not invent CRUD completion states.

### Source

States:

- `browsing`;
- `opened`;
- `previewing`;
- `writing`;
- `conflict`;
- `failed`.

Signals are derived from the existing real Source runtime: file open, preview request/outcome, write request/outcome, conflict and failure.

### Git

States:

- `unknown`;
- `clean`;
- `dirty`;
- `staging`;
- `unstaging`;
- `committing`;
- `restoring`;
- `failed`.

Signals are derived from the existing Git runtime: status observation, stage/unstage/commit/restore requests, completion and failure. Mutation completion returns to `unknown`; the next measured status snapshot resolves the machine to `clean` or `dirty`.

### Build

States:

- `ready`;
- `preview_starting`;
- `preview_running`;
- `failed`.

Only the currently implemented development-preview lifecycle is modeled. Validate/export completion states are not invented.

## Inter-EFSM communication

Each host context performs a real generic OPUS handshake:

`owasys-front/navigation -> COMMAND enter_<context>_context -> owasys-front/<context>`

then:

`owasys-front/<context> -> EVENT <context>_context_ready -> owasys-front/navigation`

using `Opus\Fsm\FsmSignalBus` with correlation/causation checks.

Navigation receives six automatic EVENT self-transitions:

- `registry_context_ready` in `registry`;
- `application_context_ready` in `application`;
- `data_context_ready` in `data`;
- `source_context_ready` in `source`;
- `git_context_ready` in `source`;
- `build_context_ready` in `build`.

Context-entry transitions are defined for every state of each host EFSM so re-entering a page does not erase an in-progress or diagnostic state solely to satisfy the handshake.

## Runtime state persistence and diagram truth

Each host EFSM uses a dedicated session key:

`opus.fsm.owasys-front.<efsm_id>`

`OwasysFsmDiagramBuilder` must restore that host EFSM and pass the real persisted `currentState()` to `OPUS_FSM_Diagram::fromDefinition()`.

It is forbidden to present `initial_state` as the current state when a host runtime snapshot exists.

Structure/Security selected-application behavior remains unchanged.

## Progressive migration boundary

R8B6B does not delete the existing global operation transitions yet. That would be a broad behavioral migration in the same patch and would violate the controlled-change contract.

Instead, real controller operations additionally advance their host EFSM lifecycle:

- Registry selection/deletion;
- Source open/preview/write/conflict/failure;
- Git status/stage/unstage/commit/restore/failure;
- Build preview start/success/failure.

The global FSM remains the routing/orchestration authority during this slice. Host EFSM runtime lifecycle is now real and measured rather than decorative. A later acceptance-backed slice may remove migrated contextual operation signals from Navigation one domain at a time.

## Security/ACL

Host/system EFSM DESIGN is a system-application mutation.

Front rule:

- host EFSMs (`registry`, `application`, `data`, `source`, `git`, `build`) force target application `owasys-front` server-side;
- host DESIGN requires `owasys:modify`;
- selected-application Structure/Security DESIGN continues to require `fsm:update`.

Back rule:

- ordinary application EFSM update/layout write continues to require `fsm:update`;
- when `site_id` is `owasys-front` or `owasys-back`, semantic EFSM writes, handler writes and layout writes additionally require `owasys:modify`;
- read operations remain under existing read ACL.

With current ACLs, admin `*:*` is allowed while developer `fsm:*` alone cannot mutate OWASYS system EFSMs.

## Non-regression invariants

- no change to `Opus/Fsm/Diagram.class.php` or R8B5D4 geometry reconciliation;
- no change to any existing `*.fsm.layout.json`;
- no JavaScript/TypeScript/Node/package-manager content under `sites/owasys-back`;
- Structure remains selected-app `navigation`;
- Security remains selected-app `security`;
- Source/Git business requests remain front -> secured REST -> back -> Composer where already implemented;
- system application deletion protection remains unchanged;
- VIEW remains read-only;
- admin host DESIGN remains available;
- developer ordinary application DESIGN remains available.

## Intended OPUS source surface

Modified existing paths:

1. `sites/owasys-front/config/site.json`;
2. `sites/owasys-front/config/fsm.json`;
3. `sites/owasys-front/application/default/bootstrap.php`;
4. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`;
5. `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
6. `sites/owasys-front/application/default/services/FsmDesignerGateway.php`;
7. `sites/owasys-front/application/default/controllers/RuntimeController.php`;
8. `sites/owasys-front/application/source/controllers/SourceController.php`;
9. `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`;
10. `sites/owasys-back/application/fsm/services/OwasysFsmLayoutCommandProvider.php`.

New paths:

11. `sites/owasys-front/application/default/services/ContextEfsmRegistry.php`;
12. `sites/owasys-front/application/default/services/ContextRuntimeCoordinatorInterface.php`;
13. `sites/owasys-front/application/default/services/ContextRuntimeCoordinator.php`;
14. `sites/owasys-front/config/registry.fsm.json`;
15. `sites/owasys-front/config/application.fsm.json`;
16. `sites/owasys-front/config/data.fsm.json`;
17. `sites/owasys-front/config/source.fsm.json`;
18. `sites/owasys-front/config/git.fsm.json`;
19. `sites/owasys-front/config/build.fsm.json`.

## Delivery gate

The applicator must:

- require exact OPUS HEAD `56d4293f21f0a049cfe7cbe968916896de47dc41`;
- require clean tracked/untracked worktree before application;
- verify exact baseline Git blob SHA for all ten existing targets;
- require all nine new targets absent;
- transform PHP through unique exact anchors only;
- mutate JSON structurally and reject duplicate IDs/registrations;
- lint all generated/modified PHP before write;
- parse/validate all generated/modified JSON before write;
- write atomically;
- verify exact 19-path repository inventory;
- run `git diff --check`;
- rollback only its own writes on post-write failure;
- never invoke Composer internally.

## Owner runtime acceptance

After applying the ZIP and external Composer validation:

1. Applications: chips `owasys-front / registry / config/registry.fsm.json`; graph is multi-state.
2. Application: `owasys-front / application / config/application.fsm.json`.
3. Data: `owasys-front / data / config/data.fsm.json`.
4. Sources: `owasys-front / source / config/source.fsm.json`.
5. Git workspace: `owasys-front / git / config/git.fsm.json`.
6. Build: `owasys-front / build / config/build.fsm.json`.
7. Profiler shows real `fsm.network` COMMAND/EVENT handshake with matching correlation/causation.
8. Source preview/write and Git stage/unstage/commit/restore still operate and advance the corresponding host EFSM lifecycle.
9. Build preview still operates and advances `ready -> preview_starting -> preview_running` on success.
10. Structure and Security remain unchanged.
11. admin can DESIGN/drag/persist host EFSMs; developer is denied host mutation but can still DESIGN ordinary application EFSMs.
12. owasys-front/owasys-back validate successfully and no backend JS/Node regression exists.

Do not commit/push OPUS until these runtime gates pass.
