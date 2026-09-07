# P117W R8NMI15 — NMI LAYOUT PERSISTENCE HANDOFF

Date: 2026-09-07
Status: DELIVERED — OWNER RUNTIME VALIDATION PENDING

## Root cause targeted

R8NMI14 projects host NMI states/signals/transitions into the frontend rendering definition only, while the backend layout authority still validates and persists geometry against the canonical micro-EFSM definition. This definition mismatch explains NMI arrows being visible while their geometry is not persistently authoritative.

## Delivered change

Differential ZIP delivered in chat: backend `sites/owasys-back/application/fsm/services/OwasysFsmLayoutCommandProvider.php` only.

The backend layout path receives a layout-only host NMI projection for the five host context EFSMs (`registry`, `data`, `source`, `git`, `build`) while canonical semantic source/hash authority remains unchanged.

## Acceptance status

No local/runtime success is claimed. Owner must validate from a clean expected OPUS baseline, apply the native ZIP, run syntax/Composer/site validations, then perform the NMI geometry reload test and return complete evidence.

## Next tranche

R8NMI16 addresses remaining I18N and measured performance defects. The current master source must be used; no local-only `source.stat` route may be assumed.
