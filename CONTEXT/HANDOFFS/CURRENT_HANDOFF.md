# CURRENT HANDOFF — MAESTRO WORKSPACE

Date: 2026-07-23

## Active milestone

P117U — canonical OWASYS secured REST + Composer backend.

```text
OPUS = generic framework
OWASYS = an OPUS application
Current OWASYS SCORE pages = frontend
REST + Composer = OWASYS backend
Created sites = independent OPUS applications
```

## Source of truth

- OPUS: `philstephibanez-wq/OPUS`, branch `master`
- differential base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- specification: `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`
- handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`
- site contract: `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`

## Only admitted OPUS root

Directories:

```text
.git .github application Config DOC Opus packages runtime scripts sites tools vendor
```

Root files:

```text
.gitignore AGENTS.md composer.json composer.lock composer.phar LICENSE README.md
```

Casing is contractual. No root `bin/`, lowercase root `config/`, root `public/` or new root.

## Rejected artifacts

Do not apply:

- P117S SHA-256 `acb79eec5cc0ce4023e79e53963f203a2c143b78fa754a4411036170f3c4220e`;
- P117T SHA-256 `ad1494d92f068789d8363b4b6a7a823ff7b6be189d36f66724f92fec91baf2c5`.

## Authoritative differential

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`
- files: 57
- bytes: 73,261
- top-level entries: `composer.json`, `Opus`, `scripts`, `sites`
- ZIP integrity verified
- no README, manifest, report, smoke, audit or check helper
- OPUS not written directly by the assistant

## Composer

Composer installs OPUS/dependencies and exposes user commands only. All scripts delegate to `scripts/opus.php`. Smokes, audits, tests and recipes are forbidden in `composer.json`.

Generic site commands belong to OPUS. OWASYS Registry/password commands are application-owned providers under `sites/owasys/` discovered through `sites/*/config/composer.commands.json`.

## OWASYS pipeline

```text
SCORE frontend
-> browser locale
-> SSO
-> ACL
-> OWASYS FSM
-> signed typed REST request
-> bearer/HMAC or Auth0 proxy authentication
-> execution FSM
-> operation allow-list
-> Composer
-> scripts/opus.php
-> generic OPUS service or OWASYS command provider
-> structured result
-> ViewModel
-> SCORE
```

The web Registry model opens no SQLite database. Registry persistence and password change occur only in the OWASYS command provider reached through REST then Composer.

## Canonical OWASYS site

OWASYS declares `OPUS_SITE_STANDARD_CONTRACT_CORE` with role `standard-opus-application`. Its FSM path is resolved from `site.json`; its signal-route registry, declared FSM, ACL, SSO and Singleton are validated without treating OWASYS as a generated site.

OWASYS has one PHP file under `www/`:

`sites/owasys/www/index.php`

It delegates only to `application/default/bootstrap.php`.

Canonical layout:

`sites/owasys/application/default/layouts/layout.score`

Delete the obsolete `sites/owasys/application/default/templates/layout.score` after extracting P117U.

## Framework rules

Every concrete framework class implements its homonymous four-marker interface. No OWASYS identifier or business implementation belongs under `Opus/` or `scripts/`.

Configuration crosses `File` plus `StructuredFileLoader` and explicit OPUS Json/Yaml/Xml parsers. Scaffold writes use `File::writeAtomic`.

`SiteScaffoldPlan` is the unique canonical plan; `FullstackApplicationScaffoldPlan` is only its compatibility adapter.

## Validation state

Green in isolated gates:

- exact root and ZIP layout;
- PHP lint: 49 files;
- JSON parse: 7 files;
- Composer user-command-only check;
- no OWASYS leakage into generic code;
- 21 concrete framework interface checks;
- one OWASYS public PHP entrypoint;
- canonical scaffold and atomic writer;
- standard application validation using signal routes and declared FSM;
- HMAC success, invalid-signature rejection and ACL rejection;
- execution FSM and Composer process/stdin boundary;
- execution storage without parameters;
- Auth0 trusted/untrusted recipes.

Pending owner gates:

- real Windows `composer.phar` and autoload;
- existing OPUS tools/recipes outside Composer aliases;
- Registry/password workflows;
- browser/no-JavaScript acceptance;
- Auth0/HTTPS/bastion;
- Windows/Linux parity.

## `owasys_old`

Do not delete `sites/owasys_old`. Deletion requires owner authorization after browser acceptance and reference scan.

## Permanent rules

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
ONLY THE OWNER-CONFIRMED OPUS ROOT IS ADMITTED.
COMPOSER EXPOSES USER COMMANDS ONLY.
OPUS IS THE FRAMEWORK.
OWASYS IS AN OPUS APPLICATION.
OWASYS PAGES ARE THE FRONTEND.
REST + COMPOSER IS THE OWASYS BACKEND.
CREATED SITES ARE INDEPENDENT OPUS APPLICATIONS.
SECRETS NEVER ENTER ARGV OR LOGS.
SCORE AND BACKEND-FIRST ARE MANDATORY.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
