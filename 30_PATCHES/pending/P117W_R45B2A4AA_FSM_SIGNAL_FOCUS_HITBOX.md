# P117W R45B2A4AA — FSM signal focus hitbox

State: OWNER APPLIED — PRESENTATION KEPT; ACTION ROUTING COMPLETED BY A4AB

## Baseline

OPUS baseline:

`0ce2dfa9a1c7175ac39f93b2ee017ed6e40643ac` — `opus_p117w_r45b2a4z_classic_fixed_fsm_autocollapse`.

A4Z is owner-validated and remains unchanged in topology, fixed geometry, initial-state root and menu autocollapse.

## Owner requirement

For the fixed classic FSM diagram:

- the signal label must be clickable when and only when the corresponding transition is permitted/actionable;
- actionable labels remain cyan under the OWASYS graphical charter;
- the full signal label box is the pointer hitbox, not text glyphs only;
- keyboard focus is obvious;
- hover/focus produces a clear cyan highlight;
- passive/non-permitted transitions do not advertise clickability;
- no JavaScript is introduced.

## A4AA presentation correction

A4AA changes only:

`sites/owasys-front/www/asset/css/fsm-native.css`

It adds:

- pointer cursor only on `.fsm-signal-link`;
- bounding-box pointer hitbox for the wrapped SVG label group;
- cyan border/text for actionable signal labels;
- cyan filled box + cyan drop-shadow on hover/focus/focus-visible;
- contrasting dark label text during hover/focus;
- no interactive styling for passive labels.

## Owner application evidence — 2026-08-16

Owner applied the direct ZIP. Git status showed exactly:

`M sites/owasys-front/www/asset/css/fsm-native.css`

The accepted A4Z graph remained visually intact.

A subsequent runtime screenshot exposed a separate functional gap: `logout` was not clickable from `registry` although the canonical FSM contains `registry --logout--> login` and OPUS_SIGNAL_ROUTES_V2 maps `logout` to the `logout` signal.

This does not invalidate the A4AA visual hitbox. The missing clickability is caused by A4Z `FsmDiagramBuilder`: it associates a displayed label only with the exact displayed transition ID. Because the fixed graph displays one representative `build --logout--> login` edge, that label is passive whenever the runtime current state is not `build`.

A4AB completes the functional action routing while retaining A4AA CSS unchanged.

## Direct artifact

`opus_p117w_r45b2a4aa_fsm_signal_focus_hitbox.zip`

SHA-256:

`fff5b2daf522065dfc61250ed863c10360e3d4da24fd11a90b0cf1eec5cd116a`

Contains exactly one complete final-path file:

- `sites/owasys-front/www/asset/css/fsm-native.css`

File SHA-256:

`3c373c863b9be86612d58a0d08f076131c528d8848d310ec867239cfa498af54`

## Continuation

A4AA remains part of the accepted direction. Do not remove its CSS. A4AB must be applied on top of A4Z + owner-applied A4AA before final owner commit/push.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.