# P117W R45B2A4BZ2 R8B5D4 — VIEW read-only geometry runtime reconciliation — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source of truth

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- Renderer target: `Opus/Fsm/Diagram.class.php` blob `255ce381932be8796f6a80d1a09228c001255d80`.
- Contextual builder: `sites/owasys-front/application/default/services/FsmDiagramBuilder.php` blob `0f17ee29537603b09911fe0f7acd7fb136b46128`.
- D3 is owner-runtime rejected and superseded by D4.

## Contract

`VIEW = DESIGN - modification capability`.

R8B5D4 changes generic `Opus/Fsm/Diagram.class.php` only. The same existing geometry reconciliation executes in VIEW and DESIGN. Only drag, CSRF rotation and persistence POST remain writable-only.

## Exact correction

- geometry runtime emission is no longer equivalent to writability; it also activates when persisted state/canvas/transition/marker geometry exists;
- renderer runtime entry records `writable` instead of returning immediately for read-only diagrams;
- SIGNAL and initial-marker runtime registries use their always-rendered geometry attributes rather than draggable-only selectors;
- existing `repairLocalTransition()` and `updateInitialMarker()` execute in both modes;
- `if (!writable) return;` is placed immediately after geometry reconciliation and before CSRF/persistence/drag/event-handler code.

No second renderer or alternate geometry path is introduced.

## Non-regression boundary

R8B5D4 does not modify or restore:

- `sites/owasys-front/www/asset/css/fsm-native.css`;
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
- any `*.fsm.layout.json` companion;
- any EFSM definition;
- OWASYS REST/back/Composer source;
- ACL/security rules;
- SecurityContext/SignalBus;
- working DESIGN right-button drag/persistence semantics.

The applicator accepts the two known local R8B5D3 paths and `sites/*/config/*.fsm.layout.json` companions as pre-existing local state only. It SHA-256 snapshots each such file before work and proves it remains byte-for-byte unchanged after application.

Any other local changed/untracked path blocks preflight. The renderer target itself must be clean and match the exact GitHub blob. The Git index must be clean.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b5d4_view_readonly_geometry_runtime_reconciliation.zip`;
- ZIP SHA-256: `96b426f5e34db3a3399e9eb13bface7c82d9129a5143bcb58e082459d63745db`;
- ZIP contains exactly `apply_a4bz2r8b5d4.php`;
- applicator SHA-256: `c83cc1acc3dfb13b2210d13242adffb143e911563528ea00a6fcf86c7b23822a`;
- applicator size: `16745` bytes;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- extracted applicator PHP lint: PASS;
- no internal Composer invocation.

## Deterministic replay

A temporary Git repository reproduced all six exact transformation anchors and included three pre-existing dirty files:

- R8B5D3 CSS target;
- R8B5D3 `ScorePageRenderer.php` target;
- Security `*.fsm.layout.json` companion.

Replay result:

- `PREFLIGHT_OK`;
- `REPO_CHANGES_VERIFIED`;
- `APPLIED`;
- exactly one additional modified path: `Opus/Fsm/Diagram.class.php`;
- all three pre-existing files retained identical SHA-256 values;
- clean index;
- no new untracked path;
- `git diff --check` PASS;
- transformed PHP lint PASS.

Static ordering checks also prove the read-only gate occurs after transition/marker reconciliation and before persistence/drag installation.

## Expected markers

- `P117W_R45B2A4BZ2R8B5D4_PREFLIGHT_BEGIN`;
- `P117W_R45B2A4BZ2R8B5D4_PREFLIGHT_OK`;
- `P117W_R45B2A4BZ2R8B5D4_REPO_CHANGES_VERIFIED`;
- `P117W_R45B2A4BZ2R8B5D4_APPLIED`;
- `baseline_head=f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`;
- `changed_paths=1`;
- `view_geometry=design-equivalent-readonly`;
- `geometry_reconciliation=view+design`;
- `editing_gate=writable-only`;
- `design_drag_persistence=unchanged`;
- `layout_storage=unchanged`;
- `rest_backend_change=none`;
- `preexisting_local_state=preserved`;
- `composer_validation=external_terminal`.

## Owner runtime acceptance

1. apply without restoring the working R8B5D3/layout files;
2. externally run `composer opus:validate-site -- owasys-front`;
3. compare the same Security EFSM in DESIGN and VIEW;
4. STATE, SIGNAL cards, transition arrows/paths, label leaders and initial marker must be graph-geometry equivalent;
5. VIEW must remain read-only with no right-button drag/persistence;
6. DESIGN right-button drag/persistence must remain operational;
7. F5 in both modes must preserve the same geometry;
8. only after those gates pass may owner commit/push OPUS.
