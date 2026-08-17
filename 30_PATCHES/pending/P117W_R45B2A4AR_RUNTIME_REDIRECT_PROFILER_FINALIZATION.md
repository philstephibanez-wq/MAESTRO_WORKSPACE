# P117W R45B2A4AR — Runtime redirect profiler finalization

Status: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED
Date: 2026-08-17

## Baseline

Owner-committed OPUS baseline:

`ce7348c87c8b2bf9e7ef6643a1df4d4fd313ad9e`

A4AQ is owner-applied and runtime-validated locally but is not yet visible in the OPUS GitHub baseline. A4AR is additive to A4AQ and touches different files.

## Evidence

Fresh owner exports after A4AQ contain the following sequence for trace:

`881ffb85bce627d619b5a2bacd85f0bd`

Front:

- receives `POST /fr-FR/applications`;
- never records `request.completed` for that POST.

Back under the same trace id:

- completes `GET /api/v1/applications` / `registry.sync`;
- completes `PUT /api/v1/session/application/essai2` / `registry.select`.

Then the browser follows the 303 and starts a new front GET `/fr-FR/sources-de-données` with a new trace id.

The front profiler JSONL has no persisted `OwasysFrontApplication` record for the POST trace although all back operations succeeded.

## Root cause

`OwasysFrontApplication::run()` owns the front request lifecycle:

1. start front trace;
2. start HTTP span;
3. dispatch selected controller;
4. record response completion;
5. end HTTP span;
6. in `finally`, stop/persist the profiler trace and clear `OPUS_TRACE_ID`.

Current `OwasysRuntimeController` handles successful FSM redirects by calling `redirect()` or `redirectExternal()`. Those methods send a 303 `Location` header and call PHP `exit`.

`exit` terminates the script before control returns to `OwasysFrontApplication::run()`. Therefore the application's completion logger, HTTP span end and profiler `finally` are bypassed. This directly explains the missing front POST record.

## A4AR contract

### Runtime redirects return to the application lifecycle

`OwasysRuntimeController::redirect()` and `redirectExternal()` become header emitters returning `void`; they no longer terminate the PHP process.

Every successful redirect branch in `OwasysRuntimeController::run()` explicitly returns immediately after setting the redirect:

- transition-failure recovery redirect;
- external development-preview redirect;
- normal post-transition redirect, including application selection, login/password flow, change-app, create-app entry and logout.

No redirect falls through to SCORE state rendering.

The controller's explicit error responder `fail()` is outside this A4AR success-redirect defect and remains unchanged.

### Application finalizes 303 responses without inventing SCORE rendering

When the runtime controller returns after emitting a 303, `OwasysFrontApplication::run()` now completes normally and executes its existing logger/profiler lifecycle.

The application reads the response status immediately after controller dispatch. It records `score.response.rendered` only for non-3xx responses. This avoids claiming that SCORE rendered a body during a redirect, in accordance with the profiler contract that panels contain only events actually measured.

For a 303 redirect the application still records:

- `owasys.front request.completed`;
- `http.response.sent` with status 303;
- the completed HTTP span;
- the persisted front trace from `Profiler::stop()` in `finally`.

## No behavior changes

A4AR does not change:

- FSM transitions or state graph;
- localized routes or redirect targets;
- HTTP redirect status: remains 303;
- REST resources or verbs;
- registry sync/select business behavior;
- ACL/SSO/session semantics;
- back application;
- SCORE templates;
- A4AQ profiler delta logic.

## Delivery

Artifact:

`opus_p117w_r45b2a4ar_runtime_redirect_profiler_finalization.zip`

SHA-256:

`8f75069a0c648ea48276a67489a3bb09ae531bf654229638e66bad277fc7c514`

Exactly two complete OWASYS front files:

1. `sites/owasys-front/application/default/Application.php`
2. `sites/owasys-front/application/default/controllers/RuntimeController.php`

No patcher. No deletion.

## Pre-delivery validation

- PHP lint passes for both delivered files.
- No trailing whitespace.
- The reconstructed pre-change `RuntimeController.php` hashes exactly to current GitHub blob `72a4848ce8895e3b3cef00a493c4851adfe2a365`; therefore the delivered file is the current source plus only the intended A4AR edits.
- The reconstructed pre-change `Application.php` hashes exactly to current GitHub blob `f2b7e3e0b8d34cb494637c5910ba702e9d6f3ffd`.
- Static smoke confirms all three successful redirect branches return from `run()` after header emission.
- `redirect()` and `redirectExternal()` contain no `exit` and retain HTTP 303.
- `fail()` is the sole remaining process-terminating path in this controller and is unchanged.
- Application static smoke confirms 3xx responses bypass the SCORE-rendered profiler event while still reaching request completion/finalization.

## Owner acceptance

Repeat the exact application-selection flow that produced the missing trace:

1. open Applications;
2. select `essai2`;
3. allow the 303 to Sources de données;
4. export front/back log and profiler JSONL.

Acceptance requires:

- the POST `/fr-FR/applications` still returns/follows the same 303 target;
- `owasys.front request.completed` exists for the POST trace;
- the front profiler JSONL contains a persisted `OwasysFrontApplication` record for that same POST trace;
- its HTTP response status is 303;
- no `score.response.rendered` event is recorded for the redirect response;
- the correlated back `registry.sync` and `registry.select` records remain present;
- Sources de données opens normally with the selected application;
- no FSM/ACL/session/REST regression.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
