# P117W R45B2A4BZ2R8A2V — Forced runtime refresh gate

State: DELIVERY PREPARED — OWNER EXECUTION REQUIRED

## Purpose

This slice changes no OPUS/OWASYS source. It exists because the owner runtime evidence after R8A2 came from the same long-lived front/back processes started many hours earlier.

The gate prevents another false validation against stale runtime state.

## Preconditions

- OPUS HEAD `9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`;
- local R8A stack present;
- `sites/owasys-front/application/default/services/FsmGuardHandlers.php` SHA-256 exactly `6007cf1be5b627aa29a9252c2d1c9cc73a8c0375551e601c6956bf8a6244ccf9`.

Any mismatch is blocking.

## Runtime sequence

The supplied CMD script:

1. verifies HEAD and canonical R8A2 target SHA;
2. lints the target;
3. runs Composer autoload generation and both site validations;
4. force-stops the current listeners on ports 8000 and 8080;
5. launches fresh `owasys-front` and `owasys-back` dev servers in new CMD windows;
6. waits for both ports to listen;
7. requests `http://127.0.0.1:8000/fr-FR`;
8. fails on unreachable/HTTP 500 and succeeds only on a non-500 HTTP response.

## Artifact

`opus_p117w_r45b2a4bz2r8a2v_forced_runtime_refresh.zip`

ZIP SHA-256:

`eff6d46cce88e6445f9c12bae64f3d3c6e424f1e0b52c27a07230f960d084c3d`

CMD SHA-256:

`2072e01b6c3d4e666caf4a10e274c6c363e0050d187e25bbb16bc0fedbf6349d`

The ZIP contains exactly one script: `r8a2v_forced_runtime_refresh.cmd`.

## Acceptance

- new front and back listeners are created;
- `/fr-FR` no longer returns HTTP 500;
- fresh logs contain new `development_server.starting` events;
- no OPUS/OWASYS commit/push before this gate passes.

R8B remains blocked until R8A2V succeeds.