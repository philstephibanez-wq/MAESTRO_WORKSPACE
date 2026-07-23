# CURRENT HANDOFF — MAESTRO WORKSPACE

Date: 2026-07-23

## Active milestone

P117T — OWASYS secured REST + Composer backend.

```text
Current OWASYS SCORE pages = frontend
OPUS REST API + Composer = backend
```

The frontend owns browser locale, SSO, deny-by-default ACL, FSM, forms, ViewModels and SCORE rendering. It performs no persistent business mutation.

The backend verifies bearer + HMAC authentication, validates the delegated actor, runs an execution FSM, resolves a typed operation through an allow-list, invokes a public Composer command, delegates to `bin/opus`, and returns a structured secret-free result.

## Source of truth

- OPUS repository: `philstephibanez-wq/OPUS`
- OPUS branch: `master`
- Differential base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Workspace repository: `philstephibanez-wq/MAESTRO_WORKSPACE`
- P117T specification: `CONTEXT/SPECIFICATIONS/OWASYS_BACKEND_REST_COMPOSER_SPEC_P117T.md`
- P117T handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_BACKEND_REST_COMPOSER_P117T_2026-07-23.md`
- Site architecture contract: `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`

## Rejected artifact

Do not use:

- `opus_owasys_p117s_rest_composer_api.zip`
- SHA-256 `acb79eec5cc0ce4023e79e53963f203a2c143b78fa754a4411036170f3c4220e`

It is rejected because it introduced a global `public/rcp` tree and embedded delivery audit/check files.

## Authoritative differential

- ZIP: `opus_owasys_p117t_backend_rest_composer.zip`
- SHA-256: `ad1494d92f068789d8363b4b6a7a823ff7b6be189d36f66724f92fec91baf2c5`
- Files: 49
- Bytes: 64,460
- Base: OPUS `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Only file directly at root: `composer.json`
- Top-level entries: `Opus`, `bin`, `config`, `sites`, `composer.json`
- No README, manifest, report, smoke, audit, check helper or global `public` tree
- ZIP integrity verified
- OPUS repository not written directly by the assistant

## Composer contract

Composer has exactly two OPUS product responsibilities:

1. install OPUS and dependencies;
2. expose stable user OPUS commands through `bin/opus`.

No smoke, audit, recipe or arbitrary technical command belongs in `composer.json`.

P117T exposes create application/site, OWASYS create/export, language add, serve/validate, route list, page/rubric creation, administrator-password change and Registry administration commands.

## Mandatory pipeline

```text
OWASYS SCORE frontend
-> browser locale
-> SSO
-> ACL
-> OWASYS FSM
-> signed typed REST request
-> backend authentication
-> delegated identity validation
-> backend execution FSM
-> operation allow-list
-> Composer
-> bin/opus
-> OPUS service or application command provider
-> structured result
-> ViewModel
-> SCORE
```

No browser-supplied shell command, Composer script, executable path, working directory, absolute target path or environment injection is accepted.

## Backend placement

- REST entrypoint: `sites/owasys/www/api/index.php`
- Server config: `sites/owasys/config/backend.rest.json`
- Operation catalog: `sites/owasys/config/backend.operations.json`
- Frontend client config: `sites/owasys/config/rcp.json`

No global `public/` directory is introduced.

## Security

- loopback HTTP permitted only for local development;
- remote deployment requires HTTPS;
- bearer token from `OPUS_OWASYS_BACKEND_TOKEN`;
- HMAC key from `OPUS_OWASYS_BACKEND_HMAC`;
- HMAC covers method, path, timestamp, nonce and body;
- nonce equals execution ID;
- clock skew, expiry and replay checked;
- delegated roles/providers restricted;
- operation ACL reapplied backend-side;
- passwords remain in body and process stdin only.

Auth0 proxy and bastion stay behind generic OPUS authentication and transport contracts.

## Framework and application rules

Every new concrete framework class implements its homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

Composer-generated applications are Singleton, FSM-module-first, browser-locale aware, OPUS I18n based, ACL deny-by-default, SSO/Auth0-proxy ready and SCORE-only, with no UI-producing `echo` or mixed HTML/PHP views.

Configuration is read through `Opus\File\File` and `StructuredFileLoader` with explicit JSON/YAML/YML/XML parsers.

## Validation completed

- PHP lint;
- JSON parsing;
- Composer contains user commands only;
- root-layout and forbidden-delivery-name checks;
- homonymous-interface/four-marker checks;
- HMAC-authenticated isolated REST execution;
- invalid-signature rejection;
- insufficient-role rejection;
- allow-listed Composer/stdin process boundary;
- execution FSM progression;
- compliant application scaffold inspection;
- ZIP integrity.

## Pending owner gates

- real Windows Composer and autoload;
- full existing OPUS recipes outside Composer aliases;
- actual Registry and password workflows;
- current OWASYS frontend against the backend;
- browser/no-JavaScript acceptance;
- Auth0 proxy, HTTPS and bastion deployment;
- Windows/Linux parity.

## Target launch

Set the same two secrets in both VS Code terminals:

```cmd
cd /d H:\OPUS
for /f "delims=" %A in ('php -r "echo bin2hex(random_bytes(32));"') do set "OPUS_OWASYS_BACKEND_TOKEN=%A"
for /f "delims=" %A in ('php -r "echo bin2hex(random_bytes(32));"') do set "OPUS_OWASYS_BACKEND_HMAC=%A"
```

Backend:

```cmd
cd /d H:\OPUS
php -S 127.0.0.1:8792 -t sites\owasys\www\api sites\owasys\www\api\index.php
```

Frontend:

```cmd
cd /d H:\OPUS
php -S 127.0.0.1:8791 -t sites\owasys\www sites\owasys\www\index.php
```

## `owasys_old`

Do not delete `sites/owasys_old`. P117Q still uses it as the rejected duplicate proving canonical discovery. Deletion requires reference scan, browser acceptance and explicit owner confirmation.

## Permanent rules

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
NO DELIVERY FILE POLLUTION IN OPUS ROOT.
COMPOSER EXPOSES USER COMMANDS ONLY.
OWASYS CURRENT PAGES ARE THE FRONTEND.
REST + COMPOSER IS THE OWASYS BACKEND.
ALL OWASYS BUSINESS OPERATIONS CROSS SECURED REST THEN COMPOSER.
SECRETS NEVER ENTER ARGV OR LOGS.
SERVER-RENDERED SCORE FIRST.
WWW IS PUBLIC ENTRY POINT AND PUBLIC ASSETS ONLY.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

OPUS is a sub-project inside MAESTRO_WORKSPACE. OPUS is not the workspace.
