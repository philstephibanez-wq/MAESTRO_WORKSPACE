# CURRENT HANDOFF — MAESTRO WORKSPACE

Date: 2026-07-23

## Active milestone

P117U — canonical OWASYS secured REST + Composer backend, with mandatory HF1 FSM correction.

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

## Authoritative code artifacts

Base differential:

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`
- files: 57
- bytes: 73,261

Mandatory hotfix after P117U:

- ZIP: `opus_owasys_p117u_hf1_fsm_contract.zip`
- SHA-256: `e711af28142a5ad287569c5107b99d41065498ea3bed70ec13b977007ae605d2`
- file: `Opus/Fsm/FsmProcessor.php`
- cause: invalid reference to undefined `SUPPORTED_CONTRACTS` constant

Rejected: P117S and P117T.

## Mandatory OWASYS process topology

OWASYS is not a single-process application after the secured REST/Composer boundary is enabled.

Two independent PHP processes are mandatory:

```text
127.0.0.1:8792 = OWASYS REST + Composer backend
127.0.0.1:8000 = current OWASYS SCORE frontend
```

Both processes use the same canonical `sites/owasys/www/index.php`; routing selects `/api/v1/...` for the backend and normal locale routes for the frontend.

The frontend client configuration targets:

```text
http://127.0.0.1:8792/api/v1/executions
```

Starting only the frontend produces the explicit blocking error:

```text
OPUS_RCP_CONNECTION_FAILED
```

This is not a permitted local fallback condition. It means the required backend process is absent or unreachable.

The two terminals must load identical values for:

- `OPUS_OWASYS_BACKEND_TOKEN`;
- `OPUS_OWASYS_BACKEND_HMAC`;
- `OPUS_OWASYS_AUTH0_PROXY_SECRET`.

The backend must be started and its status endpoint verified before the frontend is opened.

## Canonical launch order

1. Generate a temporary `runtime/owasys/backend-env.cmd` containing the three environment secrets.
2. Terminal backend: call that file, then start port `8792`.
3. Verify `GET http://127.0.0.1:8792/api/v1/status`.
4. Terminal frontend: call the same file, then start port `8000`.
5. Open `http://127.0.0.1:8000/fr-FR/applications`.
6. Delete the environment file after both servers are stopped.

A mono-process command such as only:

```text
php -S 127.0.0.1:8000 -t sites\owasys\www sites\owasys\www\index.php
```

is incomplete and must never be presented as a complete OWASYS launch recipe.

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

OWASYS declares `OPUS_SITE_STANDARD_CONTRACT_CORE` with role `standard-opus-application`.

One PHP file exists under `www`:

`sites/owasys/www/index.php`

It delegates only to `application/default/bootstrap.php`.

Canonical layout:

`sites/owasys/application/default/layouts/layout.score`

Delete obsolete `sites/owasys/application/default/templates/layout.score` after applying P117U.

## Framework rules

Every concrete framework class implements its homonymous four-marker interface. No OWASYS identifier or business implementation belongs under `Opus/` or `scripts/`.

Configuration crosses `File` plus `StructuredFileLoader` and explicit OPUS Json/Yaml/Xml parsers. Scaffold writes use `File::writeAtomic`.

`SiteScaffoldPlan` is the unique canonical plan; `FullstackApplicationScaffoldPlan` is only its compatibility adapter.

## Owner incidents recorded

1. `Undefined constant Opus\Fsm\FsmProcessor::SUPPORTED_CONTRACTS` — corrected by mandatory HF1.
2. `OPUS_RCP_CONNECTION_FAILED` while only port `8000` was running — operational cause confirmed: backend port `8792` not started.

## Pending owner gates

- real Windows Composer/autoload;
- backend status response on `8792`;
- Registry/password workflows;
- browser/no-JavaScript acceptance;
- Auth0/HTTPS/bastion;
- Windows/Linux parity.

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
THE REST BACKEND IS A MANDATORY SEPARATE PROCESS.
CREATED SITES ARE INDEPENDENT OPUS APPLICATIONS.
SECRETS NEVER ENTER ARGV OR LOGS.
SCORE AND BACKEND-FIRST ARE MANDATORY.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
