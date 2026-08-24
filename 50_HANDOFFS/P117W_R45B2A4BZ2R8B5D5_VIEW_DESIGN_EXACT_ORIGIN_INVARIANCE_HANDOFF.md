# P117W R45B2A4BZ2 R8B5D5 — VIEW/DESIGN exact graph-origin invariance — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

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

R8B5D5 establishes one final CSS origin authority after the historical cascade:

- canvas horizontal overflow remains local;
- direct diagram card is inline-origin anchored, `width:max-content`, `min-width:100%`, `max-width:none`;
- direct SVG is intrinsic and inline-origin anchored;
- inspector width may change visible viewport only, never graph coordinates;
- no hard-coded offset, transform, viewBox translation or JavaScript workaround.

The correction is cumulative with R8B5D3 effective intrinsic-scale rules. The applicator accepts either exact D3 presentation state or clean baseline presentation and normalizes both to the same final D5 bytes.

## Non-regression boundary

D5 changes only:

1. `sites/owasys-front/www/asset/css/fsm-native.css`;
2. `sites/owasys-front/application/default/services/ScorePageRenderer.php` — FSM CSS cache-buster only.

It preserves byte-for-byte:

- local R8B5D4 `Opus/Fsm/Diagram.class.php`;
- every `*.fsm.layout.json` companion;
- `fsm-designer.js`;
- REST/back/Composer;
- ACL/security/SecurityContext/SignalBus;
- profiler;
- DESIGN right-button drag/persistence;
- EFSM definitions.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b5d5_view_design_exact_origin_invariance.zip`;
- ZIP SHA-256: `29d0e961c5aa28f0338e05012ab078fcb24809a445c377caf570677b3bfa0b33`;
- ZIP contains exactly `apply_a4bz2r8b5d5.php`;
- applicator SHA-256: `6e7845aca09f998e1f26ddb99246a62722082dd3ed06876ed68f2d93f488c643`;
- applicator size: `22221` bytes;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- extracted applicator PHP lint: PASS;
- no internal Composer invocation.

## Applicator preflight

- exact OPUS HEAD is required;
- exact three HEAD blobs are required;
- Git index must be clean;
- local `Diagram.class.php` must equal the exact derived R8B5D4 transformation of the HEAD blob;
- CSS + ScorePageRenderer must be either both baseline or both exact canonical D3;
- only `sites/*/config/*.fsm.layout.json` may coexist as additional local changes;
- D4 renderer and all layout companions are SHA-256 snapshotted and verified unchanged after application.

## Deterministic replay

Two independent temporary Git repositories were exercised:

1. D4 local + baseline CSS/renderer + dirty Security layout;
2. D4 local + exact D3 CSS/renderer + dirty Security layout.

Both produced:

- `PREFLIGHT_OK`;
- `REPO_CHANGES_VERIFIED`;
- `APPLIED`;
- exactly two D5 target paths;
- identical final CSS/renderer bytes across both starting states;
- D4 renderer byte-for-byte unchanged;
- Security layout byte-for-byte unchanged;
- clean Git index;
- no new untracked path beyond the pre-existing layout;
- `git diff --check` PASS;
- renderer PHP lint PASS.

## Expected markers

- `P117W_R45B2A4BZ2R8B5D5_PREFLIGHT_BEGIN`;
- `P117W_R45B2A4BZ2R8B5D5_PREFLIGHT_OK`;
- `P117W_R45B2A4BZ2R8B5D5_REPO_CHANGES_VERIFIED`;
- `P117W_R45B2A4BZ2R8B5D5_APPLIED`;
- `baseline_head=f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`;
- `d3_start_state=baseline|d3`;
- `changed_paths=2`;
- `view_design_scale=intrinsic`;
- `view_design_origin=exact-inline-start`;
- `diagram_card_width=max-content-min-100pct`;
- `canvas_overflow_x=auto`;
- `d4_geometry_reconciliation=preserved`;
- `design_drag_persistence=unchanged`;
- `layout_storage=unchanged`;
- `rest_backend_change=none`;
- `fsm_css_revision=p117w-r45b2a4bz2r8b5d5`;
- `composer_validation=external_terminal`.

## Owner runtime acceptance

1. apply D5 without restoring D4 or any layout file;
2. run `composer opus:validate-site -- owasys-front` externally;
3. compare the same Security EFSM in DESIGN and VIEW;
4. the complete graph must have the same left-origin coordinates in both modes;
5. inspector appearance/disappearance must not translate or scale the graph;
6. narrower DESIGN canvas may scroll horizontally instead of recentering/shrinking;
7. VIEW remains read-only;
8. DESIGN right-button drag/persistence remains operational;
9. F5 keeps the same graph geometry in both modes;
10. only after these gates pass may owner commit/push OPUS.
