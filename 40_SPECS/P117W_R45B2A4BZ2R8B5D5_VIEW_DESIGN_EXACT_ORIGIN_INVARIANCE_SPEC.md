# P117W R45B2A4BZ2 R8B5D5 — VIEW/DESIGN exact graph-origin invariance — SPEC

State: ACTIVE — DELIVERY BUILD/OWNER RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- `sites/owasys-front/www/asset/css/fsm-native.css` baseline blob: `085e6a9e68b775461f18e5276e4b4c95d5b76d29`.
- `sites/owasys-front/application/default/services/ScorePageRenderer.php` baseline blob: `0512c3427a190f4a6184710372d78e21f758b39f`.
- generic renderer baseline `Opus/Fsm/Diagram.class.php` blob: `255ce381932be8796f6a80d1a09228c001255d80`.
- contextual builder blob: `0f17ee29537603b09911fe0f7acd7fb136b46128`.
- diagram SCORE partial blob: `18f2fb2d5433f3f83b6287735719faa5edaeb27f`.

R8B5D4 is required locally and must be preserved. R8B5D3 CSS/cache-buster may either be present in its exact canonical form or absent; D5 normalizes both accepted starting states to one canonical cumulative CSS result.

## Runtime evidence

Owner supplied the same `owasys-front / security` EFSM in:

- VIEW `/fr-FR/sécurité?operation=read`;
- DESIGN `/fr-FR/sécurité?fsm_design=1`.

After R8B5D4, graph-internal geometry is equivalent: states, signal cards, transition curves/arrows, label leaders and initial marker retain the same relative geometry. The complete VIEW graph remains shifted to the right.

Image registration of the two captures gives approximately unit scale (`1.000`) and about `145 px` horizontal translation. The remaining defect is therefore whole-surface origin, not semantic coordinates, persisted layout or scale.

## Source diagnosis

`FsmDiagramBuilder::buildSelectedApplicationEfsm()` loads the same definition and the same persisted state/canvas/transition/marker layout in VIEW and DESIGN. DESIGN only adds writable persistence.

`fsm-diagram.score` renders the same `.ow-fsm-native-canvas`/generic diagram in both modes; DESIGN merely places that canvas beside the inspector in `.ow-fsm-designer-workspace`, reducing available width.

The cumulative CSS still contains a centering authority on `.fsm-diagram-card` (`margin-inline: auto`) and historical responsive/intrinsic SVG rules. R8B5D3 neutralized SVG centering when present but did not establish one final, explicit wrapper+SVG origin contract. The observed translation is consistent with an intrinsic graph being centered relative to two different available widths.

No pixel-specific compensation is permitted.

## Required correction

Create one final CSS authority, after historical rules, with these semantics:

1. `.ow-fsm-native-canvas` owns horizontal overflow and never clips/recenters intrinsic graph geometry.
2. Its direct `.fsm-diagram-card` is anchored at inline origin `0`, has intrinsic `max-content` width with `min-width: 100%`, and no maximum width.
3. The direct `.fsm-diagram` remains intrinsic (`width:auto`, `max-width:none`) and has zero inline auto margin.
4. VIEW and DESIGN therefore use the same physical SVG origin; the DESIGN inspector may reduce visible width but may only introduce horizontal scrolling, never graph translation or rescaling.
5. Bump only the FSM CSS cache-buster in `ScorePageRenderer.php` to R8B5D5.

Canonical presentation contract:

`VIEW graph coordinates = DESIGN graph coordinates`

and

`VIEW = DESIGN - modification capability`.

## Safety/non-regression boundary

R8B5D5 must not modify or restore:

- local R8B5D4 `Opus/Fsm/Diagram.class.php`;
- any `*.fsm.layout.json` companion;
- any EFSM definition;
- `fsm-designer.js`;
- OWASYS REST/back/Composer source;
- ACL/security/SecurityContext/SignalBus;
- DESIGN right-button drag/persistence behavior;
- transition/leader geometry reconciliation introduced by R8B5D4.

There is no hard-coded `145px`, transform, left offset, viewBox translation or JavaScript layout workaround.

## Delivery gate

The applicator must:

- require HEAD `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2` and clean Git index;
- derive the exact R8B5D4 expected renderer from the HEAD renderer and require the local renderer to equal it byte-for-byte;
- derive exact R8B5D3 CSS/cache-buster from HEAD and accept only either the clean baseline pair or the exact canonical D3 pair;
- normalize either accepted CSS starting state to one cumulative D3+D5 CSS result;
- permit only presentation layout companions as additional pre-existing local changes and preserve them byte-for-byte;
- modify exactly `fsm-native.css` and `ScorePageRenderer.php` in addition to the already-present D4 differential;
- PHP-lint `ScorePageRenderer.php` before and after write;
- run `git diff --check`;
- rollback only the two D5 targets on post-write failure;
- invoke no Composer subprocess.

## Owner runtime acceptance

1. validate `owasys-front` externally with Composer;
2. open the same Security EFSM in DESIGN and VIEW at the same browser zoom;
3. STATE, SIGNAL, transition paths/arrows, leaders and marker must keep the same coordinates relative to the left edge of the FSM canvas;
4. DESIGN inspector appearance/disappearance must not translate or scale the SVG;
5. when DESIGN canvas is narrower, horizontal scroll is allowed and preferred over recentering/shrink/clipping;
6. VIEW remains read-only;
7. DESIGN right-button drag/persistence remains operational;
8. F5 in both modes preserves the same geometry;
9. no layout, REST, backend, security or profiler regression is acceptable.
