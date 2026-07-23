# CURRENT HANDOFF — MAESTRO WORKSPACE

Date: 2026-07-23

## Active milestone

P117U — canonical OWASYS secured REST + Composer backend, with mandatory HF1 and HF2.

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
- P117U handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`
- HF2 handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_P117U_HF2_COMPOSER_RESOLUTION_2026-07-23.md`
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

## Mandatory artifact order

### 1. P117U base

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`
- files: 57
- bytes: 73,261

### 2. HF1 — FSM contract

- ZIP: `opus_owasys_p117u_hf1_fsm_contract.zip`
- SHA-256: `e711af28142a5ad287569c5107b99d41065498ea3bed70ec13b977007ae605d2`
- file: `Opus/Fsm/FsmProcessor.php`
- fixes undefined `SUPPORTED_CONTRACTS`

### 3. HF2 — Composer resolution and HTTP boundary

- ZIP: `opus_owasys_p117u_hf2_composer_resolution.zip`
- SHA-256: `c26d32f3b1446c8bb65c668ab8c7c785783162855f8b5b02e57dd61e8e97f980`
- files: 4
- bytes: 10,447

HF2 files:

```text
Opus/Rcp/Rest/RcpRestServer.php
Opus/Rcp/Rest/RcpRestClient.php
sites/owasys/application/api/controllers/BackendApiController.php
sites/owasys/config/backend.rest.json
```

Rejected: P117S and P117T.

## Owner incidents recorded

1. `Undefined constant Opus\Fsm\FsmProcessor::SUPPORTED_CONTRACTS` — fixed by HF1.
2. `OPUS_RCP_CONNECTION_FAILED` — frontend started without backend process.
3. `OPUS_RCP_COMPOSER_PHAR_MISSING:composer.phar` — backend incorrectly required a local PHAR although Composer is globally installed.
4. Frontend `OPUS_JSON_PARSE_FAILED` — HTML backend fatal was incorrectly passed to the JSON parser.

HF2 fixes incidents 3 and 4.

## Composer runtime contract

`sites/owasys/config/backend.rest.json` declares:

```json
"composer_command": ["@composer"]
```

Generic OPUS resolution order:

1. absolute operator override `OPUS_COMPOSER_PHAR`;
2. `<OPUS_ROOT>/composer.phar`;
3. `composer.phar` found beside directories in `PATH`;
4. standard Windows Composer directories derived from `ProgramData`, `APPDATA`, `LOCALAPPDATA` and `USERPROFILE`.

The executed command remains strictly:

```text
PHP_BINARY <absolute-composer.phar>
```

No browser value, REST parameter, operation identifier, executable name, shell fragment or working-directory override participates in resolution.

## HTTP error boundary

The REST client validates HTTP status and JSON media type before parsing JSON.

- HTML backend error: `OPUS_RCP_BACKEND_HTTP_ERROR:<status>`.
- malformed JSON response: `OPUS_RCP_RESPONSE_JSON_INVALID` or `OPUS_RCP_BACKEND_JSON_INVALID:<status>`.
- controlled JSON backend error: only a validated uppercase error code is propagated.

The OWASYS API controller catches initialization failures and emits JSON 503 with contract `OPUS_RCP_REST_ERROR_V1`. It does not emit an HTML fatal page.

## Mandatory process topology

Two independent PHP processes are required:

```text
127.0.0.1:8792 = OWASYS REST + Composer backend
127.0.0.1:8000 = current OWASYS SCORE frontend
```

Both use the same `sites/owasys/www/index.php` and the same secret environment values.

The frontend targets:

```text
http://127.0.0.1:8792/api/v1/executions
```

## Canonical restart order

1. Stop both PHP servers.
2. Apply HF2 after P117U and HF1.
3. Start backend on `8792` with `runtime/owasys/backend-env.cmd`.
4. Verify `GET /api/v1/status`.
5. Start frontend on `8000` with the same environment file.
6. Open `/fr-FR/applications`.

If automatic Composer discovery fails, run `where composer`. Set `OPUS_COMPOSER_PHAR` to the absolute PHAR path only when the global wrapper directory does not expose `composer.phar` directly.

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

No direct Registry or password mutation is permitted in the frontend.

## Framework rules

Every concrete framework class implements its homonymous four-marker interface. No OWASYS business implementation belongs under `Opus/` or `scripts/`.

Configuration crosses `File` plus `StructuredFileLoader` and explicit OPUS Json/Yaml/Xml parsers. Scaffold writes use `File::writeAtomic`.

## HF2 isolated validation

Green:

- PHP lint for three changed PHP files;
- backend JSON configuration parsing;
- Composer PHAR discovery through `PATH`;
- Composer execution from a path containing spaces;
- HTML HTTP 500 mapped to `OPUS_RCP_BACKEND_HTTP_ERROR:500`;
- JSON HTTP 503 mapped to `OPUS_RCP_COMPOSER_NOT_FOUND`;
- backend initialization failure emitted as JSON 503;
- ZIP integrity.

## Pending owner gates

- HF2 extraction and Windows restart;
- backend status response on `8792`;
- real Registry synchronization through Composer;
- password workflow;
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
