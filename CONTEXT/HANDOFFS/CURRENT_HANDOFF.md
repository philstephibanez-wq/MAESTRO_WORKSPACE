# CURRENT HANDOFF — MAESTRO WORKSPACE

Date: 2026-07-23

## Purpose

Canonical resume card for a fresh chat.

## Active milestone

P117S — OPUS REST RCP / Composer API.

OWASYS is only the web UI. Every OWASYS business execution or persistent mutation crosses SSO + ACL + FSM, then the generic OPUS REST RCP server, then an allow-listed public Composer command, then `bin/opus` and a typed OPUS/application command handler.

Composer exposes user OPUS commands only. Smokes, audits, recipes and arbitrary technical commands are forbidden in `composer.json`.

## Source of truth

- OPUS repository: `philstephibanez-wq/OPUS`
- OPUS branch: `master`
- Differential base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Workspace repository: `philstephibanez-wq/MAESTRO_WORKSPACE`
- P117S specification: `CONTEXT/SPECIFICATIONS/OPUS_RCP_REST_COMPOSER_API_SPEC_P117S.md`
- P117S handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_RCP_REST_COMPOSER_P117S_2026-07-23.md`
- Site architecture contract: `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
- `H:/OPUS` is an owner-local development detail only

## Authoritative differential

- ZIP: `opus_owasys_p117s_rest_composer_api.zip`
- SHA-256: `acb79eec5cc0ce4023e79e53963f203a2c143b78fa754a4411036170f3c4220e`
- Files: 58
- Bytes: 65,973
- Only root entry: `composer.json`
- ZIP integrity: verified
- OPUS repository was not written directly by the assistant

All P117R code artifacts are rejected and superseded.

## Composer contract

Composer has exactly two OPUS product responsibilities:

1. install OPUS and dependencies;
2. expose stable user OPUS commands.

Public command families delivered in P117S:

- application/site create;
- OWASYS create/export;
- language add;
- site serve/validate;
- route list;
- page/rubric create;
- administrator-password change;
- Registry synchronize/select/clear/creation-start.

Every Composer script delegates to `bin/opus`. No smoke or audit alias remains.

## REST RCP architecture

```text
OWASYS SCORE UI
-> browser locale
-> SSO identity
-> deny-by-default ACL
-> OWASYS FSM
-> typed REST execution
-> OPUS REST authentication
-> delegated actor validation
-> RCP execution FSM
-> allow-listed Composer script
-> bin/opus
-> OPUS service or application command provider
-> structured result
-> OWASYS projection/ViewModel
-> SCORE
```

REST resources:

```text
GET  /v1/status
GET  /v1/operations
POST /v1/executions
GET  /v1/executions/{execution_id}
```

HTTP is accepted only on loopback for local development. Remote deployment requires HTTPS.

## Framework rules

Every concrete framework class implements its homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

P117S adds generic OPUS console, scaffold, runtime, Composer, REST and RCP classes behind such interfaces.

Modified `Response`, `FsmProcessor` and `FsmSiteLoader` remain behind their existing homonymous four-marker interfaces.

## Generated applications

Composer creates a complete module-first OPUS application:

- Singleton composition root;
- `application/default + application/<module>`;
- no `application/states`;
- FSM-module-first routing;
- browser-locale negotiation;
- canonical OPUS I18n catalogs;
- deny-by-default ACL;
- session and Auth0-proxy SSO boundaries;
- SCORE-only rendering;
- minimal `www/index.php`;
- no UI-producing `echo`;
- no mixed HTML/PHP views.

## OWASYS migration

The OWASYS web process no longer executes persistent Registry or password mutations.

The Registry web model does not open SQLite. It consumes an in-memory snapshot returned by the Composer-side command provider.

Migrated operations include create, validate, route list, language/page/rubric creation, export, password change and Registry synchronize/select/clear/creation-start.

## Configuration

Configuration crosses `Opus\File\File` and `StructuredFileLoader`, selecting OPUS JSON/YAML/YML/XML parsers. `FsmProcessor` and `FsmSiteLoader` were corrected to remove direct JSON configuration reads.

## Validation state

Green in isolated artifact recipes:

- PHP lint;
- JSON parse;
- Composer catalogue audit;
- homonymous-interface/four-marker audit;
- scaffold and site-command recipes;
- REST server and authentication recipes;
- Composer process-boundary recipe;
- Registry command/snapshot recipe;
- FSM structured-loader recipe;
- response-stream/no-echo recipe;
- ZIP integrity and root-entry validation.

Pending owner gates:

- real Windows Composer and autoload;
- real nested Composer/stdin execution;
- full existing OPUS recipes;
- real Registry/password workflows;
- browser/no-JavaScript acceptance;
- Auth0 proxy and HTTPS/bastion deployment;
- Windows/Linux parity.

## Target commands

```cmd
cd /d H:\OPUS
bin\cmd\CLEAN_P117R_REJECTED_RCP.cmd
bin\cmd\CHECK_P117S_REST_COMPOSER.cmd
bin\cmd\INIT_LOCAL_RCP_SECRET.cmd
```

Terminal 1:

```cmd
cd /d H:\OPUS
bin\cmd\START_OPUS_RCP_REST.cmd
```

Terminal 2:

```cmd
cd /d H:\OPUS
bin\cmd\START_OWASYS.cmd
```

## `owasys_old`

Do not delete it now. P117Q still uses `sites/owasys_old` as a rejected duplicate for canonical Registry integrity. Deletion requires reference scan, browser acceptance and explicit owner confirmation.

## Permanent rules

NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
NO DELIVERY FILE POLLUTION IN OPUS ROOT.
COMPOSER EXPOSES USER COMMANDS ONLY.
OWASYS IS WEB UI ONLY.
OWASYS BUSINESS OPERATIONS USE REST RCP THEN COMPOSER.
SECRETS NEVER ENTER COMMAND-LINE ARGUMENTS OR LOGS.
BACKEND FIRST.
SERVER-RENDERED SCORE FIRST.
JAVASCRIPT IS PROGRESSIVE ENHANCEMENT ONLY.
WWW IS PUBLIC ENTRY POINT AND PUBLIC ASSETS ONLY.
REUSE EXISTING OPUS BRICKS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

OPUS is a sub-project inside MAESTRO_WORKSPACE. OPUS is not the workspace.
