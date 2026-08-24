# P117W R45B2A4BZ2 R8B5A1 — Applicator nowdoc delimiter repair handoff

State: READY FOR OWNER APPLY — NOT YET APPLIED

## Baseline

Current OPUS GitHub `master` re-read in this work cycle:

`9031967e6f57929208b950920cd665d6ee6b749c`

`opus_p117w_r45b2a4bz2r8b4c_system_security_micro_efsm_registry_repair`

The failed R8B5A run stopped before writes and owner `git status --short` was empty, so this baseline remains valid.

## Root cause repaired

R8B5A opened the main SecurityController replacement with nowdoc `NEW` but closed it with `OLD`.

That caused the next applicator statement to be injected literally into staged `SecurityController.php`, producing the owner-visible TOKEN_PARSE error `unexpected token ","`.

R8B5A1 changes that faulty terminator to `NEW` and leaves the intended functional R8B5A differential unchanged.

## Artifact

ZIP:

`opus_p117w_r45b2a4bz2r8b5a1_security_context_signal_bus_applicator_delimiter_repair.zip`

ZIP SHA-256:

`f09c7934b18d81e7e881107fc03414e463c98410aa8958a58547f29873210bab`

Contained applicator only:

`apply_a4bz2r8b5a1.php`

Applicator SHA-256:

`9599ea663a18735f2137f9c658aec63761d55644288b18dcbbca31b37a88496a`

Applicator PHP lint: PASS.

## Intended OPUS differential

Exactly 10 paths, unchanged from R8B5A intent.

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

No backend path changes.

## Additional construction checks

R8B5A1 was checked specifically against the failure class before delivery:

- bad delimiter count = 0;
- corrected `NEW` delimiter count for affected replacement = 1;
- main and helper SecurityController nowdocs are structurally separate;
- no `$staged[$p]=replaceOnceR8B5A` applicator source appears in either injected block;
- both injected blocks combined in a synthetic SecurityController parse successfully;
- staging integrity gate now rejects applicator-source leakage explicitly;
- TOKEN_PARSE failure output now includes the parser line number.

## Required markers

- `P117W_R45B2A4BZ2R8B5A1_PREFLIGHT_OK`
- `P117W_R45B2A4BZ2R8B5A1_REPO_CHANGES_VERIFIED`
- `P117W_R45B2A4BZ2R8B5A1_APPLIED`
- `baseline_head=9031967e6f57929208b950920cd665d6ee6b749c`
- `changed_paths=10`
- `runtime_security_fsm=owasys-front/security`
- `navigation_command=enter_security_context`
- `security_event=security_context_ready`

## Owner gate

Apply R8B5A1 directly on the still-clean R8B4C baseline. Do not reset or alter OPUS first.

After successful application, `git status --short` must show exactly five modified paths and five new paths listed above.

Do not commit/push until CLI/runtime R8B5A validation succeeds.
