# P117W R45B2A4BZ2R8A2V — Forced runtime refresh handoff

State: INVALID BASELINE — SUPERSEDED BY R8B1

## Owner execution result

The script stopped immediately with:

`P117W_R45B2A4BZ2R8A2V_HEAD_INVALID:8c7f254ad9080c46bb4da4af272a5c7cd2d4a129`

No listener was stopped, no new front/back process was created and no HTTP probe was executed.

## Cause

The artifact required HEAD `9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`, but OPUS had already been committed/pushed at:

`8c7f254ad9080c46bb4da4af272a5c7cd2d4a129`

`opus_p117w_r45b2a4bz2r8b_graphical_php_handler_authoring`

GitHub inspection of that exact commit confirms that `FsmGuardHandlers.php` still contains the original R8A duplicate-ACL collision throw.

## Recovery

Do not retry this artifact.

Use P117W R45B2A4BZ2R8B1, which is bound to the real R8B HEAD, repairs/accepts the canonical guard source idempotently, validates both sites, force-restarts ports 8000/8080 and probes `/fr-FR` from a fresh front process.
