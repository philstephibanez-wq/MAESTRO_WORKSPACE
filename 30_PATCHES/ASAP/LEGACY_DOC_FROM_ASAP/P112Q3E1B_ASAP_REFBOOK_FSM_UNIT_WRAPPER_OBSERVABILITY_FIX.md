# P112Q3E1B — ASAP RefBook FSM unit wrapper observability fix

## Scope

Correct the Windows `.cmd` wrapper used to run the P112Q3E1 FSM RefBook metadata contract test.

## Contract

The wrapper must be observable and must display the PHP unit/contract marker emitted by `tests/Contract/RefBookFsmMetadataContractTest.php`, followed by the strict `ExitCode=` line.

## Expected runtime marker

```text
P112Q3E1_REFBOOK_FSM_METADATA_CONTRACT_UNIT_OK
ExitCode=0
```

## No behavior change

No framework runtime class is modified by this patch.
