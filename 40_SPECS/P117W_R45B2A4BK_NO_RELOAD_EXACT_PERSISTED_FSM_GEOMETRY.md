# P117W R45B2A4BK — No-reload exact persisted FSM geometry

## Status

IMPLEMENTED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

Owner OPUS HEAD:

`974217ee14b14ab7b7980a8d74d0df34daf08f9a` — A4BJ.

Menu work remains frozen.

## Root cause

A4BJ persisted state x/y and then forced `window.location.reload()` after a right-button drag.

That reload has two unacceptable consequences:

- surrounding page UI state is destroyed/rebuilt, including native menu collapse;
- the server recomputes transition routing, so arrows can differ from the geometry that was visible immediately after the drag.

The correction must persist presentation geometry instead of forcing a reload to reconstruct it.

## Required lifecycle

### First render without companion layout

`no *.fsm.layout.json -> calculate deterministic OPUS layout -> persist portable layout -> render -> capture exact rendered local transition geometry -> persist it before response completes`

The HTML returned by that request is therefore the same geometry that has just been persisted.

### Subsequent render

`persisted layout -> persisted state positions + persisted local transition geometry win -> render`

No automatic rerouting may replace already persisted local path/label geometry merely because the page is loaded again.

### Right-button drag in DEV

`pointerdown right -> move state -> incident arrows update in live SVG -> pointerup -> async POST exact visible geometry -> keep existing DOM`

There is no `window.location.reload()` and no replacement of the current document.

## Portable layout contract V2

Contract:

`OPUS_FSM_DIAGRAM_LAYOUT_V2`

The companion file remains presentation-only. It may contain:

- canvas width/height;
- state x/y;
- local state-to-state transition SVG path;
- transition label x/y;
- label leader path.

It must never contain duplicated FSM semantics such as state meaning, signal semantics, guards, actions, ACL decisions or business data.

Global ingress cards and self-operation cards remain target-anchored presentation objects. Their position is deterministically derived from the persisted target-state position; they are not independent workflow semantics.

## V1 compatibility

Existing `OPUS_FSM_DIAGRAM_LAYOUT_V1` files are accepted and migrated to V2 in a writable DEV runtime.

Existing manual state coordinates are preserved.

Missing transition geometry is completed from the renderer without overwriting geometry already persisted.

## Repeated drag / CSRF

A4BJ obtained a fresh CSRF token only because the full page reloaded.

A4BK must keep single-use CSRF semantics while avoiding reload:

1. save request consumes the current token;
2. server renders the response with a newly issued token;
3. client parses that response without replacing the DOM;
4. only the new token is copied into the existing diagram card;
5. another right-drag can therefore be saved on the same page.

## Security

Client-provided geometry is untrusted presentation input.

Server validation requires:

- known transition IDs only;
- bounded geometry payload;
- finite bounded coordinates;
- bounded SVG path length;
- strict SVG path-character grammar;
- existing layout key and session-bound CSRF validation;
- atomic file writes through OPUS `File` and JSON encoding through OPUS `Json`.

## Generic OPUS scope

The correction belongs in generic OPUS FSM rendering/persistence, not in menu code and not in OWASYS business logic.

Changed framework files:

- `Opus/Fsm/Diagram.class.php`;
- `Opus/Fsm/FsmDiagramLayoutStore.php`;
- `Opus/Fsm/FsmDiagramLayoutStoreInterface.php`.

No menu file and no `sites/owasys-back` file are part of A4BK.

## Acceptance

1. Drag a state with right button.
2. Release it.
3. Confirm the page does not refresh.
4. Confirm the menu keeps exactly its current open/closed state.
5. Confirm arrows keep the geometry visible at pointer release.
6. Drag another state without refreshing the page and confirm the second save succeeds.
7. Perform a real browser refresh and confirm the moved states and local transition paths/labels are restored identically from the companion file.
8. Confirm existing A4BJ V1 layout is migrated without losing manual state positions.
