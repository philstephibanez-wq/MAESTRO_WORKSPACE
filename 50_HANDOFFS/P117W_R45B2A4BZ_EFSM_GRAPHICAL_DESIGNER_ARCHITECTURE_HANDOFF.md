# P117W R45B2A4BZ — Graphical EFSM designer architecture — HANDOFF

State: ARCHITECTURE ACCEPTANCE / NEXT IMPLEMENTATION = A4BZ1

## Intent

Build a full graphical EFSM designer directly on the existing native OPUS FSM diagram.

Primary toolbar requirement:

- state CRUD;
- transition CRUD;
- transition conditions/guards.

## Core decision

Do not build a second graph model.

- semantic source: canonical `fsm.json`;
- presentation geometry: `fsm.layout.json` only;
- rendering surface: existing native OPUS SVG diagram;
- mutation path: `owasys-front -> REST -> owasys-back -> Composer`;
- frontend UI: SCORE;
- backend: PHP only, no JavaScript.

## UX contract

A dedicated Design mode is required.

In View mode the current diagram retains runtime signal execution.

In Design mode all runtime transition execution is suppressed and diagram clicks become editor selection/manipulation. This is necessary so editing a transition cannot accidentally execute it.

Sticky toolbar:

`Select | State + Edit Delete | Transition + Edit Delete | Undo Redo | Validate | Publish | Exit`

State create: toolbar -> click canvas -> inspector.

Transition create: toolbar -> source state -> target state -> inspector.

Double-click/select existing state or transition to edit.

## Transition inspector

The user-facing transition editor includes:

- source/target;
- signal definition/reference;
- local/global scope and finite global sources;
- guards/conditions;
- actions;
- runtime memory operations;
- wildcard/default semantics where canonical contract permits them.

Guards/actions are selected from registered handlers. No arbitrary PHP expression editor.

Signal remains a first-class canonical entity even though its editing UX is embedded in the transition inspector.

## Draft / publish

Semantic CRUD edits operate on a validated draft first.

No unbounded server-side draft/replay store.

Draft carries a `base_sha256` of the canonical FSM. Publish refuses to overwrite if the canonical source changed since design mode opened.

Canonical file is changed only by the secured backend Composer publish command after full validation.

Sources & Git remains responsible for Git commit/push.

## Geometry

Dragging a state, transition signal card, or other movable presentation object changes `fsm.layout.json` only.

Semantic create/update/delete changes `fsm.json` only through the semantic editor/publish pipeline.

Never infer semantic rank, guard, signal, action or target changes from pure drag geometry.

## Generic OPUS first

Implement generic semantic editing/validation in OPUS before OWASYS-specific designer controllers.

Planned generic contracts:

- `FsmDefinitionEditorInterface` / `FsmDefinitionEditor`;
- `FsmDefinitionValidatorInterface` / `FsmDefinitionValidator`;
- later optional semantic diff service.

New concrete framework classes must satisfy README-FIRST homonymous-interface requirements.

## Implementation slices

### Next: A4BZ1

Design-mode shell only:

- toolbar rendered through SCORE;
- switch View/Design;
- state/transition selection;
- read-only inspector populated from canonical semantic object;
- design mode disables runtime signal execution;
- existing drag/persisted layout behavior remains intact;
- no state/transition write yet.

This deliberately proves the interaction model before adding mutation.

### Then A4BZ2

State CRUD on a validated draft.

### Then A4BZ3

Transition + signal CRUD, graphical source->target creation, guard/action/runtime-operation builders.

### Then A4BZ4

Secured REST/back/Composer Publish with base-hash concurrency and profiler correlation.

### Then A4BZ5

Undo/redo, diagnostics overlay, keyboard UX, presentation auto-layout/reset.

## Validation focus for A4BZ1

- no duplicate FSM model introduced;
- canonical diagram remains visually identical outside Design mode;
- design mode cannot execute a user-origin signal;
- selecting a state shows canonical state fields;
- selecting a transition shows canonical signal/source/target/guards/actions/runtime operations;
- exiting Design mode restores normal runtime actionability;
- no backend JavaScript;
- no semantic source mutation.

## Workspace specification

`40_SPECS/P117W_R45B2A4BZ_EFSM_GRAPHICAL_DESIGNER_ARCHITECTURE_SPEC.md`

Specification commit:

`757e2374ae36642e87b02a26e5c9167d24d627e8`
