# P117W R45B2A4AU — Creation navigation bypass validation

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Cause

In the OWASYS creation wizard, `Annuler` and `Précédent` are submit buttons sharing forms with required data-entry controls. Without `formnovalidate`, browser HTML5 constraint validation can block those navigation actions before any HTTP request reaches OWASYS.

Owner evidence for A4AT point 1 shows exactly this failure on the first creation step: empty required application id prevents `cancel-creation` from being submitted.

## Contract

Navigation actions that do not consume or validate the current form data must bypass browser constraint validation:

- `cancel-creation` on all creation steps;
- `previous-basics`;
- `previous-security`.

Data-consuming actions retain browser validation:

- `next-security`;
- `review-creation`;
- `confirm-creation`.

The server-side validation remains authoritative for all submitted data.

## Implementation

Only `sites/owasys-front/application/creation/templates/index.score` changes.

Add the standard HTML `formnovalidate` attribute to the three Cancel buttons and both Previous buttons.

No controller, FSM, route, profiler, REST, ACL, SSO, session, CSS, JavaScript, framework or backend change.

## Source integrity

Template source is taken from OPUS owner baseline `ec133bd9c9e7f5e01177e88c5bb62133e9a72e48`.

Original Git blob: `890f81c97a44f0521bbfcb1aec70873bb879ffc6`.

A4AT does not modify this template, so A4AU applies after A4AT without overlap.

## Delivery

Artifact: `opus_p117w_r45b2a4au_creation_navigation_bypass_validation.zip`

SHA-256: `a88f22af2c4127e0079379b6b0d9e07130e8f973b8f9f933f9e8e3b9e3ae3c6b`

Exactly one complete file:

`sites/owasys-front/application/creation/templates/index.score`

## Acceptance

1. On creation Basics with application id empty and no profile selected, `Annuler` submits and returns to Applications; no browser required-field popup appears.
2. On Security, `Précédent` and `Annuler` are not blocked by required controls.
3. On Review, `Précédent` and `Annuler` remain navigational.
4. `Suivant`, `Récapitulatif` and `Créer` still enforce browser validation where applicable.
5. The A4AT redirect lifecycle can then be validated: 303 returns to Singleton and profiler lifecycle completes.
