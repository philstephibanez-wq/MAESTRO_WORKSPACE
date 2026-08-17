# P117W R45B2A4AG — Handoff

State: RUNTIME VALIDATED — MENU UX SUPERSEDED BY A4AH

## Purpose

A4AG fixes the A4AF runtime 500 by separating the full FSM diagram projection from the filtered user-navigation projection.

## Owner validation — 2026-08-17

Validated:

- `/fr-FR/applications` renders;
- `OWASYS_FSM_WORKFLOW_MENU_DIVERGENCE` is gone;
- fixed FSM diagram remains functional and is positively accepted by owner;
- typed signal rendering remains in place.

Rejected/superseded aspect:

- the `<details>` state dropdown menu is not accepted;
- each dropdown repeats the same family of global navigation signals and is not a coherent OWASYS development menu.

## Contract retained by A4AH

- canonical FSM remains source of truth;
- diagram/profiler may expose the full typed transition subset;
- navigation URLs stay FSM/ACL gated;
- technical command/outcome/system transitions do not become user-navigation controls;
- A4AG diagram behavior must not regress.

A4AH replaces only global-menu presentation and direct-state navigation projection.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.