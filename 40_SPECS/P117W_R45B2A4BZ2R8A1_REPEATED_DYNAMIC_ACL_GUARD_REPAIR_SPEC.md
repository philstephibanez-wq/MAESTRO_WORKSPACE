# P117W R45B2A4BZ2R8A1 — Repeated dynamic ACL guard repair

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Context

R8A introduced a managed PHP authority for developer-programmed EFSM GUARD/ACTION handlers and retained `acl:*` guards as dynamic application-security guards.

Owner validation of R8A failed during normal OWASYS rendering with `OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED`.

## Root cause

`OwasysFsmGuardHandlers::forConfig()` used one `$handlers` map for both:

- developer-managed application guards loaded from `FsmDeveloperHandlers.php`;
- dynamic `acl:*` guards synthesized while scanning canonical transitions.

The implementation checked `isset($handlers[$guard])` for every `acl:*` reference and raised a namespace collision. The first occurrence legitimately synthesized the dynamic handler; a second transition referencing the same ACL relation then found that synthesized handler and was incorrectly rejected as though a developer had defined an `acl:*` guard.

Repeated references to a dynamic ACL guard are valid and must be idempotent.

## Correction

The reserved namespace invariant is checked exactly once, immediately after loading developer-managed guards:

- any developer-managed guard whose ID starts with `acl:` remains a blocking `OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED:<id>` error;
- during transition scanning, an `acl:*` handler already present in the runtime map is treated as an already-synthesized dynamic handler and skipped;
- first occurrence still validates `acl:<resource>:<action>` and creates the callable through `OwasysRuntimeSecurity::isAllowed()`.

No generic OPUS engine change is required: this is application-owned OWASYS ACL adapter behavior.

## Differential scope

Exactly one R8A path changes:

- `sites/owasys-front/application/default/services/FsmGuardHandlers.php`

The repair is applied on top of the R8A-applied working tree. It does not revert or duplicate any other R8A file.

## Acceptance

- normal OWASYS page boot no longer fails when the same `acl:*` guard is referenced by multiple transitions;
- repeated dynamic ACL guard reference produces one runtime handler and no collision;
- different dynamic ACL guards are synthesized independently;
- developer-managed `acl:*` guard remains rejected;
- synthesized ACL guard delegates to `OwasysRuntimeSecurity::isAllowed()`;
- PHP lint passes;
- R8A's 17-path working-tree differential remains 17 paths after repair;
- owner validates `owasys-front` and `owasys-back` before commit/push.

## Next slice

R8B graphical GUARD/ACTION source authoring remains blocked until this owner validation succeeds.