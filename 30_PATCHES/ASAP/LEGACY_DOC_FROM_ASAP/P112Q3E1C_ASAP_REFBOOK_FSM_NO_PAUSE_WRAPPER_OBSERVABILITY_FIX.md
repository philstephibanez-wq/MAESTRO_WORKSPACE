# P112Q3E1C — ASAP RefBook FSM no-pause wrapper observability fix

## Scope

This patch fixes Windows CMD wrapper observability for the P112Q3E1 FSM RefBook metadata contract.

## Changes

- `tests/Contract/run_refbook_fsm_metadata_contract_test.cmd`
  - keeps the PHP marker visible
  - prints `ExitCode=<code>`
  - removes blocking `pause`

- `tools/smoke/run_p112q3e1_refbook_fsm_metadata_smoke.cmd`
  - runs the smoke PHP file directly
  - keeps the smoke marker visible
  - prints `ExitCode=<code>`
  - removes blocking `pause`

## Contract

Recipe-oriented wrappers must not block execution with `pause`.
Interactive/double-click pause wrappers may be introduced separately only if explicitly named as interactive wrappers.

## Validation commands

```cmd
cd /d H:\ASAP
tests\Contract\run_refbook_fsm_metadata_contract_test.cmd
tools\smoke\run_p112q3e1_refbook_fsm_metadata_smoke.cmd
```

## Expected markers

```text
P112Q3E1_REFBOOK_FSM_METADATA_CONTRACT_UNIT_OK
ExitCode=0
P112Q3E1_REFBOOK_FSM_METADATA_SMOKE_OK
ExitCode=0
```
