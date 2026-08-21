# P117W R45B2A4BZ2R4 — EFSM state action semantics

State: ARCHITECTURE CORRECTION — IMPLEMENTATION REQUIRED

## User correction

A state in the graphical EFSM designer must not be presented primarily through an OWASYS `module` concept. The semantic notion exposed by the FSM designer is **action**.

## Root cause

The current OWASYS `fsm.json` stores application dispatch metadata (`module`, `route`, template/auth/navigation metadata) directly on each state. The generic `FsmProcessor` itself does not require `module` to define a state; it validates state identity, initial/entry semantics and transition relations. `FsmSiteLoader`, however, currently derives application modules from state metadata, which couples application dispatch topology to FSM state semantics.

This coupling must not define the graphical EFSM model.

## Correct semantic model

A state is represented by:

- `id`;
- semantic type / role (`entry`, normal, final where applicable);
- state actions;
- incoming transitions;
- outgoing transitions;
- self transitions;
- optional extended-state/memory semantics.

### State action phases

State behavior uses explicit registered action identifiers:

- `entry_actions`: executed when the state becomes active;
- `do_actions`: state activity while active, when the runtime contract supports an explicit invocation point;
- `exit_actions`: executed before leaving the state.

No arbitrary PHP is editable in the designer. Actions are selected from an allow-listed OPUS action registry/handler catalog.

Transition actions/effects remain distinct from state actions:

`source.exit_actions -> transition guards -> transition actions/effects -> target.entry_actions`

`do_actions` are not transition effects.

## Designer state inspector

Primary EFSM section:

- State ID;
- role/type;
- Initial / Final flags where canonical contract allows them;
- Entry actions;
- Do actions;
- Exit actions;
- Incoming transition count/list;
- Outgoing transition count/list;
- self-loop count/list.

There is no `module` field in the semantic state editor.

OWASYS routing/navigation implementation details, while still temporarily present in the existing source contract, must not be presented as FSM state semantics.

## Generic OPUS evolution

The next implementation must be generic OPUS-first:

1. extend the canonical FSM state contract to support state action lists;
2. extend `FsmProcessor` validation for registered state action identifiers;
3. define deterministic state-action execution order;
4. expose action registry metadata to the designer through a generic OPUS service;
5. decouple `FsmSiteLoader` module discovery from `states[].module` before removing that legacy field from canonical application FSMs.

Any new concrete OPUS framework class must implement its homonymous interface extending directly the four mandatory framework interfaces.

## Compatibility migration

Do not delete `module` immediately from existing OWASYS `fsm.json` while `FsmSiteLoader` still derives module directories from it.

Migration is two-stage:

### Stage 1

- designer stops exposing `module` as state semantics;
- state actions become first-class canonical semantics;
- current application routing metadata remains compatibility-only and read-only/advanced until dispatch is decoupled.

### Stage 2

- generic OPUS dispatch/module discovery is decoupled from state records;
- OWASYS FSM source is migrated so state semantic records no longer carry module ownership;
- application routing bindings move to an application binding/dispatch contract outside the FSM semantic state object.

## Runtime order

For transition `S --signal--> T`:

1. resolve transition;
2. evaluate guards without mutation;
3. if enabled, execute `S.exit_actions`;
4. execute transition actions/effects/runtime operations;
5. update current state to `T` according to processor atomicity contract;
6. execute `T.entry_actions`;
7. persist runtime snapshot only after successful completion.

Failure semantics must be transactional or explicitly compensating; no half-transition state is acceptable.

## Acceptance

- state designer contains no primary `module` editor;
- state action semantics are visible and editable as registered action identifiers;
- entry/do/exit are distinguishable from transition effects;
- module/routing implementation metadata is not confused with EFSM semantics;
- existing OWASYS remains deployable during migration;
- final architecture removes the semantic dependency `state -> module`.