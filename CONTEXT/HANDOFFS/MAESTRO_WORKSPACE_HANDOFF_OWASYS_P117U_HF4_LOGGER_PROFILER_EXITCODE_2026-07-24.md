# MAESTRO_WORKSPACE HANDOFF — OWASYS P117U HF4 LOGGER / PROFILER / EXIT CODE

Date: 2026-07-24
Status: differential prepared; isolated diagnostics and process gates green; owner Windows/browser retest pending
Applies after: P117U + HF1 + HF2 + HF3
OPUS remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`

## Runtime incident

The owner applied HF3 and restarted the mandatory backend/frontend processes. Registry synchronization then failed with:

```text
OPUS_RCP_COMPOSER_COMMAND_FAILED
```

No application log or profiler trace existed because `ComposerCommandExecutor` collected stderr and explicitly discarded it, while `RcpRestServer` persisted only normalized execution data.

## Contract decision

Every concrete class under `Opus/` is contractually exception-aware and profiler-aware through its homonymous interface extending the four standard markers.

HF4 therefore evolves the generic framework, not OWASYS-local diagnostics. It uses the existing:

- `Opus\Log\Logger`;
- `Opus\Profiler\Profiler`;
- `Opus\Profiler\Trace`.

No replacement logger or profiler is introduced.

## HF4 artifact

- ZIP: `opus_owasys_p117u_hf4_logger_profiler_exitcode.zip`
- SHA-256: `2f48a42be49153a3c67186e26553f884c6401486e42a3747db9716d4fb1e1b07`
- Files: 7
- Payload bytes: 52,274

Contents:

```text
Opus/Log/LoggerInterface.php
Opus/Profiler/ProfilerInterface.php
Opus/Profiler/TraceInterface.php
Opus/Rcp/Composer/ComposerCommandExecutor.php
Opus/Rcp/Rest/RcpRestClient.php
Opus/Rcp/Rest/RcpRestServer.php
sites/owasys/config/backend.rest.json
```

No new root, root file, Composer alias, smoke, audit, test, report, README, manifest, cache or temporary file is introduced.

## Runtime outputs

After HF4, one failed or successful REST/Composer execution creates:

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
```

The execution response contains `trace_id`. The frontend exception appends:

```text
:TRACE:<TRACE_ID>
```

The same identifier appears in the structured log and profiler file.

## Recorded diagnostics

The backend records only bounded diagnostic metadata:

- execution/operation/script identifiers;
- FSM events;
- normalized exception class/file/line;
- observed and closed process exit codes;
- duration;
- stdout/stderr sizes;
- sanitized and truncated excerpts on failure.

Parameters and secrets are not logged. Output excerpts redact password, token, secret, authorization, API key, HMAC patterns and long hexadecimal values.

## Probable generic command-failure cause corrected

The previous process boundary ignored `proc_close()` and used only the exit code reported by `proc_get_status()`.

On Windows that observed value may be `-1` after a completed process. A valid successful OPUS result could therefore become the generic command failure.

HF4 resolves:

```text
proc_close valid code
else proc_get_status valid code
else OPUS_RCP_PROCESS_EXIT_CODE_UNAVAILABLE
```

Both values are now visible in diagnostics.

## Interface evolution

Operational method signatures are added to:

- `LoggerInterface`;
- `ProfilerInterface`;
- `TraceInterface`.

All three interfaces retain the four standard marker extensions. Existing concrete implementations satisfy the signatures. No new concrete class is added.

## Validation completed

- PHP lint for six PHP files;
- backend JSON parse;
- logger/profiler concrete-interface compatibility fixture;
- successful prefixed/multiline Composer result;
- failed Composer result and error-code propagation;
- structured log creation;
- profiler trace lifecycle;
- diagnostic output redaction;
- Windows `-1/0` exit-code fixture;
- ZIP content and integrity.

## Mandatory application order

```text
P117U
HF1
HF2
HF3
HF4
```

## Retest commands

1. stop both PHP servers;
2. extract HF4;
3. run Composer optimized autoload;
4. delete only previous runtime diagnostic files if a clean run is required;
5. start backend on `8792` with the shared local environment;
6. verify `/api/v1/status`;
7. start frontend on `8000`;
8. open `/fr-FR/applications`;
9. inspect `rcp-backend.log` and the trace named by the exception.

## Current repository state

The owner has pushed commit:

```text
96884961248fc82bf5e13187a6ffcfffacb82d9f
```

This removes the previously tracked local secret file and adds its ignore rule. HF3 remains applied locally unless separately committed after acceptance. Existing secret values pasted or previously committed must not be reused for nonlocal deployment.

## Permanent rules

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO SILENT FALLBACK.
OPUS IS THE FRAMEWORK.
OWASYS IS AN OPUS APPLICATION.
REST + COMPOSER IS THE OWASYS BACKEND.
LOGGER AND PROFILER ARE EXISTING OPUS SERVICES.
EVERY CONCRETE OPUS CLASS IS EXCEPTION-AWARE AND PROFILER-AWARE.
SECRETS NEVER ENTER GIT, ARGV, LOGS, PROFILER PAYLOADS OR DELIVERY ARTIFACTS.
