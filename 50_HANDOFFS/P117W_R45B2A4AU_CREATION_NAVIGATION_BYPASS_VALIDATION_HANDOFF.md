# P117W R45B2A4AU — Handoff

State: OWNER RUNTIME VALIDATION PARTIAL — CANCEL BUTTON PASSED; TRACE/PREVIOUS CHECKS PENDING

## Baseline

OPUS owner baseline remains:

`ec133bd9c9e7f5e01177e88c5bb62133e9a72e48` — `opus_p117w_r45b2a4as_runtime_failure_lifecycle_finalization`

A4AT is owner-applied for validation but not yet visible as a new OPUS GitHub commit. A4AU has no file overlap with A4AT and is applied after it.

## Validation failure closed

A4AT acceptance point 1 initially failed before the redirect controller was reached.

On creation Basics, clicking `Annuler` with the required application id empty caused browser-native constraint validation (`Veuillez remplir ce champ.`). The form was not submitted, so no A4AT 303 could occur.

Exact current template source confirmed `cancel-creation` was a submit button in a form containing required fields and lacked `formnovalidate`.

## A4AU

Template-only correction:

- all three `cancel-creation` buttons receive `formnovalidate`;
- `previous-basics` receives `formnovalidate`;
- `previous-security` receives `formnovalidate`;
- `next-security`, `review-creation` and `confirm-creation` remain validating submit actions.

This preserves the canonical FSM signals and server validation while preventing browser validation from blocking navigation-only transitions.

## Owner runtime evidence received

Owner report on 2026-08-18:

- `le btn annuler fonctionne`.

This validates the browser-side A4AU correction for the Cancel action: the required-field constraint no longer blocks that navigation action.

No profiler trace evidence was supplied with this report, and the Previous controls were not separately reported. Therefore A4AU is recorded as partial runtime validation rather than full acceptance.

The owner simultaneously reported an independent Menu = FSM defect: the visible `cancel_creation -> Applications` menu relation is not actionable. That defect is outside the A4AU template form and is handled by A4AV.

## Exact source integrity

Current source file:

`sites/owasys-front/application/creation/templates/index.score`

Owner-baseline Git blob before modification:

`890f81c97a44f0521bbfcb1aec70873bb879ffc6`

The reconstructed original was verified against that exact blob before A4AU transformation.

## Delivery

Artifact:

`opus_p117w_r45b2a4au_creation_navigation_bypass_validation.zip`

SHA-256:

`a88f22af2c4127e0079379b6b0d9e07130e8f973b8f9f933f9e8e3b9e3ae3c6b`

Exactly one complete file:

`sites/owasys-front/application/creation/templates/index.score`

No patcher. No deletion. No controller/framework/backend file.

## Static validation

- exact original ancestry verified by Git blob hash;
- 3/3 Cancel buttons carry `formnovalidate`;
- 2/2 Previous buttons carry `formnovalidate`;
- forward/commit buttons do not carry `formnovalidate`;
- no trailing whitespace;
- ZIP contains exactly the listed template.

## Remaining owner acceptance

1. Verify the Cancel front trace completes with `request.completed` and `http.response.sent` status 303, with no `score.response.rendered` event for the 303.
2. Security: `Précédent` and `Annuler` remain usable even if required fields are invalid/empty.
3. Review: `Précédent` and `Annuler` remain usable.
4. `Suivant`, `Récapitulatif` and `Créer` retain intended validation.
5. No FSM/REST/ACL/SSO/session/SCORE/profiler regression.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
