# P117W R45B2A4BZ2R8A1 — Repeated dynamic ACL guard repair handoff

State: DELIVERY INVALID — SUPERSEDED BY R8A1R1

Owner validation proved that the R8A1 applicator never modified the actual R8A working tree.

Owner-observed `FsmGuardHandlers.php` SHA-256:

`2532c0fe5bfa6397a70dcb8a29adba636fee60a4d3d8f751b6802ec0d3b7b4d8`

The R8A1 applicator incorrectly required:

`a677db775bfe4835d46549ae9148135bf75d77195c098db9f8ab0c892123568d`

Those files differ only by the missing final newline in the real R8A output. Because the strict preflight hash was wrong, R8A1 refused before writing and the original R8A namespace bug remained active.

Do not use `opus_p117w_r45b2a4bz2r8a1_repeated_acl_guard_repair.zip`.

Use R8A1R1 instead. R8B remains blocked until owner validation succeeds.