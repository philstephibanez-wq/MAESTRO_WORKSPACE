# P117W R45B2A4BZ2 R8B6A — OWASYS-front host context micro-EFSM fanout — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source of truth

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- R8B5D4 is accepted/pushed and preserved.
- R8B5D5 is closed/not applied by owner decision.
- R8B6A specification: `40_SPECS/P117W_R45B2A4BZ2R8B6A_HOST_CONTEXT_EFSM_FANOUT_SPEC.md`.

## Functional correction

Five top OWASYS-front workspaces stop presenting the global navigation FSM as their contextual diagram and receive autonomous host-owned micro-EFSMs:

- `registry` -> `config/registry.fsm.json`;
- `application` -> `config/application.fsm.json`;
- `data` -> `config/data.fsm.json`;
- `source` -> `config/source.fsm.json`;
- `build` -> `config/build.fsm.json`.

Structure and Security remain selected-application contexts (`navigation` and `security`) without behavioral change.

Each host EFSM performs a real inter-EFSM handshake through the existing generic `FsmSignalBus`:

`navigation -> COMMAND enter_<context>_context -> context -> EVENT <context>_context_ready -> navigation`.

The navigation state and context state are invariant across the handshake and correlation/causation IDs are verified.

## Scope discipline

R8B6A establishes authority and communication only. Existing business operations remain on their current working paths in the navigation FSM for this slice. No Registry/Data/Source/Git/Build operation is removed or redirected yet.

This minimizes regression risk. Migration of operation ownership is a later slice after these five context authorities pass runtime validation.

## Authorization

- host/system application design target is forced server-side to `owasys-front`;
- system application DESIGN requires `owasys:modify` (admin wildcard permits it);
- ordinary selected-application DESIGN remains `fsm:update`;
- VIEW remains read-only;
- system application deletion protection is unchanged.

## Exact source surface

17 paths total: 9 modified + 8 new.

Modified:

1. `sites/owasys-front/config/site.json`;
2. `sites/owasys-front/config/fsm.json`;
3. `sites/owasys-front/application/default/bootstrap.php`;
4. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`;
5. `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
6. `sites/owasys-front/application/default/services/FsmDesignerGateway.php`;
7. `sites/owasys-front/application/default/controllers/RuntimeController.php`;
8. `sites/owasys-front/application/source/controllers/SourceController.php`;
9. `sites/owasys-front/application/default/Application.php`.

New:

10. `sites/owasys-front/application/default/services/ContextEfsmRegistry.php`;
11. `sites/owasys-front/application/default/services/ContextRuntimeCoordinatorInterface.php`;
12. `sites/owasys-front/application/default/services/ContextRuntimeCoordinator.php`;
13. `sites/owasys-front/config/registry.fsm.json`;
14. `sites/owasys-front/config/application.fsm.json`;
15. `sites/owasys-front/config/data.fsm.json`;
16. `sites/owasys-front/config/source.fsm.json`;
17. `sites/owasys-front/config/build.fsm.json`.

No OWASYS-back path, layout companion, EFSM renderer, CSS or JavaScript file is modified.

## Baseline blob gates

The applicator requires exact Git blobs:

- `site.json`: `15e9a23e9726d5434b334a2aad8a33839f4f0a56`;
- `fsm.json`: `5114d51e701b34345c5b0e37b1502dc6c1478f49`;
- `bootstrap.php`: `6a862f03af1d9c443b826151221abc925dc3eadc`;
- `FsmDiagramBuilder.php`: `0f17ee29537603b09911fe0f7acd7fb136b46128`;
- `ScorePageRenderer.php`: `0512c3427a190f4a6184710372d78e21f758b39f`;
- `FsmDesignerGateway.php`: `05b24d1236728ff54386bd4427bdda1d83233f0b`;
- `RuntimeController.php`: `18f626bf83572f10553a74558d795a99066a3343`;
- `SourceController.php`: `e448d743e80cee3c1b220ba3366fd2bc47e26705`;
- `Application.php`: `9dc9b73cf4cabcc8ece3604258633a44c76898a1`.

Worktree and index must be clean and all eight new targets must be absent.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6a_host_context_efsm_fanout.zip`;
- ZIP SHA-256: `1740f3a60daf4643f4e5e806b96d6026b609f7ffb94a099e1e9ed05ed87141e6`;
- ZIP contains exactly `apply_a4bz2r8b6a.php`;
- applicator SHA-256: `e14c353774bf21a38087b42f4271b8294b3b135fa110934a0a2a31fff67896e6`;
- applicator size: `64076` bytes;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- extracted applicator PHP lint: PASS;
- no internal Composer invocation.

## Deterministic applicator replay

A temporary Git repository with syntactically valid fixtures for all nine existing targets was used to exercise the actual delivered applicator logic after substituting only the test baseline SHA/blob constants in a non-delivered test copy.

Result:

- `PREFLIGHT_OK`;
- all transformed/new PHP files linted before writes;
- all transformed/new JSON files parsed and static contracts passed;
- atomic writes completed;
- post-write PHP/JSON checks passed;
- exact inventory = 9 tracked modified + 8 untracked new;
- clean index;
- no backend/layout/renderer path;
- `git diff --check` PASS;
- `REPO_CHANGES_VERIFIED`;
- `APPLIED`.

The delivered applicator retains the real hard-coded baseline `56d4293f21f0a049cfe7cbe968916896de47dc41`; there is no test override or hidden fallback in the artifact.

## Expected markers

- `P117W_R45B2A4BZ2R8B6A_PREFLIGHT_BEGIN`;
- `P117W_R45B2A4BZ2R8B6A_PREFLIGHT_OK`;
- `P117W_R45B2A4BZ2R8B6A_REPO_CHANGES_VERIFIED`;
- `P117W_R45B2A4BZ2R8B6A_APPLIED`;
- `baseline_head=56d4293f21f0a049cfe7cbe968916896de47dc41`;
- `changed_paths=17`;
- `host_context_efsms=registry,application,data,source,build`;
- `communication=navigation>command>context>event>navigation`;
- `host_designer_acl=owasys:modify`;
- `selected_app_designer_acl=fsm:update`;
- `structure_security=preserved`;
- `r8b5d4_renderer=preserved`;
- `layout_storage=unchanged`;
- `owasys_back_change=none`;
- `composer_validation=external_terminal`.

## Owner runtime acceptance

Run external site validation, then visit the five top workspaces and require these diagram authorities:

- Applications -> `application: owasys-front`, `efsm: registry`, `source: config/registry.fsm.json`;
- Application -> `owasys-front / application / config/application.fsm.json`;
- Sources de données -> `owasys-front / data / config/data.fsm.json`;
- Sources & Git -> `owasys-front / source / config/source.fsm.json`;
- Construction et validation -> `owasys-front / build / config/build.fsm.json`.

Profiler must show the corresponding COMMAND/EVENT handshake for each context.

Non-regression gates:

- Structure still displays selected application `navigation`;
- Security still displays selected application `security`;
- existing Source/Git and Build operations still work;
- admin can DESIGN a host context;
- VIEW is read-only;
- DESIGN drag/persistence still works;
- no OWASYS-back/REST/security/profiler regression.

Do not commit/push OPUS before these runtime gates pass.
