# P117W R45B2A4BT — OWASYS unauthenticated route auth interrupt — HANDOFF

## Current status

DELIVERABLE READY / OWNER APPLY + RUNTIME VALIDATION REQUIRED

## Blocking symptom

After restart, direct `GET /fr-FR/applications` is rejected with HTTP 409 `OWASYS_FSM_RUNTIME_REJECTED:OPUS_FSM_GUARD_FAILED` before OWASYS reaches Sources/Git.

Frontend traces `8989b31e47d41c2a75f294c5b5491bb4` and `8f4ec4b2fa6fe50d9e47b6deb6332267` both show:

`begin` → `open_applications` → `g_open_applications` → `acl:registry:open` → roles `[]` → deny → guard failure.

No backend business request is needed for the failure.

## Root cause

`OwasysRuntimeController::resolveRequestSignal()` resolves a valid non-login GET route to its private navigation signal before checking whether an authenticated identity exists. Therefore an unauthenticated `/applications` request attempts registry navigation and is correctly rejected by the deny-by-default ACL guard.

The FSM already has the required canonical authentication interrupt: `auth_required` from `*` to `login` as NMI. The controller must select that existing signal for an unauthenticated valid route instead of attempting private navigation.

Unknown routes remain 404 because route validation stays before the identity gate.

## Baseline

- OPUS master: `7038d0264e90b4bb83f124fa752f834ae5ee792d`.
- RuntimeController canonical blob: `ffcc5a92f21441234bd540389459b9dea8ff25b1`.
- FSM config blob: `86eadfd70eb2717cd951e85ab9b026853e6d4228`.

## Delivered file

- `sites/owasys-front/application/default/controllers/RuntimeController.php`

No backend, framework, FSM config, ACL config, REST, JavaScript, SCORE or generated-site file changes.

## Owner validation

After direct ZIP extraction over `H:\OPUS`:

```cmd
php -l sites\owasys-front\application\default\controllers\RuntimeController.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

Then restart the normal front/back development servers with no authenticated frontend session and request `/fr-FR/applications`.

Expected contract:

- valid private unauthenticated route → FSM `auth_required` NMI → localized login redirect;
- no HTTP 409 ACL guard failure;
- unknown route still 404;
- after authentication, `/fr-FR/applications` still uses `open_applications` and the normal registry ACL;
- no new backend request for frontend authentication routing.

## Continuation

A4BS remains applied but acceptance-blocked until A4BT passes. After A4BT acceptance, resume the A4BS Sources/Git profiler validation. A4BR fresh-generation acceptance remains independently pending.

The assistant does not commit or push OPUS/OWASYS. The owner applies, validates, commits and pushes.