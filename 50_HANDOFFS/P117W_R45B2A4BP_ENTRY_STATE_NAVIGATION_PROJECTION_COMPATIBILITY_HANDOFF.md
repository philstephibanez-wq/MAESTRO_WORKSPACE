# P117W R45B2A4BP — Handoff

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

- OPUS committed master remains `7ded8369167fa6d75df7f0cf6b33b67a45a5d626` — A4BN.
- Owner applied A4BO locally and runtime validation exposed an integration defect before commit/push.
- A4BP is a one-file differential over the locally applied A4BO state.

## Runtime KO

Observed front error:

`OWASYS_NAVIGATION_STATE_TYPE_INVALID`

HTTP 500 from:

`sites/owasys-front/application/default/services/NavigationBuilder.php:104`

The failing requests are `GET /fr-FR/applications`.

For the same correlated traces, OWASYS back successfully executes `GET /api/v1/applications`, Composer `owasys:registry-sync` succeeds in-process, and REST returns 200. Back/REST/Composer are not the failing layer.

## Root cause

A4BO correctly introduced `begin` as a canonical real FSM entry state:

- `id=begin`;
- `type=entry`;
- `initial_state=begin`.

But OWASYS front NavigationBuilder retained its pre-A4BO state-type whitelist and rejected `entry` before navigation projection.

A4BP aligns that consumer with the canonical state taxonomy. It does not weaken unknown-type rejection and does not change menu semantics.

## Artifact

`opus_p117w_r45b2a4bp_entry_state_navigation_projection_compatibility.zip`

SHA-256:

`0269905ef4ac8a68977dbafcf960ad001475ae3075f277282dc057bde12a7797`

Exactly one complete file:

- `sites/owasys-front/application/default/services/NavigationBuilder.php`

## Validation performed

- `php -l` OK;
- source baseline matches committed NavigationBuilder blob `b887c80e178750ad42f1c8d1ba3279979ef939df`;
- only the supported state-type whitelist changes;
- `entry` is accepted alongside `screen`, `workflow`, `result`, `system`;
- unsupported state types still fail explicitly;
- no menu file, framework file or `owasys-back` file is included.

## Owner validation sequence

Apply A4BP over the current locally applied A4BO files.

1. restart `owasys-front`;
2. request `/fr-FR/applications`;
3. confirm HTTP 500 `OWASYS_NAVIGATION_STATE_TYPE_INVALID` is gone;
4. confirm application registry loads normally;
5. open FSM and confirm real `begin` state semantics remain intact;
6. confirm `begin` is not projected into the human menu;
7. validate login, application selection and existing menu operations;
8. commit/push OPUS only after runtime validation.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
