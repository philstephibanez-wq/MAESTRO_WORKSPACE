# P117W R45B2A4AQ — Handoff

State: OWNER RUNTIME VALIDATION PASSED — OWNER COMMIT/PUSH REQUIRED

## Baseline

Owner-committed OPUS baseline before A4AQ:

`ce7348c87c8b2bf9e7ef6643a1df4d4fd313ad9e`

A4AP is committed. A4AQ addresses the separate multi-second performance regression reported immediately afterward.

## Confirmed causes addressed by A4AQ

### Full retained-history scan on each profiled REST call

`RestClient` sends `X-Opus-Profiler: 1` automatically in development when a correlated trace id exists.

`RestServer` then stops its trace and calls `Profiler::readTrace($traceId)` to return remote profiler records to the front.

Before A4AQ, `Profiler::readTrace()` scanned every retained JSONL file from the beginning and JSON-decoded every record. With multiple REST calls sharing one front trace id, later calls also reread/retransmitted records produced by earlier calls.

### Duplicate database started event

`Trace::beginSpan()` already emits `<span>.started` automatically. Before A4AQ, `DatabaseOperationProfiler::measure()` independently emitted `database.operation.started` a second time.

## A4AQ delivery

Artifact:

`opus_p117w_r45b2a4aq_profiler_delta_read_no_db_start_dup.zip`

SHA-256:

`077c29debf5224384b483e6f8df7d8ab0c0e788f99c8b070dff3e4de243b5298`

Two complete framework files:

1. `Opus/Profiler/Profiler.php`
2. `Opus/Database/DatabaseOperationProfiler.php`

No patcher. No deletion. No site-local file.

## Implementation

### `Opus\Profiler\Profiler`

- `start()` captures an opaque SHA-256 cursor representing the last retained JSONL record before the new trace scope;
- `stop()` records that cursor against the just-stopped trace id;
- the immediate `readTrace()` for the same trace id reads only records appended after that cursor;
- newest files are walked backwards in 64 KiB chunks, so historical journal body is not rescanned;
- the cursor survives normal JSONL rotation because it follows record content rather than filename/offset;
- an expired cursor is explicit; there is no silent fallback to a full-history scan;
- after the scoped read succeeds, later ordinary `readTrace()` calls retain historical behavior for explicit Web Profiler access.

### `Opus\Database\DatabaseOperationProfiler`

The redundant explicit `database.operation.started` call is removed because `Profiler::beginSpan()` / `Trace::beginSpan()` already records it.

All actual database measurements remain: span context, SQL/parameters where present, result/completion/failure events, span end, status and duration.

## Pre-delivery smoke

Both delivered PHP files lint clean and contain no trailing whitespace.

Profiler delta smoke used a copy of the earlier 7.6 MB back JSONL:

- an older record with the same trace id existed before `start()`;
- a nested child record was appended during the scope;
- `stop()` wrote the parent record;
- first `readTrace()` returned exactly child + current parent, not the old same-trace record;
- second ordinary `readTrace()` returned the complete retained same-trace history;
- manual rotation between start and stop passed.

## Owner runtime validation — 2026-08-17

The owner applied A4AQ and returned fresh front/back logs and profiler JSONL exports.

Observed back command timings are back in the expected sub-second range:

- `registry-clear` in-process wrapper: 282.655 ms;
- first `registry-sync`: 211.842 ms;
- second `registry-sync`: 184.33 ms;
- `registry-select`: 157.15 ms.

Profiler JSONL confirms the database deduplication exactly. Each captured `registry-sync` contains:

- 31 database spans;
- 31 `database.operation.started` events;
- 31 database span-ended events.

The pre-A4AQ duplication was 62 started events for 31 database spans. A4AQ therefore restores one automatic started event per database span while retaining the measured operations.

The front `/applications` GET completes with correlated remote profiler data and no error/warning/unavailable status. The new front trace does not contain unrelated previous request traces.

A4AQ is therefore accepted at runtime for the two defects it targets. The owner still owns the OPUS commit/push; the repository baseline remains A4AP until that push occurs.

## New evidence found during A4AQ validation — next A4AR

The same validation exports expose a distinct request-lifecycle defect:

- front receives `POST /fr-FR/applications` with trace `881ffb85bce627d619b5a2bacd85f0bd`;
- back completes both `registry.sync` and `registry.select` successfully for that trace;
- the browser is redirected and immediately starts a new GET `/fr-FR/sources-de-données`;
- but the front log has no `request.completed` for the POST;
- and the front profiler JSONL has no persisted record for trace `881ffb85bce627d619b5a2bacd85f0bd`.

Current OPUS source proves the cause: `OwasysRuntimeController::redirect()` and `redirectExternal()` issue the 303 header and call `exit`. PHP process termination bypasses the continuation of `OwasysFrontApplication::run()`, including its request-completion logging, HTTP span completion and profiler `stop()` in the application's `finally` block.

This is not an A4AQ performance regression. It is a separate lifecycle/profiler completeness defect and is assigned to A4AR.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
