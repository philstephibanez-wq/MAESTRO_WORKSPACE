# P117W R45B2A4BZ2 R8B6B3 — Generic EFSM validator projection repair — SPEC

State: ACTIVE — BUILD/OWNER RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- Local owner state expected: R8B6B2 applied but not committed/pushed.
- R8B6B and R8B6B1 failed before write and are superseded.

## Runtime evidence

Owner logs dated 2026-08-25 show that R8B6B2 host inter-EFSM communication is operational before rendering failure:

- registry COMMAND/EVENT handshake completes and reaches `browsing`;
- source COMMAND/EVENT handshake completes and reaches `browsing`;
- build COMMAND/EVENT handshake completes and reaches `ready`;
- data COMMAND/EVENT handshake completes and reaches `ready`;
- application COMMAND/EVENT handshake completes and reaches `selected`.

Immediately after those completed handshakes, OWASYS-front fails with:

`OWASYS_APPLICATION_EFSM_CONTRACT_INVALID`

from:

`sites/owasys-front/application/fsm/models/ApplicationFsmModel.php:91`.

OWASYS-back logs show the corresponding secured REST/Composer source reads succeed with HTTP 200, including reads of the new host EFSM definitions. Therefore the failure is not REST, Composer, transport or host FSM execution; it is the front projection contract gate.

## Root cause

`OwasysApplicationFsmModel::snapshot()` currently accepts only these hard-coded definition contract names:

- `OPUS_APPLICATION_FSM_V1`;
- `OPUS_SECURITY_FSM_V1`;
- `OWASYS_NAVIGATION_FSM_V1`;
- `OWASYS_BACK_FSM_V1`.

R8B6B2 host EFSMs intentionally use:

`OWASYS_HOST_CONTEXT_FSM_V1`.

Adding this fifth string to the whitelist would only move the defect to the next valid EFSM contract family. The projection is generic and must validate an EFSM structurally instead of owning a closed list of business/application contract names.

## Generic OPUS authority

OPUS already provides:

`Opus\Fsm\Definition\FsmDefinitionValidator`

with structural validation for canonical states, signals, transitions, finite global sources, initial/final state references, guards/actions and runtime operations.

R8B6B3 therefore changes the projection boundary to use that generic validator.

## Exact source correction

Target:

`sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`

Changes:

1. import `Opus\Fsm\Definition\FsmDefinitionValidator`;
2. keep the requirement that a non-empty definition `contract` exists;
3. remove the hard-coded list of accepted contract values;
4. call `(new FsmDefinitionValidator())->assertValid($definition)`;
5. preserve the existing `site_id`, `efsm_id`, source-path, hash and additional projection checks.

The generic validator call is additive to the current application-specific security/context checks; it does not relax target ownership.

## R8B6B2 preservation

R8B6B3 must not rebuild or overwrite the 20-path R8B6B2 evolution.

The applicator must accept only the expected uncommitted R8B6B2 local state:

Tracked modified paths:

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

Untracked new paths:

12. `sites/owasys-front/application/default/services/ContextEfsmRegistry.php`;
13. `sites/owasys-front/application/default/services/ContextRuntimeCoordinatorInterface.php`;
14. `sites/owasys-front/application/default/services/ContextRuntimeCoordinator.php`;
15. `sites/owasys-front/config/registry.fsm.json`;
16. `sites/owasys-front/config/application.fsm.json`;
17. `sites/owasys-front/config/data.fsm.json`;
18. `sites/owasys-front/config/source.fsm.json`;
19. `sites/owasys-front/config/git.fsm.json`;
20. `sites/owasys-front/config/build.fsm.json`.

The applicator snapshots all 20 pre-existing paths byte-for-byte and proves they remain unchanged after writing only `ApplicationFsmModel.php`.

## R8B6B2 semantic preflight

Before writing, the applicator must prove the expected host evolution is present:

- `site.json.efsms` maps registry/application/data/source/git/build to their six canonical files;
- each six host definition is valid JSON, declares `contract=OWASYS_HOST_CONTEXT_FSM_V1`, `site_id=owasys-front`, matching `efsm_id`, at least two states and at least two transitions;
- `ContextEfsmRegistry.php` and `ContextRuntimeCoordinator.php` are present;
- no unrelated tracked or untracked path is accepted.

## Target gate

- exact HEAD remains `56d4293f21f0a049cfe7cbe968916896de47dc41`;
- target HEAD blob for `ApplicationFsmModel.php` is `4ffbae0db7d30f618089d11192941231f78b27e8`;
- target must be clean relative to HEAD before R8B6B3;
- two exact transformation anchors must occur once each;
- candidate target must PHP-lint before write.

## Post-write gate

After writing:

- exact local dirty inventory becomes the preserved 20 R8B6B2 paths plus `ApplicationFsmModel.php` only;
- all 20 pre-existing files retain their preflight SHA-256;
- target PHP lint passes;
- `git diff --check` passes;
- no Composer invocation occurs inside the applicator.

On post-write failure, rollback is limited to `ApplicationFsmModel.php`; R8B6B2 local work remains untouched.

## Runtime acceptance

After R8B6B3 application and external site validation:

1. Applications renders `owasys-front / registry / config/registry.fsm.json` without 500;
2. Application renders `owasys-front / application / config/application.fsm.json`;
3. Data renders `owasys-front / data / config/data.fsm.json`;
4. Source renders `owasys-front / source / config/source.fsm.json`;
5. Git workspace renders `owasys-front / git / config/git.fsm.json`;
6. Build renders `owasys-front / build / config/build.fsm.json`;
7. existing `fsm.network` COMMAND/EVENT handshakes remain correlated;
8. Structure and Security continue to render normally;
9. no regression of R8B5D4 VIEW/DESIGN geometry;
10. no commit/push until the full R8B6B2 runtime acceptance matrix passes.
