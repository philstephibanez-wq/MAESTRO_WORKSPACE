# P117W R45B2A4BZ2R8B1 — Actual R8B boot repair handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Actual baseline

Current OPUS HEAD/master is:

`8c7f254ad9080c46bb4da4af272a5c7cd2d4a129`

`opus_p117w_r45b2a4bz2r8b_graphical_php_handler_authoring`

The prior R8A2V artifact is invalid because it required `9fdf45ae...` and therefore stopped before doing anything.

GitHub inspection of the actual R8B commit confirms its `FsmGuardHandlers.php` still contains the duplicate dynamic ACL collision throw.

## Artifact

`opus_p117w_r45b2a4bz2r8b1_actual_r8b_boot_repair.zip`

ZIP SHA-256:

`15e97bc80c2fe89648fb55db396a737d42c8d2b51422070d7744f29dbb0a5825`

Contents:

- `apply_a4bz2r8b1.php`
- `run_a4bz2r8b1.cmd`

Applicator SHA-256:

`68c91db9676527d7daed1a02f74199e82140d3b0dc449918262ce50b0b428655`

Runtime CMD SHA-256:

`cb65de5065f020d3171aab1dd535683b5b3bc5d2a8e1e817f392337e191e25a6`

## Applicator behavior

Bound to HEAD `8c7f254a...`.

It accepts:

- the original R8A/R8B buggy guard source;
- the previous intermediate R8A1R1 source;
- the final canonical fixed source.

For buggy/intermediate content it writes one canonical implementation. For already-fixed content it returns `P117W_R45B2A4BZ2R8B1_ALREADY_FIXED` and does not rewrite.

Canonical target SHA-256:

`6007cf1be5b627aa29a9252c2d1c9cc73a8c0375551e601c6956bf8a6244ccf9`

Any other target content is refused.

## Runtime gate

`run_a4bz2r8b1.cmd` calls the applicator, verifies SHA/lint, regenerates optimized autoload, validates both sites, kills listeners on 8000/8080, launches fresh front/back dev servers on those explicit ports, waits for both, and requests `http://127.0.0.1:8000/fr-FR`.

It fails if the front is unreachable or returns HTTP >= 400.

Expected terminal marker:

`P117W_R45B2A4BZ2R8B1_RUNTIME_OK`

with:

- `baseline_head=8c7f254ad9080c46bb4da4af272a5c7cd2d4a129`
- `target_sha256=6007cf1be5b627aa29a9252c2d1c9cc73a8c0375551e601c6956bf8a6244ccf9`
- `old_listeners=stopped`
- `front_listener=8000`
- `back_listener=8080`
- `front_http_status=<200..399>`

## Verification performed

The exact final applicator was executed against a fixture containing the original R8B guard source while a controlled Git preflight returned the exact real R8B HEAD. It applied successfully, produced the canonical SHA, linted successfully and a second execution was idempotent.

The Windows-specific stop/start/probe sequence cannot be executed in the assistant Linux container and remains the owner gate.

## Owner action

Extract the ZIP and execute only `run_a4bz2r8b1.cmd` from `H:\OPUS`.

Do not push another OPUS commit until this runtime gate succeeds. After success, commit only the resulting canonical guard repair if it is still dirty, then continue designer validation.
