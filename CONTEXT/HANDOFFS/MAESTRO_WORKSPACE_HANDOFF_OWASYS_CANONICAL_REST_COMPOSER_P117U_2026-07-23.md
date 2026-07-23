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

No OWASYS identifier or business implementation exists in delivered `Opus/` or `scripts/` code.

## Canonical root

P117U introduces only:

```text
composer.json
Opus/
scripts/
sites/
```

No root `bin/`, lowercase root `config/`, root `public/` or new top-level directory exists.

## Rejected artifacts

Do not apply:

- P117S SHA-256 `acb79eec5cc0ce4023e79e53963f203a2c143b78fa754a4411036170f3c4220e`;
- P117T SHA-256 `ad1494d92f068789d8363b4b6a7a823ff7b6be189d36f66724f92fec91baf2c5`.

P117T is rejected because root `bin/` and lowercase root `config/` violate the admitted OPUS root.

## Authoritative differential

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`
- Files: 57
- Bytes: 73,261
- Base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Top-level entries: `composer.json`, `Opus`, `scripts`, `sites`
- ZIP integrity verified
- no README, manifest, report, smoke, audit or check helper
- OPUS repository not written directly by the assistant

## Framework evolution

P117U supplies generic OPUS components for:

- Composer-facing console under `scripts/opus.php`;
- site command service and export;
- application-owned command-provider discovery;
- typed REST/RCP client and server;
- Composer operation registry and process executor;
- bearer/HMAC and Auth0-proxy authentication;
- execution FSM and idempotency store;
- generated application runtime;
- canonical site scaffold and compatibility adapter.

`SiteScaffoldPlan` is the only architecture source. `FullstackApplicationScaffoldPlan` delegates to it.

`ScaffoldWriter` uses `File::writeAtomic` and explicit CLI stream output. `FsmProcessor`, `FsmSiteLoader`, `LocalPasswordSsoProvider` and `Response` use generic contracts, structured File/parsers and non-echo emission.

Every new concrete framework class implements its homonymous four-marker interface. Existing modified classes retain their existing homonymous four-marker interfaces.

## OWASYS canonicalization

All OWASYS-specific implementation remains under `sites/owasys/`.

OWASYS is now declared with the canonical `OPUS_SITE_STANDARD_CONTRACT_CORE` while retaining role `standard-opus-application`. The generic validator resolves its FSM path from `site.json`, validates `OPUS_SIGNAL_ROUTES_V2`, the declared FSM, ACL deny-by-default, SSO and Singleton without pretending that OWASYS is a generated site.

The canonical OWASYS layout is:

`sites/owasys/application/default/layouts/layout.score`

`OwasysScorePageRenderer` renders that path. The obsolete `sites/owasys/application/default/templates/layout.score` must be deleted after applying the ZIP.

The web Registry model opens no SQLite database. Registry persistence and password changes occur only in the OWASYS command provider reached through REST then Composer.

OWASYS has one public PHP entrypoint only:

`sites/owasys/www/index.php`

It delegates only to `application/default/bootstrap.php`; REST and frontend routes use this same front controller.

## Composer

`composer.json` contains user commands only and delegates to `scripts/opus.php`. No smoke, audit, test or recipe alias remains.

Generic commands create, validate, export and serve sites and manage language/page/rubric structures. OWASYS command scripts invoke application-owned Registry/password commands discovered from `sites/owasys/config/composer.commands.json`.

## Security

- typed operation allow-list;
- bearer plus complete-body HMAC;
- timestamp, expiry, nonce and replay checks;
- backend operation ACL;
- OWASYS provider ACL revalidation;
- Composer process argument array with shell bypass;
- secret input through request body and process stdin only;
- execution records contain no input parameters;
- generic Auth0 proxy provider validates trusted proxy/bastion address and shared secret.

## Configuration

Changed configuration reads use `File` plus `StructuredFileLoader` and explicit OPUS parsers. The differential contains no direct configuration `file_get_contents()` or `json_decode()` path.

## Isolated gates completed

- exact top-level root gate;
- Composer user-command-only gate;
- PHP lint: 49 PHP files;
- JSON parse: 7 JSON files;
- no OWASYS leakage into generic code;
- homonymous four-marker audit: 21 concrete framework classes;
- one OWASYS public PHP entrypoint;
- canonical scaffold and actual atomic write;
- canonical standard-application validation with signal routes and declared FSM;
- HMAC-authenticated REST execution;
- invalid-signature rejection;
- insufficient-role rejection;
- execution FSM success path;
- allow-listed Composer process/stdin boundary;
- execution storage without parameters;
- Auth0 trusted/untrusted recipes;
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
