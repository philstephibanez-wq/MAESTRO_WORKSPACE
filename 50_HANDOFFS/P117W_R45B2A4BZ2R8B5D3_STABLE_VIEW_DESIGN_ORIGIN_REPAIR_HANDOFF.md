# P117W R45B2A4BZ2 R8B5D3 — Stable VIEW/DESIGN origin repair — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source of truth

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- CSS blob: `085e6a9e68b775461f18e5276e4b4c95d5b76d29`.
- ScorePageRenderer blob: `0512c3427a190f4a6184710372d78e21f758b39f`.
- R8B5D2 handoff is now runtime partial / not accepted / superseded.
- R8B5D3 spec commit: `59463aef4c4a872b67ebfdb3d065676b2700b111`.

## Runtime diagnosis

Owner supplied VIEW and DESIGN screenshots of `owasys-front / security` after the R8B5D2 visual scale repair.

Measured STATE rectangles:

- VIEW: `(374,643)`, `(636,736)`, `(859,621)`, `(1350,643)`;
- DESIGN: `(209,380)`, `(471,475)`, `(694,358)`, `(1185,380)`.

All X positions differ by exactly `165 px`, while relative spacing is unchanged. The same persisted layout is therefore consumed in both modes. The defect is whole-SVG placement.

## Root cause

With intrinsic SVG width restored, `margin-inline: auto` yields two different origins:

- VIEW canvas is wider and centers the SVG;
- DESIGN canvas is reduced by the inspector and can no longer center the same intrinsic SVG.

The final CSS cascade also uses `overflow-x: hidden`, which clips an intrinsic-width diagram instead of scrolling it.

## Correction

Cumulative from clean GitHub baseline:

1. `sites/owasys-front/www/asset/css/fsm-native.css`
   - FSM SVG `max-width: none` in all three relevant historical rules;
   - base and vertical SVG `margin-inline: 0`;
   - final canvas `overflow-x: auto`, `overflow-y: visible`.
2. `sites/owasys-front/application/default/services/ScorePageRenderer.php`
   - FSM CSS cache-buster `p117w-r45b2a4bz2r8b5d3`.

No layout JSON, FSM definition, JS, REST, Composer registry, ACL or backend source changes.

## Local-state prerequisite

R8B5D2 is currently applied locally but not pushed. OPUS GitHub remains on `f053f569...`.

Before R8B5D3, restore only the two R8B5D2 target files to GitHub baseline. Do not restore any `*.fsm.layout.json` file.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b5d3_stable_view_design_origin_repair.zip`;
- ZIP SHA-256: `dc87b203c2b69701827cbde4929389baa6f8afd9f838711466a561acc5f06700`;
- ZIP contains exactly `apply_a4bz2r8b5d3.php`;
- applicator SHA-256: `d0b6f6701a41b0952245abf50d95139f93d286e759b14e4556aad280360efa93`;
- applicator size: `10683` bytes;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- no `composer.phar` and no internal `composer` subprocess invocation.

## Deterministic replay

Applicator logic was replayed end-to-end in a temporary Git repository with exact transformation anchors.

Observed:

- PREFLIGHT_OK;
- REPO_CHANGES_VERIFIED;
- APPLIED;
- exactly two modified paths;
- zero untracked files;
- clean index;
- `git diff --check` PASS;
- final CSS has `max-width:none`, stable `margin-inline:0`, and final `overflow-x:auto`.

## Expected markers

- `P117W_R45B2A4BZ2R8B5D3_PREFLIGHT_BEGIN`;
- `P117W_R45B2A4BZ2R8B5D3_PREFLIGHT_OK`;
- `P117W_R45B2A4BZ2R8B5D3_REPO_CHANGES_VERIFIED`;
- `P117W_R45B2A4BZ2R8B5D3_APPLIED`;
- `baseline_head=f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`;
- `changed_paths=2`;
- `layout_storage=unchanged`;
- `view_design_geometry_scale=intrinsic`;
- `view_design_origin=stable-left`;
- `relative_geometry=unchanged`;
- `canvas_overflow_x=auto`;
- `fsm_css_revision=p117w-r45b2a4bz2r8b5d3`;
- `composer_validation=external_terminal`.

## Owner runtime acceptance

1. externally run `composer opus:validate-site -- owasys-front`;
2. open the same Security EFSM in VIEW and DESIGN;
3. inspector appearance/disappearance must not translate or rescale STATE/SIGNAL geometry;
4. F5 in both modes must keep geometry;
5. if DESIGN canvas is narrower than intrinsic graph width, horizontal scrolling must appear instead of clipping/shrink;
6. only after these gates pass, commit/push OPUS.
