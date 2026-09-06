# P117W R8NMI9 — direct Bézier handle drag

Date: 2026-09-06
Status: delivery specification

## Owner evidence

R8NMI8 renders visible Bézier handles for NMI transitions, but they remain unusable. The active handles are injected dynamically by the OWASYS designer preview.

## Cause addressed

The previous implementation depended on delegated SVG pointer acquisition. The active controls can be inserted after the OPUS layout runtime has initialized, and drag continuity must survive leaving the SVG.

## Required behavior

1. Bind C1/C2 directly when present.
2. Observe dynamically added Bézier handles and bind them immediately.
3. Continue pointermove and pointerup/cancel at window scope.
4. Keep OPUS layout geometry/persistence as the persistence mechanism.
5. No EFSM semantic mutation.
6. Preserve NMI marker persistence, red NMI rendering and removal of the horizontal NMI bus.

## Delivery

Native differential ZIP containing only complete changed files at final repository paths. Owner applies locally, validates, commits and pushes OPUS/OWASYS.