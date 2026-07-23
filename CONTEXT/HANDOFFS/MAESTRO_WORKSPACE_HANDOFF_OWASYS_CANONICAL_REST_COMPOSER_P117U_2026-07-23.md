# MAESTRO_WORKSPACE HANDOFF — OWASYS P117U CANONICAL REST + COMPOSER

Date: 2026-07-23
Status: differential prepared; isolated gates green; owner Windows/browser gates pending
OPUS base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`

## Binding separation

```text
OPUS = generic framework and generic Composer user surface
OWASYS = an OPUS application
Current OWASYS SCORE pages = frontend
Secured REST + Composer = OWASYS backend
Created sites = independent OPUS applications
```

No OWASYS identifier or business implementation exists in the delivered `Opus/` or `scripts/` code.

## Canonical root

The owner-confirmed OPUS root is closed. P117U introduces only:

```text
composer.json
Opus/
scripts/
sites/
```

No `bin/`, root lowercase `config/`, root `public/` or new top-level directory exists.

## Rejected artifacts

Do not apply:

- P117S ZIP SHA-256 `acb79eec5cc0ce4023e79e53963f203a2c143b78fa754a4411036170f3c4220e`;
- P117T ZIP SHA-256 `ad1494d92f068789d8363b4b6a7a823ff7b6be189d36f66724f92fec91baf2c5`.

P117T is rejected because its root `bin/` and root lowercase `config/` violate the only admitted OPUS root.

## Authoritative differential

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `1ee231cbcbe9e5a4578aa6f50b7a83559f89b46f6916e93f682c50f360401e46`
- Files: 55
- Bytes: 69,473
- Base: OPUS `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Top-level entries: `composer.json`, `Opus`, `scripts`, `sites`
- ZIP integrity verified
- no README, manifest, report, smoke, audit or check helper
- OPUS repository not written directly by the assistant

## Framework evolution

P117U provides generic OPUS components for:

- Composer-facing console under `scripts/opus.php`;
- site command service and export;
- application-owned command-provider discovery;
- secured typed REST/RCP client and server;
- Composer operation registry and process executor;
- bearer/HMAC and Auth0-proxy authentication;
- execution FSM and idempotency store;
- generated application runtime;
- canonical site scaffold and compatibility adapter.

`SiteScaffoldPlan` is the only architecture source. The obsolete `FullstackApplicationScaffoldPlan` implementation becomes a compatibility adapter to `SiteScaffoldPlan`.

`ScaffoldWriter` is corrected to use `File::writeAtomic` and explicit CLI stream output. `FsmProcessor`, `FsmSiteLoader`, `LocalPasswordSsoProvider` and `Response` are corrected to use generic contracts, structured File/parsers and non-echo emission.

Every new concrete framework class implements its homonymous four-marker interface. Existing modified framework classes retain their existing homonymous four-marker interfaces.

## OWASYS application evolution

All OWASYS-specific implementation remains under `sites/owasys/`:

- `application/api/controllers/BackendApiController.php`;
- application Singleton and bootstrap;
- REST frontend client integration;
- Registry REST projection;
- OWASYS Composer command provider;
- operation, server, client and provider configuration.

The web Registry model no longer opens SQLite. Registry persistence and password changes occur only in the OWASYS application command provider reached through REST then Composer.

OWASYS has one public PHP entrypoint only:

`sites/owasys/www/index.php`

It delegates only to `application/default/bootstrap.php`. REST and frontend routes pass through that same canonical front controller.

## Composer

`composer.json` contains user commands only and delegates to `scripts/opus.php`.

No smoke, audit, test or recipe alias remains.

Generic OPUS commands create/validate/export/serve sites and manage language/page/rubric structure. OWASYS command scripts invoke application-owned Registry and password commands discovered from `sites/owasys/config/composer.commands.json`.

## Security

- typed operation allow-list;
- bearer plus complete-body HMAC;
- timestamp, expiry, nonce and replay checks;
- backend operation ACL;
- OWASYS provider ACL revalidation;
- Composer process uses an argument array with shell bypass;
- secrets use request body and process stdin only;
- execution records contain no input parameters;
- generic Auth0 proxy provider validates trusted proxy/bastion address and shared secret.

## Configuration

All changed configuration reads use `File` plus `StructuredFileLoader` and explicit OPUS parsers. The differential contains no direct `file_get_contents()` or `json_decode()` configuration path.

## Isolated gates completed

- exact top-level root gate;
- Composer user-command-only gate;
- PHP lint;
- JSON parse;
- no OWASYS leakage into generic framework code;
- homonymous four-marker interface audit: 21 concrete framework classes;
- one OWASYS public PHP entrypoint;
- canonical scaffold and actual atomic scaffold write;
- HMAC-authenticated REST execution;
- invalid-signature rejection;
- insufficient-role rejection;
- execution FSM success path;
- allow-listed Composer process/stdin boundary;
- execution storage without parameters;
- Auth0 proxy trusted and untrusted recipes;
- ZIP integrity.

## Pending owner gates

- real `composer.phar` invocation on Windows;
- `composer dump-autoload`;
- existing OPUS tools/recipes invoked outside Composer aliases;
- actual Registry SQLite and password flows;
- current OWASYS pages against the REST backend;
- browser and no-JavaScript acceptance;
- Auth0 proxy, HTTPS and bastion deployment;
- Windows/Linux parity.

## `owasys_old`

Do not delete `sites/owasys_old`. It remains the P117Q rejected duplicate reference until explicit owner authorization after browser acceptance and reference scan.

## Permanent rules

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
ONLY THE OWNER-CONFIRMED OPUS ROOT IS ADMITTED.
NO ROOT BIN.
NO ROOT LOWERCASE CONFIG.
NO ROOT PUBLIC.
COMPOSER EXPOSES USER COMMANDS ONLY.
OPUS IS THE FRAMEWORK.
OWASYS IS AN OPUS APPLICATION.
CURRENT OWASYS PAGES ARE THE FRONTEND.
REST + COMPOSER IS THE OWASYS BACKEND.
CREATED SITES ARE INDEPENDENT OPUS APPLICATIONS.
SECRETS NEVER ENTER ARGV OR LOGS.
SCORE AND BACKEND-FIRST REMAIN MANDATORY.
