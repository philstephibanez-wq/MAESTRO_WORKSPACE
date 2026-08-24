# P117W R45B2A4BZ2 R8B6A — OWASYS-front host context micro-EFSM fanout — SPEC

State: ACTIVE — BUILD/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- Accepted predecessor: R8B5D4 is committed/pushed and its renderer/layout behavior is baseline.
- R8B5D5 exact-origin cosmetic artifact is closed/not applied by owner decision.

## Runtime problem

The top OWASYS-front views do not all expose their own context EFSM. Current `OwasysFsmDiagramBuilder::contextEfsmId()` maps only:

- Structure -> selected application `navigation`;
- Security -> selected application `security`.

The following top views still display the OWASYS navigation/global FSM fallback:

- Applications / `registry`;
- Application / `application`;
- Sources de données / `data`;
- Sources & Git / `source`;
- Construction et validation / `build`.

This mixes navigation orchestration with the contextual state machine presented for each workspace.

## Ownership model

The five new EFSMs are **OWASYS-front host context machines**, not business EFSMs injected into the currently selected application:

- `registry` -> `config/registry.fsm.json`;
- `application` -> `config/application.fsm.json`;
- `data` -> `config/data.fsm.json`;
- `source` -> `config/source.fsm.json`;
- `build` -> `config/build.fsm.json`.

They model OWASYS workspace context ownership. Structure and Security remain contextualized on the selected application exactly as today.

## R8B6A scope

R8B6A establishes context authority and communication only. It does **not** migrate the existing Registry/Data/Source/Git/Build business operations out of the global navigation FSM yet.

Each new host context EFSM therefore starts with one truthful stable context state and one automatic COMMAND self-transition:

- `registry` + `enter_registry_context`;
- `application` + `enter_application_context`;
- `data` + `enter_data_context`;
- `source` + `enter_source_context`;
- `build` + `enter_build_context`.

The navigation EFSM receives one corresponding automatic EVENT self-transition:

- `registry_context_ready`;
- `application_context_ready`;
- `data_context_ready`;
- `source_context_ready`;
- `build_context_ready`.

The communication contract for every context is:

`owasys-front/navigation -> COMMAND enter_<context>_context -> owasys-front/<context> -> EVENT <context>_context_ready -> owasys-front/navigation`

COMMAND and EVENT use the existing generic `Opus\Fsm\FsmSignalBus`; direct coordinator-to-coordinator mutation is forbidden.

## Context runtime coordinator

Add one OWASYS-front application service implementing a homonymous application interface:

- `OwasysContextRuntimeCoordinatorInterface`;
- `OwasysContextRuntimeCoordinator`.

It must:

1. accept only the five host context IDs above;
2. restore the existing navigation FSM/session and require its current state to equal the requested context;
3. restore the dedicated host context EFSM/session and require its current state to equal the context ID;
4. register both processors on `FsmSignalBus`;
5. deliver the COMMAND, persist the context EFSM, then deliver the correlated EVENT and persist navigation;
6. validate correlation/causation and final state invariants;
7. propagate no passwords, tokens, CSRF values, source content or other secrets in bus context;
8. record measured `fsm.network` Profiler/Logger events.

## Central context registry

Add one OWASYS-front application registry service as the single mapping authority for presentation/runtime routing:

- host contexts: `registry`, `application`, `data`, `source`, `build`;
- selected-application contexts: module `structure` -> EFSM `navigation`, module `security` -> EFSM `security`.

`FsmDiagramBuilder`, `ScorePageRenderer`, `FsmDesignerGateway` and the context coordinator must use this authority instead of maintaining divergent literal maps.

## Presentation behavior

For the five host workspaces:

- diagram source authority is forced server-side to application `owasys-front`;
- VIEW reads the host EFSM and its persisted layout through the existing secured REST/layout projection;
- DESIGN reuses the existing R8B5D designer and remote layout persistence;
- R8B5D4 geometry reconciliation remains unchanged;
- no CSS/renderer/layout rewrite is part of R8B6A.

For Structure/Security:

- the selected application remains the authority exactly as before;
- no behavioral change is permitted.

## Authorization

No new layout permission is introduced.

- admin: may modify OWASYS system applications and their EFSMs; system application deletion remains forbidden by the existing backend deletion contract;
- developer: keeps full development capability on ordinary existing applications;
- viewer: read-only.

