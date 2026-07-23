# OPUS CURRENT STATE

Last updated: 2026-07-23.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `05a0639cda2e271e8aa6e77e2b5d8f762d15f6b9`
- Owner local repo: `H:/OPUS` only as a local detail

## Active milestone

P117U — canonical secured REST + Composer backend for the current OWASYS SCORE frontend, with mandatory HF1, HF2 and HF3.

- canonical specification: `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`
- HF2 specification: `CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF2_COMPOSER_RESOLUTION_SPEC.md`
- HF3 specification: `CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF3_COMPOSER_RESULT_CONTRACT_SPEC.md`
- canonical handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`
- HF2 handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_P117U_HF2_COMPOSER_RESOLUTION_2026-07-23.md`
- HF3 handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_P117U_HF3_COMPOSER_RESULT_CONTRACT_2026-07-23.md`

## Immutable separation

```text
OPUS = framework
OWASYS = OPUS application
OWASYS current pages = frontend
REST + Composer = OWASYS backend
Created sites = independent OPUS applications
```

Generic code contains no OWASYS business implementation. Registry and password implementations remain under `sites/owasys/`.

## Root contract

The owner-confirmed root admits only `.git`, `.github`, `application`, `Config`, `DOC`, `Opus`, `packages`, `runtime`, `scripts`, `sites`, `tools`, `vendor` and declared root files.

Root `bin/`, lowercase root `config/`, root `public/` and every new top-level directory are forbidden.

## Mandatory artifact stack

### P117U

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`

### HF1

- ZIP: `opus_owasys_p117u_hf1_fsm_contract.zip`
- SHA-256: `e711af28142a5ad287569c5107b99d41065498ea3bed70ec13b977007ae605d2`

### HF2

- ZIP: `opus_owasys_p117u_hf2_composer_resolution.zip`
- SHA-256: `c26d32f3b1446c8bb65c668ab8c7c785783162855f8b5b02e57dd61e8e97f980`

### HF3

- ZIP: `opus_owasys_p117u_hf3_composer_result_contract.zip`
- SHA-256: `f0860491df311a997d92c0a82796e7e11921911721bf02e3a8b45aece4ce6f17`
- files: 3
- bytes: 5,965

```text
.gitignore
Opus/Console/OpusConsoleApplication.php
Opus/Rcp/Composer/ComposerCommandExecutor.php
```

P117S and P117T remain rejected.

## Owner runtime incidents

### HF1

`Undefined constant Opus\Fsm\FsmProcessor::SUPPORTED_CONTRACTS` — corrected by HF1.

### Process topology

`OPUS_RCP_CONNECTION_FAILED` — backend process absent while frontend was running.

### HF2

`OPUS_RCP_COMPOSER_PHAR_MISSING:composer.phar` and HTML backend fatal parsed as JSON — corrected by HF2.

### HF3

`OPUS_RCP_COMPOSER_RESULT_MISSING` — the executor accepted only one-line JSON output. Composer-prefixed or multiline OPUS console output could not be reconstructed.

HF3 forces machine JSON for RCP stdin requests and extracts balanced JSON objects from Composer stdout while accepting only declared OPUS console contracts.

## Critical public-secret incident

The public OPUS repository currently tracks `runtime/owasys/backend-env.cmd` with the three OWASYS backend secret values.

The values are compromised and must be rotated. Required actions:

1. remove the file from the Git index and working tree;
2. commit and push the deletion plus HF3 `.gitignore` protection;
3. generate new token, HMAC and Auth0-proxy secrets;
4. restart backend and frontend with the new values.

The previous values remain compromised even after deletion because they entered public history. History purification is a separate explicit owner operation.

## Composer state

`composer.json` exposes user commands only and delegates to `scripts/opus.php`. No smoke, audit, test or recipe alias belongs in Composer.

For RCP execution, `OpusConsoleApplication` now forces `OPUS_CONSOLE_COMMAND_RESULT_V1` or `OPUS_CONSOLE_ERROR_V1` machine output from the stdin request contract.

`ComposerCommandExecutor` supports Composer preamble plus compact or multiline result envelopes. It does not return raw process output.

## OWASYS state

OWASYS remains `OPUS_SITE_STANDARD_CONTRACT_CORE`, role `standard-opus-application`, Singleton, FSM/I18n/ACL/SSO driven and SCORE-rendered.

One public PHP entrypoint exists: `sites/owasys/www/index.php`.

The web Registry model performs no SQLite access. Registry and password mutations remain application-owned Composer commands executed backend-side.

Two processes are mandatory:

```text
127.0.0.1:8792 = REST + Composer backend
127.0.0.1:8000 = SCORE frontend
```

## Framework contracts

Every concrete framework class implements its homonymous four-marker interface. HF3 modifies two existing classes and introduces no new concrete class.

Configuration reads cross `File` plus `StructuredFileLoader` and explicit OPUS Json/Yaml/Xml parsers.

## HF3 validation

Green:

- exact reproduction of pre-HF3 `OPUS_RCP_COMPOSER_RESULT_MISSING`;
- Composer preamble plus multiline OPUS result accepted after HF3;
- nested objects, braces and escaped quotes handled;
- RCP stdin forces compact machine JSON;
- safe stderr code propagation;
- PHP lint;
- homonymous interfaces retained;
- exact ZIP content and integrity.

Pending owner validation:

- apply HF3;
- remove and rotate exposed secrets;
- regenerate autoload;
- restart backend then frontend;
- Registry sync/select/clear/creation-start;
- password workflow;
- browser/no-JavaScript;
- HTTPS/Auth0/bastion;
- Windows/Linux parity.

## `owasys_old`

Do not delete until explicit owner authorization after browser acceptance and reference scan.

## Roadmap

1. Apply P117U, HF1, HF2, then HF3.
2. Remove tracked secret file and rotate all three values.
3. Start backend on `8792` and verify status.
4. Start frontend on `8000` with identical new secrets.
5. Validate Registry and password workflows.
6. Commit OPUS after owner acceptance.
7. Decide `owasys_old` separately.
8. Demo, User Book, Reference Book, LSTSAR, KB.
