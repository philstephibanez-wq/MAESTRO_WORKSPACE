# P112Q2I5 — ASAP Lstsa FSM Background Staging

## Status

Stage-only patch.

## Objective

Install the first controlled background execution contract for the Lstsa engine:

```text
Scheduler -> queue -> Runner background -> FSM -> Load -> Secure -> Transform -> Store -> Archive -> Report -> Event OK/FAIL
```

The site must never execute the heavy pipeline inside an HTTP request. A site action may enqueue a job and return immediately. The CLI/background runner owns the execution.

## Runtime contract

- `LstsaScheduler` creates an explicit run request.
- `LstsaRunner` acquires one pending run outside HTTP.
- `LstsaFsmController` authorizes each step.
- Phase objects execute one responsibility each.
- `LstsaRunStore` persists queue state, heartbeats, artifacts, events and reports.

## Phase objects

| Phase | Responsibility |
| --- | --- |
| `LstsaLoadPhase` | Read declared source fields from the source database. |
| `LstsaSecureInputPhase` | Validate source rows before transform. |
| `LstsaTransformPhase` | Apply allow-listed transforms. |
| `LstsaSecureOutputPhase` | Validate transformed output rows. |
| `LstsaStorePhase` | Write to target staging table, validate staging, then commit final table update. |
| `LstsaArchivePhase` | Persist append-only execution evidence. |
| `LstsaReportPhase` | Mark the report phase before final run reporting. |

## Target staging rule

The target final table is never written directly. The Store phase creates a controlled staging table in the target database. If staging is valid at 100%, the final table is updated in a transaction. If any error occurs, the transaction is rolled back and the staging table is removed.

## SQLite validation

P112Q2I5 validates the contract with two temporary SQLite databases:

- source DB with useful input table only;
- target DB with final table created from validated staged data only.

SQLite is used as a real transactional database for the smoke recipe, not as a dumping area. Runtime artifacts live under ignored `var/lstsa/` directories and remain purgeable by future retention policy.

## Explicit non-goals

- No UI.
- No Twig.
- No backoffice.
- No HTTP heavy execution.
- No silent fallback to direct target writes.