For host context DESIGN, server-side target is forced to `owasys-front` and the front gateway requires `owasys:modify`. Current ACL `admin = *:*` permits it; developer/viewer do not receive that capability. Selected-application DESIGN continues to require `fsm:update`.

## Existing operations/non-regression boundary

R8B6A must not change semantics of:

- Registry selection/create/update/delete workflow;
- application delete protection for `owasys-front` / `owasys-back`;
- Source/Git read, preview, write, stage, commit, restore workflows;
- Build preview/validate/export behavior;
- Security coordinator/authentication/reauthentication;
- Structure selected-application `navigation` EFSM;
- R8B5D4 VIEW reconciliation;
- right-button drag/layout persistence;
- REST resource catalog or OWASYS-back source;
- any `*.fsm.layout.json` file.

Existing business transitions remain in `config/fsm.json` during R8B6A. A later slice may migrate them one context at a time after authority/communication runtime acceptance.

## Intended source surface

Modified existing files:

1. `sites/owasys-front/config/site.json`;
2. `sites/owasys-front/config/fsm.json`;
3. `sites/owasys-front/application/default/bootstrap.php`;
4. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`;
5. `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
6. `sites/owasys-front/application/default/services/FsmDesignerGateway.php`;
7. `sites/owasys-front/application/default/controllers/RuntimeController.php`;
8. `sites/owasys-front/application/source/controllers/SourceController.php`;
9. `sites/owasys-front/application/default/Application.php`.

New files:

10. `sites/owasys-front/application/default/services/ContextEfsmRegistry.php`;
11. `sites/owasys-front/application/default/services/ContextRuntimeCoordinatorInterface.php`;
12. `sites/owasys-front/application/default/services/ContextRuntimeCoordinator.php`;
13. `sites/owasys-front/config/registry.fsm.json`;
14. `sites/owasys-front/config/application.fsm.json`;
15. `sites/owasys-front/config/data.fsm.json`;
16. `sites/owasys-front/config/source.fsm.json`;
17. `sites/owasys-front/config/build.fsm.json`.

No OWASYS-back path is modified.

## Delivery gate

The differential applicator must require exact HEAD `56d4293f21f0a049cfe7cbe968916896de47dc41`, a clean index/worktree, and exact baseline Git blobs for every existing target. New targets must not exist.

It must preflight unique transformation anchors, lint every changed/new PHP file before write, parse every changed/new JSON definition, write atomically, verify exact tracked/untracked path inventory using `git diff --name-only` plus `git ls-files --others --exclude-standard`, run `git diff --check`, and rollback only its own 17 paths on post-write failure. No Composer subprocess may be launched internally.

Static post-write gates must prove:

- five new `site.json.efsms` registrations;
- five new navigation EVENT signals and matching self-transitions;
- five host EFSM files with matching `site_id`, `efsm_id`, state and enter COMMAND;
- central module/context map has exactly the seven presentation mappings expected;
- host diagram/designer target is `owasys-front`;
- host DESIGN uses `owasys:modify` while selected-app DESIGN uses `fsm:update`;
- coordinator uses `FsmSignalBus::command()` and `event()` with correlation/causation validation;
- Source and runtime-rendered host views both invoke the coordinator;
- no backend path, layout companion or R8B5D4 renderer is changed.

## Owner runtime acceptance

After external Composer validation, verify the five top views:

- Applications -> chips show `application: owasys-front`, `efsm: registry`, `source: config/registry.fsm.json`;
- Application -> `owasys-front / application / config/application.fsm.json`;
- Sources de données -> `owasys-front / data / config/data.fsm.json`;
- Sources & Git -> `owasys-front / source / config/source.fsm.json`;
- Construction et validation -> `owasys-front / build / config/build.fsm.json`.

For each, the Profiler must contain the real COMMAND/EVENT handshake and the navigation state must remain unchanged.

Also recheck:

- Structure still displays selected application `navigation`;
- Security still displays selected application `security`;
- Source/Git and Build existing operations still work;
- admin can enter DESIGN for host contexts;
- VIEW remains read-only;
- DESIGN right-button drag/persistence remains operational;
- no backend/REST/security regression.

Only after those gates pass may the owner commit/push OPUS.
