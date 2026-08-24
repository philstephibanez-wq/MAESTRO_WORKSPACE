# P117W R45B2A4BZ2 R8B5A1 — Applicator nowdoc delimiter repair handoff

State: FAILED PREFLIGHT AGAIN — SUPERSEDED BY R8B5A2

## Baseline

OPUS GitHub `master` re-read in the failure-analysis cycle:

`9031967e6f57929208b950920cd665d6ee6b749c`

`opus_p117w_r45b2a4bz2r8b4c_system_security_micro_efsm_registry_repair`

Owner reports R8B5A1 produced the same pre-write failure class again (`IDEM`). No success markers were reached. The owner worktree had remained clean after the preceding failure and no R8B5A/R8B5A1 write is accepted.

## Important correction to the prior diagnosis

The R8B5A nowdoc terminator defect was real, but repairing that delimiter did not make the overall transformation strategy reliable enough. R8B5A1 still depended on large in-place SecurityController surgery and owner reports the same preflight failure class.

Therefore R8B5A1 is not repaired in place again.

## Supersession decision

R8B5A2 abandons the fragile strategy entirely:

- no nowdoc/heredoc transformation of existing PHP files;
- no large helper-method injection into `SecurityController.php`;
- no `FsmProcessorInterface` modification in this slice;
- autonomous Security runtime + handshake moved into a complete `OwasysSecurityRuntimeCoordinator` service;
- `SecurityController.php` receives only one short coordinator call after its existing Navigation state entry;
- existing-file PHP replacement anchors and replacements are embedded as base64 strings;
- full staged PHP is still TOKEN_PARSE validated before any write.

R8B5A1 must not be retried.
