# P117W R45B2A4BZ2 R8B5D1 — View/Design intrinsic geometry scale repair

State: ACTIVE — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- MAESTRO README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2` (`opus_p117w_r45b2a4bz2r8b5d_contextual_efsm_remote_layout_persistence`).
- Current `fsm-native.css` blob: `085e6a9e68b775461f18e5276e4b4c95d5b76d29`.
- Current `ScorePageRenderer.php` blob: `0512c3427a190f4a6184710372d78e21f758b39f`.

## Runtime evidence

R8B5D transport/persistence is operational: right-drag is available and a real companion layout file is persisted. The pushed OPUS baseline contains `sites/owasys-front/config/security.fsm.layout.json` with STATE, SIGNAL and marker geometry.

Owner observation: geometry appears restored when returning to graph DESIGN, but appears different outside DESIGN.

## Root cause

This is not a write/read persistence failure.

The SVG is rendered inside two containers of different physical width:

- VIEW: the graph canvas occupies the full panel;
- DESIGN: `.ow-fsm-designer-workspace` reserves a second column for the inspector.

`fsm-native.css` nevertheless applies `max-width: 100%` to `.ow-fsm-native-canvas .fsm-diagram` in the base rule, the viewport-containment rule and the vertical-layout rule. Therefore the same persisted intrinsic coordinates are rescaled according to the current container width. This violates the existing CSS comment/contract that the FSM geometry is fixed and overflow belongs to the canvas.

## Required correction

Preserve the SVG intrinsic geometry in both VIEW and DESIGN:

- replace the three FSM-SVG `max-width: 100%` constraints with `max-width: none`;
- keep `.ow-fsm-native-canvas { overflow: auto; }`, so oversized fixed geometry scrolls inside the diagram component and never widens the page;
- bump only the FSM CSS asset revision in `ScorePageRenderer.php` to `p117w-r45b2a4bz2r8b5d1` so the browser cannot reuse the pre-fix stylesheet;
- do not change FSM semantics, layout JSON, REST, backend, permissions, drag persistence or JS.

## Exact differential

Exactly two modified files:

1. `sites/owasys-front/www/asset/css/fsm-native.css`;
2. `sites/owasys-front/application/default/services/ScorePageRenderer.php`.

No new file in OPUS. No backend change.

## Runtime acceptance

1. Open Security or Structure in DESIGN.
2. Right-drag a STATE and a SIGNAL to obvious positions.
3. Switch to VIEW: geometry must remain the same intrinsic arrangement; only the inspector disappears.
4. Return to DESIGN: geometry must still be identical.
5. F5 in VIEW and DESIGN: same persisted arrangement.
6. For diagrams wider than the available viewport, horizontal scrolling occurs inside the graph canvas rather than SVG shrink-to-fit.
