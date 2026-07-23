# Project Index — MAESTRO WORKSPACE

## Permanent rules

NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
NO DELIVERY FILE POLLUTION IN OPUS ROOT.
COMPOSER EXPOSES USER COMMANDS ONLY.
BACKEND FIRST.
SERVER-RENDERED SCORE FIRST.
JAVASCRIPT IS PROGRESSIVE ENHANCEMENT ONLY.
WWW IS PUBLIC ENTRY POINT AND PUBLIC ASSETS ONLY.
OWASYS CURRENT PAGES ARE THE FRONTEND.
REST + COMPOSER IS THE OWASYS BACKEND.
ALL OWASYS BUSINESS OPERATIONS CROSS SECURED REST THEN COMPOSER.
SECRETS NEVER ENTER COMMAND-LINE ARGUMENTS OR LOGS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

## OPUS

- Framework PHP principal.
- Repository: `philstephibanez-wq/OPUS`.
- Branch: `master`.
- Current committed head / P117T base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`.
- Canonical site architecture: `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`.
- All concrete framework classes implement a homonymous interface extending the four standard markers.
- Generic console, Composer dispatch, REST, RCP, authentication, FSM and generated-runtime classes belong to OPUS.
- Configuration crosses `File` plus explicit structured parsers.
- OPUS code changes are delivered as a differential ZIP; the assistant does not push OPUS directly.

## OWASYS

- Portable OPUS graphical application-management frontend.
- Current SCORE pages remain the frontend.
- Secured REST API plus Composer commands form the backend.
- Frontend owns browser locale, SSO, ACL, FSM, forms, ViewModels and SCORE rendering only.
- Every business mutation crosses signed typed REST, backend actor validation, execution FSM, operation allow-list, Composer and `bin/opus`.
- Registry persistence is command-side; the web UI does not open the Registry repository.
- SCORE-only rendering; no UI-producing `echo`; no mixed PHP/HTML; no client-side command router.
- P117Q committed baseline: Singleton, regional locale, synchronized FSM navigation and canonical Registry discovery.
- P117T active contract: `CONTEXT/SPECIFICATIONS/OWASYS_BACKEND_REST_COMPOSER_SPEC_P117T.md`.
- P117T handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_BACKEND_REST_COMPOSER_P117T_2026-07-23.md`.
- P117T differential ZIP: `opus_owasys_p117t_backend_rest_composer.zip`.
- ZIP SHA-256: `ad1494d92f068789d8363b4b6a7a823ff7b6be189d36f66724f92fec91baf2c5`.
- Files: 49; bytes: 64,460; only direct root file: `composer.json`.
- Top-level entries are existing OPUS areas only: `Opus`, `bin`, `config`, `sites`, `composer.json`.
- P117S ZIP `acb79eec…` is rejected and must not be applied.
- `sites/owasys_old` remains a rejected duplicate reference until browser acceptance and explicit owner deletion approval.

## Composer

Composer has only two OPUS product responsibilities:

1. install OPUS and dependencies;
2. expose stable user commands through `bin/opus`.

Smokes, audits, recipes and arbitrary technical commands are forbidden in `composer.json`.

## OWASYS REST backend

Minimum resource model:

```text
GET  /v1/status
POST /v1/executions
```

- Site-owned entrypoint: `sites/owasys/www/api/index.php`.
- Site-owned backend and operation configuration under `sites/owasys/config/`.
- No new global `public/` tree.
- Loopback HTTP is local-development only; remote deployment requires HTTPS.
- Default local security uses bearer plus HMAC environment secrets.
- Auth0 proxy/bastion stays behind generic OPUS authentication boundaries.
- SSH may be considered later only as an optional generic OPUS transport using the same typed allow-list.

## OPUS Demo

Official demonstration to generate through OWASYS only after P117T real Composer/backend/browser/Auth0 acceptance and owner approval.

## User Book

After the compliant demo.

## Reference Book

After the User Book; official OPUS technical documentation rendered with SCORE `.score`.

## LSTSAR

Load / Secure / Transform / Store / Audit / Restore. After OWASYS and documentation. Model-driven + ODBC-driven, with independent source and transformed-target validation.

## KB

Resume after LSTSAR.

## LOGANDPLAY

Public identity and `logandplay.org` entry map; contractual alignment pending.

## MAESTRO_WORKSPACE

Global context, decisions and handoffs. OPUS is a sub-project; OPUS is not the workspace.

## Resume order

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`.
2. `CONTEXT/SPECIFICATIONS/OWASYS_BACKEND_REST_COMPOSER_SPEC_P117T.md`.
3. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_BACKEND_REST_COMPOSER_P117T_2026-07-23.md`.
4. Apply P117T to clean OPUS `36a8570…`.
5. Remove only known rejected P117S artifacts if they were extracted.
6. Start REST backend and OWASYS frontend in separate VS Code terminals with identical environment secrets.
7. Validate real Composer, Registry, password, browser, Auth0 and HTTPS flows.
8. Commit OPUS after owner acceptance.
9. Decide `owasys_old` deletion separately.
10. Demo, User Book, Reference Book, LSTSAR, KB.
