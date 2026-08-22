# P117W R45B2A4BZ2R8A2 — Runtime boot ACL repair handoff

State: OWNER VALIDATION INCOMPLETE — FRESH PROCESS REQUIRED

## Baseline

Owner OPUS HEAD remains:

`9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`

R8A/R8A1R1/R8A2 are local and unpushed. R8B is blocked.

## Corrected interpretation of latest owner logs

The front process was not restarted after the repair: the same log contains one `development_server.starting` at `2026-08-22T11:39:57Z` and later failures at `2026-08-22T21:59:21Z` through `21:59:34Z`, with no intervening start event.

The later error still reports `FsmGuardHandlers.php:68`. In the original R8A source, line 68 is the duplicate ACL `throw`; in canonical R8A2, line 68 is not an exception line. Thus the uploaded runtime evidence is from the old source image and cannot validate or invalidate the canonical R8A2 file.

## Canonical R8A2 target

`sites/owasys-front/application/default/services/FsmGuardHandlers.php`

Expected SHA-256 after R8A2:

`6007cf1be5b627aa29a9252c2d1c9cc73a8c0375551e601c6956bf8a6244ccf9`

## Required owner gate

1. verify the target SHA;
2. stop the existing listeners on ports 8000 and 8080;
3. start new `owasys-front` and `owasys-back` dev-server processes;
4. verify the new logs contain fresh `development_server.starting` events;
5. request `/fr-FR`;
6. only if the error persists on the fresh process continue code diagnosis;
7. no commit/push before successful boot.

A dedicated R8A2V runtime-refresh gate is delivered next so this restart cannot be skipped accidentally.