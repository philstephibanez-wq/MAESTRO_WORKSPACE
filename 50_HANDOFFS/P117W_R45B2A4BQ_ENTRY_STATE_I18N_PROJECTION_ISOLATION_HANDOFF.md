# P117W R45B2A4BQ — Handoff

State: OWNER APPLIED/PUSHED — RUNTIME PASS — CONTINUED BY A4BR SCAFFOLD PROPAGATION

## Baseline

- OPUS committed master before this sequence: `7ded8369167fa6d75df7f0cf6b33b67a45a5d626` — A4BN.
- Owner applied A4BO locally for canonical real `begin` semantics.
- Owner applied A4BP locally to accept `entry` in OWASYS navigation projection.
- A4BQ was the I18n projection correction on top of that sequence.
- Menu behavior remained frozen.

## New runtime KO after A4BP

The attached owner logs showed three consecutive failures for `GET /fr-FR/applications` with HTTP 500:

`OWASYS_SCORE_FSM_I18N_MESSAGE_MISSING`

All three originated from `ScorePageRenderer.php:458`.

This confirmed A4BP moved execution past the previous unsupported `entry` taxonomy error and exposed the next integration defect in the SCORE/I18n consumer.

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
- no `owasys-back` JavaScript or presentation code;
- no JavaScript added by A4BQ.

## Validation performed before owner application

- PHP lint: OK;
- committed ScorePageRenderer baseline blob verified: `dd63285db8e95f29608070c602882d562ad69a90`;
- targeted entry-state I18n smoke: technical `begin` label is retained without translation lookup;
- ordinary registry state translation still runs;
- missing non-entry label still raises `OWASYS_SCORE_FSM_I18N_MESSAGE_MISSING`;
- no trailing whitespace;
- ZIP contains exactly one complete source file.

## Owner runtime acceptance

The owner applied the A4BO+A4BP+A4BQ sequence and pushed OPUS commit:

`5fa113426e44f1c9f8489f8317affa34b755fe6d`

message:

`opus_p117w_r45b2a4bq_entry_state_i18n_projection_isolation`

Current owner screenshot confirms the OWASYS FSM page renders with:

- real rectangular `begin` state;
- no white pseudo initial marker;
- ordinary `login`, `password`, `registry` and creation states rendered;
- translated human menu intact;
- `begin` absent from the human menu;
- the previous entry-state navigation/I18n HTTP 500 failures no longer blocking rendering.

This closes the OWASYS consumer-integration sequence. The remaining A4BO scope boundary is Composer scaffold propagation for newly generated applications, handled by A4BR.
