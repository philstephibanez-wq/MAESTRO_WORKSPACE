# P117W R45B2A4V — Handoff

State: INVALID — SUPERSEDED BY R45B2A4W

A4V failed before tracked writes with:

`OPUS_P117W_R45B2A4V_ANCHOR_INVALID:transition-label-box:0`

The A4T baseline checks had already passed. No OPUS tracked file was changed by A4V.

## Delivery defect

A4V still depended on an exact serialized text body for `transitionSvg()`. The embedded representation escaping did not match the actual PHP source, so the replacement anchor could never match.

A4W removes body-text anchoring entirely. It locates the four renderer methods structurally with `token_get_all()` and replaces methods by identity and balanced PHP braces.

## Functional intent moved to A4W

- fan-out diagram readability;
- distinct signal lanes;
- bounded signal hitboxes;
- functional `change_app` through existing FSM action `clear_current_app`;
- Menu = FSM preserved.

Do not reapply A4V.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.