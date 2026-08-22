# P117W R45B2A4BZ2R8A2 — Runtime boot ACL repair

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Runtime evidence

The restarted owner `owasys-front` runtime still fails on the first `/fr-FR` request with:

`OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED`

at:

`sites/owasys-front/application/default/services/FsmGuardHandlers.php:68`.

The backend only starts and receives no business request before this front-side failure.

The original R8A generated `FsmGuardHandlers.php` has its duplicate dynamic ACL collision `throw new RuntimeException(...)` exactly at line 68. The previously intended R8A1R1 corrected source does not. Therefore the live evidence establishes that the runtime is still executing the original R8A collision branch.

## Root cause semantics

R8A used one `$handlers` map for two ownership domains:

1. developer-managed guards from `FsmDeveloperHandlers.php`;
2. dynamic `acl:<resource>:<action>` handlers synthesized while scanning transitions.

The first reference to a dynamic ACL relation inserts its callable in `$handlers`. A later transition referencing the same ACL relation sees the entry and the original R8A branch throws `OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED`, incorrectly treating a valid dynamic reuse as developer namespace ownership.

## Correction

R8A2 makes ownership explicit:

- `$managedHandlers` contains developer-programmed guards only;
- the reserved `acl:*` namespace invariant is checked only against `$managedHandlers`;
- `$handlers = $managedHandlers` then becomes the runtime map;
- the first `acl:*` transition reference validates and synthesizes the dynamic callable;
- later references use `array_key_exists($guard, $handlers)` and `continue`, making reuse idempotent;
- developer-programmed `acl:*` IDs remain blocking errors.

No generic OPUS engine change is required. This remains the OWASYS application ACL adapter.

## Recovery robustness

The applicator accepts either known local source state after EOL normalization:

- original R8A source SHA-256 `2532c0fe5bfa6397a70dcb8a29adba636fee60a4d3d8f751b6802ec0d3b7b4d8`;
- previous R8A1R1 source SHA-256 `e7c03e31c351f2d895222057bad57f92e8ba726b120517e55676f463991f69a4`.

It writes one canonical result:

`6007cf1be5b627aa29a9252c2d1c9cc73a8c0375551e601c6956bf8a6244ccf9`.

Any other source content is refused.

## Differential scope

Exactly one OPUS/OWASYS path changes:

`sites/owasys-front/application/default/services/FsmGuardHandlers.php`

## Verification performed before delivery

- applicator PHP lint: OK;
- exact original R8A owner hash `2532c0fe...` reconstructed and accepted;
- exact previous R8A1R1 hash `e7c03e31...` reconstructed and accepted;
- resulting target hash verified as `6007cf1b...`;
- resulting PHP lint: OK;
- second application returns `ALREADY_FIXED` without changing the file;
- behavioral probe: two transitions referencing `acl:foo:read` produce one reusable dynamic handler with no exception;
- second distinct `acl:bar:update` handler is independently synthesized;
- synthesized `acl:foo:read` delegates to `OwasysRuntimeSecurity::isAllowed(identity, foo, read)`;
- injected developer guard `acl:foo:read` remains rejected by `OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED`.

## Acceptance gate

R8B remains blocked until owner runtime proves `/fr-FR` boots after a fresh restart and both sites validate. No OPUS/OWASYS push before that acceptance.