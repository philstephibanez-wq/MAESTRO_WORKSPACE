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
OWASYS IS WEB UI ONLY.
OWASYS BUSINESS OPERATIONS USE REST RCP THEN COMPOSER.
SECRETS NEVER ENTER COMMAND-LINE ARGUMENTS OR LOGS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

## OPUS

- Framework PHP principal.
- Repository: `philstephibanez-wq/OPUS`.
- Branch: `master`.
- Current committed head / P117S base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`.
- Database access: ODBC-only for framework database services; OWASYS Registry remains its declared application SQLite projection behind Composer command-side access.
- `Opus\Model`: official representation layer.
- Canonical site architecture contract: `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`.
- All concrete framework classes implement a homonymous interface extending the four standard markers.
- Generic console, Composer dispatch, REST, RCP, transport, authentication, FSM and generated-runtime classes belong to OPUS.
- Configuration crosses `File` plus explicit structured parsers.

## OWASYS

- Portable OPUS graphical application-management surface.
- OWASYS is not the owner of executable or persistent domain operations.
- Every business operation crosses SSO + ACL + FSM, typed REST RCP, an allow-listed public Composer command and a typed OPUS/application handler.
- Registry persistence and query snapshots are produced command-side; the web UI does not open the Registry repository.
- SCORE-only rendering; no UI-producing `echo`; no mixed PHP/HTML; no client-side command router.
- P117Q committed baseline: Singleton, regional locale, synchronized FSM navigation and canonical Registry discovery.
- P117S active contract: `CONTEXT/SPECIFICATIONS/OPUS_RCP_REST_COMPOSER_API_SPEC_P117S.md`.
- P117S handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_RCP_REST_COMPOSER_P117S_2026-07-23.md`.
- P117S differential ZIP: `opus_owasys_p117s_rest_composer_api.zip`.
- ZIP SHA-256: `acb79eec5cc0ce4023e79e53963f203a2c143b78fa754a4411036170f3c4220e`.
- Files: 58; bytes: 65,973; only root entry: `composer.json`.
- All P117R code artifacts are rejected and superseded.
- `sites/owasys_old` remains a rejected duplicate reference until browser acceptance and explicit owner deletion approval.

## Composer

Composer has only two OPUS product responsibilities:

1. install OPUS and dependencies;
2. expose stable user commands through `bin/opus`.

Smokes, audits, recipes and arbitrary technical commands are forbidden in `composer.json`.

## REST RCP

Primary resource model:

```text
GET  /v1/status
GET  /v1/operations
POST /v1/executions
GET  /v1/executions/{execution_id}
```

The REST API is generic OPUS infrastructure. HTTP is restricted to loopback development; remote deployment requires HTTPS. SSH may be considered later only as an optional generic OPUS transport adapter using the same typed allow-list.

## OPUS Demo

Official demonstration to generate through OWASYS only after P117S real Composer/browser/Auth0 acceptance and owner approval.

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
2. `CONTEXT/SPECIFICATIONS/OPUS_RCP_REST_COMPOSER_API_SPEC_P117S.md`.
3. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_RCP_REST_COMPOSER_P117S_2026-07-23.md`.
4. Apply P117S to clean OPUS `36a8570…`.
5. Run the P117S check CMD.
6. Start REST and OWASYS in separate VS Code terminals.
7. Validate real Composer, Registry, password, browser, Auth0 and HTTPS flows.
8. Commit OPUS after owner acceptance.
9. Decide `owasys_old` deletion separately.
10. Demo, User Book, Reference Book, LSTSAR, KB.
