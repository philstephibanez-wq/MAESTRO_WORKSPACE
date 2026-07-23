# OWASYS P117U HF4 — LOGGER, PROFILER AND PROCESS EXIT CONTRACT

Date: 2026-07-24
Status: binding hotfix specification
Applies after: P117U + HF1 + HF2 + HF3
OPUS remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`

## 1. Owner runtime incident

With both OWASYS processes running and HF3 applied locally, Registry synchronization failed with:

```text
OPUS_RCP_COMPOSER_COMMAND_FAILED
```

The backend process accepted and completed the HTTP request, but no OPUS application log or profiler trace was generated. The generic Composer executor collected stdout and stderr and then explicitly discarded stderr. The RCP server stored only the normalized execution result.

## 2. Contract correction

`OpusExceptionAwareInterface` and `OpusProfilerAwareInterface` are mandatory framework contracts for every concrete class under `Opus/`. They are not passive labels. Runtime classes must surface normalized exceptions and provide enough context to the OPUS logger/profiler pipeline.

HF4 connects the existing OPUS `Logger` and `Profiler` to:

- `Opus\Rcp\Rest\RcpRestServer`;
- `Opus\Rcp\Composer\ComposerCommandExecutor`.

No parallel logging or profiling subsystem is introduced.

## 3. Diagnostic configuration

OWASYS owns its backend diagnostic locations in `sites/owasys/config/backend.rest.json`:

```json
"diagnostics": {
  "log_directory": "sites/owasys/var/logs",
  "log_file": "rcp-backend.log",
  "profiler_directory": "sites/owasys/var/profiler"
}
```

The configuration is read through `StructuredFileLoader`, therefore through the OPUS File/parser boundary.

Runtime outputs:

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
```

Both locations are runtime state and remain excluded from Git.

## 4. Logged information

The structured backend log records:

- UTC time and level;
- channel and event name;
- trace ID;
- execution ID and operation where available;
- Composer script identifier;
- FSM state;
- normalized exception class, file and line;
- observed and closed process exit codes;
- duration and output byte counts;
- bounded, sanitized stdout/stderr excerpts on failure.

The logger and executor never record:

- request parameter values;
- passwords;
- bearer tokens;
- HMAC values;
- authorization headers;
- API keys;
- full command lines;
- environment values.

Diagnostic excerpts remove ANSI sequences, redact sensitive key/value patterns and long hexadecimal secrets, and are truncated to 8 KiB.

## 5. Profiler contract

One profiler trace is created per REST execution. Events cover:

```text
execution.received
execution.validated
authenticated
authorized
dispatching
command.started
command.succeeded | command.failed
execution.succeeded | execution.failed
trace.stopped
```

The REST execution response and persistent execution record include `trace_id`. The RCP client appends the trace ID to raised backend exception codes in the form:

```text
<ERROR_CODE>:TRACE:<TRACE_ID>
```

This allows direct correlation with the log and profiler file without exposing process output to the browser.

## 6. Windows process exit correction

The previous executor trusted only `proc_get_status()['exitcode']` and discarded the result of `proc_close()`.

On Windows, the observed exit code may be `-1` even after a completed process. A valid successful OPUS console envelope could therefore be converted into the generic `OPUS_RCP_COMPOSER_COMMAND_FAILED`.

HF4 records both values and resolves the final exit code as follows:

1. valid `proc_close()` code;
2. otherwise valid `proc_get_status()` code;
3. otherwise explicit `OPUS_RCP_PROCESS_EXIT_CODE_UNAVAILABLE`.

No silent successful fallback is used.

## 7. Interface contracts

HF4 adds operational method signatures to the existing homonymous interfaces:

- `Opus\Log\LoggerInterface`;
- `Opus\Profiler\ProfilerInterface`;
- `Opus\Profiler\TraceInterface`.

They continue to extend the four mandatory markers:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The existing concrete `Logger`, `Profiler` and `Trace` classes already satisfy the added signatures. HF4 introduces no new concrete framework class.

## 8. HF4 differential

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

No root file, root directory, Composer alias, smoke, audit, test, report, README, manifest, cache or temporary file is introduced.

## 9. Validation completed

- PHP lint for six modified PHP files;
- JSON parsing for backend configuration;
- actual logger/profiler interface compatibility fixture;
- successful Composer process with prefixed multiline JSON;
- failed Composer process with OPUS error envelope;
- structured error log event generated;
- stdout/stderr secret redaction;
- RCP-owned and standalone profiler trace lifecycle;
- Windows fixture `observed=-1`, `closed=0` resolves to success;
- exact ZIP contents and integrity.

## 10. Mandatory patch and retest order

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4
```

Then restart backend first, verify status, restart frontend, reproduce the Registry page and inspect the correlated log and profiler trace.

## 11. Permanent boundaries

OPUS is the framework.
OWASYS is an OPUS application and web UI.
All OWASYS business commands cross secured REST then Composer.
Every concrete OPUS class remains exception-aware and profiler-aware through its homonymous four-marker interface.
No raw process output or secret crosses the REST response.
No silent fallback is authorized.
