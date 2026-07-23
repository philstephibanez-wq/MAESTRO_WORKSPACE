# Project Index — MAESTRO WORKSPACE

## Permanent rules

NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
BACKEND FIRST.
SERVER-RENDERED SCORE FIRST.
JAVASCRIPT IS PROGRESSIVE ENHANCEMENT ONLY.
WWW IS PUBLIC ENTRY POINT AND PUBLIC ASSETS ONLY.
OWASYS IS GUI ONLY.
ALL OWASYS OPERATIONS USE COMPOSER THROUGH RCP.
SECRETS NEVER ENTER COMMAND-LINE ARGUMENTS OR LOGS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

## OPUS

- Framework PHP principal.
- Repository: `philstephibanez-wq/OPUS`.
- Branch: `master`.
- Current head: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`.
- Database access: ODBC-only.
- `Opus\Model`: official representation layer.
- Canonical site architecture contract: `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`.
- All concrete framework classes implement a homonymous interface extending the four standard markers.
- Generic command, Composer-dispatch and RCP classes belong to OPUS.

## OWASYS

- Portable OPUS graphical application-management surface for supported Windows/Linux environments.
- OWASYS is not the owner of executable or mutating domain operations.
- Every operation crosses SSO + ACL + FSM, then RCP, then an allow-listed Composer command and typed OPUS handler.
- SCORE-only rendering; no UI-producing `echo`; no mixed PHP/HTML; no client-side command router.
- P117Q committed baseline: Singleton, regional locale, synchronized FSM navigation and canonical Registry discovery.
- P117R active contract: `CONTEXT/SPECIFICATIONS/OWASYS_COMPOSER_RCP_COMMAND_BOUNDARY_SPEC_P117R.md`.
- P117R handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_COMPOSER_RCP_P117R_2026-07-23.md`.
- P117R bootstrap ZIP: `opus_owasys_p117r_composer_rcp_bootstrap.zip`.
- ZIP SHA-256: `ea7edbfca0e9df871ac7521cd9f8dd3f55811fc75bca7108259719d9ae884350`.
- Administrator-password change is the first migrated Composer/RCP operation.
- Remaining operations are declared but explicitly unimplemented; no fallback is permitted.
- `sites/owasys_old` remains a rejected duplicate reference until exhaustive acceptance and explicit owner deletion approval.

## OPUS Demo

Official demonstration to generate through OWASYS only after complete Composer/RCP migration, backend-first conformity, renewed technical validation and owner visual acceptance.

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
2. `CONTEXT/SPECIFICATIONS/OWASYS_COMPOSER_RCP_COMMAND_BOUNDARY_SPEC_P117R.md`.
3. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_COMPOSER_RCP_P117R_2026-07-23.md`.
4. Apply and validate the P117R bootstrap ZIP.
5. Migrate every remaining OWASYS mutation to Composer/RCP.
6. Make `composer opus:audit-owasys-rcp` green.
7. Complete backend-first, no-JavaScript and browser acceptance.
8. Decide `owasys_old` deletion.
9. Demo, User Book, Reference Book, LSTSAR, KB.
