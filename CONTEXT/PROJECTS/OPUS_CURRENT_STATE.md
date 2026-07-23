# OPUS CURRENT STATE

Last updated: 2026-07-23.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head / P117U base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Owner local repo: `H:/OPUS` only as a local detail

## Active milestone

P117U — canonical secured REST + Composer backend for the current OWASYS SCORE frontend, with mandatory HF1 and HF2.

- canonical specification: `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`
- HF2 specification: `CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF2_COMPOSER_RESOLUTION_SPEC.md`
- canonical handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`
- HF2 handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_P117U_HF2_COMPOSER_RESOLUTION_2026-07-23.md`

## Immutable separation

```text
OPUS = framework
OWASYS = OPUS application
OWASYS current pages = frontend
REST + Composer = OWASYS backend
Created sites = independent OPUS applications
```

Generic code contains no OWASYS business implementation. Registry/password implementations remain under `sites/owasys/`.

## Root contract

The owner-confirmed root admits only `.git`, `.github`, `application`, `Config`, `DOC`, `Opus`, `packages`, `runtime`, `scripts`, `sites`, `tools`, `vendor` and declared root files.

Root `bin/`, lowercase root `config/`, root `public/` and every new top-level directory are forbidden.

## Mandatory artifact order

### P117U

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`
- files: 57
- bytes: 73,261

### HF1

- ZIP: `opus_owasys_p117u_hf1_fsm_contract.zip`
- SHA-256: `e711af28142a5ad287569c5107b99d41065498ea3bed70ec13b977007ae605d2`
- fixes undefined `SUPPORTED_CONTRACTS`

### HF2

- ZIP: `opus_owasys_p117u_hf2_composer_resolution.zip`
- SHA-256: `c26d32f3b1446c8bb65c668ab8c7c785783162855f8b5b02e57dd61e8e97f980`
- files: 4
- bytes: 10,447

HF2 changes only:

```text
Opus/Rcp/Rest/RcpRestServer.php
Opus/Rcp/Rest/RcpRestClient.php
sites/owasys/application/api/controllers/BackendApiController.php
sites/owasys/config/backend.rest.json
```

P117S and P117T are rejected.

## Owner runtime incidents

### HF1 incident

```text
Undefined constant Opus\Fsm\FsmProcessor::SUPPORTED_CONTRACTS
```

Corrected by HF1.

### Process-topology incident

```text
OPUS_RCP_CONNECTION_FAILED
```

Cause: frontend port `8000` running without mandatory backend port `8792`.

### HF2 incident

Backend:

```text
OPUS_RCP_COMPOSER_PHAR_MISSING:composer.phar
```

Frontend consequence:

```text
OPUS_JSON_PARSE_FAILED:http://127.0.0.1:8792/api/v1/executions:Syntax error
```

Cause: backend hardcoded a local `composer.phar` absent from the owner-confirmed root; client parsed the resulting HTML fatal page as JSON.

Corrected by HF2.

## Composer runtime after HF2

`backend.rest.json` declares the generic token `@composer`.

Trusted resolution order:

1. absolute `OPUS_COMPOSER_PHAR` operator override;
2. root-local `composer.phar`;
3. `composer.phar` discovered through `PATH` directories;
4. standard Windows Composer locations.

Execution remains `PHP_BINARY <absolute-composer.phar>` through an argument array with shell bypass. Browser and REST payloads cannot select an executable, PHAR, working directory or shell fragment.

## REST error boundary after HF2

The generic client validates HTTP status and JSON media type before parsing.

- HTML backend 500 becomes `OPUS_RCP_BACKEND_HTTP_ERROR:500`.
- malformed backend JSON becomes a stable OPUS response error.
- a controlled JSON 503 may propagate only a validated uppercase error code.

The OWASYS API controller emits initialization failures as JSON 503 using `OPUS_RCP_REST_ERROR_V1`, without HTML, stack trace or `echo`.

## OWASYS state

OWASYS remains `OPUS_SITE_STANDARD_CONTRACT_CORE`, role `standard-opus-application`, Singleton, FSM/I18n/ACL/SSO driven and SCORE-rendered.

One public PHP entrypoint exists: `sites/owasys/www/index.php`.

The web Registry model performs no SQLite access. Registry and password mutations remain application-owned Composer commands executed backend-side.

Two processes are mandatory:

```text
127.0.0.1:8792 = REST + Composer backend
127.0.0.1:8000 = SCORE frontend
```

Both processes load the same secret environment file.

## Framework contracts

Every concrete framework class implements its homonymous four-marker interface. HF2 introduces no new concrete framework class.

Configuration reads cross `File` plus `StructuredFileLoader` and explicit OPUS Json/Yaml/Xml parsers.

## Validation

Green before owner retest:

- P117U root/ZIP contract;
- HF1 FSM construction;
- HF2 PHP lint and JSON parse;
- Composer PHAR discovery through `PATH`;
- Composer execution from a path containing spaces;
- HTML HTTP 500 error boundary;
- controlled JSON 503 error propagation;
- backend initialization JSON 503;
- HF2 ZIP integrity.

Pending owner validation:

- apply HF2;
- restart backend then frontend;
- verify backend `/api/v1/status`;
- verify Registry synchronization through real Composer;
- password workflow;
- browser/no-JavaScript;
- HTTPS/Auth0/bastion;
- Windows/Linux parity.

## `owasys_old`

Do not delete until explicit owner authorization after browser acceptance and reference scan.

## Roadmap

1. Apply P117U, HF1, then HF2.
2. Start backend on `8792` and verify status.
3. Start frontend on `8000` with identical secrets.
4. Validate Registry and password workflows.
5. Commit OPUS after owner acceptance.
6. Decide `owasys_old` separately.
7. Demo, User Book, Reference Book, LSTSAR, KB.
