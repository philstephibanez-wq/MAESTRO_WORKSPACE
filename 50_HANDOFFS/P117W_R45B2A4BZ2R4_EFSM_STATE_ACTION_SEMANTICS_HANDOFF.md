# P117W R45B2A4BZ2R4 — EFSM developer-programmed handlers — HANDOFF

State: CORRECTED CONTRACT — PREVIOUS STATE-ACTION MODEL REJECTED

## Fixed invariants

- OPUS is a framework; its execution engine is the EFSM.
- State is an EFSM state, not a module/route/page/action container.
- Signal origin is USER or AUTOMATE (`automatic`).
- Transition owns signal + guards + developer actions + native runtime operations + target.
- Guards are predicates programmed and registered by the developer.
- Actions are code programmed and registered by the developer.
- `push`, `pop`, `poke`, `peek` are native EFSM runtime primitives, distinct from developer actions.
- Routes are runtime consequences of signal/transition execution, never constitutive state semantics.
- The designer is a development tool: it must eventually let the developer program real guard/action PHP handlers, not merely type dangling names.

## Rejected interpretations

Do not introduce:

- `entry_actions`;
- `do_actions`;
- `exit_actions`;
- framework-invented business action opcodes;
- `module`/`route` as primary state fields in the EFSM inspector.

## Current code cause to treat

`FsmProcessor` accepts developer guard callables but still hard-codes several OWASYS/application guard semantics. That violates the framework/EFSM separation.

`FsmActionDispatcher` already follows the right direction: action IDs are resolved only through explicitly registered developer handlers.

## Next deliverable

P117W R45B2A4BZ2R5 — developer handler truth + EFSM-only inspector foundation.

R5 must:

1. remove hard-coded application guard semantics from generic `FsmProcessor`;
2. move the required OWASYS guard behavior into `OwasysFsmGuardHandlers` so existing behavior is preserved;
3. expose real guard/action handler catalogs to the designer snapshot;
4. remove module/route/template/auth/navigation fields from the EFSM state inspector;
5. present transition guards/actions/runtime operations as distinct EFSM concepts;
6. keep the current R2 stateless draft/distributed mutation contract intact;
7. prepare, but not fake, the next handler-code authoring slice.

R5 is not allowed to claim that PHP handler authoring is complete unless real source mutation through the secured OWASYS workflow is implemented and tested.
