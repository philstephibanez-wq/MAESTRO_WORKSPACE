# MAESTRO_WORKSPACE HANDOFF — OWASYS P117T REST + COMPOSER BACKEND

Date: 2026-07-23
Status: clean differential prepared; isolated validation green; owner Windows/Composer/browser validation pending
OPUS base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`

## Binding decision

OWASYS is now treated as two layers:

```text
Current OWASYS SCORE pages = frontend
Secured OPUS REST API + Composer = backend
```

The frontend keeps browser locale, SSO, ACL, FSM, forms, ViewModels and SCORE rendering. It performs no persistent business mutation.

The backend authenticates the frontend service, verifies HMAC integrity, validates the delegated actor, applies an execution FSM and operation ACL, maps the typed operation to an allow-listed public Composer script, invokes `bin/opus`, and returns a structured secret-free result.

Canonical specification:

`CONTEXT/SPECIFICATIONS/OWASYS_BACKEND_REST_COMPOSER_SPEC_P117T.md`

## Rejected artifact

The following artifact is rejected and must not be applied:

- ZIP: `opus_owasys_p117s_rest_composer_api.zip`
- SHA-256: `acb79eec5cc0ce4023e79e53963f203a2c143b78fa754a4411036170f3c4220e`

Reasons: global `public/rcp`, embedded delivery audit/check files and excessive delivery footprint.

## Authoritative P117T differential

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

Composer contains user OPUS commands only:

- create application/site;
- OWASYS create/export;
- add language;
- serve/validate site;
- list routes;
- create page/rubric;
- administrator-password change;
- OWASYS Registry sync/select/clear/creation-start.

Every script delegates to `bin/opus`. No smoke, audit or recipe alias remains.

## REST backend placement

The backend public entrypoint is site-owned:

`sites/owasys/www/api/index.php`

Backend configuration is site-owned:

- `sites/owasys/config/backend.rest.json`
- `sites/owasys/config/backend.operations.json`
- `sites/owasys/config/rcp.json`

No global `public/` directory is introduced.

## Security

Default local transport:

- loopback HTTP only for development;
- bearer token from `OPUS_OWASYS_BACKEND_TOKEN`;
- HMAC key from `OPUS_OWASYS_BACKEND_HMAC`;
- HMAC covers method, path, timestamp, nonce and complete body;
- nonce equals execution identifier;
- request expiry and clock skew enforced;
- execution identifier replay rejected;
- delegated roles/providers restricted by configuration;
- operation ACL reapplied in the backend;
- passwords remain in body/stdin only.

Remote deployment requires HTTPS. Auth0 proxy/bastion remains behind generic OPUS authentication boundaries.

## Generic framework classes

P117T adds or restores generic OPUS classes for:

- public console application;
- site/application command services;
- application command-provider dispatch;
- compliant application scaffold;
- generated Singleton site runtime;
- Composer command registry and executor;
- RCP identity/authentication/execution FSM;
- REST client/server/execution store.

Every new concrete framework class implements its homonymous interface extending the four required markers.

Modified framework classes retain existing homonymous interfaces:

- `Response`;
- `FsmProcessor`;
- `FsmSiteLoader`;
- `LocalPasswordSsoProvider`.

## Frontend migration

The current OWASYS pages remain unchanged as the presentation frontend.

Frontend services/models are corrected so that:

- password change calls the generic REST client;
- Registry synchronize/select/clear/creation-start call the REST backend;
- the web Registry model no longer opens persistent storage;
- Composer-side OWASYS command provider owns Registry persistence;
- FSM actions remain the frontend lifecycle owner;
- returned data is projected into existing ViewModels and SCORE pages.

## Generated application contract

Composer-generated applications are immediately:

- Singleton;
- `application/default + application/<module>`;
- FSM-module-first;
- browser-locale aware;
- OPUS I18n based;
- ACL deny-by-default;
- SSO/Auth0-proxy ready;
- SCORE only;
- free of UI-producing `echo` and mixed HTML/PHP views.

## Validation completed

- PHP syntax for every PHP file in the differential;
- JSON parsing for every JSON file;
- no smoke/audit/recipe in Composer scripts;
- only `composer.json` directly at root;
- no forbidden delivery or global public entry;
- homonymous-interface/four-marker verification;
- isolated HMAC-authenticated REST execution;
- invalid-signature rejection;
- insufficient-role rejection;
- allow-listed Composer process boundary using JSON stdin/result;
- execution FSM progression;
- compliant application scaffold inspection;
- ZIP integrity.

## Pending owner validation

- real Windows Composer command invocation;
- full Composer autoload;
- all existing OPUS recipes outside Composer aliases;
- actual Registry persistence and password workflow;
- current OWASYS pages against the backend;
- browser and no-JavaScript acceptance;
- Auth0 proxy, HTTPS and bastion deployment;
- Windows/Linux parity.

## Cleanup commands

Use only if a rejected P117S package was extracted:

```cmd
cd /d H:\OPUS
if exist public\rcp rmdir /s /q public\rcp
if exist bin\internal\audit_p117s_rest_composer.php del /q bin\internal\audit_p117s_rest_composer.php
if exist bin\cmd\CHECK_P117S_REST_COMPOSER.cmd del /q bin\cmd\CHECK_P117S_REST_COMPOSER.cmd
if exist bin\cmd\INIT_LOCAL_RCP_SECRET.cmd del /q bin\cmd\INIT_LOCAL_RCP_SECRET.cmd
if exist bin\cmd\CLEAN_LOCAL_RCP_SECRET.cmd del /q bin\cmd\CLEAN_LOCAL_RCP_SECRET.cmd
if exist bin\cmd\START_OPUS_RCP_REST.cmd del /q bin\cmd\START_OPUS_RCP_REST.cmd
if exist bin\cmd\START_OWASYS.cmd del /q bin\cmd\START_OWASYS.cmd
```

Do not delete pre-existing project files unrelated to the rejected artifact.

## Launch commands

Generate two independent secrets once per terminal session:

```cmd
cd /d H:\OPUS
for /f "delims=" %A in ('php -r "echo bin2hex(random_bytes(32));"') do set "OPUS_OWASYS_BACKEND_TOKEN=%A"
for /f "delims=" %A in ('php -r "echo bin2hex(random_bytes(32));"') do set "OPUS_OWASYS_BACKEND_HMAC=%A"
```

Terminal 1 — backend:

```cmd
cd /d H:\OPUS
php -S 127.0.0.1:8792 -t sites\owasys\www\api sites\owasys\www\api\index.php
```

Terminal 2 — frontend, with the same two environment values:

```cmd
cd /d H:\OPUS
php -S 127.0.0.1:8791 -t sites\owasys\www sites\owasys\www\index.php
```

## `owasys_old`

Do not delete `sites/owasys_old`. P117Q still uses it as the rejected duplicate proving canonical discovery. Deletion remains subject to reference scan, browser acceptance and explicit owner confirmation.

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
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
