# P117W R45B2A4BP — Handoff

State: OWNER RUNTIME PARTIAL PASS — TAXONOMY ERROR CLEARED — SUPERSEDED BY A4BQ

## Baseline

- OPUS committed master remains `7ded8369167fa6d75df7f0cf6b33b67a45a5d626` — A4BN.
- Owner applied A4BO locally and runtime validation exposed an integration defect before commit/push.
- A4BP was applied as a one-file differential over that local A4BO state.

## Original KO

Observed front error:

`OWASYS_NAVIGATION_STATE_TYPE_INVALID`

HTTP 500 from:

`sites/owasys-front/application/default/services/NavigationBuilder.php:104`

The failing requests were `GET /fr-FR/applications`.

## Root cause treated

A4BO correctly introduced `begin` as a canonical real FSM entry state:

- `id=begin`;
- `type=entry`;
- `initial_state=begin`.

But OWASYS front NavigationBuilder retained its pre-A4BO state-type whitelist and rejected `entry` before navigation projection.

A4BP aligned that consumer with the canonical state taxonomy. It did not weaken unknown-type rejection and did not change menu semantics.

## Runtime result after A4BP

The owner reran OWASYS front. The previous `OWASYS_NAVIGATION_STATE_TYPE_INVALID` error no longer occurred.

Three consecutive `GET /fr-FR/applications` requests then failed later in the pipeline with HTTP 500:

`OWASYS_SCORE_FSM_I18N_MESSAGE_MISSING`

from `ScorePageRenderer.php:458`.

This demonstrates that A4BP passed the entry-state taxonomy gate and exposed a downstream SCORE/I18n projection mismatch. The real `begin` state carries a technical identifier that must not be treated as a human translation key.

A4BQ is the current continuation and must be applied on top of A4BO+A4BP.

## A4BP artifact

`opus_p117w_r45b2a4bp_entry_state_navigation_projection_compatibility.zip`

SHA-256:

`0269905ef4ac8a68977dbafcf960ad001475ae3075f277282dc057bde12a7797`

Exactly one complete file:

- `sites/owasys-front/application/default/services/NavigationBuilder.php`

## Current owner sequence

Do not remove A4BP. Apply A4BQ, restart `owasys-front`, and repeat `/fr-FR/applications` validation before any OPUS commit/push.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
