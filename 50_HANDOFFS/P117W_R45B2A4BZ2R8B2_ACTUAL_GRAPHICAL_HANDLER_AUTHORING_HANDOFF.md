# P117W R45B2A4BZ2R8B2 — Actual graphical PHP GUARD/ACTION authoring handoff

State: OWNER COMMITTED/PUSHED — VALIDATION FAILED — SUPERSEDED BY R8B3

## Landed OPUS baseline

`76b59191492f4efabf343e85be841f4832fe0ced`

`opus_p117w_r45b2a4bz2r8b2_actual_graphical_handler_authoring`

## Owner validation result

After recreating generated application `essai`, the owner reports:

- the diagram shown by Conception is not `essai`'s FSM;
- a new STATE cannot be created.

## Confirmed causes

The current design surface still sources topology from the OWASYS host FSM. The front designer command gateway still targets `owasys-front`, while the backend draft provider still assumes `config/fsm.json` instead of resolving the selected application's canonical FSM path.

R8B2 also introduced a JavaScript initialization blocker: `handlerSourceEditor` is tested before its `const` declaration, so design initialization can stop before STATE handlers are registered.

The fresh generated `essai` FSM exposes two generic scaffold defects: no declared signal registry despite validator requirements, and dangling profiler transitions after the profiler state is removed by environment normalization.

Finally, generic `FsmSiteLoader` still treats a pure state without a module field as an implicit module with the same ID, which prevents persistent pure STATE authoring.

## Required recovery

Apply and owner-validate R8B3 before further handler evolution.

R8B3 makes the selected application the designer authority, targets its canonical FSM through front -> secured REST -> back -> Composer, persists STATE create/rename/delete atomically, repairs generated signal/profiler contracts, and separates pure STATE identity from application-module ownership.

No claim of R8B2 acceptance remains.