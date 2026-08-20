# P117W R45B2A4BM — Persisted right-drag signal cards

## Status

CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

- OPUS GitHub `master` remains at `974217ee14b14ab7b7980a8d74d0df34daf08f9a` — A4BJ.
- A4BK/A4BL were delivered as owner-applied local differentials; A4BM contains complete replacements for the two FSM geometry files and includes the A4BL anchor/self-heal behavior.
- Menu work remains frozen.

## Owner requirement

The owner must be able to move transition signal cards in DEV just like FSM state nodes.

A signal card is the complete technical transition presentation object:

- signal identifier;
- guards;
- effects/actions;
- scope badge when present.

Moving the card is presentation-only. It must never alter canonical FSM semantics, signal origin, guards, actions, target state, ACL decisions, menu projection or business behavior.

## Interaction contract

Right-button drag is the layout gesture for both states and signal cards.

### State drag

`right pointerdown on state -> move state -> incident local edges reroute live -> release -> async save -> current DOM retained`

### Signal-card drag

`right pointerdown on signal card -> move complete signal/guards/effects card -> leader follows live -> release -> async save -> current DOM retained`

Left-click actionability remains unchanged. A user-actionable signal keeps its existing GET/POST dispatch semantics; only right-button drag edits presentation geometry.

## Layout contract V3

Portable companion layout contract becomes:

`OPUS_FSM_DIAGRAM_LAYOUT_V3`

V3 persists presentation only:

- canvas width/height;
- state x/y;
- transition local path where applicable;
- signal-card center x/y for local, global and self transitions;
- derived leader path snapshot.

No FSM semantic field is duplicated into the layout companion.

Existing `OPUS_FSM_DIAGRAM_LAYOUT_V2` and V1 files are accepted and migrated in writable DEV mode without losing state positions or existing valid local transition presentation geometry.

## Anchoring invariants

A4BL remains mandatory inside A4BM:

- local state-to-state path start must touch the current source-state boundary;
- local path end must touch the current target-state boundary;
- stale local persisted paths are rejected and deterministically rerouted;
- signal-card position is independent presentation geometry and is retained even when a stale local edge path is repaired;
- label leaders are derived from current live topology and current signal-card position, not blindly trusted from stale persisted `leader_path` data.

For global/self signal cards, the signal-card x/y can now be persisted independently. Their FSM semantics remain target-defined by the canonical FSM.

## No reload / repeated saves

A4BM preserves the A4BK no-reload contract:

- no `window.location.reload()`;
- save is asynchronous;
- menu/scroll/current DOM state remains unchanged;
- CSRF remains session-bound and single-use;
- successful response rotates the CSRF token without replacing the page;
- multiple state and signal drags may therefore be saved on the same page.

## Security

Client geometry remains untrusted presentation input.

Server normalization continues to enforce:

- known transition IDs only;
- known state IDs for state saves;
- bounded payload size;
- finite bounded coordinates;
- bounded/validated SVG path syntax;
- explicit layout key;
- CSRF validation;
- atomic OPUS `File` persistence and OPUS JSON encoding.

A dedicated `save-signal` presentation action does not accept or mutate an FSM state ID.

## Generic OPUS scope

The capability belongs in generic OPUS FSM diagram rendering/persistence, not in OWASYS business logic.

Changed framework files:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Fsm/FsmDiagramLayoutStore.php`

No menu file and no `sites/owasys-back` file are changed.

## Acceptance

1. Load the OWASYS FSM with the existing companion layout; do not delete it.
2. Confirm stale local arrows self-heal and remain anchored.
3. Right-drag a normal local signal card; confirm the complete signal/guards/effects card follows the pointer.
4. Confirm its dashed leader follows the card while the underlying transition remains source/target anchored.
5. Right-drag a global signal card and a self signal card; confirm their positions are independently movable.
6. Release each drag and confirm no page refresh and no menu-state change.
7. Confirm left-click actionability remains unchanged.
8. Perform multiple state/signal drags without browser refresh and confirm every save succeeds.
9. Perform one deliberate browser refresh and confirm state and signal-card positions are restored.
10. Confirm the companion migrates to `OPUS_FSM_DIAGRAM_LAYOUT_V3`.
11. Repeat on a generated application using its own `config/application.fsm.layout.json`.
