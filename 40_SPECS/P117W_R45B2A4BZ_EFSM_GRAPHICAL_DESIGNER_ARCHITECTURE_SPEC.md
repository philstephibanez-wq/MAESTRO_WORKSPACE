# P117W R45B2A4BZ — Graphical EFSM designer architecture

State: ARCHITECTURE DEFINED — IMPLEMENTATION TO BE INCREMENTAL

## Objective

Turn the existing OPUS native EFSM diagram into a complete graphical designer without creating a second FSM model.

The designer must allow graphical CRUD of states and transitions, including transition guards/conditions, while preserving the canonical OPUS/OWASYS contracts.

## Non-negotiable architecture

### One semantic source of truth

`fsm.json` remains the sole semantic source of truth.

The designer must never introduce an independent graph document, browser-only FSM model, Mermaid source, duplicated database FSM, or generated PHP FSM.

### Presentation geometry remains separate

`fsm.layout.json` remains presentation-only:

- state x/y;
- transition path/label geometry;
- movable signal-card geometry;
- canvas metadata.

Moving an object changes layout only. Creating/updating/deleting a state, signal or transition changes FSM semantics.

### Existing diagram is the designer surface

The current native SVG renderer remains the rendering engine. Design interactions are added to that projection instead of creating another canvas implementation.

### OWASYS distributed command path

All semantic mutations follow the existing contract:

`owasys-front -> secured REST -> owasys-back -> allow-listed Composer -> owasys-back -> response -> owasys-front`

The frontend owns SCORE UI and presentation only. The backend owns validation/business mutation and contains no JavaScript.

## Designer modes

### View mode

Existing runtime behavior remains unchanged:

- actionable user signals may execute;
- current state is highlighted;
- signal colors retain user/automatic origin semantics.

### Design mode

Runtime transition execution is disabled on the diagram.

Clicks select semantic objects instead of firing application signals. This prevents accidental business operations while editing the machine.

## Toolbar

A sticky toolbar is projected above the existing diagram:

- Selection;
- State: Create / Edit / Delete;
- Transition: Create / Edit / Delete;
- Undo / Redo;
- Validate;
- Publish;
- Exit design mode.

Signal editing is exposed inside the transition inspector because a transition references a canonical signal, but signals remain first-class semantic entities in `fsm.json`.

## Direct graphical interactions

### State creation

1. activate `Create state`;
2. click empty canvas location;
3. open the SCORE inspector;
4. validate semantic fields;
5. render the draft state at the chosen initial geometry.

### State editing

Select or double-click a state and edit its semantic properties in the inspector.

Typical fields are derived from the canonical contract, not hardcoded as a second schema:

- id;
- type;
- module;
- route;
- template when applicable;
- authentication/current-app requirements;
- navigation visibility/order/label;
- diagram rank/order hints.

### State deletion

Deletion is blocked while unresolved incident transitions exist. The UI must show the exact dependency set and require an explicit semantic choice rather than silently cascading.

The initial state cannot be deleted until another valid initial state is selected.

### Transition creation

1. activate `Create transition`;
2. select/drag from a source state;
3. select/drop on the target state;
4. configure the transition in the inspector;
5. validate;
6. redraw the draft.

### Transition editing

Selecting a transition edge or signal card opens the transition inspector.

### Transition deletion

Delete only the selected transition. If its referenced signal becomes orphaned, the designer reports that separately and offers explicit signal cleanup; it never silently removes shared signal semantics.

## Transition inspector

The inspector is structured rather than free-form PHP.

### General

- transition id;
- source;
- target / `next_state`;
- local/global scope;
- finite `from_states` for global transitions;
- wildcard/default semantics where supported by the canonical FSM contract.

### Signal

- canonical signal id;
- existing signal selection or explicit creation;
- signal type;
- origin: `user` or `automatic`;
- menu visibility/order/label metadata where valid.

### Guards / conditions

Conditions map to canonical transition guards.

The designer selects only registered/allowed guard handlers. Arbitrary PHP expressions are forbidden.

A guard list is ordered and represents conjunction semantics. Alternative OR paths are modeled as separate transitions, which keeps the EFSM explicit and graphically inspectable.

### Actions

Ordered selection of registered/allowed action handlers. Arbitrary PHP code is forbidden.

### Runtime memory operations

Structured editor for the canonical runtime-operation vocabulary, including the existing stack/memory operations (`push`, `pop`, `poke`, `peek`) and their schema-defined operands.

## Generic OPUS layer

The semantic editing engine must be generic OPUS functionality before OWASYS-specific UI is added.

