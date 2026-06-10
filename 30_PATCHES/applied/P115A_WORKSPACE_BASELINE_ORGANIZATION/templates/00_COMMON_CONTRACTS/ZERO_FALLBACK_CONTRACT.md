# Zero Fallback Contract

## Rule

A capability must either use the official path or fail with an explicit error.

## Forbidden

- Silent fallback.
- Hidden compatibility bridge.
- Unknown default path.
- Auto-created source root.
- Runtime guessing when the official root is missing.

## Required

- Explicit root.
- Explicit contract.
- Explicit error if missing.
- Explicit report for every patch/audit operation.
