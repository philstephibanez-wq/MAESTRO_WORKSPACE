# P117W R45B2A4BS — OWASYS Source/Git lazy runtime — HANDOFF

## Current status

APPLIED / A4BS RUNTIME ACCEPTANCE BLOCKED BEFORE SOURCE

## Why this package exists

A4BS removes mandatory Git status, Git history and selected-file diff work from ordinary Source renders and makes Git loading explicit.

The owner runtime attempt on 2026-08-20 did not reach that behavior. The first `GET /fr-FR/applications` after restart failed in the OWASYS frontend FSM before any Source route or backend REST business request.

## Baseline

OPUS `master` observed before A4BS preparation:

`7038d0264e90b4bb83f124fa752f834ae5ee792d`

Canonical A4BS source blobs:

- SourceController: `8b0af1a1c01fc324d079ded5bfad3d85a766136f`
- source SCORE template: `26b91eab1da0bec20b135276416dd63e116afc07`

A4BR fresh-generation acceptance remains pending. A4BS does not close or supersede A4BR.

## Delivered A4BS files

- `sites/owasys-front/application/source/controllers/SourceController.php`
- `sites/owasys-front/application/source/templates/index.score`

No backend, framework, JavaScript, FSM, REST contract, generated-site or translation-catalogue file changes.

## Runtime evidence received

Frontend traces:

- `8989b31e47d41c2a75f294c5b5491bb4`
- `8f4ec4b2fa6fe50d9e47b6deb6332267`

Both execute the same failing path:

`GET /fr-FR/applications` → FSM state `begin` → signal `open_applications` → global transition `g_open_applications` → guard `acl:registry:open` → empty roles/default deny → `OPUS_FSM_GUARD_FAILED` → HTTP 409.

The failure occurs before Source/Git and before a correlated owasys-back request. Therefore A4BS itself is not functionally rejected; its acceptance is blocked and unexecuted.

## Root cause selected for next blocker package

`OwasysRuntimeController::resolveRequestSignal()` resolves a valid private GET route directly to its navigation signal even when no authenticated identity exists. From the canonical real entry state `begin`, `/applications` therefore dispatches `open_applications`; the registry ACL guard correctly denies it before the later target-state authentication check can convert the request to `auth_required`.

The FSM already contains the canonical `auth_required` NMI transition from `*` to `login`. The smallest correction is to route an unauthenticated valid non-login GET through that existing signal before private navigation dispatch. Invalid routes must still remain explicit 404.

## Next package

A4BT — OWASYS unauthenticated route auth interrupt.

After A4BT acceptance:

1. verify unauthenticated `/fr-FR/applications` redirects to login rather than returning 409;
2. authenticate and verify `/fr-FR/applications` succeeds normally;
3. resume A4BS Source/Git acceptance and profiler timing checks;
4. keep A4BR fresh-generation acceptance pending until separately executed.

## Role boundary

The assistant prepares the A4BT differential ZIP and updates MAESTRO_WORKSPACE only. The owner applies, validates, commits and pushes OPUS/OWASYS.