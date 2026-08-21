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
- State: Create / Edit / Rename / Delete;
- Transition: Create / Edit / Rename / Delete;
- Condition: Create / Edit / Rename / Delete when condition catalog support is available;
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

## Semantic rename / refactor operations

Rename is not implemented as delete + create and not as blind text replacement. It is an atomic semantic refactor command with dependency analysis and validation.

### Rename state

Renaming a state ID must update every canonical reference in the same draft transaction, including as applicable:

- `states[].id`;
- `initial_state`;
- transition `from`;
- transition `next_state` / target;
- finite global `from_states`;
- state-keyed semantic metadata owned by the canonical FSM contract.

Presentation references in `fsm.layout.json` are migrated separately but atomically with the semantic rename so the visual placement is preserved.

The rename is rejected if the target ID already exists or if any dependent reference cannot be migrated deterministically.

### Rename transition

Renaming a transition ID updates:

- the canonical transition ID;
- transition-keyed persisted geometry in `fsm.layout.json`;
- any designer/runtime metadata whose identity contract is explicitly transition-ID based.

It does not change signal identity, source, target, guards or actions.

### Rename condition / guard

The current canonical model represents transition conditions as guard references. To support reliable graphical CRUD/rename, conditions must have stable semantic identity rather than being edited as arbitrary PHP text.

Preferred generic evolution: introduce/standardize a first-class condition/guard catalog whose entries have:

- condition ID;
- registered handler/binding;
- optional description/schema metadata.

Transitions reference condition IDs. `renameCondition(old,new)` then updates the catalog ID and every transition guard reference atomically.

Until this catalog exists, a guard rename is permitted only when OPUS can prove that the guard token is a registered symbolic handler identifier and can migrate every reference safely. Arbitrary PHP/expression text remains forbidden.

The same refactor principle may later be reused for signal/action renaming where their canonical identity warrants it.

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

## Editable Bézier transition geometry

All normal transition arrows should use cubic Bézier presentation geometry in Design mode, while preserving the semantic source/target endpoints.

### Geometry model

A transition curve is represented as:

`P0 -> C1 -> C2 -> P3`

where:

- `P0` is the source anchor/port;
- `P3` is the target anchor/port;
- `C1` and `C2` are draggable Bézier control points.

The rendered SVG path uses a cubic `C` command.

### Interactive editing

When a transition is selected in Design mode:

- show source/target anchors;
- show two control handles;
- draw light helper lines `P0-C1` and `C2-P3`;
- dragging C1/C2 updates only presentation geometry;
- dragging the signal card remains independent from curve editing;
- a `Reset curve` command restores generic automatic routing.

Self loops also use Bézier geometry with loop-specific control points.

### Persistence

Bézier control geometry belongs only to `fsm.layout.json`.

Prefer storing control points as offsets relative to the attached source/target anchors rather than absolute coordinates. This allows a state to move while retaining the visual character of its connected curve.

Suggested transition layout payload:

```json
{
  "path_kind": "cubic_bezier",
  "source_control": {"dx": 90, "dy": 0},
  "target_control": {"dx": -90, "dy": 0},
  "label_x": 0,
  "label_y": 0
}
```

Exact storage schema remains an OPUS generic layout contract decision. Semantics are never inferred from control-point geometry.

### Automatic routing fallback

If no manual Bézier control geometry is persisted, the generic OPUS renderer computes deterministic cubic Bézier control points from source/target ports and collision/routing rules.

Manual geometry wins only for the selected transition's presentation. Delete/reset of manual geometry returns to automatic routing.

## Generic OPUS layer

The semantic editing engine must be generic OPUS functionality before OWASYS-specific UI is added.

Proposed components:

- `FsmDefinitionEditorInterface` / `FsmDefinitionEditor`;
- `FsmDefinitionValidatorInterface` / `FsmDefinitionValidator`;
- optional `FsmDefinitionDiffInterface` / `FsmDefinitionDiff` for diagnostics/preview;
- extension of the native FSM diagram component with design-mode selection metadata and designer interaction hooks;
- generic Bézier transition-layout support in the renderer/layout persistence layer.

Every new concrete OPUS class must implement a homonymous interface extending directly the four mandatory OPUS framework interfaces.

The editor API is semantic and entity-based, not text-patch based:

- create/update/rename/delete state;
- create/update/rename/delete signal where supported by canonical identity rules;
- create/update/rename/delete transition;
- create/update/rename/delete condition/guard catalog entries;
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

- FSM state resource: CRUD + rename/refactor;
- FSM transition resource: CRUD + rename/refactor;
- FSM signal resource: CRUD + rename/refactor where enabled;
- FSM condition resource: CRUD + rename/refactor;
- FSM layout resource: update/reset Bézier/control geometry;
- FSM publish capability separated from ordinary draft editing.

SSO identity, CSRF protection, REST authentication and existing OWASYS front/back correlation remain mandatory.

## Validation / diagnostics

Publish is disabled on blocking diagnostics.

At minimum validate:

- unique state/signal/transition/condition IDs;
- valid initial state;
- every transition source/target exists;
- every referenced signal exists;
- every referenced condition/guard exists and is registered;
- signal origin/type contract;
- registered guard/action handlers;
- runtime-operation schema;
- global scope/from_states consistency;
- navigation/module/route contract where applicable;
- no illegal deletion dependencies;
- semantic rename leaves no stale reference;
- layout semantics remain presentation-only;
- persisted Bézier geometry references existing transitions and finite numeric control points.

Non-blocking diagnostics may include unreachable states or orphaned non-referenced signal/condition definitions, according to the canonical contract.

Invalid objects are highlighted directly in the graph and listed in a diagnostics drawer.

## Profiler / audit

Designer activity must remain measurable and correlated:

- designer open;
- semantic draft command;
- semantic rename/refactor command;
- Bézier/layout edit;
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
- expose transition Bézier handles read-only/preview-ready metadata;
- no semantic mutation yet.

### A4BZ2 — State CRUD + rename

- generic OPUS state editor/validator;
- graphical create/edit/rename/delete state;
- atomic dependent-reference migration;
- dependency diagnostics;
- draft redraw;
- no Publish yet.

### A4BZ3 — Transition + signal + condition CRUD/refactor

- graphical source->target creation;
- signal inspector;
- condition/guard catalog and rename support;
- guard/action/runtime-operation builders;
- create/edit/rename/delete transition;
- draft redraw.

### A4BZ3B — Bézier transition editor

- generic cubic Bézier routing for normal transitions;
- control-point handles in Design mode;
- relative persisted control geometry;
- self-loop Bézier support;
- reset-to-automatic routing;
- no semantic mutation from geometry edits.

### A4BZ4 — Secure publish

- front REST gateway;
- back validation;
- allow-listed Composer publish command;
- optimistic `base_sha256` conflict protection;
- canonical atomic write;
- profiler correlation.

### A4BZ5 — UX completion

- bounded undo/redo covering semantic refactors and layout edits;
- keyboard shortcuts;
- diagnostics overlay/drawer;
- explicit orphan cleanup;
- auto-layout/reset-layout commands that affect presentation only.

## Acceptance principle

The graphical designer is an editor of the canonical EFSM, not a competing model. A round trip:

`canonical fsm.json -> designer -> publish -> canonical fsm.json`

must preserve every semantic field not explicitly modified by the user.

A rename must be a dependency-safe semantic refactor. A Bézier edit must be presentation-only.