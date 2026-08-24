# P117W R45B2A4BZ2 R8B5D5 — VIEW/DESIGN exact graph-origin invariance — HANDOFF

State: BUILD IN PROGRESS — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source of truth

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- CSS baseline blob: `085e6a9e68b775461f18e5276e4b4c95d5b76d29`.
- ScorePageRenderer baseline blob: `0512c3427a190f4a6184710372d78e21f758b39f`.
- generic Diagram baseline blob: `255ce381932be8796f6a80d1a09228c001255d80`.
- R8B5D4 local renderer correction is required and preserved.

## Runtime diagnosis

Owner captures after R8B5D4 show internal graph geometry reconciled but the complete VIEW graph remains shifted right relative to DESIGN. Registration gives unit scale and approximately `145 px` X translation. The remaining defect is whole-surface origin/cascade, not persisted coordinates.

## Correction contract

R8B5D5 establishes one final CSS origin authority:

- canvas horizontal overflow remains local;
- diagram card is inline-origin anchored and intrinsic-width with `min-width:100%`;
- SVG is intrinsic and inline-origin anchored;
- inspector width may change visible viewport only, never graph coordinates.

No hard-coded offset or JS transform.

## Non-regression boundary

D5 changes only `fsm-native.css` plus the FSM CSS cache-buster in `ScorePageRenderer.php`. It must preserve D4 `Diagram.class.php`, all layout companions, JS, REST/back/Composer, ACL/security, profiler and DESIGN drag/persistence.

## Artifact

Pending deterministic build/replay/hash publication before delivery.
