# P117W R45B2A4AK — FSM viewport containment

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED
Date: 2026-08-17

## Baseline

Owner-applied A4AI canonical FSM with A4AJ global-rail autocollapse.

A4AK is cumulative with A4AJ. No FSM semantic, REST, ACL, I18n, profiler or backend change is introduced.

## Owner finding

After A4AJ the permanent vertical global rail is gone, but the authenticated OWASYS page can still become wider than the browser viewport. The symptom is a page-level horizontal scrollbar: the FSM menu and diagram can only be inspected by moving the whole document sideways.

The owner must not require a wider monitor to operate the FSM UI.

## Root cause

Two independent intrinsic-width surfaces are insufficiently contained:

1. `.ow-global-nav.ow-fsm-menu` is a flex row whose desktop contract uses `overflow: visible`; a sufficiently large canonical state set can therefore enlarge document inline size.
2. The fixed FSM SVG/card intentionally uses intrinsic width (`width: max-content`, SVG `max-width:none`). That is valid for fixed topology, but the containing panel/canvas must establish the scroll boundary and must never propagate that intrinsic width to the page.

This is presentation containment only. Reordering, suppressing states or changing FSM topology to make it fit is forbidden.

## Delivered correction

`fsm-native.css` now establishes explicit viewport containment:

- menu, FSM panel and FSM canvas use `width/max-width:100%` and `min-width:0`;
- menu uses responsive `flex-wrap:wrap` instead of expanding the document;
- dropdown overflow remains visible and native `<details>` autocollapse remains unchanged;
- FSM panel clips any propagated inline overflow;
- FSM canvas owns horizontal/vertical scrolling for the intrinsically wide fixed diagram;
- diagram card remains intrinsically sized, so topology and geometry are not scaled or reordered.

A4AJ `navigation.score` is included unchanged so the ZIP can be applied directly over the current A4AI owner commit as a cumulative UI delivery.

## Artifact

`opus_p117w_r45b2a4ak_fsm_viewport_containment.zip`

SHA-256:

`a881aca0eb080096963b7ed82001395ca4b1a7e66693ec9b278a7febbed61024`

Complete files:

1. `sites/owasys-front/application/default/templates/partials/navigation.score`
2. `sites/owasys-front/www/asset/css/fsm-native.css`

No deletion required. No JavaScript added.

## Pre-delivery checks

- ZIP contains only final-path complete files;
- CSS brace balance: 57/57;
- no tabs;
- no trailing whitespace;
- A4AJ navigation template included unchanged;
- no OPUS/OWASYS repository write performed by assistant.

## Acceptance

1. Browser document itself has no FSM-induced horizontal overflow.
2. Header/main content remain viewport-wide without sideways page navigation.
3. Menu stays one row when it fits and wraps only when required by viewport width.
4. Opening a menu state still overlays its signals and exclusive autocollapse still works.
5. Fixed FSM diagram is unchanged semantically and geometrically.
6. If the diagram is wider than its panel, only the FSM canvas displays horizontal scrolling.
7. Current-state highlight, typed colors and actionable signal focus remain unchanged.
8. A4AI canonical 16-state workflow remains unchanged.

Owner alone applies, validates, commits and pushes OPUS/OWASYS.