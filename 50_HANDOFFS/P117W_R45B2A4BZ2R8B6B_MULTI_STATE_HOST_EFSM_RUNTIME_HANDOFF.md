# P117W R45B2A4BZ2 R8B6B — Multi-state host EFSM runtime — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob revalidated immediately before packaging: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master revalidated immediately before packaging: `56d4293f21f0a049cfe7cbe968916896de47dc41` (`opus_p117w_r45b2a4bz2r8b5d4_view_readonly_geometry_runtime_reconciliation`).
- Accepted predecessor: R8B5D4.
- R8B6A is rejected, archived for traceability, and must never be applied.
- R8B6B specification: `40_SPECS/P117W_R45B2A4BZ2R8B6B_MULTI_STATE_HOST_EFSM_RUNTIME_SPEC.md`.

## Delivered correction

R8B6B replaces the rejected one-state fanout with six autonomous OWASYS-front host EFSMs:

- `registry` -> `config/registry.fsm.json`;
- `application` -> `config/application.fsm.json`;
- `data` -> `config/data.fsm.json`;
- `source` -> `config/source.fsm.json`;
- `git` -> `config/git.fsm.json`;
- `build` -> `config/build.fsm.json`.

The machines are multi-state and represent only runtime facts that current OWASYS can actually emit. No fictional Data CRUD or Build validate/export outcomes are added.

Navigation remains the top routing/orchestration FSM for this controlled migration slice. Existing contextual global transitions are not removed yet. Real controller operations additionally advance the dedicated host EFSM runtime, allowing the next slice to remove global ownership domain-by-domain after runtime acceptance.

## Runtime communication

Every host view performs a real generic OPUS inter-EFSM handshake:

`owasys-front/navigation -> COMMAND enter_<context>_context -> owasys-front/<context> -> EVENT <context>_context_ready -> owasys-front/navigation`

The implementation uses `Opus\Fsm\FsmSignalBus`, verifies correlation/causation and records measured `fsm.network` Logger/Profiler events.

Dedicated runtime snapshots use:

`opus.fsm.owasys-front.<efsm_id>`

The contextual diagram restores this runtime and renders the persisted current state rather than always presenting the EFSM initial state.

## Runtime lifecycles

### Registry

- `browsing`;
- `selecting`;
- `deleting`;
- `failed`.

Application selection request/success and deletion request are measured. Deletion completion remains in the existing global workflow; there is deliberately no synthetic host `deletion_succeeded` event. Re-entry reconciles transient Registry states to `browsing`.

### Application

- `unselected`;
- `selected`.

### Data

- `detached`;
- `ready`.

No Data business CRUD controller currently exists, so no fictional CRUD states are emitted.

### Source

- `browsing`;
- `opened`;
- `previewing`;
- `writing`;
- `conflict`;
- `failed`.

Real file-open, preview, write, conflict and failure signals drive the machine.

### Git

- `unknown`;
- `clean`;
- `dirty`;
- `staging`;
- `unstaging`;
- `committing`;
- `restoring`;
- `failed`.

Real status, stage, unstage, commit, restore and failure signals drive the machine. Mutation completion returns to `unknown`; the next real status snapshot resolves `clean`/`dirty`.

### Build

- `ready`;
- `preview_starting`;
- `preview_running`;
- `failed`.

Only the currently implemented development-preview lifecycle is modeled.

## Context projection

A single `OwasysContextEfsmRegistry` owns the mapping used by runtime, diagram and designer:

- Applications -> host `registry`;
- Application -> host `application`;
- Data -> host `data`;
- Source -> host `source`;
- Source with Git workspace active -> host `git`;
- Build -> host `build`;
- Structure -> selected application `navigation`;
- Security -> selected application `security`.

R8B5D4 renderer/geometry behavior and existing layout companions are not modified.

## Security correction

The current backend accepted EFSM semantic/layout mutation with `fsm:update` only. Because developer has `fsm:*`, a front-only host DESIGN restriction would be bypassable by direct REST calls.

R8B6B closes this at both boundaries:

- ordinary application EFSM mutation: existing `fsm:update` rule remains;
- system application (`owasys-front`/`owasys-back`) semantic EFSM writes and handler writes: additionally require `owasys:modify` on back;
- system application layout writes: additionally require `owasys:modify` on back;
- host designer target is forced server-side to `owasys-front` and requires `owasys:modify` on front;
- Structure/Security selected-application DESIGN remains `fsm:update`.

Current ACL means admin `*:*` passes; developer `fsm:*` alone cannot mutate OWASYS system EFSMs.

## Exact OPUS surface

20 paths total: 11 modified + 9 new.

Modified:

1. `sites/owasys-front/config/site.json`;
2. `sites/owasys-front/config/fsm.json`;
3. `sites/owasys-front/application/default/bootstrap.php`;
4. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`;
5. `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
6. `sites/owasys-front/application/default/services/FsmDesignerGateway.php`;
7. `sites/owasys-front/application/default/controllers/RuntimeController.php`;
8. `sites/owasys-front/application/source/controllers/SourceController.php`;
9. `sites/owasys-front/application/default/Application.php`;
10. `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`;
11. `sites/owasys-back/application/fsm/services/OwasysFsmLayoutCommandProvider.php`.

New:

