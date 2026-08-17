# P117W R45B2A4AI — Handoff

State: DESIGN LOCK / IMPLEMENTATION NEXT

## Owner requirement

Do not continue with A4AH.

The owner requires a complete FSM, not a reduced page graph. Explicit example:

`Applications -> create_app -> Application created`

Universal actions such as `logout` must be connected to all applicable states.

Submenus must remain part of the workflow UI.

## Required implementation

1. Add generic OPUS support for ordinary global transitions distinct from NMI.
2. Exact state-local transition takes precedence over global transition.
3. Replace duplicated OWASYS universal transition families with global transitions.
4. Model `logout -> login` globally and render it as connected to every applicable state.
5. Separate global top-level navigation from local state workflow submenu transitions.
6. Audit current outcome/self-loop signals and promote observable workflow/result conditions to explicit states where required.
7. Application lifecycle must include explicit creation result semantics, not collapse directly from creation to data.
8. Source/Git outcome lifecycle must be audited similarly.
9. Keep A4AG fixed readable diagram, typed colors, click/focus behavior and Account/Password split.
10. Menu and diagram remain two projections of one canonical FSM; no parallel registry.

## Do not do

- do not remove submenus;
- do not duplicate every global `open_*`/`logout` transition per state;
- do not hide missing states by changing diagram presentation;
- do not treat every business outcome as a self-loop by default;
- do not patch NavigationBuilder independently from the FSM model.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.