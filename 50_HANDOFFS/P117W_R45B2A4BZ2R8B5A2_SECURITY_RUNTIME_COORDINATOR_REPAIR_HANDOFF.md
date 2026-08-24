# P117W R45B2A4BZ2 R8B5A2 — SecurityRuntimeCoordinator repair handoff

State: READY FOR OWNER APPLY — NOT YET APPLIED

## Baseline

OPUS GitHub `master` re-read in this work cycle:

`9031967e6f57929208b950920cd665d6ee6b749c`

`opus_p117w_r45b2a4bz2r8b4c_system_security_micro_efsm_registry_repair`

R8B5A and R8B5A1 are superseded and must not be retried.

## Artifact

ZIP:

`opus_p117w_r45b2a4bz2r8b5a2_security_runtime_coordinator_repair.zip`

ZIP SHA-256:

`da8ca2f8ecaa0d74faecbc1ce6f7e94f56329d772ce1cb26d32d8baf0f43d498`

Contained applicator only:

`apply_a4bz2r8b5a2.php`

Applicator SHA-256:

`ff4da26ea7b6a4e6936135b9a174b2f2a30a077e0230330bb081996a37aa717b`

Applicator PHP lint: PASS.

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

Total: 11 paths. No backend path.

## Construction strategy

R8B5A2 no longer injects runtime helper methods into `SecurityController.php`.

The complete independent runtime/SignalBus handshake lives in `OwasysSecurityRuntimeCoordinator`.

The controller modification is only one short call after the existing current-application id validation. The existing Navigation entry logic is preserved.

Existing PHP anchors/replacements are base64 encoded; no nowdoc/heredoc is used for existing-file transformations.

## Validation already executed

- `apply_a4bz2r8b5a2.php` PHP lint PASS;
- `FsmSignalBusInterface.php` lint PASS;
- `FsmSignalBus.php` lint PASS;
- SecurityContext interface/writer/class lint PASS;
- SecurityRuntimeCoordinator interface/class lint PASS;
- synthetic controller insertion lint PASS;
- synthetic bootstrap insertion lint PASS;
- isolated SignalBus test: `R8B5A2_SIGNAL_BUS_RUNTIME_TEST_OK`;
- COMMAND/EVENT correlation and causation PASS;
- sensitive context rejection PASS;
- ZIP contains exactly one applicator.

## Applicator success markers

- `P117W_R45B2A4BZ2R8B5A2_PREFLIGHT_OK`
- `P117W_R45B2A4BZ2R8B5A2_REPO_CHANGES_VERIFIED`
- `P117W_R45B2A4BZ2R8B5A2_APPLIED`
- `baseline_head=9031967e6f57929208b950920cd665d6ee6b749c`
- `changed_paths=11`
- `runtime_security_fsm=owasys-front/security`
- `navigation_command=enter_security_context`
- `security_event=security_context_ready`

## Owner gate

Apply directly on the clean R8B4C baseline. Do not reset first.

After apply, `git status --short` must show exactly 4 modified paths and 7 new paths listed above.

Do not commit/push until static and runtime gates pass.
