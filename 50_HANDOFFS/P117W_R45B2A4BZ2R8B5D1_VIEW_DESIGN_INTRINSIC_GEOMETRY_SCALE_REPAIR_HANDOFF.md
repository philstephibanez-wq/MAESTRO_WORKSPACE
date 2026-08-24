# P117W R45B2A4BZ2 R8B5D1 — View/Design intrinsic geometry scale repair — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source of truth

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- Parent R8B5D is pushed and contains real `security.fsm.layout.json` persisted geometry.
- R8B5D1 spec commit: `63a46b4847ac5f02da41e402124cb10858390310`.

## Runtime qualification

Owner initially reported persistence KO, then clarified that the moved geometry returns when graph DESIGN is reopened.

This proves the R8B5D storage path is operational. The pushed baseline itself contains the generated companion layout. The remaining defect is visual parity between VIEW and DESIGN.

## Root cause

`fsm-native.css` contradicts its own fixed-geometry viewport contract. The SVG is constrained by `max-width: 100%` while DESIGN and VIEW use different container widths because DESIGN reserves the inspector column. Identical persisted coordinates are therefore visually rescaled between modes.

## Correction

R8B5D1 changes exactly two front files:

1. `sites/owasys-front/www/asset/css/fsm-native.css` — all three FSM-SVG shrink-to-fit constraints become `max-width: none`; canvas overflow remains `auto`;
2. `sites/owasys-front/application/default/services/ScorePageRenderer.php` — FSM CSS cache-buster becomes `p117w-r45b2a4bz2r8b5d1`.

No FSM definition, layout data, REST route, Composer command, ACL, backend code or JS is changed.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b5d1_view_design_intrinsic_geometry_scale_repair.zip`;
- ZIP SHA-256: `e2ab433bdbf09108c6c28204bd0fbf5ca172e19b7cfb05519a4965d1788e04c8`;
- ZIP contains exactly `apply_a4bz2r8b5d1.php`;
- applicator SHA-256: `ad04bc2a77bce8169fdac74959dffbd73f28b37cd5effff35e3326275566f12e`;
- applicator size: 10209 bytes;
- applicator PHP lint: PASS;
- ZIP re-extraction and byte comparison: PASS.

## Applicator gates

Before write:

- exact HEAD `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`;
- clean tracked/index/untracked state;
- exact CSS blob `085e6a9e68b775461f18e5276e4b4c95d5b76d29`;
- exact renderer blob `0512c3427a190f4a6184710372d78e21f758b39f`;
- each CSS replacement anchor exactly once;
- cache-buster anchor exactly once;
- generated renderer PHP lint before write.

After write:

- renderer PHP lint;
- fixed-geometry CSS contract;
- exact two-file differential;
- zero untracked and clean index;
- `git diff --check`;
- unchanged HEAD;
- `composer opus:validate-site -- owasys-front`.

Post-write failure restores both original files.

## Expected markers

- `P117W_R45B2A4BZ2R8B5D1_PREFLIGHT_BEGIN`;
- `P117W_R45B2A4BZ2R8B5D1_PREFLIGHT_OK`;
- `P117W_R45B2A4BZ2R8B5D1_REPO_CHANGES_VERIFIED`;
- `P117W_R45B2A4BZ2R8B5D1_APPLIED`;
- `baseline_head=f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`;
- `changed_paths=2`;
- `layout_storage=unchanged`;
- `view_design_geometry_scale=intrinsic`;
- `canvas_overflow=scroll`;
- `fsm_css_revision=p117w-r45b2a4bz2r8b5d1`.

## Runtime acceptance pending

Switch DESIGN -> VIEW -> DESIGN and F5 in both modes. STATE/SIGNAL positions must keep the same intrinsic geometry. Wide diagrams must scroll inside the canvas instead of shrinking differently between modes.
