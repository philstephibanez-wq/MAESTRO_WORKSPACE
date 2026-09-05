# P117W R45B2A4BZ2R8B6R1 — Handoff

State: OWNER CORRECTION RECORDED — PREFLIGHT REQUIRED
Date: 2026-09-05

## Correction accepted

The previous reasoning that NMI could be absent from `essai` or `owasys-front` merely because the current JSON lacked `interrupt:"nmi"` was invalid. Chat memory/current-file absence does not override MAESTRO_WORKSPACE authority.

The authoritative A4F contract defines NMI for emergency/security/runtime interruption and explicitly classifies `auth_required` as the OWASYS front NMI and `fail -> api` as the OWASYS back NMI.

The owner further clarifies the architectural requirement: every OPUS application must have an NMI strategy for security violations and critical runtime errors. Exact signals/targets remain application-specific and must be derived from contract/source.

## Required next work

1. Preflight exact local OPUS HEAD/worktree.
2. Re-read the current canonical FSM/scaffold/runtime sources from GitHub at that baseline.
3. Determine where the front NMI was lost and whether generated `essai` exposes the required security/critical NMI strategy.
4. Treat the generic OPUS/scaffold cause before any local OWASYS or `essai` workaround.
5. Produce one native differential ZIP with complete files at final paths only after baseline gates pass.
6. Owner applies, validates runtime/visual behavior, then commits/pushes OPUS/OWASYS.

## Delivery constraints

- No assistant commit/push to OPUS/OWASYS.
- No automatic reset/deletion of owner changes.
- No ZIP before exact baseline/worktree evidence.
- One bounded owner action at a time.
- NMI visual distinctness is preserved; ordinary state/transition palette work is a separate concern.
