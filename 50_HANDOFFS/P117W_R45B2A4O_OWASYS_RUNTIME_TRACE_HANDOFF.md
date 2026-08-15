# P117W R45B2A4O — OWASYS runtime trace handoff

State: OWNER DIAGNOSTIC OUTPUT REQUIRED

## Why this gate exists

The owner validated that A4N is committed/published (`c5122e03b40f6f483e325e7f0192984dd089c093`) but `/fr-FR/applications` still returns HTTP 500 with browser-safe code `OWASYS_FRONT_RUNTIME_FAILED` and trace `dcd84950c19c44c62bf834a4cb47034f`.

The OWASYS application catch path logs the actual exception class, source file and source line under this trace ID. Therefore the next correction must be derived from that runtime evidence, not from another speculative menu/FSM edit.

## Artifact

`opus_p117w_r45b2a4o_runtime_trace_resolver.zip`

SHA-256: `9a6f44b5ca734300dd0e9878918f65b8c5dd8dfb390ffa1d7d845efeb04c3866`

## Owner sequence

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4o_runtime_trace_resolver.zip"
php tools\diagnose_p117w_r45b2a4o_runtime_trace.php dcd84950c19c44c62bf834a4cb47034f
```

Return the complete diagnostic output.

Expected successful markers:

- `OPUS_P117W_R45B2A4O_TRACE_FOUND`
- `ERROR_CODE=...`
- `EXCEPTION_CLASS=...`
- `EXCEPTION_FILE=...`
- `EXCEPTION_LINE=...`
- `SOURCE_CONTEXT_BEGIN` / `SOURCE_CONTEXT_END` when source is inside OPUS
- `OPUS_P117W_R45B2A4O_DIAGNOSIS_COMPLETE`

## Stop conditions

- `OPUS_P117W_R45B2A4O_HEAD_INVALID`: stop; source baseline changed.
- `OPUS_P117W_R45B2A4O_TRACE_NOT_FOUND`: stop; do not invent a functional patch. Diagnose Logger/Profiler persistence using the recent `var` files printed by the tool.

## Next functional revision

The next functional delivery is intentionally blocked until the trace identifies the exact A4N exception source. Once resolved, fix the root cause while preserving the established `Menu = FSM` contract: state=context/menu entry, outgoing signals=submenu/commands, signal endpoint emits the signal, FSM owns `next_state`, and diagram consumes the same normalized projection.

The diagnostic tool is one-shot and must not be committed with OPUS.
