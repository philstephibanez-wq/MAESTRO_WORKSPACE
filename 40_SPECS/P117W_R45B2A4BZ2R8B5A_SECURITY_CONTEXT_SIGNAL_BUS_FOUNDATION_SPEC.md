# P117W R45B2A4BZ2 R8B5A — SecurityContext + SignalBus foundation

State: DELIVERY READY — OWNER APPLY REQUIRED

## Source-of-truth gate

This slice was built only after re-reading the current GitHub sources in the same work cycle.

Current OPUS `master`:

`9031967e6f57929208b950920cd665d6ee6b749c`

`opus_p117w_r45b2a4bz2r8b4c_system_security_micro_efsm_registry_repair`

The compare gate from `4043702f...` to `9031967e...` confirms R8B4C contains exactly four paths: the two system `site.json` registry changes plus the two new system `security.fsm.json` files.

Current mandatory contracts re-read before construction include README-FIRST, zero-fallback, Git/branch, active micro-EFSM architecture, current OPUS FSM processor/interface/session store, OWASYS Security controller/bootstrap and current Navigation/Security definitions.

## Why R8B5 is split

The parent R8B5 design contains two independently testable runtime concerns:

1. establish the generic inter-EFSM transport plus independent Security runtime ownership;
2. move fresh reauthentication lifecycle ownership onto the Security EFSM.

R8B5A delivers concern 1 completely. R8B5B will only begin after owner acceptance of the transport/runtime ownership foundation.

This avoids mixing first-network debugging with reauthentication mutation semantics.

## Cause treated by R8B5A

After R8B4/R8B4C, OWASYS displays the correct contextual Security definition, but `OwasysSecurityController` still executes the host Navigation FSM and persists only `opus.fsm.owasys-front`.

Security therefore has definition authority but not independent runtime ownership.

The active architecture requires each EFSM current state to remain private and inter-EFSM cooperation to occur through signals, not direct cross-state mutation.

## Exact differential

Modified tracked files:

1. `Opus/Fsm/FsmProcessorInterface.php`
2. `sites/owasys-front/application/default/bootstrap.php`
3. `sites/owasys-front/application/security/controllers/SecurityController.php`
4. `sites/owasys-front/config/fsm.json`
5. `sites/owasys-front/config/security.fsm.json`

New files:

6. `Opus/Fsm/FsmSignalBusInterface.php`
7. `Opus/Fsm/FsmSignalBus.php`
8. `sites/owasys-front/application/security/services/SecurityContextInterface.php`
9. `sites/owasys-front/application/security/services/SecurityContextWriterInterface.php`
10. `sites/owasys-front/application/security/services/SecurityContext.php`

No backend path and no JavaScript/Node artifact is changed.

## Generic OPUS evolution

`FsmSignalBusInterface` is a new framework interface extending directly:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

`FsmSignalBus` is the homonymous concrete component.

First transport contract:

- in-process;
- unicast only;
- bounded queue;
- `command` / `event` categories;
- explicit `source_fsm`, `target_fsm`, signal;
- message id, correlation id, optional causation id;
- TTL/hop count;
- bounded scalar/array context;
- sensitive context keys rejected before transport;
- Logger and Profiler metadata instrumentation only;
- unknown target and malformed envelope fail explicitly.

No fallback target, broadcast, multicast or network transport is introduced.

`FsmProcessorInterface` also receives the already-existing concrete `transition()` signature so generic runtime coordination is not coupled to an undeclared concrete-only operation.

## SecurityContext ownership

OWASYS-front gains:

- read-only `OwasysSecurityContextInterface`;
- writer `OwasysSecurityContextWriterInterface`;
- `OwasysSecurityContext` implementation.

Security owns writes. Transport consumers receive only the read-only contract.

The context contains authorization/runtime facts only: subject, roles, provider, selected application id and Security runtime state. It contains no password, token, CSRF value or provider secret.

## Independent runtime ownership

Navigation keeps session key:

`opus.fsm.owasys-front`

Security gains independent session key:

`opus.fsm.owasys-front.security`

The Security controller resolves OWASYS-front's own named `security` EFSM through `FsmSiteLoader::processorForSiteRootEfsm()`.

For an already authenticated management session, first synchronization is performed through real Security transitions:

`anonymous -> login_requested -> authenticating -> authentication_succeeded -> authenticated`

No direct state assignment is used.

## First COMMAND/EVENT handshake

Navigation remains owner of route state `security`.

After Navigation reaches `security`:

1. Navigation sends COMMAND `enter_security_context` to `owasys-front/security`;
2. Security consumes it through a state-preserving `authenticated -> authenticated` transition;
3. Security emits EVENT `security_context_ready` to `owasys-front/navigation`;
4. Navigation consumes it through `security -> security`;
5. EVENT correlation id equals COMMAND correlation id;
6. EVENT causation id equals COMMAND message id.

Neither processor receives a direct state write from the other.

## Construction validation

- all five new PHP source files: `php -l` PASS;
- final applicator: `php -l` PASS;
- framework interface inheritance check: PASS;
- isolated `FsmSignalBus` runtime test: PASS;
- COMMAND delivery: PASS;
- causally linked EVENT delivery: PASS;
- sensitive context rejection: PASS.

The applicator additionally performs on the owner repository before writing:

- exact HEAD gate;
- clean worktree/index gate;
- exact Git blob gates for all five modified tracked files;
- absence gates for all five new files;
- configuration reads through StructuredFileLoader;
- structural JSON mutation via OPUS Json;
- FsmDefinitionValidator validation for Navigation and Security;
- FsmProcessor construction for both definitions;
- TOKEN_PARSE on every staged PHP file;
- exact final ten-path Git status verification;
- rollback on post-write failure.

## Acceptance

Static/CLI:

- applicator required three success markers;
- `changed_paths=10`;
- PHP lint changed/new PHP;
- `git diff --check`;
- `composer dump-autoload -o`;
- validate `owasys-front`, `owasys-back`, `essai`;
- no forbidden backend JS/Node artifacts.

Runtime from OWASYS-front:

- normal authenticated session remains valid;
- Security still displays the selected application's contextual Security EFSM;
- Navigation runtime remains `security`;
- OWASYS-front Security runtime is independently `authenticated`;
- Profiler/Logger show COMMAND `enter_security_context` Navigation -> Security;
- Profiler/Logger show EVENT `security_context_ready` Security -> Navigation;
- same correlation id;
- EVENT causation id = COMMAND message id;
- no secret context appears;
- Structure and Sources + Git remain unchanged functionally.

Do not commit/push OPUS until owner runtime acceptance.

## Next slice

R8B5B: bind real fresh-auth success/failure to Security EFSM `reauth_required / reauthentication_succeeded / reauthentication_failed` while Navigation remains independently in `security`.
