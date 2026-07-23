# CURRENT HANDOFF — MAESTRO WORKSPACE

Date: 2026-07-23

## Purpose

Canonical resume card for a fresh chat.

## Active priority

Migrate every executable or mutating OWASYS operation to an allow-listed Composer command invoked through RCP.

OWASYS is exclusively the interactive graphical surface. It collects intent, applies SSO + ACL + FSM, requests preview/confirmation, submits a typed RCP command and renders structured results through SCORE.

OWASYS must not own or directly execute site creation, structure mutation, source writes, build/export, Registry writes, Git stage/commit, cleanup, user bootstrap, administrator-password mutation, SSO administration or any future persistent operation.

## Source of truth

- OPUS repository: `philstephibanez-wq/OPUS`
- OPUS branch: `master`
- Current OPUS head: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Workspace repository: `philstephibanez-wq/MAESTRO_WORKSPACE`
- P117R specification: `CONTEXT/SPECIFICATIONS/OWASYS_COMPOSER_RCP_COMMAND_BOUNDARY_SPEC_P117R.md`
- P117R handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_COMPOSER_RCP_P117R_2026-07-23.md`
- Site architecture contract: `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
- `H:/OPUS` is an owner development detail only

## P117R differential — replacement authoritative artifact

- ZIP: `opus_owasys_p117r_composer_rcp_differential.zip`
- SHA-256: `587638d2b436a74b41c0ecb3efe5d28468ab9806a7aefbe5051bdd541d491d8d`
- Files: 11
- Base: OPUS `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Only legitimate root file: `composer.json`
- No README, manifest, report, launch script, cleanup script or validation script is included at OPUS root
- OPUS repository was not written directly by the assistant

The previous artifact `opus_owasys_p117r_composer_rcp_bootstrap.zip` with SHA-256 `ea7edbfca0e9df871ac7521cd9f8dd3f55811fc75bca7108259719d9ae884350` is rejected and must not be used because it polluted the OPUS root.

## Files in the authoritative differential

```text
composer.json
config/rcp-commands.json
Opus/Rcp/ComposerRcpClient.php
Opus/Rcp/ComposerRcpClientInterface.php
Opus/Rcp/RcpCommandCatalog.php
Opus/Rcp/RcpCommandCatalogInterface.php
Opus/Security/Sso/LocalPasswordSsoProvider.php
sites/owasys/application/default/services/RuntimeSecurity.php
sites/owasys/config/rcp.json
tools/audit_owasys_composer_rcp_boundary.php
tools/opus_rcp_dispatch.php
```

## Implemented in P117R bootstrap

- generic OPUS Composer/RCP catalog and client;
- homonymous interfaces extending the four standard markers;
- root Composer operation catalog;
- administrator-password change migrated to Composer/RCP;
- command-side ACL revalidation;
- secret payload through standard input, never command-line arguments;
- stable structured result without passwords or stack traces;
- local password store migrated to OPUS `File` + `Json` with atomic write;
- bootstrap and exhaustive boundary audits.

## Deliberately incomplete

Only `security.admin-password.change` is implemented in this bootstrap.

All other declared operations are `implemented=false` and fail explicitly with `OPUS_RCP_OPERATION_NOT_IMPLEMENTED`. No local fallback is authorized.

The exhaustive gate remains red until all operations are migrated:

```cmd
composer opus:audit-owasys-rcp
```

## Mandatory target architecture

```text
OWASYS SCORE form
-> authenticated request
-> SSO identity
-> deny-by-default ACL
-> FSM signal and guards
-> immutable command intent
-> RCP request
-> allow-listed Composer command
-> typed OPUS command handler
-> structured result
-> OWASYS ViewModel
-> SCORE rendering
```

Generic command/RCP classes belong to OPUS. OWASYS contains only presentation adapters and ViewModel mapping.

Every new concrete OPUS class implements its homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

## Administrator-password rule

Password bootstrap, reset and change are commands.

No password may appear in URL/query, Composer or PHP command-line arguments, logs, profiler traces, audit details, exceptions, raw process output, committed configuration or differential artifacts.

## Exact next work

1. Extract the authoritative differential into clean OPUS `36a8570…`.
2. Run Composer autoload, bootstrap audit, PHP lint and `git diff --check`.
3. Test the real Windows administrator-password form through Composer/RCP.
4. Inventory and migrate every remaining OWASYS mutation.
5. Keep the exhaustive audit red until no direct mutation remains.
6. Complete backend-first, no-JavaScript and browser acceptance.
7. Delete `sites/owasys_old` only after exhaustive acceptance and explicit owner confirmation.

## `owasys_old`

Do not delete it now. P117Q uses it as an explicit rejected duplicate to prove canonical Registry selection of `sites/owasys`.

## Permanent rules

NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
NO DELIVERY FILE POLLUTION IN OPUS ROOT.
OWASYS IS GUI ONLY.
ALL OPERATIONS USE COMPOSER THROUGH RCP.
SECRETS NEVER ENTER COMMAND-LINE ARGUMENTS OR LOGS.
BACKEND FIRST.
SERVER-RENDERED SCORE FIRST.
JAVASCRIPT IS PROGRESSIVE ENHANCEMENT ONLY.
WWW IS PUBLIC ENTRY POINT AND PUBLIC ASSETS ONLY.
REUSE EXISTING OPUS BRICKS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

OPUS is a sub-project inside MAESTRO_WORKSPACE. OPUS is not the workspace.
