# P117W R45B2A4BZ2 R8B5A2 — SecurityRuntimeCoordinator repair

State: ACTIVE DELIVERY SPEC

## Source-of-truth gate

Re-read in this work cycle:

- `README-FIRST.md` current master;
- OPUS `master` current HEAD `9031967e6f57929208b950920cd665d6ee6b749c`;
- current `SecurityController.php`, `bootstrap.php`, `site.json`, `FsmSiteLoader.php`, Navigation FSM and Security FSM;
- active micro-EFSM architecture and zero-fallback contract.

R8B5A and R8B5A1 both failed before writes while attempting large in-place `SecurityController.php` surgery. R8B5A2 treats the construction cause by eliminating that surgery.

## Functional target retained

R8B5A2 keeps the R8B5A vertical objective:

- generic OPUS `FsmSignalBusInterface` + `FsmSignalBus`;
- independent OWASYS-front Security runtime using named EFSM `security` and its own session snapshot;
- explicit SecurityContext;
- COMMAND Navigation -> Security `enter_security_context`;
- EVENT Security -> Navigation `security_context_ready`;
- shared correlation id and event causation id = command message id;
- Navigation remains in state `security` while Security remains `authenticated`;
- Logger/Profiler receive metadata-only network events;
- no backend or JavaScript change.

## Structural repair

The runtime coordination implementation moves out of `SecurityController.php` into complete application service files:

- `SecurityRuntimeCoordinatorInterface.php`;
- `SecurityRuntimeCoordinator.php`.

`SecurityController.php` remains structurally intact except for one short call after its existing application-id validation. Its existing Navigation FSM handling remains authoritative.

The coordinator restores the already-persisted Navigation session, requires Navigation state `security`, restores/synchronizes OWASYS-front Security EFSM, performs the COMMAND/EVENT handshake, persists each target EFSM, and returns runtime metadata to the controller.

## Removed risk surface

R8B5A2 deliberately removes from this slice:

- `FsmProcessorInterface` modification;
- SecurityController constant replacement;
- SecurityController helper-method injection;
- all existing-PHP nowdoc/heredoc replacements.

Existing PHP replacements use short exact base64-encoded anchor/replacement pairs only.

## Exact differential

Modified:

- `sites/owasys-front/application/default/bootstrap.php`
- `sites/owasys-front/application/security/controllers/SecurityController.php`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/config/security.fsm.json`

New:

- `Opus/Fsm/FsmSignalBusInterface.php`
- `Opus/Fsm/FsmSignalBus.php`
- `sites/owasys-front/application/security/services/SecurityContextInterface.php`
- `sites/owasys-front/application/security/services/SecurityContextWriterInterface.php`
- `sites/owasys-front/application/security/services/SecurityContext.php`
- `sites/owasys-front/application/security/services/SecurityRuntimeCoordinatorInterface.php`
- `sites/owasys-front/application/security/services/SecurityRuntimeCoordinator.php`

Total: 11 paths. No `sites/owasys-back` path.

## Applicator gates

- exact HEAD `9031967e...`;
- clean worktree/index;
- exact four tracked blobs;
- seven new paths absent;
- vendor autoload present;
- exact unique PHP anchors;
- structural Navigation/Security JSON mutation;
- `FsmDefinitionValidator` + `FsmProcessor` construction;
- TOKEN_PARSE on every staged PHP before write;
- framework four-parent interface rule for `FsmSignalBusInterface`;
- exact eleven-path git status after atomic writes;
- rollback on post-write failure.

## Construction verification before delivery

- applicator PHP lint PASS;
- all seven new PHP files lint PASS;
- synthetic exact controller insertion lint PASS;
- synthetic exact bootstrap insertion lint PASS;
- isolated SignalBus COMMAND/EVENT runtime PASS;
- correlation/causation PASS;
- sensitive-context rejection PASS.

## Runtime acceptance

After apply, before commit/push:

1. OWASYS-front Security still renders selected application's contextual Security EFSM;
2. Navigation runtime is `security`;
3. OWASYS-front Security runtime is `authenticated`;
4. Profiler/Logger show COMMAND `enter_security_context` and EVENT `security_context_ready`;
5. correlation ids match and EVENT causation references COMMAND message id;
6. Structure and Sources + Git remain functional;
7. no backend changes.

R8B5B reauthentication ownership remains a later slice after R8B5A2 acceptance.
