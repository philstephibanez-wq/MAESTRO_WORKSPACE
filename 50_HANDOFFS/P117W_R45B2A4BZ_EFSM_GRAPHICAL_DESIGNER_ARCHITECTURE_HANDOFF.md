# P117W R45B2A4BZ — Graphical EFSM designer architecture — HANDOFF

State: ARCHITECTURE ACCEPTANCE / NEXT IMPLEMENTATION = A4BZ1

## Intent

Build a full graphical EFSM designer directly on the existing native OPUS FSM diagram.

Primary requirements now include:

- state CRUD + semantic rename;
- transition CRUD + semantic rename;
- condition/guard CRUD + rename;
- explicit signal membership in the human/user menu;
- editable cubic Bézier transition arrows.

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

In Design mode all runtime transition execution is suppressed and diagram clicks become editor selection/manipulation.

Sticky toolbar target:

`Select | State + Edit Rename Delete | Transition + Edit Rename Delete | Condition + Edit Rename Delete | Undo Redo | Validate | Publish | Exit`

State create: toolbar -> click canvas -> inspector.

Transition create: toolbar -> source state -> target state -> inspector.

Double-click/select existing state or transition to edit.

## Rename/refactor contract

Rename is atomic semantic refactoring, never delete/create and never blind text replacement.

### State rename

Migrates every canonical state reference in the same draft operation, including initial state, transition source/target, finite global sources and state-keyed metadata. Matching layout state key is migrated so placement survives.

### Transition rename

Migrates canonical transition ID and transition-keyed layout geometry without altering its source, target, signal, guards or actions.

### Condition rename

Preferred generic evolution is a first-class symbolic condition/guard catalog. Transitions reference condition IDs and rename migrates all references atomically. Arbitrary PHP expression editing/renaming is forbidden.

## Signal user-menu contract

The signal inspector must expose an explicit checkbox/toggle:

`Dans le menu utilisateur: Oui / Non`

It maps directly to canonical `signals[].menu`; there is no parallel menu configuration.

When enabled, expose the relevant canonical menu metadata such as:

- `menu_order`;
- I18n `label_key`;
- applicable menu host/state metadata.

Validation follows the existing OWASYS NavigationBuilder contract:

- only `origin=user` may be a human menu control;
- `navigation + menu=true` may project a top-level resource/navigation item;
- `command + menu=true` may project a resource-operation submenu/action;
- `outcome` and `system` never become human menu controls;
- automatic signals cannot be marked for the user menu;
- visibility/actionability still depends on current FSM state, guards, ACL and target availability.

The designer disables the toggle when a signal is structurally ineligible and shows the reason.

Changing menu membership is a semantic draft edit included in Undo/Redo, Validate and Publish.

## Bézier transition editing

Selected transitions in Design mode expose cubic Bézier handles:

`P0 -> C1 -> C2 -> P3`

- P0/P3 remain attached to source/target ports;
- C1/C2 are draggable control points;
- helper tangents appear while selected;
- signal-card position remains independently editable;
- self loops also use Bézier control geometry;
- `Reset curve` removes manual geometry and restores automatic routing.

Bézier geometry is presentation-only and persists in `fsm.layout.json`, preferably as control offsets relative to source/target anchors.

No semantic property may be inferred from curve geometry.

## Draft / publish

Semantic CRUD/refactor/menu edits operate on a validated draft first.

No unbounded server-side draft/replay store.

Draft carries a `base_sha256` of the canonical FSM. Publish refuses to overwrite if the canonical source changed since Design mode opened.

Canonical file is changed only by the secured backend Composer publish command after full validation.

Sources & Git remains responsible for Git commit/push.

## Generic OPUS first

Planned generic capabilities:

- `FsmDefinitionEditorInterface` / `FsmDefinitionEditor`;
- `FsmDefinitionValidatorInterface` / `FsmDefinitionValidator`;
- optional semantic diff service;
- generic semantic rename/refactor operations;
- generic signal menu-projection mutation/validation;
- generic cubic Bézier transition-layout persistence/rendering.

New concrete framework classes must satisfy README-FIRST homonymous-interface requirements.

## Implementation slices

### Next: A4BZ1 — Design-mode shell

- toolbar rendered through SCORE;
- switch View/Design;
- state/transition selection;
- read-only inspector populated from canonical semantic object;
- signal inspector already displays origin/type/menu/menu order/label metadata;
- design mode disables runtime signal execution;
- transition selection exposes Bézier handle metadata/preview without persistence edits yet;
- no semantic mutation.

### A4BZ2 — State CRUD + rename

- generic state editor/validator;
- create/edit/rename/delete state;
- dependency-safe reference migration;
- draft redraw.

### A4BZ3 — Transition/signal/condition CRUD + refactor

- graphical source -> target creation;
- create/edit/rename/delete transition;
- signal inspector and `Dans le menu utilisateur` toggle;
- condition/guard catalog and rename;
- guards/actions/runtime memory operations;
- draft redraw.

### A4BZ3B — Bézier transition editor

- cubic Bézier automatic routing;
- C1/C2 drag handles;
- relative control persistence;
- self-loop Bézier support;
- reset-to-automatic routing.

### A4BZ4 — Secure publish

- front REST gateway;
- back validation;
- allow-listed Composer publish command;
- optimistic `base_sha256` conflict protection;
- canonical atomic write;
- profiler correlation.

### A4BZ5 — UX completion

- bounded Undo/Redo for semantic refactors, menu edits and layout edits;
- keyboard shortcuts;
- diagnostics overlay/drawer;
- orphan cleanup;
- auto-layout/reset-layout.

## Validation focus for A4BZ1

- no duplicate FSM model;
- canonical diagram unchanged outside Design mode;
- Design mode cannot execute a user-origin signal;
- selecting a state shows canonical state fields;
- selecting a transition shows source/target/signal/guards/actions/runtime operations;
- signal inspector shows current `menu` status and eligibility reason;
- exiting Design mode restores runtime actionability;
- no backend JavaScript;
- no semantic mutation.

## Workspace specification

`40_SPECS/P117W_R45B2A4BZ_EFSM_GRAPHICAL_DESIGNER_ARCHITECTURE_SPEC.md`

Current specification commit:

`d4219c38fc00d8119b5f0b15ec00b73f7b4d76b6`
