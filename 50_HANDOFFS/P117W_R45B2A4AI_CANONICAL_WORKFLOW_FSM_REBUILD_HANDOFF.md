# P117W R45B2A4AI — Handoff

State: SPECIFIED — CODE DELIVERY REQUIRED

## Current owner decision

A4AH is rejected. Do not continue treating the direct seven-link menu as accepted behavior.

The fixed FSM diagram direction remains acceptable, but its semantic projection is incomplete.

## Confirmed source facts

Current OWASYS front principal `fsm.json` has only 11 states, while it carries 45 signals and 165 transitions.

`application_created` is currently an outcome signal on `creation -> data`, not a state.

The creation wizard already owns real states `basics`, `security`, `review` in a separate `creation.wizard.fsm.json`, so those states are invisible to the principal diagram/menu model.

`logout` already has explicit canonical transitions from the current finite states, but the current fixed diagram builder only chooses one representative logout edge (`build -> login`).

Source/Git operations similarly use many command/outcome self-loops in state `source`.

## Next implementation target

R45B2A4AI must fix the model before changing presentation:

- canonical workflow state domain, not page/module-only state domain;
- creation workflow states integrated into the principal canonical model;
- `Application created` as explicit state;
- lifecycle-state audit for Source/Git and build preview;
- generic finite global-transition applicability for logout/change_app/global navigation;
- branch-specific hierarchical submenus derived from FSM;
- diagram derived from canonical topology instead of a handpicked `LOGICAL_EDGES` sample;
- global transition rail/bus permitted for readability if every applicable source remains visibly connected;
- typed signal colors and cyan current-action focus preserved.

## Mandatory owner example

The resulting model must make a flow of the following nature explicit:

`Applications -> create_app -> ...creation workflow... -> Application created`

and must show `logout -> login` from every applicable authenticated state.

## Governance

README-FIRST remains binding. Root cause only. OPUS/OWASYS delivered by differential direct ZIP; owner applies, validates, commits and pushes. Assistant writes only MAESTRO_WORKSPACE directly.
