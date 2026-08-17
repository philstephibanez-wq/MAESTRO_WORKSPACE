# P117W R45B2A4AT — Front redirect lifecycle completion

Status: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED
Date: 2026-08-17

## Baseline

Current owner-committed OPUS baseline:

`ec133bd9c9e7f5e01177e88c5bb62133e9a72e48` — `opus_p117w_r45b2a4as_runtime_failure_lifecycle_finalization`

A4AS is now visible on OPUS GitHub and is the source baseline for this delivery.

## Root cause

A4AR/A4AS restored complete Singleton lifecycle finalization for the default runtime controller, but the same process-termination pattern remained in the three specialized OWASYS front controllers dispatched by `OwasysFrontApplication`:

1. `OwasysCreationController`;
2. `OwasysSourceController`;
3. `OwasysSecurityController`.

Their successful redirect helpers still emitted HTTP 303 `Location` headers and called PHP `exit`. The security legacy-view canonicalization path also performed an inline header + `exit`.

Those exits terminate the request from inside the specialized controller. As a result, control cannot return to `OwasysFrontApplication::run()`, so its common A4AS completion path is bypassed for those redirect requests:

- `owasys.front request.completed` may be absent;
- `http.response.sent` may be absent;
- the HTTP span may not complete normally;
- the front profiler trace may not be persisted by the application `finally`;
- the common A4AS rule that 3xx responses must not claim `score.response.rendered` cannot be applied.

This is the same request-lifecycle cause as A4AR, not a new profiler-storage problem.

## Generic OPUS service check

README-FIRST requires proposing/reusing a generic OPUS service before a local non-business workaround.

Current OPUS already provides the required generic component:

- `Opus/Http/Response.php`, blob `93d2c6840efc69aaa4640134960ae51fd311487a`;
- `Opus/Http/ResponseInterface.php`, blob `d03872e3ba27f48a9a73535bffb85e24c7e60d4c`.

`Response::empty(int $status, array $headers)` constructs an empty-body response and `send()` emits the status and headers through the OPUS HTTP response mechanism without terminating PHP. `Response` implements the homonymous interface and that interface extends the four mandatory framework contracts.

Therefore A4AT does not add or modify a framework abstraction. It reuses the existing generic OPUS HTTP service.

## Exact source ancestry

Before modification, each complete controller was reconstructed from the current A4AS tree and verified against its exact Git blob:

- `CreationController.php` -> `a181971a541ce88c2feffcc996ab1fe0dc0b7b69`;
- `SourceController.php` -> `cefb182efeeefd97400f486491f33c286af4a0e8`;
- `SecurityController.php` -> `531270789666f20beef4cfc68e5b2b5dff5c21a4`.

The delivery therefore starts from the exact owner-committed A4AS files, not from historical copies.

## A4AT implementation

### Creation controller

`OwasysCreationController` now imports and uses `Opus\Http\Response`.

Its redirect helper:

- returns `void` rather than `never`;
- sends `Response::empty(303, ['Location' => ...])->send()`;
- contains no `exit`.

Every branch that performs a successful redirect returns immediately afterward:

- unauthenticated creation access -> login;
- creation cancellation -> applications;
- successful application creation -> data.

No branch falls through into further FSM or SCORE work after emitting a redirect.

### Source controller

`OwasysSourceController` already imported `Opus\Http\Response`; A4AT reuses it for all redirect helpers.

The three helpers now return `void`, emit an empty OPUS HTTP 303 response and contain no `exit`:

- generic route redirect;
- source redirect with query string;
- current-source redirect with query string.

All successful redirect call sites now return immediately:

- unauthenticated source access -> login;
- no selected application -> applications;
- successful Git mutation -> current source + `git_status`;
- successful source write -> current source + `source_status=saved`.

Locale preservation has one additional control-flow requirement. `enterSourceState()` can canonicalize a locale change back to the remembered source path. It now returns `?string`; after issuing that 303 it returns `null`, and `run()` immediately returns when it receives `null`. This preserves the existing FSM memory/persist behavior without rendering or processing after the redirect.

### Security controller

`OwasysSecurityController` now imports and uses `Opus\Http\Response`.

