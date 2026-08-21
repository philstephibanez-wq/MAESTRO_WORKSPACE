# P117W R45B2A4BZ2R4 — EFSM developer-programmed transition semantics

State: ARCHITECTURE CORRECTED — SUPERSEDES THE PREVIOUS R4 STATE-ACTION INTERPRETATION

## Correction

OPUS is a framework whose execution engine is the EFSM. The EFSM model must stay EFSM-only.

A state is not a module, route, page, screen or action container. The previous R4 proposal introducing `entry_actions`, `do_actions` and `exit_actions` is rejected and must not be implemented.

## EFSM contract retained for OPUS

### State

A state carries EFSM state identity/role only:

- `id`;
- initial-state membership through the machine-level `initial_state` relation;
- final-state membership only where the canonical contract supports it.

Incoming/outgoing/self-transition counts are derived diagnostics, not state semantics.

### Signal

A signal is an EFSM input/event. OWASYS distinguishes the origin:

- `user`;
- `automatic` (automate).

Routes are consequences of signal/transition execution in the application runtime. A route is not a constitutive property of an EFSM state.

### Transition

A transition owns the executable EFSM relation:

- source state;
- signal;
- ordered guard/condition references;
- ordered developer action references;
- native EFSM runtime operations where declared;
- target state.

### Guards

Guards are real predicates programmed by the application developer and registered with the EFSM runtime. The generic OPUS engine must not invent application guard semantics.

A referenced guard without a real registered handler is invalid at execution time and must be diagnosed before publish by the designer validation path.

### Actions

Actions are real application code programmed by the developer and registered with the action dispatcher. The EFSM references the action identifier; the dispatcher executes the developer handler.

The action vocabulary is not a closed framework instruction set. Developers create new actions by writing real PHP handlers and registering them.

### Native EFSM operations

`push`, `pop`, `poke`, `peek` are native EFSM runtime/memory primitives. They are not developer business actions and must remain distinct from the action-handler layer.

## Designer contract

The graphical designer is a development tool/IDE for the OPUS EFSM. It must support both semantic graph editing and developer handler authoring.

It must therefore allow the developer to:

- create/edit/rename/delete states, signals and transitions according to the canonical EFSM contract;
- create/edit guards by programming real PHP guard handlers and registering them;
- create/edit actions by programming real PHP action handlers and registering them;
- attach ordered guards/actions to transitions;
- configure native runtime operations separately;
- validate that every referenced guard/action has a real handler before publish.

The designer must never create a dangling action/guard name and pretend that it is executable.

## Current code truth

`Opus\Fsm\FsmProcessor` already accepts developer guard callables, but it also still contains hard-coded application-specific guard implementations (`app_exists`, `current_app_required`, `must_change_password`, etc.). Those application semantics must leave the generic engine and live in application developer handlers.

`Opus\Fsm\FsmActionDispatcher` already requires explicit registered handlers and rejects missing actions. This is the correct action execution direction.

OWASYS already programs real action handlers in `application/default/services/FsmActionHandlers.php` and ACL guard handlers in `application/default/services/FsmGuardHandlers.php`.

## State metadata contamination

Current OWASYS `fsm.json` still carries `module`, `route`, template/auth/navigation and diagram metadata inside state records. That is legacy/application projection coupling, not the EFSM state semantic model.

The graphical EFSM inspector must stop presenting these fields as state semantics. Their runtime decoupling is a separate migration and must not be confused with the EFSM core.

## Immediate implementation direction

1. remove application-specific hard-coded guards from generic `FsmProcessor` while preserving behavior by registering them explicitly in OWASYS developer guard handlers;
2. expose the actual registered/programmable guard and action handler catalog to the designer;
3. make the state inspector EFSM-only;
4. make transition inspection distinguish signal, guards, developer actions and native runtime operations;
5. add handler-authoring integration in a following slice so a developer can create/edit real PHP guard/action code from the designer workflow;
6. keep all semantic mutations on the required distributed path front -> secured REST -> back -> allow-listed Composer -> response -> front.

Any new concrete OPUS framework class must implement a homonymous interface extending directly the four mandatory framework interfaces.

## Acceptance

- no `entry_actions`, `do_actions` or `exit_actions` are introduced;
- no `module` or `route` is presented as EFSM state semantics;
- guard semantics are developer code, not hard-coded application logic in the generic engine;
- action semantics are developer code registered with the dispatcher;
- native push/pop/poke/peek remain distinct;
- a missing referenced guard/action is rejected/diagnosed;
- the designer remains an EFSM development tool, not a JSON form or an application-page designer.
