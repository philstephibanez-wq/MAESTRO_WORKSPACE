# CURRENT HANDOFF — MAESTRO WORKSPACE

Date: 2026-07-24

## Active milestone

P117U — canonical OWASYS secured REST + Composer backend, with mandatory HF1, HF2, HF3 and HF4.

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
- current remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`
- canonical specification: `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`
- HF2 specification: `CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF2_COMPOSER_RESOLUTION_SPEC.md`
- HF3 specification: `CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF3_COMPOSER_RESULT_CONTRACT_SPEC.md`
- HF4 specification: `CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF4_LOGGER_PROFILER_EXITCODE_SPEC.md`
- HF4 handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_P117U_HF4_LOGGER_PROFILER_EXITCODE_2026-07-24.md`
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

No root `bin/`, lowercase root `config/`, root `public/` or new root.

## Mandatory artifact order

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

### HF4

- ZIP: `opus_owasys_p117u_hf4_logger_profiler_exitcode.zip`
- SHA-256: `2f48a42be49153a3c67186e26553f884c6401486e42a3747db9716d4fb1e1b07`
- files: 7
- payload bytes: 52,274

```text
Opus/Log/LoggerInterface.php
Opus/Profiler/ProfilerInterface.php
Opus/Profiler/TraceInterface.php
Opus/Rcp/Composer/ComposerCommandExecutor.php
Opus/Rcp/Rest/RcpRestClient.php
Opus/Rcp/Rest/RcpRestServer.php
sites/owasys/config/backend.rest.json
```

P117S and P117T remain rejected.

## Owner runtime incidents

1. undefined FSM constant — HF1;
2. absent backend process — mandatory two-process topology;
3. local Composer PHAR assumption and HTML/JSON boundary — HF2;
4. multiline/prefixed Composer result not parsed — HF3;
5. generic `OPUS_RCP_COMPOSER_COMMAND_FAILED` with no log or profiler trace — HF4.

## HF4 diagnostics contract

The existing OPUS `Logger` and `Profiler` are now injected into the generic RCP server and Composer executor.

Runtime outputs:

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
```

One trace covers the complete REST execution, authentication, ACL, FSM, Composer process and result boundary. The REST response includes `trace_id`; the client exception appends `:TRACE:<TRACE_ID>`.

The log contains normalized exception information, FSM state, script identifier, process exit values, duration and bounded sanitized output excerpts. Request parameter values and secrets are never logged or profiled.

## Windows exit-code correction

The previous executor discarded `proc_close()` and trusted only `proc_get_status()['exitcode']`. Windows may report `-1` there for an already completed process.

HF4 resolves the process code from valid `proc_close()`, otherwise valid observed code, otherwise raises `OPUS_RCP_PROCESS_EXIT_CODE_UNAVAILABLE`. No silent success fallback exists.

## Framework contract

Every concrete class under `Opus/` implements a homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

HF4 makes the Logger/Profiler/Trace interfaces operational by declaring their existing public methods. It introduces no new concrete framework class.

## Mandatory process topology

```text
127.0.0.1:8792 = REST + Composer backend
127.0.0.1:8000 = current SCORE frontend
```

Both use the same local environment values and the same canonical `sites/owasys/www/index.php`.

## Critical secret status

The tracked runtime secret file was removed and pushed in OPUS commit `96884961248fc82bf5e13187a6ffcfffacb82d9f`.

Previously committed values remain compromised. Values pasted into diagnostic conversations must not be reused for remote or production deployment. Generate fresh values before nonlocal use.

## HF4 validation

Green:

- PHP lint for six PHP files;
- JSON configuration parse;
- existing Logger/Profiler/Trace implementation compatibility;
- structured log and profiler trace fixtures;
- output redaction;
- successful and failed Composer result fixtures;
- Windows observed `-1`, closed `0` exit-code fixture;
- exact ZIP content and integrity.

## Pending owner gates

- apply HF4 after HF3;
- regenerate optimized autoload;
- restart backend and frontend;
- verify backend status;
- reproduce Registry synchronization;
- inspect correlated log and profiler trace;
- Registry select/clear/creation-start;
- password workflow;
- browser/no-JavaScript;
- HTTPS/Auth0/bastion;
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
REST + COMPOSER IS THE OWASYS BACKEND.
LOGGER AND PROFILER ARE EXISTING OPUS SERVICES.
EVERY CONCRETE OPUS CLASS IS EXCEPTION-AWARE AND PROFILER-AWARE.
SECRETS NEVER ENTER GIT, ARGV, LOGS, PROFILER PAYLOADS OR DELIVERY ARTIFACTS.
SCORE AND BACKEND-FIRST ARE MANDATORY.
