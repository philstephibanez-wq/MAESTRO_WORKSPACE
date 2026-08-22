# P117W R45B2A4BZ2R8A1 — Repeated dynamic ACL guard repair handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Layering baseline

Apply on top of the R8A-applied working tree produced from OPUS commit:

`9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`

R8A has not been accepted. Its owner validation failed with `OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED`.

## Artifact

`opus_p117w_r45b2a4bz2r8a1_repeated_acl_guard_repair.zip`

ZIP SHA-256:

`8b5f1f00f749440ffe0388729800931ab94754ddc75daf8364b9a3fdf27f921c`

Applicator SHA-256:

`c2900d014b7b546a37a778b286ea249cd0c55e7004d1952703ecf6ca32d46054`

The ZIP contains exactly one differential applicator: `apply_a4bz2r8a1.php`.

The assistant does not commit/push OPUS/OWASYS.

## Exact repair scope

One file only:

- `sites/owasys-front/application/default/services/FsmGuardHandlers.php`

Expected R8A source SHA-256 before repair:

`a677db775bfe4835d46549ae9148135bf75d77195c098db9f8ab0c892123568d`

Expected source SHA-256 after repair:

`e7c03e31c351f2d895222057bad57f92e8ba726b120517e55676f463991f69a4`

## Corrected runtime semantics

- developer-managed guard map is checked once for forbidden `acl:*` IDs;
- canonical repeated references to the same dynamic ACL guard are idempotent;
- first ACL occurrence validates `acl:<resource>:<action>` and synthesizes the runtime callable;
- subsequent occurrences reuse it by `continue`, not by throwing a namespace collision;
- actual developer ownership of `acl:*` remains rejected.

## Verification performed before delivery

- final applicator `php -l`: OK;
- ZIP extraction: exactly one applicator;
- extracted applicator `php -l`: OK;
- exact R8A generated `FsmGuardHandlers.php` reconstructed and its expected pre-repair SHA-256 verified;
- repair applicator executed on an R8A-shaped fixture: success;
- repaired PHP lint: OK;
- exact post-repair SHA-256 verified;
- second applicator execution refused with exit code 20;
- behavioral runtime probe with test doubles:
  - two transitions referencing `acl:foo:read` produced one dynamic handler with no exception;
  - a second distinct `acl:bar:update` handler was synthesized;
  - dynamic handler executed `OwasysRuntimeSecurity::isAllowed()` with resource `foo`, action `read`;
  - a developer-managed `acl:foo:read` handler was still rejected with `OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED:acl:foo:read`.

## Expected applicator markers

`P117W_R45B2A4BZ2R8A1_APPLIED`

- `cause=repeated_dynamic_acl_guard_misclassified_as_managed_collision`
- `acl_namespace_check=managed_handlers_once`
- `repeated_acl_reference=idempotent`
- `changed_files=1`

## Owner validation

After applying R8A1:

1. lint `sites/owasys-front/application/default/services/FsmGuardHandlers.php`;
2. regenerate optimized Composer autoload;
3. run `composer opus:validate-site -- owasys-front`;
4. run `composer opus:validate-site -- owasys-back`;
5. relaunch/open OWASYS and verify normal page boot succeeds;
6. verify the top menu still has no `FSM` entry;
7. open developer EFSM designer and confirm the diagram renders;
8. inspect `git status --short`; the overall R8A differential should still be 17 paths, with this one file repaired in place;
9. do not commit/push until owner validation passes.

## Next slice

R8B graphical GUARD/ACTION source authoring only after successful owner validation of R8A + R8A1.