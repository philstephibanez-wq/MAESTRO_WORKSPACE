# P117W R45B2A4BZ2R8A2 — Runtime boot ACL repair

State: DELIVERY PREPARED — OWNER VALIDATION NOT YET EXECUTED ON A FRESH PROCESS

## Corrected runtime evidence

The owner logs do **not** show a fresh restart after R8A2.

`owasys-front` has a single `development_server.starting` event at `2026-08-22T11:39:57Z`, while the later failures occur at `2026-08-22T21:59:21Z` through `21:59:34Z`. There is no second `development_server.starting` event between them.

The later requests still fail with:

`OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED`

at:

`sites/owasys-front/application/default/services/FsmGuardHandlers.php:68`.

This line number is decisive:

- original R8A source: line 68 is `throw new RuntimeException(...)` for the duplicate ACL collision;
- canonical R8A2 result: line 68 is the continuation of `$guards = $transition['guards'] ?? ...` and cannot throw that exception.

Therefore the uploaded trace proves only that the long-lived front process still executed the original R8A source image. It does **not** constitute a failed runtime validation of the canonical R8A2 file.

The backend log likewise contains only its earlier start event and no business request.

## R8A2 correction

R8A2 makes ACL ownership explicit:

- `$managedHandlers` contains developer-programmed guards only;
- the reserved `acl:*` namespace invariant is checked only against `$managedHandlers`;
- `$handlers = $managedHandlers` becomes the runtime map;
- first `acl:*` transition reference synthesizes the dynamic callable;
- later references reuse it idempotently;
- developer-programmed `acl:*` IDs remain forbidden.

Canonical target SHA-256:

`6007cf1be5b627aa29a9252c2d1c9cc73a8c0375551e601c6956bf8a6244ccf9`

## Acceptance gate

Before any further code change, owner validation must occur against a freshly started front/back process after verifying the canonical target SHA. R8B remains blocked until that fresh-process gate succeeds. No OPUS/OWASYS push before acceptance.