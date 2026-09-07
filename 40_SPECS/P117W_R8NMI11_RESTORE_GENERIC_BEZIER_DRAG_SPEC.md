# P117W R8NMI11 — Restore generic Bézier drag

## Cause

The pre-NMI OPUS renderer on GitHub already contains a working generic Bézier pointerdown path. For `target.kind === 'bezier'`, it builds the drag state inline, captures the pointer on the SVG, marks the overlay as dragging, and then relies on the existing generic pointermove/pointerup persistence path.

The NMI iterations introduced a second helper/capture acquisition path and changed the button gate. This altered the generic Bézier interaction for every transition, not only NMI transitions.

## Required correction

Restore the pre-NMI generic Bézier pointerdown implementation exactly for all transitions:

- left mouse button starts Bézier drag;
- drag state is built inline in the normal SVG `pointerdown` listener;
- pointer capture is taken on the SVG;
- the existing generic `pointermove`, `pointerup`, geometry update and persistence paths remain authoritative;
- no special NMI event acquisition path is introduced;
- NMI rendering, anchoring, red presentation, marker movement and persisted NMI geometry remain unchanged.

## Acceptance

1. Select a non-NMI cubic transition: C1/C2 are visible and movable.
2. Select an NMI cubic transition: C1/C2 are visible and movable.
3. Dragging either handle updates the curve continuously.
4. Reload preserves the edited curve.
5. No regression to NMI source anchoring or NMI marker persistence.
