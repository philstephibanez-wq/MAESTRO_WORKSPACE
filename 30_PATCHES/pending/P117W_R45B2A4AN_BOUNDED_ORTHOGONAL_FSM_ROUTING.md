# P117W R45B2A4AN — Bounded orthogonal FSM routing

Status: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED
Date: 2026-08-17

## Owner finding

A4AM is insufficient. Reducing the rendered diagram with CSS does not correct the excessive routing geometry. The owner reports no useful visual reduction and observes signal arrows outside the visible SVG viewport.

## Audited root cause

Baseline principal FSM remains A4AI (16 canonical states / 50 typed signals / 55 canonical transitions).

The classic renderer allocates long `outer-return` / `outer-forward` corridors from source/target port ordinals. In particular the long-return formula uses an unbounded lane ordinal multiplied by 30px.

For the current A4AI projection the reproduced geometry is:

- SVG viewBox height: `1256`;
- outer transition path minimum Y: `76`;
- outer transition path maximum Y before correction: `1464`;
- therefore real transition geometry can be emitted below the SVG viewBox.

This is not a browser-width issue and is not solved by CSS scaling.

The same audit finds 21 externally routed transition instances but only 8 distinct visual rail families after grouping by direction + signal + semantic target: 6 upper rails and 2 lower rails. Repeating one increasingly deep curve per instance is unnecessary presentation geometry.

## A4AN contract

### 1. Generic OPUS geometry normalization

Add generic framework component:

- `Opus/Fsm/FsmDiagramGeometryNormalizerInterface.php`
- `Opus/Fsm/FsmDiagramGeometryNormalizer.php`

The concrete class implements its homonymous contractual interface. The interface extends directly the four mandatory OPUS framework contracts.

The component may modify presentation geometry only. It must not change canonical states, transition ids, signals, targets, actionability or semantic labels.

### 2. Bounded outer corridors

Only transitions already classified by the renderer as `outer-forward` or `outer-return` are normalized.

Their exact semantic endpoints are retained, but large cubic excursions are replaced with deterministic orthogonal rails inside the existing viewBox.

Rails are grouped by:

- top/bottom direction;
- signal label;
- semantic target state resolved from the transition endpoint.

This makes repeated globals such as `logout` visually share a rail while preserving every source connection.

### 3. Duplicate rail labels

For a shared visual rail:

- the actionable label is retained when one exists for the current state;
- otherwise one representative label remains visible;
- passive duplicate labels are hidden, not duplicated on the same rail;
- transition groups and paths remain present.

### 4. Real physical scale

CSS `zoom` is removed from the FSM diagram.

The generic normalizer emits physical SVG `width` / `height` at 60% while preserving the canonical viewBox. This makes the reduction measurable and avoids the browser-dependent behavior observed with A4AL/A4AM.

Signal-label typography is increased in user units and label backgrounds are expanded before physical scaling so signals remain readable at the smaller diagram size.

### 5. Cache identity

`OwasysScorePageRenderer` changes the FSM stylesheet revision to `p117w-r45b2a4an` so the owner validation cannot accidentally reuse an older cached CSS revision.

## Pre-delivery geometry smoke

Using the exact A4AI state ranks and projected outer-transition families:

- outer instances: 21;
- original Y range: `76..1464`;
- normalized Y range: `70..1044`;
- SVG viewBox: `0..1256`;
- path outside viewBox after normalization: none;
- shared visual rail labels: 8 families;
- actionable current-state `logout` label remains visible;
- physical SVG size from `3856x1256` becomes `2313.6x753.6` at 60%.

## Delivery

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

No patcher and no deletion.

## Acceptance

1. No `outer-forward` / `outer-return` path is outside the SVG viewBox.
2. The large bottom parabolic curves in the owner screenshot are replaced by compact orthogonal rails.
3. Diagram physical size is visibly smaller than A4AM.
4. Signal labels are visibly more readable despite the smaller overall diagram.
5. Repeated `logout` / same-target outer families share rails instead of consuming successively deeper vertical corridors.
6. The current actionable signal label remains clickable/focusable.
7. State order, canonical topology, current-state highlight, typed signal colors and menu FSM semantics are unchanged.
8. No REST, ACL, session, backend or application FSM semantics change.
9. Owner alone applies, validates, commits and pushes OPUS/OWASYS.
