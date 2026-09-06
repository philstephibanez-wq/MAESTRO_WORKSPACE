# P117W R8NMI6 — NMI Bézier visibility

Date: 2026-09-06
Status: delivery specification

## Owner evidence

R8NMI5 runtime evidence confirms that NMI color, anchoring, marker movement and persistence are acceptable, but Bézier handles are not visible in OWASYS design mode even when the selected NMI transition reports `layout.path_kind = cubic_bezier`.

## Root cause

`Opus/Fsm/Diagram.class.php` introduced native NMI Bézier controls and also unconditionally hid `.fsm-designer-bezier-preview` for every `.nmi-transition`. In OWASYS designer mode, native OPUS layout persistence may be non-writable while the OWASYS designer still creates its own selected-transition Bézier preview. The unconditional CSS therefore hides the only available handles.

## Required behavior

1. Native NMI Bézier controls remain authoritative whenever they actually exist.
2. OWASYS designer Bézier preview remains visible when native NMI controls are absent.
3. Duplicate overlays are prevented by an explicit runtime class indicating that native NMI controls exist.
4. No NMI semantic, persistence, routing, marker movement or non-NMI transition behavior changes.

## Implementation contract

`ensureNmiBezierControls()` adds `has-native-nmi-bezier-controls` only after a native overlay exists. CSS hides the OWASYS `.fsm-designer-bezier-preview` only for an NMI transition carrying that explicit class.

## Delivery

Native differential ZIP containing only the complete changed `Opus/Fsm/Diagram.class.php` at its final repository path. Owner applies and validates locally; assistant does not commit or push OPUS/OWASYS.