# P117W R45B2A4BZ2R5 — Developer-programmed EFSM guard runtime

State: IMPLEMENTED FOR OWNER VALIDATION

## Contract

OPUS is a framework whose execution engine is the EFSM. The generic EFSM engine must not embed OWASYS/application-specific guard semantics.

A named guard referenced by an EFSM transition is executable application code programmed and registered by the developer. The generic `FsmProcessor` only invokes the registered callable and enforces guard purity (no EFSM state/memory/stack mutation during guard evaluation).

Actions remain developer-programmed handlers dispatched separately by `FsmActionDispatcher`. Native `push`, `pop`, `poke`, `peek` remain EFSM runtime primitives and are not developer business actions.

## Root cause treated

`Opus\Fsm\FsmProcessor` currently hard-codes named guard behavior such as `route_exists`, `app_exists`, `current_app_required`, `current_app_or_creation_request` and `must_change_password`. That makes application semantics part of the generic engine and contradicts the developer-programmed EFSM contract.

## Changes

1. `FsmProcessor::evaluateGuard()` owns no named application guard vocabulary after this slice.
2. Every referenced named guard must have a caller-provided registered handler.
3. Missing handler fails explicitly with `OPUS_FSM_GUARD_HANDLER_MISSING:<guard>`.
4. Existing OWASYS compatibility guard implementations move to `sites/owasys-front/application/default/services/FsmGuardHandlers.php` as actual application PHP handlers.
5. Dynamic `acl:<resource>:<action>` handlers remain application runtime handlers.
6. Existing guard-purity protection in `evaluateGuardPure()` is retained.
7. FSM state/module/route contamination is not expanded by this slice; `route_exists` is retained only as an OWASYS compatibility handler until dispatch/routing is decoupled from state records.
8. No JavaScript is added to owasys-back.

## Designer consequence

This slice establishes the runtime truth required by the graphical EFSM developer IDE: a guard name corresponds to real developer-programmed PHP, not to semantics secretly implemented by the framework. The following designer slice can therefore expose handler catalog/source authoring without inventing executable behavior.

## Framework class rule

No new concrete OPUS framework class is introduced by this slice. Existing `FsmProcessor` continues implementing `FsmProcessorInterface`.

## Acceptance

- generic `FsmProcessor` contains no OWASYS/application guard implementation;
- registered developer guard is executed;
- unregistered guard is rejected explicitly;
- OWASYS current guard behavior is preserved through application handlers;
- guard purity remains enforced by the processor;
- actions and native EFSM runtime operations remain distinct layers;
- no backend JavaScript/Node impact;
- delivery is a direct differential ZIP applicator only, with no OPUS/OWASYS commit by the assistant.
