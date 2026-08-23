# P117W R45B2A4BZ2R8B2 — Actual graphical PHP GUARD/ACTION authoring

State: OWNER COMMITTED/PUSHED — VALIDATION FAILED — SUPERSEDED BY R8B3

## Landed OPUS commit

`76b59191492f4efabf343e85be841f4832fe0ced`

`opus_p117w_r45b2a4bz2r8b2_actual_graphical_handler_authoring`

The owner recreated the generated application `essai` and reported two blocking failures:

- Conception still displays the OWASYS host FSM instead of the selected `essai` FSM;
- STATE Create does not operate.

## Post-landing root-cause audit

The failures are not presentation-only.

1. `OwasysFsmDiagramBuilder` is still host-bound. In design mode it loads `owasys-front/config/site.json` and then the host `navigation.fsm`, so the graph source remains OWASYS rather than the current selected application.
2. `OwasysFsmDesignerGateway` still hardcodes semantic draft and handler endpoints to `owasys-front`, so even a visually corrected graph would mutate the wrong application.
3. `OwasysFsmDraftCommandProvider` still hardcodes `/config/fsm.json`; generated applications canonically use `config/application.fsm.json`.
4. R8B2 JavaScript references `handlerSourceEditor` before its `const` declaration. The resulting temporal-dead-zone `ReferenceError` aborts designer initialization before STATE event listeners are installed.
5. Freshly generated `sites/essai/config/application.fsm.json` contains no `signals` registry although the generic EFSM validator requires every transition signal to be declared.
6. The same freshly generated FSM has the `profiler` state removed but retains profiler-related transitions. `ProfilerEnvironmentScaffoldPolicy::withoutProfilerFsm()` removes only transition ID exactly `open.profiler`, while actual transition IDs are `open.profiler.from.*` and normal application transitions can still originate from `profiler`.
7. `FsmSiteLoader` currently interprets an EFSM state without `module` as if `module == state.id`; that re-couples a pure STATE created by the designer to an application module directory.

## Consequence

R8B2 remains useful for the graphical PHP GUARD/ACTION source editor, but its owner acceptance is invalid. No further handler-authoring evolution should be stacked until selected-application EFSM authority and STATE creation are corrected.

## Superseding slice

`P117W R45B2A4BZ2R8B3 — Selected application EFSM authority + persistent STATE CRUD`

R8B3 is bound to the real R8B2 owner baseline `76b5919...` and treats the causes above.