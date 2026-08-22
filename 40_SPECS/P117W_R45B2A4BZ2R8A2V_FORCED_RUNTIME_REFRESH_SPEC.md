# P117W R45B2A4BZ2R8A2V — Forced runtime refresh gate

State: INVALID BASELINE — SUPERSEDED BY R8B1

## Owner result

Execution stopped before any runtime action with:

`P117W_R45B2A4BZ2R8A2V_HEAD_INVALID:8c7f254ad9080c46bb4da4af272a5c7cd2d4a129`

The gate incorrectly required the pre-R8B HEAD `9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`.

GitHub now establishes that the actual OPUS master/owner HEAD is:

`8c7f254ad9080c46bb4da4af272a5c7cd2d4a129`

commit message:

`opus_p117w_r45b2a4bz2r8b_graphical_php_handler_authoring`

That commit contains the original duplicate dynamic-ACL collision branch in `sites/owasys-front/application/default/services/FsmGuardHandlers.php`.

## Consequence

R8A2V did not stop listeners, did not launch fresh dev-server processes and did not probe `/fr-FR`.

Its artifact must not be retried.

The recovery baseline is now the actual R8B commit and is handled by P117W R45B2A4BZ2R8B1.
