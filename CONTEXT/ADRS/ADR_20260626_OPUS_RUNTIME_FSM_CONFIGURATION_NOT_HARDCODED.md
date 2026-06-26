# ADR — OPUS runtime FSM transitions must be configured, not hardcoded

## Date

2026-06-26

## Status

Accepted

## Context

During P7A1D web-profiler and runtime exception pipeline work, the OPUS runtime may need mandatory framework transitions such as boot, request start, routing, controller/view/rendering, profiler flush, shutdown or failure states.

The user explicitly refused any hardcoded demo-like transition list inside PHP classes.

## Decision

Mandatory OPUS runtime FSM transitions must be stored as OPUS configuration data, not embedded in PHP logic.

Recommended root location:

```text
config/fsm_runtime/
```

The directory belongs to the OPUS project root and is read by OPUS runtime services.

No PHP class may own a fixed transition sequence such as:

```text
BOOT -> PACKAGE_READY -> I18N_READY -> RENDER_READY -> DONE
```

That kind of sequence must be represented in configuration files and loaded explicitly.

## Target structure

```text
config/fsm_runtime/
  runtime_boot.json
  runtime_request.json
  runtime_profiler.json
  runtime_exception.json
```

A minimal transition file should expose structured data, for example:

```json
{
  "schema": "OPUS_FSM_RUNTIME_V1",
  "id": "runtime_boot",
  "initial_state": "BOOT_START",
  "final_states": ["BOOT_READY", "BOOT_FAILED"],
  "transitions": [
    {
      "from": "BOOT_START",
      "signal": "autoload.ready",
      "to": "BOOT_AUTOLOAD_READY",
      "collector": "runtime"
    }
  ]
}
```

## Rules

```text
- transitions are data, not hardcoded PHP behavior ;
- the runtime loader must fail explicitly if config/fsm_runtime is missing when required ;
- unknown states/signals must fail explicitly ;
- profiler collectors may read FSM events but must not define FSM transitions ;
- web profiler may display FSM traces but must not be the source of truth ;
- generated demo FSM files must not be restored ;
- Opus/Fsm/Fsm.php remains deleted.
```

## Impact on P7A1D

P7A1D must not introduce hardcoded runtime FSM sequences.

If P7A1D needs runtime transition tracing, it must add a loader contract and read from `config/fsm_runtime/` or defer that part to a later P7A1E/P7A1F milestone.

## Consequences

This keeps OPUS reusable and configurable.

It also prevents recurrence of the removed demo FSM pattern.
