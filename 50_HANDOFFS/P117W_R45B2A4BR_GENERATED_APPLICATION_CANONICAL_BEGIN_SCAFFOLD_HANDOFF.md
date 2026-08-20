# P117W R45B2A4BR — Handoff

State: OWNER COMMITTED / FRESH-GENERATION ACCEPTANCE PENDING

## Canonical OPUS baseline

- OPUS `master`: `3e5d9e18b19015807b6d1320b5d93c3bcd21f571` — `opus_p117w_r45b2a4br_generated_application_canonical_begin_scaffold_reissue_dc9095c`, owner commit dated 2026-08-20.
- Direct parent: `dc9095c108842931bbfad184d88f5ae1c2480ee2` — owner persisted OWASYS FSM layout commit.
- A4BR changes exactly `Opus/Scaffold/SiteScaffoldPlan.php`.
- Owner commit is canonical reconciliation evidence for the delivered framework delta. It does not by itself prove fresh generated-site runtime acceptance.

## A4BR result now committed

### Frontend/fullstack generation

New generated application FSMs contain a real entry state:

`begin (type=entry, module=home) -> explicit open_<route> signal -> functional state`

The source-state transition matrix includes `begin`, therefore `open_home`, optional `open_login`, and `open_profiler` can be dispatched from the entry state.

`initial_state` is `begin`.

No physical `application/begin` module is required; `begin` executes on the existing `home` module surface.

### Backend generation

New generated backend application FSMs contain:

`begin (type=entry, module=api) --dispatch_api--> api`

and preserve:

`api --dispatch_api--> api`

`initial_state` is `begin`. The separate REST request FSM remains unchanged.

## Runtime evidence received after owner commit

The supplied OWASYS runtime capture is healthy for the current OWASYS navigation path:

- `/fr-FR/applications` completes successfully;
- the canonical OWASYS FSM executes `open_applications` from current state `registry` and remains in `registry` through the global transition;
- the correlated REST request `/api/v1/applications` returns HTTP 200;
- registry synchronization succeeds;
- profiler trace status contains no warning/error for that request.

This evidence validates the live OWASYS navigation/REST path, not A4BR scaffold generation.

The selected generated application in the same capture is `essai2`, whose recorded selection/update evidence is dated 2026-08-19, before the A4BR owner commit on 2026-08-20. It cannot be used as fresh-generation acceptance for A4BR.

## Remaining acceptance gate

Before opening the next OPUS behavior package, validate A4BR against sites generated after commit `3e5d9e18...`:

1. Generate one fresh frontend or fullstack application.
2. Confirm its `config/application.fsm.json` has `initial_state=begin`.
3. Confirm one real `begin` state has `type=entry`, maps to `home`, and has explicit transitions from `begin` to functional states.
4. Start the fresh generated application and confirm first functional routing occurs through a real transition from `begin`.
5. Open its DEV FSM diagram and confirm `begin` is a real ordinary draggable state.
6. Generate one fresh backend application.
7. Confirm backend `initial_state=begin`, `begin --dispatch_api--> api`, and preserved `api --dispatch_api--> api`.
8. Confirm no generated `application/begin` directory exists.
9. Validate both fresh sites with the canonical OPUS validation path.

## Continuation rule

No new OPUS/OWASYS source delta is authorized from the current evidence alone. The next milestone is selected only after the fresh-generation acceptance above either:

- passes, allowing A4BR closure and the next generic FSM propagation boundary to be selected; or
- fails, in which case the next deliverable is the smallest root-cause correction in OPUS.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
