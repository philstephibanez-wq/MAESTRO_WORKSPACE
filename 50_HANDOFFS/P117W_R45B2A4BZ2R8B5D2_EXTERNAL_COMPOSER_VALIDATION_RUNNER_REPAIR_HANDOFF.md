# P117W R45B2A4BZ2 R8B5D2 — External Composer validation runner repair — HANDOFF

State: APPLIED LOCALLY — RUNTIME PARTIAL PASS — NOT ACCEPTED — NOT PUSHED — SUPERSEDED BY R8B5D3

## Source of truth

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master remains `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- CSS blob at baseline: `085e6a9e68b775461f18e5276e4b4c95d5b76d29`.
- ScorePageRenderer blob at baseline: `0512c3427a190f4a6184710372d78e21f758b39f`.
- R8B5D1 is FAILED/ROLLED BACK and MUST NOT be retried.
- R8B5D2 spec commit: `5a16a154fbe4387751549fb0b86c494b44ca824e`.

## Runner repair achieved

R8B5D2 removed internal Composer execution from the applicator. The source transform could therefore be applied without the R8B5D1 `composer.phar` runner failure.

## Runtime evidence after R8B5D2

Owner supplied VIEW and DESIGN screenshots for `owasys-front / security`.

Pixel comparison of the four STATE rectangles gives:

- VIEW rectangles: `(374,643)`, `(636,736)`, `(859,621)`, `(1350,643)`;
- DESIGN rectangles: `(209,380)`, `(471,475)`, `(694,358)`, `(1185,380)`.

Every X coordinate differs by exactly `+165 px` VIEW versus DESIGN while pairwise STATE spacing remains identical. Y differences are page/header placement only. Therefore:

- persisted EFSM geometry is being reused;
- R8B5D storage/read path is operational;
- R8B5D2 successfully removes scale distortion;
- remaining defect is whole-SVG origin placement, not persistence or geometry.

## Remaining root cause

The CSS keeps `margin-inline: auto` on the FSM SVG. VIEW has a wider canvas and centers the intrinsic SVG. DESIGN reserves an inspector column; when the intrinsic SVG is wider than its reduced canvas, auto margins resolve differently and the SVG becomes left-aligned. The same persisted coordinates therefore appear globally translated between modes.

A second cascade defect is also present: the final `P117W_R45B2A4BG` rule overrides earlier canvas scrolling with `overflow-x: hidden`. After removing SVG shrink, wide diagrams must instead expose horizontal scrolling.

## Supersession

R8B5D2 is not to be committed or pushed. R8B5D3 is cumulative from the clean GitHub baseline and will:

1. keep intrinsic SVG scale (`max-width: none`);
2. make SVG origin stable (`margin-inline: 0`);
3. restore final horizontal canvas overflow to `auto`;
4. bump the FSM CSS cache-buster;
5. keep Composer validation external to the applicator.

Because OPUS master is still the clean R8B5D baseline, the owner must restore the two R8B5D2 target files before applying R8B5D3. No persisted layout file is to be restored by this cleanup.
