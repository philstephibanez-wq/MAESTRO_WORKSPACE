# P117W R45B2A4AD — Handoff

State: OWNER VALIDATION REQUIRED

## Purpose

Correct the canonical FSM semantic error where `open_account` means "change password".

The navigation is not patched independently. A4AD corrects the FSM first, then aligns route resolution and SCORE rendering with that FSM.

## Required working-tree baseline

Apply A4AD after the current A4AC working tree. A4AD changes only account/password semantics and the fixed-diagram projection required by the new state. It does not replace the A4AC generic renderer, CSS or ScorePageRenderer.

## Artifact

`opus_p117w_r45b2a4ad_account_password_fsm_split.zip`

SHA-256:

`c213f21a611677c3f14ab25ee7ee857f8554193ef8605c72319091021dd7388e`

Files:

- `sites/owasys-front/application/account/templates/index.score`
- `sites/owasys-front/application/account/templates/password.score`
- `sites/owasys-front/application/default/controllers/RuntimeController.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/config/routes.json`
- `sites/owasys-front/config/routes.localized.json`

## Semantic contract after extraction

- `open_account -> account`;
- `open_password_change -> password`;
- account route = `account`;
- password route = `account/password`;
- French public paths = `compte` and `compte/mot-de-passe`;
- `password_change_required -> password`;
- `password_change_failed: password -> password`;
- `password_changed: password -> registry`;
- header Account URL uses canonical `account`;
- password form remains SCORE and moves to `password.score`;
- account overview remains in the existing `account` module;
- no parallel state registry is introduced.

## Validation already executed

- PHP lint: RuntimeController OK;
- PHP lint: FsmDiagramBuilder OK;
- FSM JSON decode OK;
- routes JSON decode OK;
- localized routes JSON decode OK;
- 11 FSM states;
- 45 signals;
- 165 transitions;
- 0 duplicate concrete state/signal pairs;
- 0 undeclared signals;
- 0 unused signals;
- 11/11 `open_account` transitions target `account`;
- 11/11 `open_password_change` transitions target `password`;
- localized route collisions: 0 across 25 languages.

## Owner validation sequence

1. Extract A4AD at `H:\OPUS`.
2. Verify working tree contains the expected seven A4AD files plus any already-uncommitted A4AC files.
3. Lint RuntimeController and FsmDiagramBuilder.
4. Run `git --no-pager diff --check`.
5. Rebuild Composer autoload.
6. Restart `owasys-front`.
7. From Applications, activate `open_account` or the header `Compte` link.
8. Confirm URL `/fr-FR/compte`, FSM state `account`, and Account overview body.
9. Activate `Changer le mot de passe`.
10. Confirm URL `/fr-FR/compte/mot-de-passe`, FSM state `password`, and password form.
11. Return to Applications and confirm fixed diagram geometry remains stable except for the legitimate additional password state/edge.
12. Validate `change_app` and `logout` still work.
13. Validate locale change from Account stays on Account; from Password stays on Password.
14. Validate a must-change-password identity is forced to Password, never merely Account.

Do not mark A4AD complete before owner runtime validation.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.