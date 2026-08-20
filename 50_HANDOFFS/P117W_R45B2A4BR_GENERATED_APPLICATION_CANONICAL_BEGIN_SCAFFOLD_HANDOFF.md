# P117W R45B2A4BR — Handoff

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

- OPUS committed master: `5fa113426e44f1c9f8489f8317affa34b755fe6d` — A4BQ.
- This baseline already contains canonical real `begin` semantics and the OWASYS navigation/I18n integration corrections.
- Owner runtime screenshot confirms OWASYS now renders a real rectangular `begin` state and continues through `login`/functional states without the previous entry-state projection failures.
- Menu behavior remains frozen.

## Cause treated

A4BO deliberately left one propagation boundary for a subsequent milestone: `SiteScaffoldPlan` still generated new applications with `home` or `api` directly as `initial_state`.

That would allow newly created applications to reintroduce the old semantic model. A4BR corrects generation itself; it does not synthesize or rewrite FSMs at runtime.

## A4BR behavior

### Frontend/fullstack

Generated `config/application.fsm.json` now starts with a real state:

`begin (type=entry, module=home) -> explicit open_<route> signal -> requested functional state`

The source-state matrix includes `begin`, so `open_home`, optional `open_login` and `open_profiler` are real transitions from the entry state.

No `application/begin` directory is created; `begin` uses the existing `home` module as its execution surface.

### Backend

Generated backend application FSM now contains:

`begin (type=entry, module=api) --dispatch_api--> api`

The existing `api --dispatch_api--> api` relation is preserved. The REST internal request FSM is not altered.

### Contract compatibility

The application FSM contract stays `OPUS_APPLICATION_FSM_V1`. Legacy generated applications without a real entry state remain untouched/readable; newly generated applications are born with the canonical A4BO entry form.

## Artifact

`opus_p117w_r45b2a4br_generated_application_canonical_begin_scaffold.zip`

SHA-256:

`726e17bf9f59769b4b83492a89c51fbf741ad3457e652641724147b341e5fac1`

Exactly one complete file:

- `Opus/Scaffold/SiteScaffoldPlan.php`

No OWASYS site file. No menu file. No new framework class.

## Validation performed

- source baseline matches committed OPUS blob `bac0a8387fef34dbb2ea987b6fd6070b8ba357a1` byte-for-byte before the delta;
- PHP lint OK;
- frontend generated FSM + `FsmProcessor` smoke OK: begin -> home;
- fullstack generated FSM + processor smoke OK: begin -> home;
- backend generated FSM + processor smoke OK: begin -> api;
- login-enabled generated frontend smoke OK: begin -> login;
- no generated `application/begin` path;
- no trailing whitespace;
- ZIP contains exactly the expected complete file.

## Owner application

Apply A4BR over OPUS `5fa113426e44f1c9f8489f8317affa34b755fe6d`.

Then generate fresh test applications rather than modifying an existing generated application. The acceptance target is the generator output itself.

Recommended owner runtime sequence:

1. generate a fresh frontend or fullstack test app;
2. inspect its `config/application.fsm.json` and confirm `initial_state=begin` + real `type=entry` state;
3. start it and confirm first functional page is reached through a real transition from `begin`;
4. inspect its DEV diagram and confirm `begin` is a draggable ordinary state;
5. generate/validate a fresh backend app and confirm `begin --dispatch_api--> api`;
6. confirm no `application/begin` directory exists;
7. owner commits/pushes OPUS only after validation.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
