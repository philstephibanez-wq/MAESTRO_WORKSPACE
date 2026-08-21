# P117W R45B2A4BZ1 — EFSM graphical designer design-mode shell

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Scope

Implement the first non-mutating slice of the graphical EFSM designer defined by P117W R45B2A4BZ.

A4BZ1 proves the interaction model on the existing native OPUS SVG diagram before semantic CRUD is introduced.

## Governing contracts

- `README-FIRST.md` is authoritative.
- `config/fsm.json` remains the sole semantic source of truth.
- `fsm.layout.json` remains presentation-only.
- no second graph/FSM model is introduced.
- OWASYS frontend UI remains SCORE-only.
- no JavaScript is added to `sites/owasys-back`.
- no semantic mutation and no REST/Composer mutation path exist in this slice.

## Permission model

Design mode is available only when ACL permits `fsm:update`.

- admin: allowed through `*:*`;
- developer: allowed through `fsm:*`;
- viewer: not allowed.

A request containing `fsm_design=1` without `fsm:update` must fail deny-by-default with `OPUS_ACL_DENIED:fsm:update`.

## Server-selected mode

View mode is the default.

Design mode is requested with the query parameter:

`fsm_design=1`

The mode is server-resolved so it is explicit, bookmarkable and profiler-visible.

When OPUS Profiler is already requested, entering/leaving design mode preserves `profiler=1`.

## Toolbar

The existing SCORE FSM partial receives the designer toolbar.

In View mode only the localized `Design` entry is exposed.

In Design mode the toolbar displays the target designer structure:

- Select;
- State: Create / Edit / Rename / Delete;
- Transition: Create / Edit / Rename / Delete;
- Condition: Create / Edit / Rename / Delete;
- Validate;
- Publish;
- return to View.

Only Select/View are active in A4BZ1. Semantic CRUD, Validate and Publish controls are deliberately disabled until later slices.

## Read-only canonical snapshot

When Design mode is active, `OwasysFsmDiagramBuilder` emits a read-only projection of the exact canonical objects already represented by the displayed diagram.

Contract:

`OWASYS_EFSM_DESIGNER_SNAPSHOT_V1`

Payload contains only projected/allowed:

- canonical states;
- canonical transitions;
- canonical referenced signals;
- initial/current state metadata.

The payload is JSON encoded then Base64 transported as a SCORE data attribute. It is an inspection projection, not an independent state machine and never becomes authoritative.

No payload is emitted outside active Design mode.

## Selection behavior

In active Design mode:

- clicking an SVG state selects that state;
- clicking an SVG transition, signal card or transition label selects that transition;
- selection visually highlights the canonical SVG object;
- the right-side inspector renders canonical field/value pairs with DOM `textContent`, never HTML injection.

State inspector fields include:

- `id`;
- `type`;
- `module`;
- `route`;
- `template`;
- authentication/current-app requirements;
- navigation metadata;
- diagram rank/order hints;
- whether the state is the initial state.

Transition inspector fields include:

- `id`;
- `from`;
- `next_state`;
- scope/from_states;
- signal;
- guards/conditions;
- actions;
- runtime operations;
- signal type/origin;
- `menu`, `menu_order`, `label_key`, `menu_state`, resource and operation;
- computed structural menu eligibility reason.

## Runtime action suppression

A4BZ1 must guarantee that inspection cannot execute the application.

While Design mode is active:

- signal links have browser hit-testing disabled;
- POST signal foreignObjects have browser hit-testing disabled;
- click and submit events are captured and cancelled before runtime handlers;
- Enter/Space activation of signal controls is cancelled.

View mode retains existing actionability unchanged.

Existing right-button layout dragging remains available where the generic layout store already marks geometry writable.

## Bézier preview

A4BZ1 does not persist editable Bézier controls yet.

When a selected transition is already represented by one simple cubic SVG path `M ... C ...`, the designer overlays read-only:

- P0 source endpoint;
- C1 source control;
- C2 target control;
- P3 target endpoint;
- tangent helper lines.

The inspector reports `layout.path_kind=cubic_bezier`.

Compound/non-simple current paths report `compound_or_none` and are left untouched. A4BZ3B will introduce generic editable/persisted Bézier control geometry.

## I18n

Designer command labels are resolved through `ApplicationTranslationRuntime` in the `default` module.

The applicator adds the A4BZ1 designer keys to every base-language catalog declared by `site.json -> i18n.catalog_base_locales`. Regional overlays continue to inherit their base catalog according to the existing explicit overlay policy.

Canonical technical property names in the inspector remain intentionally invariant.

## Profiler

Entering active Design mode records a real frontend event:

- category: `fsm`;
- event: `designer.opened`;
- measured context: request path, current FSM state, mode.

No fabricated backend/REST/Composer event is generated because A4BZ1 performs no semantic mutation.

## Files changed by the differential applicator

- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
- `sites/owasys-front/application/default/layouts/layout.score`
- `sites/owasys-front/www/asset/css/fsm-native.css`
- new `sites/owasys-front/www/asset/js/fsm-designer.js`
- all base-language `sites/owasys-front/application/default/local/<language>.json` catalogs declared by `site.json`.

No file in `sites/owasys-back` is changed.

No framework concrete class is introduced, therefore README-FIRST homonymous-interface rules are not triggered by this slice.

## Acceptance

1. `composer opus:validate-site -- owasys-front` remains valid.
2. Viewer cannot request `?fsm_design=1`.
3. Developer/admin sees localized Design entry.
4. View mode diagram behaves exactly as before.
5. Design mode shows the complete toolbar shell and read-only inspector.
6. Selecting state/transition shows canonical fields.
7. `signal.menu` and its metadata are visible in transition inspection.
8. Design-mode click/submit cannot execute a runtime signal.
9. right-button layout dragging still works when layout persistence is writable.
10. simple cubic transition selection shows P0/C1/C2/P3 preview handles.
11. no semantic file is changed by using the UI.
12. no backend JS exists or is added.

## Next slice after validation

P117W R45B2A4BZ2 — state CRUD + dependency-safe semantic rename on a validated draft.