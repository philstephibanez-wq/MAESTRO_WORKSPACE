# P117W R45B2A4AU — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

OPUS owner baseline remains:

`ec133bd9c9e7f5e01177e88c5bb62133e9a72e48` — `opus_p117w_r45b2a4as_runtime_failure_lifecycle_finalization`

A4AT is owner-applied for validation but not yet visible as a new OPUS GitHub commit. A4AU has no file overlap with A4AT and is intended to be applied after it.

## Validation failure closed

A4AT acceptance point 1 failed before the redirect controller was reached.

On creation Basics, clicking `Annuler` with the required application id empty causes browser-native constraint validation (`Veuillez remplir ce champ.`). The form is not submitted, so no A4AT 303 can occur.

Exact current template source confirms `cancel-creation` is a submit button in a form containing required fields and lacks `formnovalidate`.

## A4AU

Template-only correction:

- all three `cancel-creation` buttons receive `formnovalidate`;
- `previous-basics` receives `formnovalidate`;
- `previous-security` receives `formnovalidate`;
- `next-security`, `review-creation` and `confirm-creation` remain validating submit actions.

This preserves the canonical FSM signals and server validation while preventing browser validation from blocking navigation-only transitions.

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

## Owner acceptance

1. Basics: with empty application id/profile, click `Annuler`; no browser validation popup; Applications is reached through the A4AT 303.
2. Verify the corresponding front trace completes with `request.completed` and `http.response.sent` status 303, with no `score.response.rendered` event for the 303.
3. Security: `Précédent` and `Annuler` remain usable even if required fields are invalid/empty.
4. Review: `Précédent` and `Annuler` remain usable.
5. `Suivant`, `Récapitulatif` and `Créer` retain intended validation.
6. No FSM/REST/ACL/SSO/session/SCORE/profiler regression.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
