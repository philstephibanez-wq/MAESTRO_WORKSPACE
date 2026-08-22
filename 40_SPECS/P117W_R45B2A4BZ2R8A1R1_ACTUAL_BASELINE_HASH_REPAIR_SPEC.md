# P117W R45B2A4BZ2R8A1R1 — Actual baseline hash repair

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Cause

R8A1 contained the correct repeated dynamic ACL guard runtime repair but an incorrect strict preflight SHA. The R8A-generated `FsmGuardHandlers.php` has no final newline and hashes to:

`2532c0fe5bfa6397a70dcb8a29adba636fee60a4d3d8f751b6802ec0d3b7b4d8`

R8A1 expected the same content with a final newline:

`a677db775bfe4835d46549ae9148135bf75d77195c098db9f8ab0c892123568d`

Therefore R8A1 refused the real owner working tree and did not apply its runtime correction.

## Correction

R8A1R1 targets the exact owner-observed SHA `2532c0fe...` and replaces the file with the verified corrected implementation whose SHA is:

`e7c03e31c351f2d895222057bad57f92e8ba726b120517e55676f463991f69a4`

Runtime semantics remain:

- developer-managed `acl:*` IDs are forbidden;
- first canonical dynamic ACL reference synthesizes its callable;
- repeated references to that same ACL guard reuse it idempotently;
- distinct dynamic ACL guards are synthesized independently.

## Differential scope

Exactly one file:

- `sites/owasys-front/application/default/services/FsmGuardHandlers.php`

## Acceptance

- applicator accepts owner-observed SHA `2532c0fe...`;
- result SHA is exactly `e7c03e31...`;
- PHP lint passes;
- second application is refused;
- duplicate `acl:foo:read` references produce one dynamic handler without exception;
- normal OWASYS boot succeeds before any work on R8B.

R8B remains blocked until owner validation passes.