Proposed components:

- `FsmDefinitionEditorInterface` / `FsmDefinitionEditor`;
- `FsmDefinitionValidatorInterface` / `FsmDefinitionValidator`;
- optional `FsmDefinitionDiffInterface` / `FsmDefinitionDiff` for diagnostics/preview;
- extension of the native FSM diagram component with design-mode selection metadata and designer interaction hooks.

Every new concrete OPUS class must implement a homonymous interface extending directly the four mandatory OPUS framework interfaces.

The editor API is semantic and entity-based, not text-patch based:

- create/update/delete state;
- create/update/delete signal;
- create/update/delete transition;
- set initial state;
- validate complete definition.

## Stateless draft contract

Do not introduce an unbounded server-side replay/draft store.

The design session carries:

- immutable `base_sha256` of the live FSM source;
- current validated draft definition;
- draft revision/hash;
- local undo/redo command history bounded in the browser session.

Each semantic command is sent to the backend and validated against the generic OPUS editor/validator. The backend returns the normalized draft and diagnostics.

No canonical file is changed until Publish.

## Publish and concurrency

Publish is optimistic and atomic:

1. backend re-reads the canonical FSM through OPUS File + StructuredFileLoader;
2. current source SHA-256 must equal the design session `base_sha256`;
3. the complete draft is validated;
4. Composer executes the allow-listed mutation/publish command;
5. canonical JSON is written atomically;
6. the resulting definition is re-read and revalidated;
7. frontend reloads the canonical machine and diagram.

A source-hash mismatch is a conflict, never an overwrite.

Git commit/push is not automatic; Sources & Git remains responsible for source-control operations.

## Rendering loop

After each accepted draft command:

1. backend returns normalized draft + diagnostics;
2. frontend passes the validated draft to the existing OPUS native renderer;
3. the SVG is regenerated;
4. current draft geometry is merged through `fsm.layout.json` presentation rules;
5. the SCORE designer surface replaces only the diagram/inspector fragment.

The live application navigation remains based on the published FSM until Publish, so an invalid/incomplete draft cannot strand the user in the application menu.

## ACL / security

Deny-by-default.

Suggested resource capabilities:

- FSM state resource: CRUD;
- FSM transition resource: CRUD;
- FSM signal resource: CRUD;
- FSM publish capability separated from ordinary draft editing.

SSO identity, CSRF protection, REST authentication and existing OWASYS front/back correlation remain mandatory.

## Validation / diagnostics

Publish is disabled on blocking diagnostics.

At minimum validate:

- unique state/signal/transition IDs;
- valid initial state;
- every transition source/target exists;
- every referenced signal exists;
- signal origin/type contract;
- registered guard/action handlers;
- runtime-operation schema;
- global scope/from_states consistency;
- navigation/module/route contract where applicable;
- no illegal deletion dependencies;
- layout semantics remain presentation-only.

Non-blocking diagnostics may include unreachable states or orphaned non-referenced signal definitions, according to the canonical contract.

Invalid objects are highlighted directly in the graph and listed in a diagnostics drawer.

## Profiler / audit

Designer activity must remain measurable and correlated:

- designer open;
- semantic draft command;
- REST validation request;
- backend validation;
- Composer publish;
- publish conflict/failure/success;
- final reload.

No secret or fabricated event data.

## Incremental implementation sequence

### A4BZ1 — Design-mode shell

- toolbar;
- select state/transition;
- SCORE inspector read-only;
- runtime signal execution disabled in design mode;
- no semantic mutation yet.

### A4BZ2 — State CRUD

- generic OPUS state editor/validator;
- graphical create/edit/delete state;
- dependency diagnostics;
- draft redraw;
- no Publish yet.

### A4BZ3 — Transition + signal CRUD

- graphical source->target creation;
- signal inspector;
- guard/action/runtime-operation builders;
- edit/delete transition;
- draft redraw.

### A4BZ4 — Secure publish

- front REST gateway;
- back validation;
- allow-listed Composer publish command;
- optimistic `base_sha256` conflict protection;
- canonical atomic write;
- profiler correlation.

### A4BZ5 — UX completion

- bounded undo/redo;
- keyboard shortcuts;
- diagnostics overlay/drawer;
- explicit orphan cleanup;
- auto-layout/reset-layout commands that affect presentation only.

## Acceptance principle

The graphical designer is an editor of the canonical EFSM, not a competing model. A round trip:

`canonical fsm.json -> designer -> publish -> canonical fsm.json`

must preserve every semantic field not explicitly modified by the user.