# P117W R45B2A4AR — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

Owner-committed OPUS baseline:

`ce7348c87c8b2bf9e7ef6643a1df4d4fd313ad9e`

A4AQ is owner-applied and runtime-validated locally. It is not yet visible in the OPUS GitHub baseline. A4AR layers on top of that local state and changes different files.

## A4AQ validation consumed

Fresh owner exports show A4AQ restored the targeted profiler path:

- `registry-clear`: 282.655 ms in-process wrapper;
- first `registry-sync`: 211.842 ms;
- second `registry-sync`: 184.33 ms;
- `registry-select`: 157.15 ms;
- each captured registry-sync contains 31 database spans and exactly 31 database started events.

Thus the previous 62-started-events-for-31-spans duplication is removed and back work is again sub-second in this capture.

## New defect exposed by the same validation

For front trace `881ffb85bce627d619b5a2bacd85f0bd`:

- front receives `POST /fr-FR/applications`;
- back successfully completes `registry.sync` and `registry.select` under the same correlation trace;
- browser then follows the redirect to `/fr-FR/sources-de-données`;
- front never writes `request.completed` for the POST;
- front profiler JSONL contains no persisted application trace for that POST.

## Root cause proved in current source

`OwasysRuntimeController::redirect()` and `redirectExternal()` send the canonical 303 `Location` header and then call PHP `exit`.

The front Singleton owns profiler finalization in `OwasysFrontApplication::run()`. Because `exit` terminates the script from inside the controller, control never returns to the Singleton's completion code and its `finally` block is not reached for the redirect request.

The missing POST profiler trace is therefore deterministic request-lifecycle termination, not another profiler storage problem.

## A4AR implementation

### Runtime controller

Successful redirect helpers no longer terminate PHP.

`redirect()` and `redirectExternal()` retain the same validation, URL and HTTP 303 behavior but return `void` after emitting headers.

Every successful redirect branch in `run()` immediately returns after invoking the helper, preventing fall-through rendering while returning control to the application Singleton.

The explicit error `fail()` path is unchanged.

### Front Singleton

After a controller returns, the Singleton obtains the actual response status before diagnostic completion.

For 3xx responses it does not emit the SCORE `response.rendered` event because no SCORE body was rendered. It still performs the normal completion sequence:

- logger `request.completed`;
- HTTP `response.sent` with status 303;
- HTTP span end;
- profiler stop/persistence in `finally`;
- `OPUS_TRACE_ID` cleanup.

## Delivery

Artifact:

`opus_p117w_r45b2a4ar_runtime_redirect_profiler_finalization.zip`

SHA-256:

`8f75069a0c648ea48276a67489a3bb09ae531bf654229638e66bad277fc7c514`

Exactly two complete files:

1. `sites/owasys-front/application/default/Application.php`
2. `sites/owasys-front/application/default/controllers/RuntimeController.php`

No patcher. No deletion. No backend file.

## Pre-delivery validation

PHP lint passes on both complete files and no trailing whitespace is present.

Source-integrity check:

- reverse the A4AR edits from delivered `RuntimeController.php` → Git blob hash is exactly current OPUS blob `72a4848ce8895e3b3cef00a493c4851adfe2a365`;
- reverse the A4AR edits from delivered `Application.php` → Git blob hash is exactly current OPUS blob `f2b7e3e0b8d34cb494637c5910ba702e9d6f3ffd`.

This proves the ZIP was built from the exact current source rather than from a historical controller copy.

Static smoke passes:

- normal runtime redirect returns immediately to the Singleton;
- transition-recovery redirect returns immediately;
- external preview redirect returns immediately;
- both redirect helpers retain 303 and contain no `exit`;
- application excludes SCORE-rendered diagnostic on 3xx and continues completion/finalization.

## Owner validation

Apply A4AR over the current local OPUS state containing A4AQ, restart `owasys-front`, then repeat application selection.

Required evidence after selecting `essai2`:

1. same functional redirect to Sources de données;
2. POST `/fr-FR/applications` has `request.completed` in front log;
3. front JSONL contains the same POST trace id;
4. that trace contains `http.response.sent` status 303;
5. that trace does not claim `score.response.rendered` for the redirect;
6. back correlation still contains `registry.sync` + `registry.select`;
7. no FSM/REST/ACL/session regression.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
