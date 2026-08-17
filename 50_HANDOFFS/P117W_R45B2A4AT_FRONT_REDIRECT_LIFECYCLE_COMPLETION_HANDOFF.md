# P117W R45B2A4AT — Handoff

State: OWNER VALIDATION FAILED — POINT 1 BLOCKED BEFORE HTTP REQUEST

## Owner baseline

`ec133bd9c9e7f5e01177e88c5bb62133e9a72e48` — `opus_p117w_r45b2a4as_runtime_failure_lifecycle_finalization`

A4AT was produced from this exact owner baseline.

## A4AT scope

A4AT removes process termination from successful redirects in the three specialized OWASYS-front controllers:

- CreationController;
- SourceController;
- SecurityController.

Redirects use the existing `Opus\Http\Response::empty(303, ...)->send()` mechanism and return to `OwasysFrontApplication::run()` so A4AS can finalize request/profiler lifecycle.

Artifact: `opus_p117w_r45b2a4at_front_redirect_lifecycle_completion.zip`

SHA-256: `59dddd868769d712a6ea5dede48cb4c626e0d6ba15c47a8404b175a07e4005fb`

## Owner validation result

Point 1 — Creation cancel: **FAILED**.

Owner screenshot evidence shows that clicking `Annuler` on the first creation step triggers the browser-native required-field message on the empty application identifier instead of reaching the controller.

The A4AT 303 lifecycle itself is therefore not exercised for this case: HTML5 constraint validation blocks form submission before an HTTP request is sent.

Current SCORE source confirms the cause: `cancel-creation` is a submit button in the same form as required `owasys_site_id` and required `owasys_profile` controls, without `formnovalidate`.

This is a sibling UI/form contract defect, not a reason to restore `exit` or alter the A4AT redirect lifecycle.

Correction is assigned to A4AU: non-data navigation submit actions (`cancel-creation`, `previous-basics`, `previous-security`) bypass HTML5 constraint validation while data-consuming forward/commit actions keep validation.

Points 2–6 remain unvalidated in this evidence set.

A4Z/A4AN/A4AO/A4AP FSM/UI invariants and A4AQ/A4AS profiler lifecycle invariants remain mandatory.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
