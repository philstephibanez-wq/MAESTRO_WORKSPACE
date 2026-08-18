# P117W R45B2A4AY — Guarded FSM Transition Inspection

State: SPEC + CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Owner decision

On 2026-08-18 the owner accepted the guarded/conditional FSM direction described after A4AX.

Canonical model:

`current_state + signal + guards(context) -> transition enabled|denied -> actions -> target_state`

A guard is a pure predicate. It may read runtime facts and FSM state but must not mutate FSM state, memory or stack. Actions remain the mutation/effect phase after guards have accepted the transition.

The model remains a finite state machine with guarded transitions (EFSM in formal terminology).

## Cause addressed by A4AY

OPUS `FsmProcessor` already evaluates transition guards during `transition()`, including built-in guards such as `app_exists`, `current_app_required`, `must_change_password`, and application-supplied guard handlers.

However the UI/actionability layers have no non-mutating public way to ask the FSM processor whether the exact transition is currently enabled. OWASYS therefore currently recalculates availability using parallel ACL/current-app/route rules in NavigationBuilder and related projection code.

That duplication prevents FSM + guards from being the single authority.

## Generic OPUS evolution

A4AY changes only the generic FSM processor contract.

### `FsmProcessorInterface`

Adds:

`inspectTransition(string $currentState, string $signal, array $context = []): array`

The interface continues to extend directly the four mandatory OPUS framework contracts.

### `FsmProcessor`

Adds the non-mutating inspection contract:

`OPUS_FSM_TRANSITION_INSPECTION_V1`

The returned decision contains:

- FSM name;
- current state;
- requested signal;
- transition found/not found;
- enabled/denied;
- reason: `enabled`, `guard_refused`, or `transition_not_found`;
- transition id and scope;
- target state;
- canonical guard list;
- per-guard result;
- failed guard list;
- transition actions;
- target state definition.

`inspectTransition()` does not change current state, memory, stack, and intentionally does not emit execution profiler events.

`transition()` now consumes `inspectTransition()` instead of maintaining a second guard-evaluation path. Execution therefore uses the same decision that future Menu = FSM and diagram actionability will consume.

## Guard purity

A4AY enforces that a guard handler cannot mutate FSM runtime state.

Before each guard evaluation the runtime snapshot is captured. If the guard changes state, memory or stack, OPUS restores the snapshot and rejects it with:

`OPUS_FSM_GUARD_MUTATED_RUNTIME:<guard>`

This enforces the accepted separation:

- guards = conditions only;
- actions/runtime operations = mutations only.

External side effects outside the FSM object cannot be mechanically detected and remain forbidden by contract.

## Determinism in A4AY

A4AY deliberately preserves the current deterministic transition-selection contract:

- one local transition per `(state, signal)`;
- one finite global transition per `(source state, signal)`;
- local exact transition wins over ordinary global;
- NMI remains the sole preemptive wildcard source.

Conditional branching to multiple different target states for the same `(state, signal)` is not introduced in this foundation delivery. It is not needed to establish guard-aware actionability and would require a separate ambiguity contract.

## No OWASYS workflow topology change yet

A4AY does not alter:

- `sites/owasys-front/config/fsm.json`;
- the six-workspace development mesh;
- Menu = FSM;
- FSM diagram;
- REST/routing;
- ACL/SSO;
- SCORE;
- profiler persistence.

The next OWASYS delivery must instantiate the same FsmProcessor/guard context for projection and replace duplicated actionability checks with the A4AY inspection result before new business-readiness guards are added.

## Acceptance

1. PHP lint for both delivered files.
2. `inspectTransition()` on a denied guard returns `enabled=false`, identifies the failed guard, and leaves snapshot unchanged.
3. The same transition with satisfied context returns `enabled=true` and leaves snapshot unchanged.
4. Missing transition returns `transition_found=false`, `enabled=false` without mutation.
5. Ordinary global transitions are inspectable.
6. `transition()` on denied guard still raises `OPUS_FSM_GUARD_FAILED:<guard>`.
7. `transition()` on accepted guard still executes target/runtime operations.
8. A mutating guard is rolled back and rejected with `OPUS_FSM_GUARD_MUTATED_RUNTIME:<guard>`.
9. No OWASYS FSM topology/UI regression.
