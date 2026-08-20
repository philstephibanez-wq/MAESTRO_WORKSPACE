# P117W R45B2A4BS — OWASYS Source/Git lazy runtime

## Status

DELIVERABLE APPLIED / RUNTIME ACCEPTANCE BLOCKED BEFORE SOURCE

## Gate classification

A4BR fresh-generation acceptance remains pending and is not closed by this milestone.

A4BS is an explicit blocker correction interleaved before that acceptance because the owner reported latency inside OWASYS itself and requested the next deliverable. It does not advance the generated-application FSM propagation sequence.

The owner runtime attempt on 2026-08-20 did not reach the Source/Git route. It failed earlier on `GET /fr-FR/applications` because the unauthenticated frontend FSM attempted `open_applications` from `begin` and the `acl:registry:open` guard correctly denied the empty-role identity. Therefore A4BS is neither accepted nor functionally rejected: its behavior remains untested until the independent authentication-entry blocker is corrected.

## Canonical baseline

- OPUS `master`: `7038d0264e90b4bb83f124fa752f834ae5ee792d`.
- `sites/owasys-front/application/source/controllers/SourceController.php` source blob: `8b0af1a1c01fc324d079ded5bfad3d85a766136f`.
- `sites/owasys-front/application/source/templates/index.score` source blob: `26b91eab1da0bec20b135276416dd63e116afc07`.
- A4BR canonical scaffold commit remains `3e5d9e18b19015807b6d1320b5d93c3bcd21f571`.

## Root cause

The OWASYS Source/Git controller eagerly executes the complete Git read path during every ordinary source page render:

1. secured REST Git status;
2. secured REST Git history;
3. secured REST selected-file Git diff when a source file is selected.

Those operations are independent from source browsing/editing, but were placed on the mandatory server-render path. Consequently, opening Sources or selecting a source file pays Git/REST/backend/Git-process latency even when the user did not request Git information.

The correction is to remove Git reads from the mandatory source-render path, not to hide latency in JavaScript, change timeouts, or bypass the OWASYS front → REST → back architecture.

## Canonical behavior

Ordinary Source GET without `git=1`:

- loads source listing/selection only;
- does not call `gitStatus`, `gitHistory` or `gitDiff`;
- renders a SCORE Git load action;
- preserves all source editor behavior.

Explicit Source GET with `git=1`:

- executes the existing secured Git read chain;
- renders status, selected-file diff and history exactly through the existing contracts;
- uses no alternate backend route and no fallback.

Git mutation POSTs remain unchanged in authority and still pass through the existing FSM, ACL, CSRF, REST and backend paths. Their redirect now carries `git=1` so the Git workspace stays visible after stage/unstage/commit/restore.

The `git` query option is strict: absent means Git not requested; exactly `1` means Git requested; any other supplied value fails explicitly with `OWASYS_GIT_WORKSPACE_OPTION_INVALID` and HTTP 400.

## Scope

Exactly two complete OWASYS frontend files change:

- `sites/owasys-front/application/source/controllers/SourceController.php`
- `sites/owasys-front/application/source/templates/index.score`

No new class is introduced.
No OPUS framework class changes.
No owasys-back file changes.
No JavaScript changes.
No REST contract changes.
No FSM/menu changes.
No generated application changes.
No i18n catalogue changes; the SCORE load control reuses existing Git translation keys.

## Delivery

ZIP differential direct:

`opus_p117w_r45b2a4bs_owasys_source_git_lazy_runtime.zip`

The owner applies the complete frontend delivery files over `H:\OPUS`, validates, then alone commits/pushes OPUS.

## Static integrity evidence

The prepared complete controller, with only the A4BS transformations reversed, reconstructs Git blob `8b0af1a1c01fc324d079ded5bfad3d85a766136f`, exactly the canonical source blob.

The prepared complete SCORE template, with only the A4BS lazy-load block reversed, reconstructs Git blob `26b91eab1da0bec20b135276416dd63e116afc07`, exactly the canonical source blob.

PHP lint of the delivered `SourceController.php` succeeds in the delivery build environment.

## Runtime evidence — 2026-08-20

The first browser request after restart was `GET /fr-FR/applications` while no authenticated identity was present. Frontend traces `8989b31e47d41c2a75f294c5b5491bb4` and `8f4ec4b2fa6fe50d9e47b6deb6332267` both failed with HTTP 409 `OWASYS_FSM_RUNTIME_REJECTED:OPUS_FSM_GUARD_FAILED` before any Source/Git route was reached.

Detailed profiler/log evidence shows `begin --open_applications--> registry`, empty roles, the `acl:registry:open` guard denied by default, then `guard_refused`. The backend had only started and received no correlated business request for this failure. This establishes an independent frontend authentication-entry defect rather than an A4BS Source/Git failure.

A4BT is inserted to correct that root cause. After A4BT acceptance, resume this A4BS acceptance from the Source/Git route.

## Acceptance

1. A4BT must first restore canonical unauthenticated routing to login.
2. Open Sources/Git without `git=1` and confirm source browsing/editing remains functional.
3. Confirm the Git section exposes the explicit load action but does not contain loaded status/history before activation.
4. Use the OPUS profiler and confirm the initial source request contains no Git status/history/diff backend work.
5. Activate the Git control; confirm the URL carries `git=1` and status/history/diff are then populated from the existing secured REST chain.
6. Exercise one Git mutation and confirm the redirect keeps `git=1` and the refreshed Git workspace remains visible.
7. Request an invalid explicit Git option such as `git=0`; confirm explicit rejection `OWASYS_GIT_WORKSPACE_OPTION_INVALID` with HTTP 400.
8. Compare profiler timings before/after. Acceptance is based on measured removal of mandatory Git work from the ordinary Source request, not on subjective UI impression.

## Deferred separate concern

The application-deletion menu/workflow issue is not mixed into A4BS. It remains a distinct OWASYS blocker to be corrected by its own smallest root-cause package after the current authentication-entry blocker and A4BS evidence, unless the owner changes priority.