12. `sites/owasys-front/application/default/services/ContextEfsmRegistry.php`;
13. `sites/owasys-front/application/default/services/ContextRuntimeCoordinatorInterface.php`;
14. `sites/owasys-front/application/default/services/ContextRuntimeCoordinator.php`;
15. `sites/owasys-front/config/registry.fsm.json`;
16. `sites/owasys-front/config/application.fsm.json`;
17. `sites/owasys-front/config/data.fsm.json`;
18. `sites/owasys-front/config/source.fsm.json`;
19. `sites/owasys-front/config/git.fsm.json`;
20. `sites/owasys-front/config/build.fsm.json`.

No JavaScript/TypeScript/Node/package-manager/lockfile is added to `sites/owasys-back`.

## Baseline blob gates

The applicator requires the exact OPUS HEAD above, a completely clean worktree/index and these exact current Git blobs:

- `sites/owasys-front/config/site.json`: `15e9a23e9726d5434b334a2aad8a33839f4f0a56`;
- `sites/owasys-front/config/fsm.json`: `5114d51e701b34345c5b0e37b1502dc6c1478f49`;
- `sites/owasys-front/application/default/bootstrap.php`: `6a862f03af1d9c443b826151221abc925dc3eadc`;
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`: `0f17ee29537603b09911fe0f7acd7fb136b46128`;
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`: `0512c3427a190f4a6184710372d78e21f758b39f`;
- `sites/owasys-front/application/default/services/FsmDesignerGateway.php`: `05b24d1236728ff54386bd4427bdda1d83233f0b`;
- `sites/owasys-front/application/default/controllers/RuntimeController.php`: `18f626bf83572f10553a74558d795a99066a3343`;
- `sites/owasys-front/application/source/controllers/SourceController.php`: `e448d743e80cee3c1b220ba3366fd2bc47e26705`;
- `sites/owasys-front/application/default/Application.php`: `9dc9b73cf4cabcc8ece3604258633a44c76898a1`;
- `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`: `aeaca86ea6ec25d3d90b5d99435b29e0f13ff7e3`;
- `sites/owasys-back/application/fsm/services/OwasysFsmLayoutCommandProvider.php`: `5a9f7150867d783a9e92fb7a7d7c51b306d8c65e`.

All nine new paths must be absent before writes begin.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6b_multi_state_host_efsm_runtime.zip`;
- ZIP SHA-256: `c89368600f98c56fa29087fc2333d30e16d44543c546f1620f1485802f52c29c`;
- ZIP contains exactly `apply_a4bz2r8b6b.php`;
- applicator size: `130203` bytes;
- applicator SHA-256: `2852c7c5c4f7bc3cd7167980fac8974bcb78840fcefceef5f5adce32a8ac5d69`;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- extracted applicator PHP lint: PASS;
- three embedded new service PHP files linted separately: PASS;
- six host EFSM definitions passed deterministic state/signal/transition uniqueness and reference validation against the current `FsmProcessor` constraints: PASS;
- no internal Composer invocation.

## Applicator safety

Before writing it:

- validates exact HEAD;
- requires empty `git status --porcelain`;
- validates every existing target blob;
- requires every new target absent;
- enforces exact unique PHP replacement anchors;
- structurally mutates `site.json` and global `fsm.json`;
- parses all candidate JSON;
- lints all candidate PHP before write.

After writing it:

- re-lints PHP;
- re-parses JSON;
- requires exact modified/untracked inventories;
- runs `git diff --check`;
- rolls back only its own 20 paths on post-write failure.

## Expected success markers

- `P117W_R45B2A4BZ2R8B6B_PREFLIGHT_BEGIN`;
- `P117W_R45B2A4BZ2R8B6B_PREFLIGHT_OK`;
- `P117W_R45B2A4BZ2R8B6B_REPO_CHANGES_VERIFIED`;
- `baseline_head=56d4293f21f0a049cfe7cbe968916896de47dc41`;
- `changed_paths=20`;
- `host_context_efsms=registry,application,data,source,git,build`;
- `communication=navigation>command>context>event>navigation`;
- `runtime_state_projection=persisted`;
- `host_designer_acl=owasys:modify`;
- `selected_app_designer_acl=fsm:update`;
- `backend_system_mutation_acl=owasys:modify`;
- `composer_validation=external_terminal`;
- `P117W_R45B2A4BZ2R8B6B_APPLIED`.

## Owner validation

Do not commit/push OPUS immediately after application.

First validate both OWASYS sites externally, then perform runtime acceptance:

1. Applications -> `owasys-front / registry / config/registry.fsm.json`, graph multi-state.
2. Application -> `owasys-front / application / config/application.fsm.json`.
3. Data -> `owasys-front / data / config/data.fsm.json`.
4. Source -> `owasys-front / source / config/source.fsm.json`.
5. Open Git workspace -> `owasys-front / git / config/git.fsm.json`.
6. Build -> `owasys-front / build / config/build.fsm.json`.
7. Profiler shows real `fsm.network` COMMAND/EVENT traffic with matching correlation/causation.
8. Source preview/write still works and advances Source runtime states.
9. Git stage/unstage/commit/restore still works and advances Git runtime states; status then resolves clean/dirty.
10. Build preview still works and reaches `preview_running` on success.
11. Structure still displays selected application `navigation`.
12. Security still displays selected application `security`.
13. admin can open host DESIGN, move geometry and persist it.
14. developer cannot mutate host/system EFSMs but can still DESIGN ordinary application EFSMs.
15. VIEW remains read-only and R8B5D4 geometry remains unchanged.

Only after all runtime gates pass may the owner commit/push OPUS.
