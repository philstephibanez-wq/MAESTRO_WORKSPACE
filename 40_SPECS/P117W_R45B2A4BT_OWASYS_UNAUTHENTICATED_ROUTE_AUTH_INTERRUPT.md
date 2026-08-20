# P117W R45B2A4BT — OWASYS unauthenticated route auth interrupt

## Status

DELIVERABLE PREPARED / OWNER RUNTIME ACCEPTANCE PENDING

## Gate classification

A4BT is an independent OWASYS frontend blocker discovered while attempting A4BS acceptance. A4BS remains applied but untested because the failure occurs before the Source/Git route. A4BR fresh-generation acceptance also remains separately pending.

## Canonical baseline

- OPUS `master`: `7038d0264e90b4bb83f124fa752f834ae5ee792d`.
- Target file: `sites/owasys-front/application/default/controllers/RuntimeController.php`.
- Canonical source blob: `ffcc5a92f21441234bd540389459b9dea8ff25b1`.
- OWASYS navigation FSM remains `sites/owasys-front/config/fsm.json`, blob `86eadfd70eb2717cd951e85ab9b026853e6d4228`.

## Runtime evidence

On 2026-08-20 after restarting OWASYS, unauthenticated requests to `/fr-FR/applications` failed twice with HTTP 409:

- trace `8989b31e47d41c2a75f294c5b5491bb4`;
- trace `8f4ec4b2fa6fe50d9e47b6deb6332267`.

The frontend profiler/log chain is deterministic:

`begin --open_applications--> registry` → guard `acl:registry:open` → roles `[]` → ACL `default:deny` → `OPUS_FSM_GUARD_FAILED` → `OWASYS_FSM_RUNTIME_REJECTED`.

The backend had only started; no correlated business REST request was required to reproduce the failure. The defect is therefore in frontend request-to-FSM routing.

## Root cause

`OwasysRuntimeController::resolveRequestSignal()` has a special case for the login route, but for every other valid GET route it immediately resolves and returns the route's navigation signal without first converting an absent identity into the canonical authentication interrupt.

At the same time, `currentState()` correctly resets an unauthenticated protected-state session to the FSM initial state `begin`. Consequently, an unauthenticated direct request to `/applications` starts from `begin` and dispatches `open_applications`.

The global `g_open_applications` transition is correctly protected by `acl:registry:open`. Because the identity is absent, the guard fails before `assertTargetStateAccess()` can produce `OWASYS_AUTH_REQUIRED`. The existing transition-failure conversion therefore never receives the authentication-specific error and the request surfaces as HTTP 409.

This is not an ACL defect and must not be corrected by weakening `acl:registry:open` or granting anonymous registry access.

## Canonical correction

After a GET route has been resolved and validated as an existing route, but before its private navigation signal is returned:

- if no authenticated identity exists, return `auth_required` with redirect enabled;
- otherwise preserve the resolved navigation signal unchanged.

The route lookup remains before this authentication gate so an unknown route still fails explicitly with 404 rather than becoming a hidden login fallback.

The existing FSM transition remains the source of truth:

`t_auth_required`: `from=*`, `signal=auth_required`, `next_state=login`, action `clear_session`, interrupt `nmi`.

Thus the canonical unauthenticated flow becomes:

`valid private GET` → `auth_required` → FSM NMI → `login` → HTTP 303 localized login route.

## Scope

Exactly one complete OWASYS frontend file changes:

- `sites/owasys-front/application/default/controllers/RuntimeController.php`

No new class.
No OPUS framework class change.
No FSM configuration change.
No ACL policy change.
No backend change.
No REST contract change.
No JavaScript change.
No SCORE template change.
No generated application change.

## Delivery

ZIP differential direct:

`opus_p117w_r45b2a4bt_owasys_unauthenticated_route_auth_interrupt.zip`

The ZIP contains only the complete modified file at its final repository path. The owner extracts it over `H:\OPUS`, validates, then alone commits/pushes OPUS.

## Acceptance

1. Lint `RuntimeController.php` and regenerate optimized autoload.
2. Validate `owasys-front` and `owasys-back` through normal OPUS validation.
3. Start the normal front/back development servers with no authenticated frontend session.
4. Request `/fr-FR/applications` directly.
5. Confirm the response redirects to localized login instead of returning HTTP 409.
6. Confirm profiler/FSM evidence shows the existing `auth_required` transition to `login` and does not show a denied `acl:registry:open` attempt for that unauthenticated request.
7. Request a nonexistent localized route while unauthenticated and confirm it remains explicit 404, proving no hidden fallback was introduced.
8. Authenticate normally and confirm `/fr-FR/applications` then dispatches `open_applications`, passes the registry ACL, and renders normally.
9. Confirm no owasys-back request is introduced merely to decide frontend authentication routing.
10. Resume A4BS Source/Git acceptance after this blocker passes.

## Non-solutions forbidden

- no anonymous ACL grant for `registry:open`;
- no removal of the FSM guard;
- no direct redirect around the FSM;
- no catch-all route-to-login fallback;
- no backend workaround;
- no session fabrication;
- no silent compatibility bridge.