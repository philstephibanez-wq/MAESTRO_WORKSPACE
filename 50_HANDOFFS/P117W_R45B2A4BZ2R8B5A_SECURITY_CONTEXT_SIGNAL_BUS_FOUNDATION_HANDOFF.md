# P117W R45B2A4BZ2 R8B5A — SecurityContext + SignalBus foundation handoff

State: FAILED PREFLIGHT — SUPERSEDED BY R8B5A1

## Authoritative baseline

OPUS GitHub `master`:

`9031967e6f57929208b950920cd665d6ee6b749c`

`opus_p117w_r45b2a4bz2r8b4c_system_security_micro_efsm_registry_repair`

## Intended R8B5A concern

R8B5A was intended to establish the first autonomous OWASYS-front Security runtime and bounded inter-EFSM COMMAND/EVENT transport foundation.

Intended differential: 10 paths, with no `sites/owasys-back` change.

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

## Failed artifact

ZIP:

`opus_p117w_r45b2a4bz2r8b5a_security_context_signal_bus_foundation.zip`

ZIP SHA-256:

`7f0f61e02bacb966f0a2a548f1a3cbc380bb3963b2b5ff237971656af4236d94`

Applicator:

`apply_a4bz2r8b5a.php`

Applicator SHA-256:

`5cbd07c070c201a678053925138537dc5eff0414a47f856f49d31570b320686f`

## Owner evidence

Owner execution stopped during preflight before any repository write:

`P117W_R45B2A4BZ2R8B5A_PHP_PARSE_INVALID:sites/owasys-front/application/security/controllers/SecurityController.php:syntax error, unexpected token ","`

Owner `git status --short` was empty immediately afterwards.

Therefore OPUS remained unchanged at the authoritative R8B4C baseline.

## Root cause

The applicator used two consecutive nowdoc replacements in the SecurityController transform.

The main replacement opened its replacement body with nowdoc identifier `NEW` but incorrectly closed that body with identifier `OLD`.

Because the applicator itself was still syntactically valid, PHP treated the following applicator source — including the second `replaceOnceR8B5A(...)` call — as literal contents of the first `NEW` nowdoc until a later `NEW` terminator was reached.

That applicator source was therefore staged inside `SecurityController.php`, where TOKEN_PARSE correctly rejected it with `unexpected token ","`.

This is an applicator-construction defect. It is not an OPUS runtime/source defect.

## Supersession

R8B5A is not to be reused.

R8B5A1 repairs only the applicator construction/provenance layer. Functional R8B5A intent and the exact 10-path repository differential are unchanged.

R8B5A1 additionally checks that no applicator-source fragment leaked into staged SecurityController content and reports PHP parse line numbers on any future parse failure.
