# P117W R45B2A4AS — Handoff

State: OWNER COMMITTED/PUSHED IN OPUS — A4AT FOLLOW-UP

## Owner baseline

Owner OPUS commit observed on 2026-08-17:

`ec133bd9c9e7f5e01177e88c5bb62133e9a72e48` — `opus_p117w_r45b2a4as_runtime_failure_lifecycle_finalization`

The owner commit/push establishes A4AS as the current GitHub baseline. Separate runtime acceptance evidence for the A4AS failure cases was not supplied in this turn, so no additional runtime-validation claim is made here.

A4AQ is therefore included in the owner-applied lineage represented by the current OPUS tree.

## Cause closed by A4AS

A4AR removed process termination from successful runtime redirects, but `OwasysRuntimeController::fail()` still emitted a raw text response and called `exit($message)`.

That remaining exit bypassed `OwasysFrontApplication::run()` exception handling and `finally`, preventing the front Singleton from owning SCORE error rendering, HTTP failure telemetry and profiler persistence.

A naive throw-only replacement would have introduced a second defect because the request-signal catch mapped ordinary exceptions to 400. A declared 404/405 failure therefore also had to pass through that catch without being rewritten.

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
- no successful runtime redirect terminates PHP.

### Front Singleton

- `failureStatus()` first preserves an already-declared HTTP error status;
- failure logger/profiler events include that status;
- existing SCORE `runtime-error.score` rendering owns the error body;
- after successful SCORE failure rendering, `http.response.sent` records the actual error status;
- the HTTP span then ends as error with error code + status;
- the existing `finally` persists the profiler trace and clears `OPUS_TRACE_ID`.

For successful 3xx responses, the Singleton skips `score.response.rendered`, records `request.completed` and `http.response.sent`, closes the HTTP span and reaches profiler finalization.

## A4AS delivery

Artifact:

`opus_p117w_r45b2a4as_runtime_failure_lifecycle_finalization.zip`

SHA-256:

`00a7a9dd261b8ff75f3c0b0b596f094b845d81717bd4b70d49c306cea88cbb1f`

Exactly two complete files:

1. `sites/owasys-front/application/default/Application.php`
2. `sites/owasys-front/application/default/controllers/RuntimeController.php`

No patcher. No deletion. No backend file. No SCORE template change.

## Pre-delivery evidence retained

PHP lint passed on both complete files and neither contained trailing whitespace.

Source-integrity reversal proved exact source ancestry from the then-current owner baseline:

- delivered `RuntimeController.php` minus A4AR+A4AS -> OPUS blob `72a4848ce8895e3b3cef00a493c4851adfe2a365`;
- delivered `Application.php` minus A4AR+A4AS -> OPUS blob `f2b7e3e0b8d34cb494637c5910ba702e9d6f3ffd`.

Static smoke confirmed zero runtime-controller `exit`, no raw text failure path, preserved 303 behavior, exact declared error statuses and complete Singleton failure finalization.

## Follow-up discovered after owner commit — A4AT

An audit of the current A4AS OPUS tree found the same successful-redirect lifecycle anti-pattern still present in three specialized OWASYS front controllers:

- `application/creation/controllers/CreationController.php`;
- `application/source/controllers/SourceController.php`;
- `application/security/controllers/SecurityController.php`.

Those controllers still emitted 303 `Location` headers and called `exit`, bypassing the same front Singleton completion/profiler lifecycle that A4AR/A4AS repaired for the runtime controller.

The generic OPUS HTTP service was checked before proposing any local workaround. `Opus\Http\Response` already provides `Response::empty(status, headers)->send()` and its homonymous interface satisfies the four mandatory framework contracts. No new framework abstraction is required.

This cause is assigned to A4AT.

A4Z/A4AN/A4AO/A4AP FSM/UI invariants remain untouched.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
