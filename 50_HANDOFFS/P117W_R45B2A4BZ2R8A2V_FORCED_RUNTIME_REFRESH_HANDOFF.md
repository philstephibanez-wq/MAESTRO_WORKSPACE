# P117W R45B2A4BZ2R8A2V — Forced runtime refresh handoff

State: DELIVERY PREPARED — OWNER EXECUTION REQUIRED

## Why this exists

The latest owner logs show the front process started once at `2026-08-22T11:39:57Z` and then handled failing requests at `2026-08-22T21:59:21Z` through `21:59:34Z`. There is no intervening `development_server.starting` event.

The same trace still reports the original R8A exception at `FsmGuardHandlers.php:68`. Canonical R8A2 cannot throw on line 68. Therefore a fresh-process validation has not yet occurred.

## Artifact

`opus_p117w_r45b2a4bz2r8a2v_forced_runtime_refresh.zip`

ZIP SHA-256:

`eff6d46cce88e6445f9c12bae64f3d3c6e424f1e0b52c27a07230f960d084c3d`

CMD SHA-256:

`2072e01b6c3d4e666caf4a10e274c6c363e0050d187e25bbb16bc0fedbf6349d`

Contents:

- `r8a2v_forced_runtime_refresh.cmd`

No OPUS/OWASYS source file is modified by this gate.

## Preconditions enforced by the script

- current directory becomes `H:\OPUS`;
- HEAD must equal `9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`;
- canonical R8A2 `FsmGuardHandlers.php` SHA must equal `6007cf1be5b627aa29a9252c2d1c9cc73a8c0375551e601c6956bf8a6244ccf9`;
- target PHP lint must pass;
- Composer autoload and both site validations must pass.

## Runtime action

The script then force-stops current listeners on ports 8000 and 8080, waits, launches fresh front/back dev servers, waits for both listeners, then probes `/fr-FR`.

Exit is blocking if front is unreachable or still returns HTTP 500.

## Expected success marker

`P117W_R45B2A4BZ2R8A2V_RUNTIME_REFRESHED`

with:

- `target_sha256=6007cf1be5b627aa29a9252c2d1c9cc73a8c0375551e601c6956bf8a6244ccf9`
- `old_listeners=stopped`
- `front_listener=8000`
- `back_listener=8080`
- `front_http_status=<non-500>`

## Verification scope

The script structure and hashes were generated deterministically. The Windows process-control and live Composer/dev-server execution cannot be executed in the assistant Linux container and remain owner-runtime validation.

No commit/push until this gate succeeds. R8B remains blocked.