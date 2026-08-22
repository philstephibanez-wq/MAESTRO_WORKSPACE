# P117W R45B2A4BZ2R8A1R1 — Actual baseline hash repair handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Layering baseline

Apply on top of the current R8A working tree produced from OPUS commit:

`9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`

R8A1 is invalid and must not be used.

## Owner-observed exact target

`sites/owasys-front/application/default/services/FsmGuardHandlers.php`

Current SHA-256:

`2532c0fe5bfa6397a70dcb8a29adba636fee60a4d3d8f751b6802ec0d3b7b4d8`

The value was confirmed from the owner's Windows working tree. It is exactly the R8A generated source without a final newline.

## Artifact

`opus_p117w_r45b2a4bz2r8a1r1_actual_baseline_hash_repair.zip`

ZIP SHA-256:

`395491b0b19f96d40824049d7842a91e5a13488e1c679d78b5c71323f18b031f`

Applicator SHA-256:

`8d08bdb186d77eb9be53dc6b5e304545f36bc432c7d9043882e3b08caf5deb3c`

Corrected target SHA-256:

`e7c03e31c351f2d895222057bad57f92e8ba726b120517e55676f463991f69a4`

The ZIP contains exactly one differential applicator: `apply_a4bz2r8a1r1.php`.

## Verification performed

- final applicator `php -l`: OK;
- exact current R8A source reconstructed without trailing newline and SHA verified as `2532c0fe...`;
- applicator executed on that exact byte baseline: success;
- output SHA verified as `e7c03e31...`;
- repaired PHP lint: OK;
- second application refused with exit code 20 and `ALREADY_APPLIED`;
- behavioral probe with duplicate `acl:foo:read` plus distinct `acl:bar:update`: duplicate reference idempotent, two dynamic ACL handlers produced, no namespace exception.

## Expected markers

`P117W_R45B2A4BZ2R8A1R1_APPLIED`

- `cause=r8a_actual_file_has_no_final_newline_and_r8a1_hash_preflight_missed_it`
- `runtime_fix=repeated_dynamic_acl_guard_idempotent`
- `acl_namespace_check=managed_handlers_once`
- `repeated_acl_reference=idempotent`
- `changed_files=1`

## Owner validation

After application:

1. verify target SHA equals `e7c03e31...`;
2. lint `FsmGuardHandlers.php`;
3. regenerate optimized Composer autoload;
4. validate `owasys-front` and `owasys-back`;
5. restart/open OWASYS and verify normal `/fr-FR` boot;
6. only after successful boot reopen the EFSM designer;
7. do not commit/push until the runtime validation passes.

R8B remains blocked.