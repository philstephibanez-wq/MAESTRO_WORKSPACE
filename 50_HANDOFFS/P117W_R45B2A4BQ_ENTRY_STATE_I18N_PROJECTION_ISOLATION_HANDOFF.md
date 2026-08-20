# P117W R45B2A4BQ — Handoff

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

- OPUS committed master: `7ded8369167fa6d75df7f0cf6b33b67a45a5d626` — A4BN.
- Owner has A4BO locally applied for canonical real `begin` semantics.
- Owner has A4BP locally applied to accept `entry` in OWASYS navigation projection.
- A4BQ is a one-file differential over that local state.
- Menu behavior remains frozen.

## New runtime KO after A4BP

The attached owner logs show three consecutive failures for `GET /fr-FR/applications` with HTTP 500:

`OWASYS_SCORE_FSM_I18N_MESSAGE_MISSING`

All three originate from `ScorePageRenderer.php:458`.

This confirms A4BP moved execution past the previous unsupported `entry` taxonomy error and exposed the next integration defect in the SCORE/I18n consumer.

## Root cause treated

A4BO's canonical `begin` state is a technical FSM control state. Its identifier `begin` is not a user-facing translation key.

A4BP allowed that valid state type into the navigation projection, but `ScorePageRenderer` still translated every projected state label without distinguishing technical entry states.

Therefore the renderer attempted to resolve `begin` as an I18n message and failed by design under the zero-fallback contract.

A4BQ does not add a fake translation. It corrects the projection boundary: entry-state IDs remain technical and bypass only the human state-label translation step.

## Artifact

`opus_p117w_r45b2a4bq_entry_state_i18n_projection_isolation.zip`

SHA-256:

`0b4aeae6ed560ba18e7e720570d4df85c3e8f26ce38c0856c20a951221ae1ac7`

Exactly one complete file:

- `sites/owasys-front/application/default/services/ScorePageRenderer.php`

## Preserved invariants

- canonical `initial_state=begin` from A4BO is unchanged;
- `begin` remains `type=entry`;
- `begin --open_login--> login` is unchanged;
- no human menu entry is created for `begin`;
- ordinary state/menu/operation/target translations are unchanged;
- genuine missing non-entry I18n messages still fail explicitly;
- no menu source file changes;
- no OPUS framework class changes;
- no `owasys-back` changes;
- no JavaScript added.

## Validation performed

- PHP lint: OK;
- committed ScorePageRenderer baseline blob verified: `dd63285db8e95f29608070c602882d562ad69a90`;
- targeted entry-state I18n smoke: technical `begin` label is retained without translation lookup;
- ordinary registry state translation still runs;
- missing non-entry label still raises `OWASYS_SCORE_FSM_I18N_MESSAGE_MISSING`;
- no trailing whitespace;
- ZIP contains exactly one complete source file.

## Owner validation sequence

Apply A4BQ over the current local A4BO+A4BP files.

1. restart `owasys-front`;
2. request `/fr-FR/applications`;
3. confirm the SCORE FSM I18n 500 is gone;
4. confirm applications registry renders normally;
5. confirm no `begin` item appears in the human menu;
6. open FSM and confirm real `begin` state + `open_login` relation remain visible;
7. validate login, application selection and ordinary translated menus;
8. commit/push OPUS only after runtime validation.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
