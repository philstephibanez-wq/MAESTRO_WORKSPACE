# P117W R45B2A4BZ2 R8B5A3 — Repository inventory verifier repair handoff

State: READY FOR OWNER APPLY — NOT YET APPLIED

## Baseline

Current OPUS GitHub `master` re-read in this work cycle:

`9031967e6f57929208b950920cd665d6ee6b749c`

`opus_p117w_r45b2a4bz2r8b4c_system_security_micro_efsm_registry_repair`

R8B5A2 failed only in its post-write repository inventory verifier and rolled back. Owner `git status --short` was empty afterward.

## Artifact

ZIP:

`opus_p117w_r45b2a4bz2r8b5a3_repository_inventory_verifier_repair.zip`

ZIP SHA-256:

`8cbeb1de329a90294027ed9a2ef31db41b89c3b991b7b11fc19915764b7d438b`

Contained applicator:

`apply_a4bz2r8b5a3.php`

Applicator SHA-256:

`5780ddebcba10337155b2ec00d640e2b5c9714816c983501db9fd5016304b300`

Applicator PHP lint: PASS.

## Functional differential

Identical to R8B5A2: 11 paths, 4 modified + 7 new, no backend path.

R8B5A3 changes only applicator version markers/temp suffix and the post-write exact-path verifier.

A normalized A2→A3 applicator diff was checked and confirms no embedded functional payload or source transformation changed.

## Verifier repair

R8B5A2 used `git status --porcelain`, whose default behavior collapses untracked directory trees.

R8B5A3 now validates separately:

- modified tracked files with `git diff --name-only`;
- new files with `git ls-files --others --exclude-standard`;
- staged index remains empty with `git diff --cached --name-only`.

No compact-status parser participates in post-write acceptance.

## Deterministic Git reproduction

A temporary Git repository with the exact four modified-path names and seven new-path names was used.

Default porcelain reproduced:

- four ` M` file lines;
- `?? Opus/`;
- `?? sites/owasys-front/application/security/services/`.

The replacement inventory returned exactly four modified paths and all seven individual new paths.

## Required success markers

- `P117W_R45B2A4BZ2R8B5A3_PREFLIGHT_OK`
- `P117W_R45B2A4BZ2R8B5A3_REPO_CHANGES_VERIFIED`
- `P117W_R45B2A4BZ2R8B5A3_APPLIED`
- `baseline_head=9031967e6f57929208b950920cd665d6ee6b749c`
- `changed_paths=11`
- `runtime_security_fsm=owasys-front/security`
- `navigation_command=enter_security_context`
- `security_event=security_context_ready`

## Owner gate

Apply R8B5A3 directly on the clean R8B4C baseline. Do not reset or alter OPUS first.

After successful apply, do not commit/push. Proceed to PHP lint, `git diff --check`, Composer autoload, three `opus:validate-site` commands and runtime Security/SignalBus validation.
