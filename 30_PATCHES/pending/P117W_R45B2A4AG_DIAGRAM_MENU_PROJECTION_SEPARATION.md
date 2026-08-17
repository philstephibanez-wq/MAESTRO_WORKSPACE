# P117W R45B2A4AG — Diagram / menu projection separation

State: RUNTIME VALIDATED — MENU UX SUPERSEDED BY A4AH

## Baseline

A4AD Account/Password split + A4AE traceable fixed diagram + A4AF typed signals.

## Owner runtime feedback — 2026-08-17

A4AG removes the A4AF HTTP 500 `OWASYS_FSM_WORKFLOW_MENU_DIVERGENCE`.

Owner runtime feedback after A4AG:

- fixed FSM diagram is now judged "pas mal du tout";
- signal-type coloring and full semantic diagram remain useful;
- global menu presentation is rejected as incoherent because each state is rendered as a dropdown containing substantially the same navigation signal set.

A4AG therefore validates the diagram/menu projection separation but does not settle global-menu UX.

## Root correction delivered by A4AG

A4AG correctly separates:

1. full semantic FSM projection -> diagram/profiler;
2. user-navigation signal projection -> actionable navigation facts.

Technical command/outcome/system transitions remain in the diagram while being absent from the user menu. This contract remains required by A4AH.

## Artifact

`opus_p117w_r45b2a4ag_diagram_menu_projection_separation.zip`

SHA-256:

`2f09fd727de59d937452dfd6ba964e9b786f6b473b5ddc18a8a7de43622ec51a`

## Runtime status

Validated by owner:

- `/fr-FR/applications` renders again;
- fixed FSM diagram remains functional;
- diagram/menu projection divergence is removed.

Superseded by A4AH only for global-menu presentation. A4AH must preserve the A4AG separation contract and diagram behavior.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.