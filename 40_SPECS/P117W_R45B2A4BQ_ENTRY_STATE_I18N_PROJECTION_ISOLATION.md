# P117W R45B2A4BQ — Entry-state I18n projection isolation

## Status

OWNER APPLIED/PUSHED — RUNTIME PASS — CONTINUED BY A4BR SCAFFOLD PROPAGATION

## Historical baseline

- OPUS committed master before A4BO/A4BP/A4BQ: `7ded8369167fa6d75df7f0cf6b33b67a45a5d626` — A4BN.
- A4BO introduced the canonical real `begin` FSM state (`type=entry`, `initial_state=begin`).
- A4BP made `entry` a supported OWASYS navigation-projection state type.
- Menu behavior remained frozen.

## Runtime failure evidence

After A4BP, `GET /fr-FR/applications` reached SCORE rendering but failed repeatedly with HTTP 500:

`OWASYS_SCORE_FSM_I18N_MESSAGE_MISSING`

The exception originated from:

`sites/owasys-front/application/default/services/ScorePageRenderer.php:458`

The previous `OWASYS_NAVIGATION_STATE_TYPE_INVALID` integration failure was therefore passed; the next consumer mismatch was the I18n projection layer.

## Root cause

A4BO intentionally declares the real entry state's navigation presentation label as the technical FSM identifier `begin`.

A4BP permits `type=entry` to pass through the navigation projection, but `OwasysScorePageRenderer::normalizeI18nViewData()` still treated every navigation state's label as a human I18n key and called `translateStateText()` unconditionally.

That meant the technical canonical identifier `begin` was incorrectly looked up as an I18n message. No `begin` translation is supposed to exist: an entry state is a technical control state and is not a human navigation resource.

Adding a fake `begin` translation would only mask the projection defect and violate the cause-first/zero-fallback contracts.

## A4BQ correction

`OwasysScorePageRenderer` distinguishes canonical FSM `type=entry` states when normalizing navigation view data.

For an entry state:

- the technical canonical state ID is retained as the internal navigation label;
- no I18n lookup is performed for that state label;
- the state remains non-visible according to its EFSM navigation metadata;
- its transition/signal data remains available to diagnostic consumers;
- ordinary state, target, operation and page I18n behavior is unchanged.

For every non-entry state, missing I18n messages still fail explicitly with `OWASYS_SCORE_FSM_I18N_MESSAGE_MISSING`. There is no silent fallback.

## Scope

Exactly one complete file changed:

- `sites/owasys-front/application/default/services/ScorePageRenderer.php`

No menu file changes. No `owasys-back` JavaScript/presentation changes. No JavaScript was added.

## Artifact

`opus_p117w_r45b2a4bq_entry_state_i18n_projection_isolation.zip`

SHA-256:

`0b4aeae6ed560ba18e7e720570d4df85c3e8f26ce38c0856c20a951221ae1ac7`

## Pre-application validation

- `php -l` on `ScorePageRenderer.php`: OK;
- source baseline verified against committed OPUS blob `dd63285db8e95f29608070c602882d562ad69a90` before the A4BQ delta;
- targeted smoke with an A4BO-style `begin` entry state whose technical label is deliberately not translatable: entry label stays `begin` and rendering continues;
- normal registry state translation still executes;
- normal missing non-entry I18n key still raises `OWASYS_SCORE_FSM_I18N_MESSAGE_MISSING`;
- no trailing whitespace;
- ZIP contains exactly one complete final-path source file.

## Owner runtime acceptance

The owner applied the complete A4BO/A4BP/A4BQ integration sequence and pushed OPUS:

`5fa113426e44f1c9f8489f8317affa34b755fe6d`

`opus_p117w_r45b2a4bq_entry_state_i18n_projection_isolation`

Owner runtime screenshot confirms normal OWASYS FSM rendering with the real rectangular `begin` state, translated menu, no white pseudo marker and no blocking entry-state navigation/I18n error.

The outstanding architectural propagation identified by A4BO is now Composer generation: fresh OPUS applications must be born with the same real `begin` semantics. This is A4BR.
