# CURRENT HANDOFF — MAESTRO WORKSPACE

Date: 2026-07-23

## Active milestone

P117U — canonical OWASYS secured REST + Composer backend, with mandatory HF1, HF2 and HF3.

```text
OPUS = generic framework
OWASYS = an OPUS application
Current OWASYS SCORE pages = frontend
REST + Composer = OWASYS backend
Created sites = independent OPUS applications
```

## Source of truth

- OPUS repository: `philstephibanez-wq/OPUS`
- branch: `master`
- current remote head reviewed: `05a0639cda2e271e8aa6e77e2b5d8f762d15f6b9`
- canonical specification: `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`
- HF2 specification: `CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF2_COMPOSER_RESOLUTION_SPEC.md`
- HF3 specification: `CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF3_COMPOSER_RESULT_CONTRACT_SPEC.md`
- canonical P117U handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`
- HF2 handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_P117U_HF2_COMPOSER_RESOLUTION_2026-07-23.md`
- HF3 handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_P117U_HF3_COMPOSER_RESULT_CONTRACT_2026-07-23.md`
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

### 3. HF2 — Composer discovery and HTTP/JSON boundary

- ZIP: `opus_owasys_p117u_hf2_composer_resolution.zip`
- SHA-256: `c26d32f3b1446c8bb65c668ab8c7c785783162855f8b5b02e57dd61e8e97f980`
- files: 4
- bytes: 10,447

### 4. HF3 — Composer result contract

- ZIP: `opus_owasys_p117u_hf3_composer_result_contract.zip`
- SHA-256: `f0860491df311a997d92c0a82796e7e11921911721bf02e3a8b45aece4ce6f17`
- files: 3
- bytes: 5,965

HF3 contents:

```text
.gitignore
Opus/Console/OpusConsoleApplication.php
Opus/Rcp/Composer/ComposerCommandExecutor.php
```

P117S and P117T remain rejected.

## Owner runtime incidents

1. `Undefined constant Opus\Fsm\FsmProcessor::SUPPORTED_CONTRACTS` — corrected by HF1.
2. `OPUS_RCP_CONNECTION_FAILED` — frontend started without the mandatory backend process.
3. `OPUS_RCP_COMPOSER_PHAR_MISSING:composer.phar` — local PHAR was incorrectly mandatory; corrected by HF2.
4. HTML backend fatal parsed as JSON — corrected by HF2.
5. `OPUS_RCP_COMPOSER_RESULT_MISSING` — Composer output envelope could be multiline or prefixed; corrected by HF3.

## HF3 result boundary

An RCP stdin request with contract `OPUS_RCP_COMPOSER_COMMAND_REQUEST_V1` now forces `OpusConsoleApplication` to emit machine JSON, independently of command-line option forwarding.

`ComposerCommandExecutor` extracts complete balanced JSON objects from stdout and accepts only:

```text
OPUS_CONSOLE_COMMAND_RESULT_V1
OPUS_CONSOLE_ERROR_V1
```

It supports Composer preamble output and formatted multiline JSON. Arbitrary stdout/stderr is not returned to REST callers or persisted.

## Critical security incident

The public OPUS repository currently tracks:

```text
runtime/owasys/backend-env.cmd
```

The file contains all three OWASYS backend secret values. The values must not be copied into documentation, responses or artifacts.

All existing values are compromised and must be rotated. Required owner action:

1. stop both servers;
2. remove the file from the Git index and local disk;
3. commit and push the deletion plus the HF3 `.gitignore` rule;
4. generate new token, HMAC and Auth0-proxy secret values;
5. restart both processes with the new values.

Deletion alone is insufficient because the previous values are already present in public Git history. Rotation is mandatory. History purification remains a separate explicit owner-controlled operation.

## Mandatory process topology

Two independent PHP processes remain required:

```text
127.0.0.1:8792 = OWASYS REST + Composer backend
127.0.0.1:8000 = current OWASYS SCORE frontend
```

Both use the same canonical `sites/owasys/www/index.php` and the same newly generated environment values.

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

Every concrete framework class implements its homonymous four-marker interface. HF3 introduces no new concrete class and no OWASYS business implementation under `Opus/` or `scripts/`.

Configuration crosses `File` plus `StructuredFileLoader` and explicit OPUS Json/Yaml/Xml parsers.

## HF3 validation

Green:

- exact reproduction of the previous `OPUS_RCP_COMPOSER_RESULT_MISSING`;
- Composer preamble plus multiline result accepted after HF3;
- nested JSON and escaped-string braces handled;
- RCP stdin forces compact JSON output;
- safe stderr code propagation;
- PHP lint for both modified classes;
- existing homonymous interfaces retained;
- exact ZIP content and integrity.

## Pending owner gates

- apply HF3;
- remove and rotate exposed secrets;
- regenerate Composer autoload;
- backend status on `8792`;
- real Registry synchronization through Composer;
- Registry selection, clear and creation-start;
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
SECRETS NEVER ENTER GIT, ARGV, LOGS OR DELIVERY ARTIFACTS.
SCORE AND BACKEND-FIRST ARE MANDATORY.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
