# P117W R45B2A4AH — Handoff

State: OWNER REJECTED — SUPERSEDED BY R45B2A4AI

## Owner rejection

A4AH is rejected because it removed the FSM submenus and therefore removed visible workflow relations from the OWASYS development menu.

The owner explicitly requires workflow semantics such as:

`Applications -> create_app -> Application created`

and requires universal transitions such as `logout` to be connected to all states.

## Root cause

The current FSM mixes three concerns incorrectly:

- global application navigation duplicated from every concrete state;
- local workflow commands;
- observable business outcomes encoded only as signals/self-loops instead of explicit workflow states where appropriate.

A4AH fixed only the menu presentation and therefore cannot be accepted.

## Required continuation

Do not continue from A4AH as accepted baseline.

R45B2A4AI must first rebuild the canonical FSM semantics, including:

- generic OPUS global-transition support;
- `logout -> login` as one universal transition connected to all applicable states;
- separation between global navigation and local workflow transitions;
- restoration of state-specific submenus;
- explicit business workflow/result states where required;
- preservation of typed signal colors and readable fixed diagram geometry.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.