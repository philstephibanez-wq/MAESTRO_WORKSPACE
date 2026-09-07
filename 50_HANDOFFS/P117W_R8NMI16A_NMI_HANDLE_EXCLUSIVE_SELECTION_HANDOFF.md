# P117W R8NMI16A — NMI HANDLE EXCLUSIVE SELECTION HANDOFF

Date: 2026-09-07
Status: DELIVERED — OWNER RUNTIME VALIDATION PENDING

## Accepted baseline

R8NMI15 NMI layout persistence is owner-accepted, committed and pushed as OPUS commit `a352a984f246dbdf1213e9cf26b3b9bf4a6e6b61`.

## Root cause treated

`OPUS_FSM_Diagram::layoutInteractionScript()` instantiated native C1/C2 Bézier controls as immediately draggable and the SVG CSS exposed every NMI control overlay at once. There was no exclusive NMI editing selection state.

## Delivered correction

Native differential ZIP `R8NMI16A.zip` changes only `Opus/Fsm/Diagram.class.php`.

The generic OPUS diagram interaction now:
- initializes NMI Bézier controls hidden and non-interactive;
- exposes C1/C2 only for the one NMI transition selected by a left interaction;
- deselects previously selected NMI controls when another NMI is selected;
- clears selection on a left interaction outside NMI transitions;
- preserves right-button state, signal-card and marker dragging;
- preserves NMI semantic definition and backend layout persistence authority.

## Static validation performed by chat

- reconstructed source verified byte-for-byte against authoritative Git blob `faec5f7f9aabaf1306c65999ad0f1fdfe440c102` before modification;
- PHP syntax validation passed;
- embedded layout-interaction JavaScript syntax validation passed;
- differential ZIP verified to contain exactly `Opus/Fsm/Diagram.class.php`.

## Runtime acceptance required

Owner must apply the ZIP locally, validate OPUS/OWASYS, then verify:
1. no NMI handles before selection;
2. selecting one NMI shows only its C1/C2 handles;
3. selecting the other transfers exclusive controls;
4. clicking outside hides them;
5. edited curve persists after reload;
6. NMI marker/state/signal-card dragging has no regression.

R8NMI16 I18N/performance remains open after this bounded interaction correction.
