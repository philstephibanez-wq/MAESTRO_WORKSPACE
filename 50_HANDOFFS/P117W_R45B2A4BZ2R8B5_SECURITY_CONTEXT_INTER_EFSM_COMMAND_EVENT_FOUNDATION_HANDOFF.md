# P117W R45B2A4BZ2 R8B5 — SecurityContext + inter-EFSM COMMAND/EVENT foundation handoff

State: ACTIVE — IMPLEMENTATION SPLIT INTO R8B5A THEN R8B5B

## Current authoritative OPUS baseline

GitHub `master` was re-read after owner R8B4C acceptance and push.

Current HEAD:

`9031967e6f57929208b950920cd665d6ee6b749c`

`opus_p117w_r45b2a4bz2r8b4c_system_security_micro_efsm_registry_repair`

Compare against the prior HEAD confirms R8B4C contains exactly the expected four system Security registry/source paths.

## Parent design

The R8B5 parent specification remains the architectural target:

- autonomous Security runtime ownership;
- read-only/writer SecurityContext split;
- generic inter-EFSM SignalBus;
- COMMAND/EVENT distinction and causality;
- Navigation and Security current states remain private;
- real Security reauthentication lifecycle ownership.

## Delivery split

To keep one validation concern per differential, implementation is split:

### R8B5A — READY FOR OWNER APPLY

Delivers:

- `FsmSignalBusInterface` + `FsmSignalBus`;
- additive `FsmProcessorInterface::transition()` declaration;
- SecurityContext read-only/writer contracts;
- independent OWASYS-front Security EFSM session/runtime;
- COMMAND `enter_security_context` Navigation -> Security;
- EVENT `security_context_ready` Security -> Navigation;
- correlation/causation and Logger/Profiler metadata instrumentation.

Authoritative child spec:

`40_SPECS/P117W_R45B2A4BZ2R8B5A_SECURITY_CONTEXT_SIGNAL_BUS_FOUNDATION_SPEC.md`

Authoritative child handoff:

`50_HANDOFFS/P117W_R45B2A4BZ2R8B5A_SECURITY_CONTEXT_SIGNAL_BUS_FOUNDATION_HANDOFF.md`

### R8B5B — GATED BY R8B5A OWNER ACCEPTANCE

Will bind the real fresh-auth path to Security EFSM transitions:

- `reauth_required`;
- `reauthentication_succeeded`;
- `reauthentication_failed`.

Navigation must remain independently in its own `security` state during that lifecycle.

## Rule

Do not generate or apply R8B5B before R8B5A runtime acceptance. Do not mix the two concerns into one owner commit.
