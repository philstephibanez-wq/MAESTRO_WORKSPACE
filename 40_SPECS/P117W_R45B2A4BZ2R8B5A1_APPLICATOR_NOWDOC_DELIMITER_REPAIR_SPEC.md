# P117W R45B2A4BZ2 R8B5A1 — Applicator nowdoc delimiter repair

State: DELIVERY TARGET

## Source-of-truth gate

This repair was prepared only after re-reading the current `README-FIRST.md` and current OPUS GitHub `master`.

Authoritative OPUS baseline remains:

`9031967e6f57929208b950920cd665d6ee6b749c`

`opus_p117w_r45b2a4bz2r8b4c_system_security_micro_efsm_registry_repair`

Owner evidence confirms the failed R8B5A preflight wrote no repository files and left `git status --short` empty.

## Cause

R8B5A's SecurityController applicator transform opened the main replacement body with nowdoc identifier `NEW` but closed that replacement with `OLD`.

PHP therefore consumed the following applicator code as literal staged SecurityController text until a later `NEW` terminator. TOKEN_PARSE then correctly failed on the leaked applicator syntax.

## Repair

R8B5A1 changes the faulty replacement terminator from `OLD` to `NEW` so that the two intended SecurityController transformations are separate executable applicator statements.

No OPUS/OWASYS functional change is added or removed relative to intended R8B5A.

The exact intended repository differential remains 10 paths:

Modified:

- `Opus/Fsm/FsmProcessorInterface.php`
- `sites/owasys-front/application/default/bootstrap.php`
- `sites/owasys-front/application/security/controllers/SecurityController.php`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/config/security.fsm.json`

New:

- `Opus/Fsm/FsmSignalBusInterface.php`
- `Opus/Fsm/FsmSignalBus.php`
- `sites/owasys-front/application/security/services/SecurityContextInterface.php`
- `sites/owasys-front/application/security/services/SecurityContextWriterInterface.php`
- `sites/owasys-front/application/security/services/SecurityContext.php`

No `sites/owasys-back` path changes.

## Added applicator integrity gates

Before write, R8B5A1 now additionally requires:

- staged SecurityController contains no leaked `$staged[$p]=replaceOnceR8B5A` applicator fragment;
- staged SecurityController contains no `:runtime-helpers` applicator label fragment;
- exactly one `synchronizeSecurityRuntime()` helper is staged;
- exactly one `coordinateSecurityContext()` helper is staged;
- exactly one `signalBus()` helper is staged;
- PHP parse failures include the parser line number.

## Construction validation

Performed before delivery:

- corrected applicator PHP lint: PASS;
- bad delimiter occurrence count: 0;
- correct `NEW` delimiter occurrence for the affected transform: 1;
- main SecurityController replacement and helper replacement extracted independently: PASS;
- applicator-source leakage into either replacement body: 0;
- synthetic SecurityController containing both final injected blocks: PHP lint PASS.

## Acceptance

The owner must apply only on exact HEAD `9031967e6f57929208b950920cd665d6ee6b749c` with clean worktree/index.

Required successful markers use prefix:

`P117W_R45B2A4BZ2R8B5A1_`

After apply, repository status must contain exactly the 10 intended paths. No commit/push before CLI/runtime validation.
