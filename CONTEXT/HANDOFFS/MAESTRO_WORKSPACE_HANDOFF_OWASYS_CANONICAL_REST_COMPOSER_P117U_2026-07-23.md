# MAESTRO_WORKSPACE HANDOFF — OWASYS P117U CANONICAL REST + COMPOSER

Date: 2026-07-23
Status: base differential prepared; mandatory HF1 and HF2 required; owner Windows/browser retest pending
OPUS base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`

## Binding separation

```text
OPUS = generic framework and generic Composer user surface
OWASYS = an OPUS application
Current OWASYS SCORE pages = frontend
Secured REST + Composer = OWASYS backend
Created sites = independent OPUS applications
```

No OWASYS business implementation belongs in generic `Opus/` or `scripts/` code.

## Canonical root

P117U introduces only:

```text
composer.json
Opus/
scripts/
sites/
```

No root `bin/`, lowercase root `config/`, root `public/` or new top-level directory exists.

## Required artifacts

### P117U base

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`
- Files: 57
- Bytes: 73,261

### Mandatory HF1

- ZIP: `opus_owasys_p117u_hf1_fsm_contract.zip`
- SHA-256: `e711af28142a5ad287569c5107b99d41065498ea3bed70ec13b977007ae605d2`
- fixes undefined `SUPPORTED_CONTRACTS`

### Mandatory HF2

- ZIP: `opus_owasys_p117u_hf2_composer_resolution.zip`
- SHA-256: `c26d32f3b1446c8bb65c668ab8c7c785783162855f8b5b02e57dd61e8e97f980`
- Files: 4
- Bytes: 10,447

HF2 handoff:

`CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_P117U_HF2_COMPOSER_RESOLUTION_2026-07-23.md`

HF2 specification:

`CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF2_COMPOSER_RESOLUTION_SPEC.md`

P117S and P117T remain rejected.

## Framework evolution

P117U supplies generic OPUS console, site services, application-command discovery, typed REST/RCP client/server, Composer operation registry/executor, bearer/HMAC and Auth0-proxy authentication, execution FSM/store, generated runtime and canonical scaffold components.

Every new concrete framework class implements its homonymous four-marker interface. Existing modified classes retain their interfaces.

`SiteScaffoldPlan` is the only architecture source. `FullstackApplicationScaffoldPlan` delegates to it. `ScaffoldWriter` uses `File::writeAtomic`.

HF1 corrects the FSM contract lookup.

HF2 corrects the generic Composer runtime boundary:

- trusted local/global Composer PHAR discovery;
- no browser-selected executable or shell command;
- HTTP status and media-type validation before JSON parsing;
- controlled OWASYS JSON 503 initialization response.

## OWASYS canonicalization

All OWASYS-specific implementation remains under `sites/owasys/`.

OWASYS declares `OPUS_SITE_STANDARD_CONTRACT_CORE`, role `standard-opus-application`. Its FSM, routes, ACL, SSO, Singleton and modules are validated from application configuration.

Canonical layout:

`sites/owasys/application/default/layouts/layout.score`

The obsolete `sites/owasys/application/default/templates/layout.score` must be deleted after applying P117U.

The frontend Registry model opens no SQLite database. Registry persistence and password changes occur only in OWASYS command providers reached through REST then Composer.

One public PHP entrypoint exists:

`sites/owasys/www/index.php`

## Mandatory process topology

```text
127.0.0.1:8792 = secured REST + Composer backend
127.0.0.1:8000 = current SCORE frontend
```

Both processes use the same `sites/owasys/www/index.php` and identical secret environment values. The backend must be started and checked before the frontend.

## Owner runtime incidents

1. FSM undefined constant — corrected by HF1.
2. Frontend launched without backend — corrected operationally by mandatory two-process launch order.
3. Backend required absent root `composer.phar` — corrected by HF2 trusted Composer discovery.
4. Frontend parsed backend HTML fatal as JSON — corrected by HF2 HTTP/JSON boundary.

## Security

- typed operation allow-list;
- bearer plus complete-body HMAC;
- timestamp, expiry, nonce and replay checks;
- backend ACL and provider ACL revalidation;
- Composer process argument array with shell bypass;
- secrets in request body/process stdin only;
- no input parameters in execution records;
- Auth0 proxy/bastion validation;
- no local business fallback.

## Configuration

Changed configuration reads use `File` plus `StructuredFileLoader` and explicit OPUS parsers. No root configuration directory is added.

## Validation completed

P117U/HF1 gates plus HF2 isolated gates are green:

- PHP lint and JSON parsing;
- root contract and ZIP integrity;
- homonymous framework interfaces;
- canonical scaffold/atomic write;
- FSM contract construction;
- Composer PHAR discovery through `PATH`;
- Composer execution from a path containing spaces;
- HTML HTTP 500 stable error mapping;
- JSON HTTP 503 stable error propagation;
- backend initialization JSON 503.

## Pending owner gates

- apply HF2;
- restart backend then frontend;
- verify backend `/api/v1/status`;
- verify real Registry synchronization through Composer;
- password workflow;
- browser/no-JavaScript acceptance;
- Auth0/HTTPS/bastion;
- Windows/Linux parity.

## `owasys_old`

Do not delete `sites/owasys_old` until explicit owner authorization after browser acceptance and reference scan.

## Permanent rules

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
ONLY THE OWNER-CONFIRMED OPUS ROOT IS ADMITTED.
COMPOSER EXPOSES USER COMMANDS ONLY.
OPUS IS THE FRAMEWORK.
OWASYS IS AN OPUS APPLICATION.
CURRENT OWASYS PAGES ARE THE FRONTEND.
REST + COMPOSER IS THE OWASYS BACKEND.
CREATED SITES ARE INDEPENDENT OPUS APPLICATIONS.
SECRETS NEVER ENTER ARGV OR LOGS.
SCORE AND BACKEND-FIRST REMAIN MANDATORY.
