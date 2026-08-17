# P117W R45B2A4AT — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Owner baseline

Current OPUS owner baseline:

`ec133bd9c9e7f5e01177e88c5bb62133e9a72e48` — `opus_p117w_r45b2a4as_runtime_failure_lifecycle_finalization`

A4AS is committed/pushed and is the exact source tree used for A4AT.

## Root cause

A4AR/A4AS fixed process termination in the default runtime controller, but an audit of the same A4AS tree found the identical successful-redirect lifecycle defect in all three specialized front controllers:

- CreationController;
- SourceController;
- SecurityController.

Those controllers still sent 303 `Location` headers and called `exit`, so their redirect requests could not return to `OwasysFrontApplication::run()` for `request.completed`, `http.response.sent`, HTTP span completion and profiler persistence.

The Security legacy `?view=` canonicalization contained the same inline header + `exit` pattern.

## Generic OPUS service decision

No new framework abstraction is introduced.

Current `Opus\Http\Response` already supports an empty response with arbitrary status and headers through `Response::empty(...)->send()` and does not terminate PHP. Its homonymous interface extends the four mandatory OPUS framework contracts.

A4AT therefore reuses the existing generic OPUS HTTP service instead of adding controller-local response infrastructure.

## Exact source integrity

The three current A4AS controller originals were reconstructed and verified against the owner Git tree before modification:

- CreationController -> blob `a181971a541ce88c2feffcc996ab1fe0dc0b7b69`;
- SourceController -> blob `cefb182efeeefd97400f486491f33c286af4a0e8`;
- SecurityController -> blob `531270789666f20beef4cfc68e5b2b5dff5c21a4`.

A4AT is therefore based on exact current files, not historical copies.

## A4AT implementation

### Creation

- uses `Opus\Http\Response` for empty HTTP 303 redirects;
- redirect helper returns `void`, contains no `exit`;
- unauthenticated redirect returns immediately;
- cancel-creation redirect returns immediately;
- successful creation -> Data redirect returns immediately.

### Source

- all three redirect helpers use `Response::empty(303, ['Location' => ...])->send()`;
- all successful source/Git redirect call sites return immediately;
- unauthenticated and no-current-app redirects return immediately;
- locale/source-path canonicalization returns `null` after redirect;
- `enterSourceState()` is therefore `?string`, and `run()` returns when it receives `null`.

### Security

- uses `Opus\Http\Response` for empty HTTP 303 redirects;
- unauthenticated and no-current-app redirects return immediately;
- generic redirect helper contains no `exit`;
- legacy `/security?view=<view>` GET canonicalization uses the same OPUS response mechanism and returns `null`;
- `securityView()` becomes `?string`, and `run()` returns after a canonicalization redirect.

## A4AS completion path reused

No change to `OwasysFrontApplication` is needed.

After the specialized controller returns from a 303, the A4AS Singleton already:

- reads status 303;
- suppresses the false `score.response.rendered` event for 3xx;
- logs `request.completed`;
- records `http.response.sent` 303;
- ends the HTTP span;
- reaches `Profiler::stop()` in `finally`.

## Delivery

Artifact:

`opus_p117w_r45b2a4at_front_redirect_lifecycle_completion.zip`

SHA-256:

`59dddd868769d712a6ea5dede48cb4c626e0d6ba15c47a8404b175a07e4005fb`

Exactly three complete files:

1. `sites/owasys-front/application/creation/controllers/CreationController.php`
2. `sites/owasys-front/application/source/controllers/SourceController.php`
3. `sites/owasys-front/application/security/controllers/SecurityController.php`

No patcher. No deletion. No backend/framework/template file.

## Static validation

- PHP lint passes on all three files;
- zero trailing whitespace;
- zero `exit` in all three delivered controllers;
- zero direct raw `Location` headers in the delivered controllers;
- six redirects use `Response::empty(303, ...)`;
- all relevant redirect call sites terminate controller work with `return` or nullable-return propagation;
- ZIP contains exactly the three listed files.

## Owner validation

Apply A4AT and restart `owasys-front`.

Representative acceptance evidence required:

1. Creation cancel redirects to Applications with 303 and a persisted complete front trace.
2. Successful source save redirects to the same source with `source_status=saved`, with `request.completed` and `http.response.sent` 303.
3. Security legacy `?view=roles` redirects to the canonical localized Security/Roles route with the same complete lifecycle.
4. For every tested 303, no `score.response.rendered` event is claimed.
5. Source locale switching preserves the remembered source path through canonicalization.
6. No FSM/REST/ACL/SSO/session/SCORE/source/Git/creation regression.

A4Z/A4AN/A4AO/A4AP FSM/UI invariants and A4AQ/A4AS profiler lifecycle invariants remain mandatory.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
