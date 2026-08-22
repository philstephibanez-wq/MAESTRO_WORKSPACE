# P117W R45B2A4BZ2R8A1R1 — Actual baseline hash repair handoff

State: SUPERSEDED BY R8A2 — OWNER RUNTIME STILL EXECUTED ORIGINAL R8A BRANCH

## Evidence after attempted continuation

Owner runtime trace on 2026-08-22 still failed at:

`sites/owasys-front/application/default/services/FsmGuardHandlers.php:68`

with:

`OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED`

Line 68 is the exact `throw new RuntimeException(...)` in the original R8A generated source, where a second reference to an already-synthesized dynamic `acl:*` guard is misclassified as a developer namespace collision.

The R8A1R1 corrected source has no throw at line 68. Therefore the live runtime evidence proves that the corrected source was not the source executed by the restarted owner runtime.

R8A1R1 is retained as historical delivery evidence but must no longer be used as the active recovery artifact.

## Superseding slice

Use `P117W_R45B2A4BZ2R8A2_RUNTIME_BOOT_ACL_REPAIR`.

R8A2 accepts the exact original R8A source (`2532c0fe...`) and the previous R8A1R1 source (`e7c03e31...`) after canonical EOL normalization, then writes one explicit repaired source with separate managed/dynamic maps semantics.

R8B remains blocked until `/fr-FR` boots successfully on owner runtime.
