# P117W R45B2A4AA — Handoff

State: OWNER APPLIED — KEEP CSS; CONTINUE WITH A4AB

## Baseline

OPUS:

`0ce2dfa9a1c7175ac39f93b2ee017ed6e40643ac` — A4Z classic fixed FSM + autocollapse.

A4Z is accepted and must not be reworked.

## A4AA scope

A4AA is presentation-only and changes exactly one OWASYS front asset:

`sites/owasys-front/www/asset/css/fsm-native.css`

It provides the cyan full-box hitbox and hover/focus affordance for renderer-generated `.fsm-signal-link` anchors.

## Owner application

Owner extracted A4AA successfully. Git showed only the expected CSS modification.

The CSS remains required and is not rejected.

## Functional gap discovered after application

The fixed A4Z graph displays representative transitions independent from the runtime current state. `FsmDiagramBuilder` currently assigns an anchor URL only when the exact displayed transition ID is actionable in Menu=FSM.

Example confirmed by owner screenshot:

- displayed representative: `build --logout--> login`;
- runtime state: `registry` / Applications;
- canonical runtime transition: `registry --logout--> login` exists and is actionable;
- route registry maps `logout` to the `logout` signal;
- displayed `logout` label nevertheless has no anchor because `t_logout__from__build` is not the current-state transition.

This is a diagram interaction mapping defect, not a CSS defect.

## Required continuation — A4AB

Keep A4AA CSS unchanged. A4AB changes `FsmDiagramBuilder` so a fixed displayed label becomes interactive when the same semantic `signal + target` is actionable from the runtime current state.

The selected URL must always come from the current Menu=FSM projection. No ACL, route or FSM bypass is permitted.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.