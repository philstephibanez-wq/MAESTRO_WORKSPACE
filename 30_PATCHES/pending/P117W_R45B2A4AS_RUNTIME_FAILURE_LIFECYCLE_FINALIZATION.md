# P117W R45B2A4AS — Runtime failure lifecycle finalization

Status: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED
Date: 2026-08-17

## Baseline

Owner-committed OPUS baseline:

`ce7348c87c8b2bf9e7ef6643a1df4d4fd313ad9e`

A4AQ is owner-applied and runtime-validated locally but is not yet visible in the OPUS GitHub baseline.

A4AR identified and corrected the successful-redirect lifecycle termination caused by `exit` in `OwasysRuntimeController::redirect()` and `redirectExternal()`. A4AS retains the complete A4AR behavior and closes the remaining runtime failure path in the same two files. The A4AS ZIP therefore supersedes the A4AR ZIP for those files and may be applied directly over the current local A4AQ state.

## Root cause

After A4AR, `OwasysRuntimeController::fail()` remains the sole process-terminating path in the runtime controller:

1. it sets an HTTP error status;
2. it emits a `text/plain` content type;
3. it calls `exit($message)`.

That termination bypasses the owning `OwasysFrontApplication::run()` catch/finally lifecycle exactly as the successful redirect exits did before A4AR.

Consequences for runtime failures include:

- the Singleton cannot render the existing SCORE runtime-error page;
- the front profiler trace can be left incomplete or unpersisted;
- `http.response.sent` is not measured for the error response;
- the response bypasses the front application's canonical exception/logging/finalization path;
- a direct text response violates the OWASYS front SCORE-only UI contract.

Simply replacing `exit` with an exception is insufficient by itself. `resolveRequestSignal()` is already wrapped by a controller-level catch that converts ordinary exceptions to HTTP 400. Without preserving an already-declared HTTP status, a controller `fail(404, ...)` or `fail(405, ...)` would be caught and incorrectly collapsed to 400.

## A4AS contract

### Runtime controller failure propagation

`OwasysRuntimeController::fail()` now:

- preserves the requested HTTP status through `http_response_code($status)`;
- emits no body and no `text/plain` header;
- throws a `RuntimeException` carrying the canonical error message;
- contains no `exit`.

The existing `resolveRequestSignal()` catch first reads the current response status. If an HTTP error status in the 400–599 range has already been declared by `fail()`, it rethrows the same exception rather than wrapping it as `OWASYS_REQUEST_REJECTED`/400.

Ordinary exceptions that have not declared an HTTP failure retain the previous mapping:

- ACL denial -> 403;
- other request-resolution rejection -> 400.

Thus the existing controller statuses remain exact, including 400, 403, 404, 405 and 409 paths.

### Front Singleton owns the complete failure response

`OwasysFrontApplication::failureStatus()` now prefers an already-declared HTTP 4xx/5xx status before applying its ACL/generic fallback.

The application catch path now:

1. resolves the safe error code and exact response status;
2. records both in the front logger/profiler failure events;
3. emits the trace response header when possible;
4. renders the existing `default/templates/runtime-error.score` page through SCORE;
5. records the real `http.response.sent` event with the error status;
6. ends the HTTP span as error with both code and status;
7. reaches the existing `finally`, where `Profiler::stop()` persists the trace and `OPUS_TRACE_ID` is cleared.

If SCORE failure rendering itself throws, the HTTP span is deliberately left open so the existing `finally` fallback marks it `OWASYS_HTTP_REQUEST_INCOMPLETE`; no false response-sent event is invented.

### A4AR retained

A4AS retains the complete A4AR redirect correction:

- successful internal and external redirect helpers return `void` and contain no `exit`;
- every successful redirect branch returns immediately to the Singleton after emitting the canonical 303;
- 3xx responses do not claim a SCORE `response.rendered` event;
- successful redirect requests reach request completion, HTTP span completion and profiler persistence.

## No behavior changes

A4AS does not change:

- canonical FSM states, signals, guards, transitions or diagram topology;
- localized routes or successful redirect targets;
- HTTP successful redirect status 303;
- REST resources, verbs or back-end business calls;
- ACL policy, SSO identity or session semantics;
- OWASYS back;
- SCORE templates or UI layout;
- A4AQ profiler delta-read/database-event logic.

## Delivery

Artifact:

`opus_p117w_r45b2a4as_runtime_failure_lifecycle_finalization.zip`

SHA-256:

`00a7a9dd261b8ff75f3c0b0b596f094b845d81717bd4b70d49c306cea88cbb1f`

Exactly two complete files at final paths:

1. `sites/owasys-front/application/default/Application.php`
2. `sites/owasys-front/application/default/controllers/RuntimeController.php`

No patcher. No deletion. No backend file. No template file.

## Source-integrity validation

The delivery was reconstructed from the exact owner-committed OPUS A4AP source, with A4AR and A4AS applied only to the intended lifecycle code.

Mechanical reversal of A4AR+A4AS from the delivered files yields the exact current OPUS Git blobs:

- `RuntimeController.php` -> `72a4848ce8895e3b3cef00a493c4851adfe2a365`;
- `Application.php` -> `f2b7e3e0b8d34cb494637c5910ba702e9d6f3ffd`.

This proves that the complete delivered files contain the current source plus only the intended changes rather than a historical copy.

## Pre-delivery validation

- PHP lint passes for both delivered files.
- No trailing whitespace exists in either delivered file.
- The delivered runtime controller contains zero `exit` statements.
- The delivered runtime controller contains no `text/plain` failure response.
- Both redirect helpers retain HTTP 303.
- Declared 4xx/5xx failures are rethrown through the request-resolution catch rather than collapsed to 400.
- The front Singleton preserves declared failure status.
- The failure path emits `http.response.sent` only after SCORE failure rendering succeeds.
- Error span completion carries the real HTTP status.
- A4AR's 3xx SCORE-event exclusion remains present.

## Owner runtime acceptance

Apply A4AS, restart `owasys-front`, then validate both successful and failed lifecycle paths.

### A4AR non-regression

Repeat application selection:

- POST `/fr-FR/applications` still follows the same 303 to Sources de données;
- front `request.completed` exists for the POST trace;
- front profiler contains that POST trace;
- `http.response.sent` is 303;
- no `score.response.rendered` is claimed for the redirect;
- back correlation still contains registry sync/select.

### A4AS failure lifecycle

Exercise at least:

- an unknown localized route -> HTTP 404;
- a disallowed HTTP method on an existing runtime route -> HTTP 405;
- an ACL-denied runtime action where available -> HTTP 403.

For each failure:

- the browser/client receives the exact expected HTTP status;
- the body is the existing SCORE runtime-error page, not raw plain text;
- front log contains `request.failed` with the same status;
- profiler contains `http.exception.caught` and `http.response.sent` with that status;
- the HTTP span ends as error;
- the complete front trace is persisted after the request;
- no FSM/REST/ACL/session regression is observed.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
