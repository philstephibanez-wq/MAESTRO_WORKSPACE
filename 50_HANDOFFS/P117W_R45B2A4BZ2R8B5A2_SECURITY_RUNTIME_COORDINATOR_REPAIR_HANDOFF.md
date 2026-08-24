# P117W R45B2A4BZ2 R8B5A2 — SecurityRuntimeCoordinator repair handoff

State: FAILED POST-WRITE VERIFIER — ROLLED BACK — SUPERSEDED BY R8B5A3

## Baseline

OPUS GitHub `master` re-read in the failure-analysis work cycle:

`9031967e6f57929208b950920cd665d6ee6b749c`

`opus_p117w_r45b2a4bz2r8b4c_system_security_micro_efsm_registry_repair`

R8B5A and R8B5A1 were already superseded. R8B5A2 must not be retried.

## Owner-visible failure

R8B5A2 reached:

- `P117W_R45B2A4BZ2R8B5A2_PREFLIGHT_OK`

Then failed after writing the staged differential with:

`P117W_R45B2A4BZ2R8B5A2_POST_WRITE_FAILED:REPOSITORY_DIFFERENTIAL_INVALID`

The diagnostic showed four tracked modifications correctly and the two untracked roots compacted by Git as:

- `?? Opus/`
- `?? sites/owasys-front/application/security/services/`

rather than the seven individual untracked files expected by the verifier.

Owner `git status --short` was empty after the failure, proving rollback completed.

## Root cause

The functional staged files had already passed PHP TOKEN_PARSE and FSM validation before the write phase.

The failure was caused only by the post-write verifier using:

`git status --porcelain`

Git intentionally collapses untracked directory trees in this mode. Therefore comparing that output to seven individual expected new paths was invalid verifier logic.

## Supersession

R8B5A3 preserves the complete intended R8B5A2 functional differential unchanged and replaces only repository inventory verification:

- tracked modifications: `git diff --name-only`;
- untracked files: `git ls-files --others --exclude-standard`;
- index remains required clean.

A deterministic Git simulation reproduces the R8B5A2 compact-directory failure and proves the R8B5A3 commands enumerate exactly four modified files and seven untracked files.
