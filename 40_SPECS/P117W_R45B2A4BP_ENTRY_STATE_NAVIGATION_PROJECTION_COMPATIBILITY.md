# P117W R45B2A4BP — Entry state navigation projection compatibility

## Status

OWNER RUNTIME PARTIAL PASS — TAXONOMY ERROR CLEARED — SUPERSEDED BY A4BQ

## Baseline

- OPUS GitHub committed baseline: `7ded8369167fa6d75df7f0cf6b33b67a45a5d626` — A4BN.
- A4BO was applied locally by the owner for runtime validation and introduced the canonical real `begin` FSM state with `type=entry`.
- Menu behavior remains frozen; A4BP is compatibility plumbing only.

## Original runtime failure

After A4BO application, OWASYS front failed on `GET /fr-FR/applications` with HTTP 500:

`OWASYS_NAVIGATION_STATE_TYPE_INVALID`

The exception was raised by `sites/owasys-front/application/default/services/NavigationBuilder.php` line 104.

## Root cause treated by A4BP

A4BO extended the canonical OPUS FSM semantic state taxonomy with the real entry state:

`id=begin`, `type=entry`, `initial_state=begin`.

`FsmProcessor` accepted and validated that canonical entry-state contract, but `OwasysNavigationBuilder` retained the older closed presentation whitelist:

- `screen`
- `workflow`
- `result`
- `system`

A4BP added `entry` to that supported state taxonomy without weakening unknown-type rejection or changing menu visibility/actionability rules.

## Runtime result

A4BP successfully moved the request past `OWASYS_NAVIGATION_STATE_TYPE_INVALID`.

The next owner run reached SCORE rendering and failed instead with:

`OWASYS_SCORE_FSM_I18N_MESSAGE_MISSING`

on repeated `GET /fr-FR/applications` requests.

This new error is a separate downstream integration defect: the SCORE I18n projection was still treating the technical entry-state identifier `begin` as a human translation key.

A4BQ supersedes A4BP as the current delivery by isolating technical entry-state labels from human I18n translation while retaining the A4BP state-type compatibility.

## Artifact

`opus_p117w_r45b2a4bp_entry_state_navigation_projection_compatibility.zip`

SHA-256:

`0269905ef4ac8a68977dbafcf960ad001475ae3075f277282dc057bde12a7797`

Exactly one complete file:

- `sites/owasys-front/application/default/services/NavigationBuilder.php`

## Historical validation performed

- PHP lint: OK;
- source baseline verified against OPUS committed `NavigationBuilder.php` blob `b887c80e178750ad42f1c8d1ba3279979ef939df`;
- state-type whitelist contains `entry`, `screen`, `workflow`, `result`, `system`;
- unsupported types still fail explicitly;
- ZIP contains exactly one complete final-path file.

## Current continuation

Keep A4BP applied. Apply A4BQ on top of the current local A4BO+A4BP state. Do not roll back the `entry` taxonomy support.
