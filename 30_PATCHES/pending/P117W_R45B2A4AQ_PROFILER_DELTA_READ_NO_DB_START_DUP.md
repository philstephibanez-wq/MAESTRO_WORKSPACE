# P117W R45B2A4AQ — Profiler delta read + DB started-event deduplication

Status: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED
Date: 2026-08-17

## Baseline

Owner-committed OPUS baseline:

`ce7348c87c8b2bf9e7ef6643a1df4d4fd313ad9e`

This is A4AP shared actionable logout rail.

## Owner finding

OWASYS has again become extremely slow, with multi-second lag.

The owner supplied current front/back text logs and JSONL profiler journals. The observed degradation is not explained by the business command durations alone.

Current supplied journal sizes:

- owasys-back profiler JSONL: about 7.6 MB;
- owasys-front profiler JSONL: about 3.9 MB.

Recent front requests include approximately 3–10 second envelopes. Back registry operations that used to complete in tens/hundreds of milliseconds now show second-scale wrapper times.

## Root cause 1 — distributed profiler rereads all retained history

`Opus\Api\Rest\RestClient` automatically sends `X-Opus-Profiler: 1` in dev/local/development whenever a correlated trace id exists.

`Opus\Api\Rest\RestServer`, when that header is present:

1. stops its profiler trace;
2. calls `Profiler::readTrace($traceId)`;
3. embeds the returned records in the REST response;
4. the front imports those records into its active trace.

Current `Profiler::readTrace()` scans every retained profiler JSONL file from the beginning and JSON-decodes every record before selecting the requested trace id.

Therefore every ordinary correlated REST call in development pays a cost proportional to accumulated profiler history.

There is a second semantic amplification: when one front HTTP request makes multiple REST calls with the same trace id, the later `readTrace()` returns records already returned by earlier calls. `Trace::importRecord()` can de-duplicate a record only inside the current front Trace object by record id, but the back still rescans and retransmits the historical records. The transport and storage work is repeated unnecessarily.

## Root cause 2 — duplicate database started events

`Trace::beginSpan()` already emits `<span-name>.started` automatically with the span context.

`DatabaseOperationProfiler::measure()` then emits `database.operation.started` a second time with the same database context.

The supplied registry-sync trace contains:

- 31 database spans;
- 62 `database.operation.started` events;
- exactly two started events per database span.

On that captured trace, removing only the redundant second started event removes 31 events and reduces serialized record size by about 19%, while preserving the span, SQL/context, completion/result event and ended event.

## A4AQ contract

### 1. Generic Profiler read-after-stop delta

Extend the existing concrete `Opus\Profiler\Profiler`; no new concrete framework class is introduced.

At `start()` capture an opaque digest of the last retained JSONL record.

At successful `stop()` retain the trace id and its start cursor in memory.

If `readTrace()` is called immediately for that same just-stopped trace on the same Profiler instance, read only records appended after the start cursor. This is the distributed REST hand-off path.

The cursor is a SHA-256 digest of record content, not a path or byte offset, so normal profiler file rotation does not invalidate it.

Delta reading walks newest retained files backwards in bounded chunks and stops as soon as it reaches the cursor. Only records created inside the just-finished scope are returned in chronological order.

If the cursor has expired beyond retention, fail explicitly with `OPUS_PROFILER_READ_CURSOR_EXPIRED`; no silent fallback to a full-history scan.

After one successful scoped read, ordinary `readTrace()` behavior returns to the existing full retained-history semantics. Thus an explicit Web Profiler trace request still sees the retained trace history.

### 2. Database profiler event deduplication

Remove the manual `database.operation.started` emission from `DatabaseOperationProfiler::measure()`.

Do not remove:

- the database span;
- its start context including SQL/parameters when present;
- completion/result/failure events;
- the automatic span-ended event;
- duration/status measurement.

This is diagnostic deduplication, not profiler suppression.

### 3. No changes outside profiler instrumentation

No FSM, SCORE, REST resource contract, ACL, SSO/session, Composer allow-list, database business logic or OWASYS frontend/backend behavior changes.

Profiler remains mandatory and active.

## Delivery

Artifact:

`opus_p117w_r45b2a4aq_profiler_delta_read_no_db_start_dup.zip`

SHA-256:

`077c29debf5224384b483e6f8df7d8ab0c0e788f99c8b070dff3e4de243b5298`

Exactly two complete framework files:

1. `Opus/Profiler/Profiler.php`
2. `Opus/Database/DatabaseOperationProfiler.php`

No patcher. No deletion. No OWASYS-local workaround.

## Pre-delivery validation

- PHP lint passes for both delivered files.
- No trailing whitespace in either file.
- Delta smoke starts from the owner's 7.6 MB back journal and adds an old record using the same trace id before the new request.
- First read after stop returns exactly the two current-scope records and excludes the older same-trace record.
- A subsequent ordinary read returns the complete three-record retained history.
- Read-after-stop delta smoke on the 7.6 MB journal completes without scanning the historical body and remains independent of journal length.
- Manual file rotation between start and stop is passed: cursor in `.1`, new records in current JSONL, current-scope read still returns the correct two records.
- Captured registry-sync diagnostic audit confirms 62 database started events for 31 spans before A4AQ; the delivered source contains no second manual started emission.

## Acceptance

Apply over committed A4AP without deleting the existing profiler journals first. The existing large journals are required to validate the regression fix rather than masking it through a reset.

Acceptance requires:

1. ordinary OWASYS navigation/registry operations no longer accumulate multi-second delay merely because profiler history is large;
2. a REST call receives only profiler records generated during that call, not earlier records with the same trace id;
3. a second REST operation inside the same front trace does not retransmit profiler records from the first operation;
4. explicit Web Profiler trace access still works;
5. database panel still contains measured database spans, SQL/context, completion/result and timing information;
6. exactly one automatic `database.operation.started` exists per database span;
7. Logger and Profiler remain enabled;
8. no FSM/REST/ACL/session/business regression.

If owner timing still shows a material append-only-file cost after A4AQ with the historical full-scan removed, profiler storage segmentation becomes the next isolated concern. Do not pre-emptively change retention semantics in A4AQ.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
