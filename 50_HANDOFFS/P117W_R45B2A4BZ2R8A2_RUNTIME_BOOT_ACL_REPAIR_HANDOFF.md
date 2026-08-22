# P117W R45B2A4BZ2R8A2 — Runtime boot ACL repair handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Baseline

Owner OPUS HEAD remains:

`9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`

R8A is applied locally and not pushed. R8B is blocked. The latest owner runtime trace proves the front still executes the original R8A duplicate dynamic ACL collision branch at `FsmGuardHandlers.php:68`.

## Artifact

`opus_p117w_r45b2a4bz2r8a2_runtime_boot_acl_repair.zip`

ZIP SHA-256:

`d0cbdaf4a8540009be2c3d147035f85f122413e8de5d4f9d1c05d0deeba15921`

Applicator SHA-256:

`0e9416f91b5ebb3441f2a781e17fbcb0a994555da8ece31b1df38f250d539e6e`

The ZIP contains exactly one differential applicator: `apply_a4bz2r8a2.php`.

The assistant does not commit/push OPUS/OWASYS.

## Exact target

`sites/owasys-front/application/default/services/FsmGuardHandlers.php`

Accepted known source states, after canonical EOL normalization:

- original R8A: SHA-256 `2532c0fe5bfa6397a70dcb8a29adba636fee60a4d3d8f751b6802ec0d3b7b4d8`;
- previous R8A1R1: SHA-256 `e7c03e31c351f2d895222057bad57f92e8ba726b120517e55676f463991f69a4`.

Canonical result SHA-256:

`6007cf1be5b627aa29a9252c2d1c9cc73a8c0375551e601c6956bf8a6244ccf9`.

Any unknown target content is refused.

## Corrected runtime semantics

- developer handlers are kept in `$managedHandlers`;
- `acl:*` reserved namespace is checked only against those developer handlers;
- runtime `$handlers` starts as `$managedHandlers`;
- first valid `acl:<resource>:<action>` reference synthesizes the security callable;
- repeated references reuse the synthesized callable idempotently;
- developer-owned `acl:*` remains forbidden.

## Verification performed

- final applicator `php -l`: OK;
- test fixture with exact original R8A source hash: application success;
- result target SHA verified `6007cf1b...`;
- resulting target `php -l`: OK;
- second application: `P117W_R45B2A4BZ2R8A2_ALREADY_FIXED` and no mutation;
- fixture with exact previous R8A1R1 source also accepted and converted to the same canonical result;
- behavioral PHP probe: repeated `acl:foo:read` reference idempotent, distinct `acl:bar:update` synthesized, actual security delegation executed, developer `acl:*` injection still rejected.

## Expected markers

`P117W_R45B2A4BZ2R8A2_APPLIED`

- `cause=runtime_still_executed_r8a_duplicate_acl_collision_branch`
- `managed_acl_namespace=checked_only_against_developer_handlers`
- `dynamic_acl_reference=idempotent_reuse`
- `target_sha256=6007cf1be5b627aa29a9252c2d1c9cc73a8c0375551e601c6956bf8a6244ccf9`
- `changed_files=1`

## Owner validation

1. apply R8A2;
2. verify target SHA `6007cf1b...`;
3. lint target;
4. regenerate optimized Composer autoload;
5. validate both sites;
6. fully restart front and back dev servers;
7. open `/fr-FR` before the designer;
8. confirm no `OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED` appears;
9. inspect fresh front/back logs;
10. do not commit/push until boot is successful.

R8B stays blocked until this gate passes.