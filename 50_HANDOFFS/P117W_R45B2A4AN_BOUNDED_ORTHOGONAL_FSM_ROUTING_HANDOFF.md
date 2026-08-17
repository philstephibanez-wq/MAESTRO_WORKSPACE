# P117W R45B2A4AN — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

Latest OPUS owner commit visible remotely:

`1c86e851fa989473468edf86962b3648e19a0911`

This is A4AI canonical workflow FSM. The owner has subsequently applied the A4AJ–A4AM visual iterations locally; those later iterations are not yet visible as OPUS remote commits.

A4AN is delivered against that current cumulative working tree and replaces the insufficient CSS-only geometry treatment.

## Owner finding

The A4AM browser capture proves two blocking presentation defects:

1. overall diagram reduction is not operationally evident;
2. some signal arrows/curves are emitted outside the SVG viewport.

A4AM is therefore insufficient for diagram geometry and must not be considered accepted.

## Root cause confirmed

The classic OPUS renderer creates long `outer-forward` / `outer-return` cubic corridors from transition port ordinals.

The long-return branch uses an ordinal-derived offset multiplied by 30px. With the A4AI topology this produces geometry beyond the declared SVG viewBox.

Reproduced geometry:

- SVG viewBox: `3856 x 1256`;
- outer paths before A4AN: Y `76..1464`;
- therefore lower signal paths can exceed the viewBox by more than 200 user units.

The 21 externally routed transition instances collapse to 8 distinct rail families when grouped by direction + signal + semantic target. The extra vertical depth was renderer geometry, not FSM semantics.

## A4AN delivery

Artifact:

`opus_p117w_r45b2a4an_bounded_orthogonal_fsm_routing.zip`

SHA-256:

`e85c5c043f5b50f13fc370d31f6f7f6b77daade78af90b3d6d4c4986cae92ff5`

Five complete files:

1. `Opus/Fsm/FsmDiagramGeometryNormalizerInterface.php`
2. `Opus/Fsm/FsmDiagramGeometryNormalizer.php`
3. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
4. `sites/owasys-front/application/default/services/ScorePageRenderer.php`
5. `sites/owasys-front/www/asset/css/fsm-native.css`

No patcher. No deletion.

## Generic OPUS evolution

A new OPUS FSM geometry component normalizes only presentation geometry after semantic SVG generation.

It preserves:

- every transition group and transition id;
- source and target endpoints;
- signal types;
- actionability and URLs;
- state order and fixed canonical layout;
- current-state highlight.

Only already-classified `outer-forward` and `outer-return` paths are changed.

Their excessive cubic excursions become deterministic orthogonal rails bounded by the existing SVG viewBox.

Repeated global families such as logout share the appropriate visual rail. The actionable label for the current state wins label ownership; otherwise one passive representative label remains. Duplicate passive labels are hidden while their transition paths remain present.

## Physical size and labels

A4AN removes CSS `zoom` as the scaling mechanism.

The geometry normalizer emits the SVG at 60% physical width/height while retaining the canonical viewBox. For the A4AI projection:

- semantic viewBox remains `3856 x 1256`;
- physical size becomes `2313.6 x 753.6`;
- signal typography is enlarged in SVG user units before scaling;
- label backgrounds are expanded accordingly.

`ScorePageRenderer` now requests `fsm-native.css?v=p117w-r45b2a4an` to force a distinct cache identity for owner validation.

## Pre-delivery checks passed

- PHP lint: four delivered PHP files OK;
- no trailing whitespace in delivered PHP/CSS;
- exact outer transition instance count: 21;
- original reproduced outer Y range: `76..1464`;
- normalized outer Y range: `70..1044`;
- no normalized outer path exceeds viewBox `0..1256`;
- 13 duplicate passive labels suppressed, leaving 8 shared visual rail-label families;
- actionable current-state logout label remains visible/clickable in smoke;
- routing identity becomes `bounded-orthogonal-v5`;
- direct ZIP contains exactly the five complete files listed above.

## Owner validation

Apply A4AN over the current local A4AI+A4AJ+A4AK+A4AL+A4AM working tree, then restart `owasys-front` and hard-refresh the browser.

Acceptance in browser:

1. the deep parabolic bottom `cancel_creation` / return curves seen in the owner screenshot are gone;
2. no signal edge leaves the bordered FSM canvas;
3. repeated outer/global families use compact shared orthogonal rails;
4. diagram is visibly smaller than A4AM without unreadably shrinking signal names;
5. cyan actionable signal labels still hover/focus/click normally;
6. state order, current-state highlight and typed colors are unchanged;
7. menu/autocollapse and application FSM behavior are unchanged.

Do not mark A4AN accepted before this owner browser validation.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
