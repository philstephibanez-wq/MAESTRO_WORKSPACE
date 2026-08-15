# P117W R45B2A4O — OWASYS runtime trace gate

State: DIAGNOSTIC GATE — OWNER OUTPUT REQUIRED

## Source baseline

- OPUS owner-published HEAD: `c5122e03b40f6f483e325e7f0192984dd089c093`
- Commit subject: `opus_p117w_r45b2a4n_menu_fsm_runtime_fix`
- Failing request observed by owner: `/fr-FR/applications`
- Browser-safe error: `OWASYS_FRONT_RUNTIME_FAILED`
- HTTP status: `500`
- Trace observed: `dcd84950c19c44c62bf834a4cb47034f`

## Root-cause rule

A4N is confirmed as the published and executed baseline, but the browser intentionally hides non-safe exception messages. `sites/owasys-front/application/default/Application.php` already writes, under the request trace ID, `error_code`, `exception_class`, `exception_file` and `exception_line` to the mandatory OWASYS logger.

No further functional FSM/menu patch is authorized from inference alone. The exact exception file/line from the A4N runtime trace is the next source of truth.

## Diagnostic deliverable

Artifact: `opus_p117w_r45b2a4o_runtime_trace_resolver.zip`

SHA-256: `9a6f44b5ca734300dd0e9878918f65b8c5dd8dfb390ffa1d7d845efeb04c3866`

Contains only:

- `tools/diagnose_p117w_r45b2a4o_runtime_trace.php`

The diagnostic is non-destructive for tracked OPUS/OWASYS files. It:

1. refuses a HEAD other than A4N;
2. validates the supplied trace ID;
3. scans `sites/owasys-front/var` recursively for that exact trace;
4. extracts structured `error_code`, `exception_class`, `exception_file`, `exception_line` without dumping arbitrary log payloads;
5. prints source context only when the exception file is inside the OPUS checkout;
6. lints the A4N navigation/FSM/runtime PHP surfaces;
7. makes no tracked-source mutation.

## Owner command

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4o_runtime_trace_resolver.zip"
php tools\diagnose_p117w_r45b2a4o_runtime_trace.php dcd84950c19c44c62bf834a4cb47034f
```

## Acceptance

Required output begins with `OPUS_P117W_R45B2A4O_TRACE_FOUND` and identifies an exception class/file/line, followed by `SOURCE_CONTEXT_BEGIN` when that source is in OPUS.

If the trace is not found, stop. Do not guess a functional correction. Use the reported recent `var` files to determine why Logger/Profiler persistence did not retain the contractually emitted trace.

## Functional contract preserved for the subsequent correction

- Menu = FSM.
- Each FSM state is a menu state/context.
- Outgoing signals of that state are its submenu.
- State selection does not itself transition.
- A signal endpoint emits a signal; the FSM transition alone determines `next_state`.
- Diagram is a second functional projection of the exact same normalized FSM/menu projection.
- Normal global `from:"*"` remains forbidden; typed NMI remains out-of-band.
