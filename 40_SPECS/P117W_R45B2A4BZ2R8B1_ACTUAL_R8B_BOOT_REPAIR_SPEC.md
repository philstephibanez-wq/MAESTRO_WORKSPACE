# P117W R45B2A4BZ2R8B1 — Actual R8B boot repair

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Authoritative baseline

OPUS HEAD/master:

`8c7f254ad9080c46bb4da4af272a5c7cd2d4a129`

Commit message:

`opus_p117w_r45b2a4bz2r8b_graphical_php_handler_authoring`

The previous R8A2V gate was invalid because it still required the pre-R8B HEAD.

## Root cause

The R8B commit contains the original R8A implementation of `OwasysFsmGuardHandlers::forConfig()` where developer-managed guards and dynamically synthesized `acl:*` handlers share one `$handlers` map.

A first `acl:<resource>:<action>` occurrence creates a runtime callable. A repeated reference then triggers `OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED` because presence in the runtime map is incorrectly treated as developer namespace ownership.

## Correction

`FsmGuardHandlers.php` is normalized to the canonical fixed implementation:

- `$managedHandlers` contains only developer-programmed guards;
- reserved `acl:*` validation is performed only against `$managedHandlers`;
- `$handlers = $managedHandlers` becomes the runtime map;
- first dynamic ACL reference validates and synthesizes the callable;
- repeated references are idempotent via `array_key_exists(...); continue;`;
- developer-owned `acl:*` remains forbidden.

Canonical fixed SHA-256:

`6007cf1be5b627aa29a9252c2d1c9cc73a8c0375551e601c6956bf8a6244ccf9`

The applicator is idempotent: if the local working tree already contains that canonical R8A2 repair, it performs no source rewrite and continues successfully.

## Runtime validation gate

A companion CMD script:

1. executes the idempotent repair applicator bound to the real R8B HEAD;
2. verifies the canonical target SHA;
3. lints the target;
4. runs Composer optimized autoload generation;
5. validates `owasys-front` and `owasys-back`;
6. force-stops listeners on 8000 and 8080;
7. starts fresh front/back dev servers explicitly on 8000/8080;
8. waits for both listeners;
9. requests `/fr-FR`;
10. fails on unreachable or HTTP >= 400.

This guarantees the HTTP result comes from a process started after the corrected source is present.

## Differential scope

Potential OPUS/OWASYS source change: exactly one file:

`sites/owasys-front/application/default/services/FsmGuardHandlers.php`

The runtime CMD is a delivery/validation script outside the repository.

## Artifact

`opus_p117w_r45b2a4bz2r8b1_actual_r8b_boot_repair.zip`

ZIP SHA-256:

`15e97bc80c2fe89648fb55db396a737d42c8d2b51422070d7744f29dbb0a5825`

Applicator SHA-256:

`68c91db9676527d7daed1a02f74199e82140d3b0dc449918262ce50b0b428655`

Runtime CMD SHA-256:

`cb65de5065f020d3171aab1dd535683b5b3bc5d2a8e1e817f392337e191e25a6`

## Verification performed before delivery

- final PHP applicator lint: OK;
- exact final applicator executed against a fixture exposing the real R8B HEAD through the Git preflight and containing the exact original R8A/R8B guard source;
- application produced canonical SHA `6007cf1b...`;
- resulting target PHP lint: OK;
- second application returned `P117W_R45B2A4BZ2R8B1_ALREADY_FIXED` without rewriting;
- final ZIP contains exactly `apply_a4bz2r8b1.php` and `run_a4bz2r8b1.cmd`;
- Windows listener/process control cannot be executed in the assistant Linux container and remains owner-runtime acceptance.

## Acceptance

- `P117W_R45B2A4BZ2R8B1_RUNTIME_OK`;
- target SHA exactly `6007cf1b...`;
- both ports are served by fresh processes;
- `/fr-FR` returns HTTP < 400;
- fresh logs no longer contain `OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED` for the boot request.
