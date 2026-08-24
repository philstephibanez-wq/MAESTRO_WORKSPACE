# P117W R45B2A4BZ2 R8B5A — SecurityContext + SignalBus foundation handoff

State: READY FOR OWNER APPLY — NOT YET APPLIED

## Baseline

OPUS GitHub `master` was re-read in the same work cycle and is:

`9031967e6f57929208b950920cd665d6ee6b749c`

`opus_p117w_r45b2a4bz2r8b4c_system_security_micro_efsm_registry_repair`

R8B4C is therefore now committed/pushed and is the authoritative baseline.

## Artifact

ZIP:

`opus_p117w_r45b2a4bz2r8b5a_security_context_signal_bus_foundation.zip`

ZIP SHA-256:

`7f0f61e02bacb966f0a2a548f1a3cbc380bb3963b2b5ff237971656af4236d94`

Contained applicator only:

`apply_a4bz2r8b5a.php`

Applicator SHA-256:

`5cbd07c070c201a678053925138537dc5eff0414a47f856f49d31570b320686f`

Applicator PHP lint: PASS.

## Exact intended repository differential

Modified:

- `Opus/Fsm/FsmProcessorInterface.php`
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

Total: 10 paths.

No `sites/owasys-back` path is changed.

## Functionality

R8B5A establishes the first real autonomous Security runtime and inter-EFSM transport foundation.

- Navigation keeps `opus.fsm.owasys-front`.
- Security gains `opus.fsm.owasys-front.security`.
- Security is loaded from named EFSM id `security`.
- authenticated OWASYS session synchronizes Security through actual transitions to `authenticated`.
- Navigation sends COMMAND `enter_security_context`.
- Security stays `authenticated` and returns EVENT `security_context_ready`.
- Navigation stays `security`.
- COMMAND and EVENT share correlation id.
- EVENT causation id is the COMMAND message id.
- Logger and Profiler receive metadata-only network events.
- sensitive bus context keys are rejected.

This slice deliberately does not yet bind fresh-auth reauthentication transitions; that is R8B5B after acceptance.

## Applicator safety

Required baseline HEAD:

`9031967e6f57929208b950920cd665d6ee6b749c`

The applicator requires:

- clean worktree;
- clean index;
- exact tracked blobs;
- all five new paths absent;
- valid vendor autoload;
- structural JSON mutation;
- Navigation/Security definition validation;
- processor construction for both definitions;
- TOKEN_PARSE for staged PHP;
- framework interface contract check;
- exact ten-path post-write status;
- rollback on post-write failure.

Required success markers:

- `P117W_R45B2A4BZ2R8B5A_PREFLIGHT_OK`
- `P117W_R45B2A4BZ2R8B5A_REPO_CHANGES_VERIFIED`
- `P117W_R45B2A4BZ2R8B5A_APPLIED`
- `baseline_head=9031967e6f57929208b950920cd665d6ee6b749c`
- `changed_paths=10`
- `runtime_security_fsm=owasys-front/security`
- `navigation_command=enter_security_context`
- `security_event=security_context_ready`

## Construction tests already executed

- new framework/interface PHP lint: PASS;
- new SecurityContext PHP lint: PASS;
- applicator PHP lint: PASS;
- framework four-parent interface check: PASS;
- isolated FsmSignalBus COMMAND/EVENT test: `R8B5A_SIGNAL_BUS_RUNTIME_TEST_OK`;
- correlation/causation check: PASS;
- sensitive context rejection check: PASS.

## Owner validation after apply

Do not commit/push yet.

CLI:

1. `git status --short` must show exactly ten intended paths.
2. lint changed/new PHP.
3. `git diff --check`.
4. `composer dump-autoload -o`.
5. `composer opus:validate-site -- owasys-front`.
6. `composer opus:validate-site -- owasys-back`.
7. `composer opus:validate-site -- essai`.

Runtime:

1. start/restart OWASYS front/back development servers;
2. log into OWASYS-front and select an application;
3. open Security;
4. selected-application contextual Security diagram must remain unchanged;
5. inspect Profiler/Logger `fsm.network` events;
6. verify COMMAND Navigation -> Security `enter_security_context`;
7. verify EVENT Security -> Navigation `security_context_ready`;
8. verify same correlation id and event causation id = command message id;
9. handshake event must report Navigation=`security`, Security=`authenticated`;
10. verify Structure and Sources + Git remain functional.

Only after these gates may owner commit/push R8B5A.

## Next

R8B5B: real fresh-auth reauthentication lifecycle owned by Security EFSM while Navigation remains autonomous.
