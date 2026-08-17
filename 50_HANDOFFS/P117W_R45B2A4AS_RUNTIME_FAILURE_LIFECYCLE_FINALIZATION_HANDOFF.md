# P117W R45B2A4AS — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

Owner-committed OPUS baseline:

`ce7348c87c8b2bf9e7ef6643a1df4d4fd313ad9e`

A4AQ is owner-applied and runtime-validated locally but is not yet visible in the OPUS GitHub baseline.

A4AS contains and preserves the complete A4AR redirect lifecycle correction and supersedes the A4AR ZIP for the same two OWASYS front files.

## Cause closed by A4AS

A4AR removed process termination from successful redirects, but `OwasysRuntimeController::fail()` still emitted a raw text response and called `exit($message)`.

That remaining exit bypasses `OwasysFrontApplication::run()` exception handling and `finally`, preventing the front Singleton from owning SCORE error rendering, HTTP failure telemetry and profiler persistence.

A naive throw-only replacement would introduce a second defect because the existing request-signal catch maps ordinary exceptions to 400. A declared 404/405 failure therefore also needs to pass through that catch without being rewritten.

## A4AS implementation

### Runtime controller

- `fail()` sets the intended HTTP status and throws the canonical error as `RuntimeException`.
- `fail()` emits no body, no `text/plain` header and no `exit`.
- the request-signal catch rethrows an exception when a 4xx/5xx response status is already declared, preserving controller statuses such as 404 and 405;
- existing ACL 403 and generic request-rejection 400 mappings remain unchanged for failures that have not already declared a status.

A4AR redirect behavior is retained:

- internal/external redirect helpers return `void`;
- both retain HTTP 303;
- all successful redirect branches return immediately to the Singleton;
- no successful redirect terminates PHP.

### Front Singleton

- `failureStatus()` first preserves an already-declared HTTP error status;
- failure logger/profiler events include that status;
- existing SCORE `runtime-error.score` rendering owns the error body;
- after successful SCORE failure rendering, `http.response.sent` records the actual error status;
- the HTTP span then ends as error with error code + status;
- the existing `finally` persists the profiler trace and clears `OPUS_TRACE_ID`.

If failure rendering itself fails, the existing incomplete-span fallback remains authoritative and no response-sent event is invented.

## Delivery

Artifact:

`opus_p117w_r45b2a4as_runtime_failure_lifecycle_finalization.zip`

SHA-256:

`00a7a9dd261b8ff75f3c0b0b596f094b845d81717bd4b70d49c306cea88cbb1f`

Exactly two complete files:

1. `sites/owasys-front/application/default/Application.php`
2. `sites/owasys-front/application/default/controllers/RuntimeController.php`

No patcher. No deletion. No backend file. No SCORE template change.

## Pre-delivery evidence

PHP lint passes on both complete files and neither contains trailing whitespace.

Source-integrity reversal proves exact current-source ancestry:

- delivered `RuntimeController.php` minus A4AR+A4AS -> OPUS blob `72a4848ce8895e3b3cef00a493c4851adfe2a365`;
- delivered `Application.php` minus A4AR+A4AS -> OPUS blob `f2b7e3e0b8d34cb494637c5910ba702e9d6f3ffd`.

Static smoke confirms:

- zero `exit` in delivered runtime controller;
- zero raw `text/plain` runtime failure path;
- both redirects still emit 303;
- declared 4xx/5xx failures survive the internal request catch unchanged;
- front failure status is preserved;
- SCORE owns failure rendering;
- `http.response.sent` is recorded after successful failure rendering;
- error span carries the actual status;
- A4AR's 3xx `score.response.rendered` exclusion remains intact.

## Owner validation

Apply A4AS and restart `owasys-front`.

Required successful-path evidence:

1. application selection still returns/follows the canonical 303;
2. POST front trace is persisted;
3. `request.completed` and `http.response.sent` status 303 exist;
4. no SCORE rendered event is claimed for that 303;
5. correlated back registry work remains present.

Required failure-path evidence:

1. unknown localized route returns 404 with SCORE runtime-error UI;
2. disallowed method on an existing runtime route returns 405 with SCORE runtime-error UI;
3. ACL denial, when exercised, returns 403 with SCORE runtime-error UI;
4. each failed request has front `request.failed`, `http.exception.caught`, `http.response.sent`, an error-ended HTTP span and a persisted front trace;
5. no raw plain-text runtime error response appears;
6. no FSM/REST/ACL/session regression.

A4Z/A4AN/A4AO/A4AP FSM/UI invariants remain untouched by this lifecycle-only delivery.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
