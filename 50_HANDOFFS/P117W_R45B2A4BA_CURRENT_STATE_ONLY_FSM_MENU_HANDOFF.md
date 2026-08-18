# P117W R45B2A4BA — Handoff

State: OWNER COMMITTED/PUSHED IN OPUS — PRIMARY MENU STRUCTURE OBSERVED — A4BB FOLLOW-UP

## Owner OPUS commit

`e0267052c0ca9442b492f36dfc1daad5c40d7508` — `opus_p117w_r45b2a4ba_current_state_only_fsm_menu`

A4BA is the owner baseline for A4BB.

## Owner runtime evidence

The owner screenshot after A4BA shows the intended current-state-only menu structure:

- only the current state (`Workflows` in the captured request) has the dropdown affordance;
- inactive canonical states are static labels;
- the former inactive-state `Ø` dropdowns are gone;
- outgoing signals are hosted only by the current state.

No claim is made here about every historical A4BA acceptance point beyond the supplied runtime evidence.

## Semantic issue exposed by the successful menu correction

Once the current-state projection became readable, the owner identified that `Workflows` itself had no valid independent developer responsibility.

Accepted architecture decision:

- workflow is the FSM graph itself: states + signals + guards + transitions + actions;
- the OWASYS FSM is the workflow of the developer using OWASYS;
- the selected/generated application's FSM is a different FSM and represents that application's workflow;
- the two machines must never be conflated;
- the selected application's FSM must be visible/editable as an application resource in OWASYS;
- generated OPUS applications must expose their own FSM in development runtime/profiler context.

## Repository audit after the decision

At owner HEAD A4BA:

- `sites/owasys-front/application/workflows/` contains only scaffold placeholders (`.gitkeep`) and no business controller/model/template;
- generated applications already receive `config/application.fsm.json` from `Opus/Scaffold/SiteScaffoldPlan.php`;
- `Opus/Application/Runtime/GeneratedSiteRuntime.php` already renders the generated application's FSM diagram from that canonical definition;
- therefore the generated-app DEV requirement already has a generic OPUS foundation and must not be reimplemented locally in OWASYS.

## Follow-up

A4BB replaces the user-visible `Workflows` concept with an `FSM` application-resource surface and renders the selected application's canonical FSM through the existing secured REST source boundary.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
