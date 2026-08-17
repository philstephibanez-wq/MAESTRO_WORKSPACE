# P117W R45B2A4AH — Direct FSM state menu restore

State: OWNER REJECTED — SUPERSEDED BY R45B2A4AI

## Rejection — 2026-08-17

Owner runtime validation rejects A4AH.

Observed regression:

- A4AH removed the FSM submenus entirely;
- it reduced the UI to a direct state bar;
- this hides the workflow relations the owner explicitly requires;
- the diagram is visually improved, but the underlying OWASYS FSM remains semantically incomplete.

Owner clarified the required model with the example:

`Applications -> create_app -> Application created`

Owner also requires `logout` to be linked to all states.

## Root architectural error

The current OWASYS navigation FSM has only a small set of page/module states while many observable workflow conditions are encoded only as signals/outcomes or self-loops.

Examples include:

- `application_created`;
- `application_creation_failed`;
- `application_deleted`;
- `registry_action_failed`;
- `password_changed` / `password_change_failed`;
- source/Git outcomes such as `source_written`, `source_conflict`, `source_staged`, `source_committed`, `source_restored`, `git_action_failed`.

The current model also duplicates global navigation transitions (`open_*`, `change_app`, `logout`) once per concrete state. This creates a dense artificial complete graph and repeated menus.

A4AH treated the presentation symptom instead of rebuilding the FSM semantics.

## Superseded direction

R45B2A4AI must rebuild the FSM contract before another menu patch:

1. retain a coherent top-level navigation bar;
2. restore state-specific submenus derived from real local workflow transitions;
3. model observable workflow/result conditions as explicit states where semantically appropriate;
4. introduce a generic OPUS global-transition contract so universal transitions are not duplicated once per state;
5. model `logout` as one global transition to `login`, graphically connected to all applicable states;
6. model global section navigation (`change_app`, `open_data`, `open_structure`, etc.) separately from local workflow commands;
7. keep typed signal colors and the fixed readable FSM diagram;
8. do not invent a parallel menu registry: menu remains a projection of the canonical FSM.

A4AH artifact MUST NOT be committed as an accepted solution.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.