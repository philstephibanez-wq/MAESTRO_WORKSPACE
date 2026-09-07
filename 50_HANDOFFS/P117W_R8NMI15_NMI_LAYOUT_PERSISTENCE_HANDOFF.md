# P117W R8NMI15 — NMI LAYOUT PERSISTENCE HANDOFF

Date: 2026-09-07
Status: ACCEPTED — OWNER COMMITTED AND PUSHED

## Root cause targeted

R8NMI14 projects host NMI states/signals/transitions into the frontend rendering definition only, while the backend layout authority still validates and persists geometry against the canonical micro-EFSM definition. This definition mismatch explains NMI arrows being visible while their geometry is not persistently authoritative.

## Delivered change

Differential ZIP delivered in chat: backend `sites/owasys-back/application/fsm/services/OwasysFsmLayoutCommandProvider.php` only.

The backend layout path receives a layout-only host NMI projection for the five host context EFSMs (`registry`, `data`, `source`, `git`, `build`) while canonical semantic source/hash authority remains unchanged.

## Acceptance evidence

Owner runtime feedback: NMI geometry persistence is OK after reload. Owner then committed and pushed the accepted OPUS change.

Authoritative OPUS commit: `a352a984f246dbdf1213e9cf26b3b9bf4a6e6b61` (`opus_p117w_r8nmi15_nmi_layout_persistence`).

## Newly observed defect

All native NMI Bézier handles are exposed/interactive simultaneously in writable designer mode. Current `OPUS_FSM_Diagram` creates one control overlay per NMI transition during initialization without any exclusive activation state.

This is a generic OPUS diagram interaction defect, not an OWASYS-local semantic defect.

## Next tranche

R8NMI16A makes native NMI Bézier controls exclusively active for one selected NMI transition at a time. R8NMI16 I18N/performance remains open after that bounded correction.