Its generic redirect helper returns `void`, emits the empty OPUS 303 response and contains no `exit`.

Unauthenticated and no-current-application redirect branches now return immediately.

The legacy canonicalization path `/security?view=<view>` previously performed an inline `Location` header + `exit`. `securityView()` now returns `?string`; on a valid legacy GET it emits the canonical 303 via `Response::empty()`, returns `null`, and `run()` returns immediately. Normal canonical views continue returning their view name unchanged.

## Singleton completion contract

A4AT does not modify `OwasysFrontApplication` because A4AS already provides the generic post-dispatch lifecycle required here.

After any specialized controller returns from an A4AT 303, the A4AS Singleton:

1. reads the actual response status;
2. does not emit `score.response.rendered` for 3xx;
3. sets the request status to completed;
4. logs `owasys.front request.completed`;
5. records `http.response.sent` with status 303;
6. ends the HTTP span successfully;
7. reaches `finally`, persists the profiler trace and clears `OPUS_TRACE_ID`.

Thus A4AT extends the already-accepted lifecycle model to every successful redirect path dispatched by the front Singleton.

## No behavior changes

A4AT does not change:

- canonical FSM states, signals, guards, actions or topology;
- FSM session keys or remembered source path semantics;
- redirect status: remains HTTP 303;
- localized redirect targets;
- creation REST/Composer behavior;
- source/Git REST resources, verbs or CSRF behavior;
- security mutation FSM, ACL, SSO or reauthentication semantics;
- SCORE templates or visual layout;
- OWASYS back;
- OPUS framework files;
- A4AQ profiler storage/performance behavior;
- A4AS runtime error lifecycle behavior.

## Delivery

Artifact:

`opus_p117w_r45b2a4at_front_redirect_lifecycle_completion.zip`

SHA-256:

`59dddd868769d712a6ea5dede48cb4c626e0d6ba15c47a8404b175a07e4005fb`

Exactly three complete final-path files:

1. `sites/owasys-front/application/creation/controllers/CreationController.php`
2. `sites/owasys-front/application/source/controllers/SourceController.php`
3. `sites/owasys-front/application/security/controllers/SecurityController.php`

No patcher. No deletion. No backend file. No framework file. No template file.

## Pre-delivery validation

All three delivered files pass PHP lint.

Trailing whitespace count is zero for all three files.

Static lifecycle smoke:

- delivered CreationController `exit` count: 0;
- delivered SourceController `exit` count: 0;
- delivered SecurityController `exit` count: 0;
- direct raw `Location` header count in the three delivered files: 0;
- `Response::empty(303, ...)` redirect sites: 6 total;
- Creation redirect helper/call sites return normally to the Singleton;
- Source redirect helpers/call sites return normally, including nullable locale canonicalization;
- Security redirect helper and legacy-view canonicalization return normally;
- no change was made to A4AS Singleton 3xx finalization.

ZIP inspection confirms exactly the three files listed above and no extra file.

## Owner runtime acceptance

Apply A4AT over OPUS `ec133bd9...`, restart `owasys-front`, and validate representative redirects from each specialized controller.

### Creation

At minimum exercise one creation redirect, preferably `cancel-creation`:

- HTTP 303 target remains Applications;
- the redirect request has front `request.completed`;
- profiler contains `http.response.sent` status 303;
- no `score.response.rendered` is claimed for the 303;
- the complete front trace is persisted.

If practical, also validate successful application creation -> Data.

### Source

At minimum exercise successful source save:

- HTTP 303 returns to the same source with `source_status=saved`;
- front request completion and persisted trace exist;
- `http.response.sent` is 303;
- no SCORE-rendered event is claimed for the redirect.

Also verify that switching locale while a source path is remembered keeps the same source path after the canonical redirect.

### Security

Exercise legacy canonicalization, for example a GET using the legacy `view=roles` form:

- redirect target is the canonical localized Security/Roles route;
- status remains 303;
- front completion/profiler trace is complete;
- no SCORE-rendered event is claimed for the redirect.

### Cross-cutting

No FSM, REST, ACL, SSO, session, SCORE, source/Git or creation regression is acceptable.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
