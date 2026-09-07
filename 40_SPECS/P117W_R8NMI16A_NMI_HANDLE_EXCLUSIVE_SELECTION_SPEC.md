# P117W R8NMI16A — NMI HANDLE EXCLUSIVE SELECTION SPEC

Date: 2026-09-07
Status: ACTIVE

## Authority and baseline

This bounded correction is defined from OPUS GitHub `master` after accepted R8NMI15 commit `a352a984f246dbdf1213e9cf26b3b9bf4a6e6b61`, under `README-FIRST.md` and the native ZIP stepwise workflow contract.

## Observed defect

In writable FSM designer mode, every NMI transition receives a native Bézier control overlay during initialization. The controls are visible and interactive for all NMI transitions simultaneously.

## Root cause

`OPUS_FSM_Diagram::layoutInteractionScript()` calls `ensureNmiBezierControls()` for every transition whose `data-from-state` is `*`. The function creates C1/C2 handles with `data-layout-bezier-draggable="1"` immediately, and the SVG CSS displays every `.fsm-nmi-bezier-controls` overlay. There is no selected-NMI interaction state.

## Required generic OPUS behavior

- Native NMI Bézier controls remain available in writable designer mode.
- Zero or one NMI transition is selected for curve editing at a time.
- Inactive NMI overlays are hidden and their C1/C2 handles are non-interactive/non-tab-focusable.
- Left interaction on an NMI transition selects that transition and deselects any previously selected NMI transition.
- Interaction outside NMI transitions clears NMI control selection unless a handle drag is in progress.
- Selecting another NMI transition must not alter any geometry by itself.
- Existing right-button state/signal/marker dragging and persisted NMI geometry remain unchanged.
- NMI semantic definition and backend layout authority are unchanged.

## Scope

Generic framework correction in `Opus/Fsm/Diagram.class.php` only. No OWASYS-local CSS or JavaScript workaround is permitted.

## Acceptance

1. Open a host contextual EFSM containing both NMI transitions in writable designer mode.
2. No NMI Bézier handles are shown before selecting an NMI transition.
3. Select the first NMI transition: only its C1/C2 controls appear and are draggable.
4. Select the second NMI transition: first controls disappear; only second controls remain active.
5. Click outside NMI transitions: controls disappear.
6. Drag one selected control, persist, reload: authored curve remains persisted.
7. No regression in NMI marker dragging, state dragging, signal-card dragging, or normal transition rendering.

## Delivery

Native differential ZIP, short name, complete final file at repository-relative path, SHA-256 verified. Owner applies with CMD from `%USERPROFILE%\Downloads` into `H:\OPUS` and validates gate-by-gate.
