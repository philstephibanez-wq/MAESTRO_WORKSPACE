# P117W R45B2A4AA — FSM signal focus hitbox

State: OWNER VALIDATION REQUIRED

## Baseline

OPUS baseline:

`0ce2dfa9a1c7175ac39f93b2ee017ed6e40643ac` — `opus_p117w_r45b2a4z_classic_fixed_fsm_autocollapse`.

A4Z is owner-validated and remains unchanged in topology, fixed geometry, initial-state root and menu autocollapse.

## Owner requirement

For the fixed classic FSM diagram:

- the signal label must be clickable when and only when the corresponding transition is permitted/actionable;
- actionable labels must remain cyan under the OWASYS graphical charter;
- the full signal label box is the pointer hitbox, not text glyphs only;
- keyboard focus must be obvious;
- hover/focus must produce a clear cyan highlight;
- passive/non-permitted transitions must not advertise clickability;
- no JavaScript is introduced.

## Root cause

The generic OPUS renderer already wraps a transition label in `<a class="fsm-signal-link">` when a transition URL is provided. `OwasysFsmDiagramBuilder` only provides such URLs for Menu=FSM signals whose projection has `actionable === true`.

Therefore FSM/actionability is already correct. The remaining defect is the OWASYS presentation layer: `fsm-native.css` only forces cyan text and does not provide a strong box-level hover/focus affordance.

## A4AA correction

A4AA changes only:

`sites/owasys-front/www/asset/css/fsm-native.css`

It preserves A4Z and adds:

- pointer cursor only on `.fsm-signal-link`;
- bounding-box pointer hitbox for the wrapped SVG label group;
- cyan border around actionable signal labels;
- cyan label text at rest;
- cyan filled box + cyan drop-shadow on hover/focus/focus-visible;
- contrasting dark label text during hover/focus;
- no interactive styling for passive labels.

No FSM, route, ACL, SCORE template, renderer PHP, REST or backend change is introduced.

## Direct artifact

`opus_p117w_r45b2a4aa_fsm_signal_focus_hitbox.zip`

SHA-256:

`fff5b2daf522065dfc61250ed863c10360e3d4da24fd11a90b0cf1eec5cd116a`

Contains exactly one complete final-path file:

- `sites/owasys-front/www/asset/css/fsm-native.css`

File SHA-256:

`3c373c863b9be86612d58a0d08f076131c528d8848d310ec867239cfa498af54`

## Pre-delivery validation

- ZIP contains exactly the single expected final-path CSS file;
- A4AA revision marker present;
- `:focus-visible` styling present;
- cyan `var(--ow-accent)` stroke/fill rules present;
- SVG `pointer-events: bounding-box` hitbox present;
- no JavaScript introduced.

## Owner acceptance

1. A4Z graph geometry/topology remains identical.
2. A4Z menu autocollapse remains identical.
3. On the current state, each permitted transition label appears cyan and is clickable across the whole label box.
4. Mouse hover visibly highlights the full label box in cyan.
5. Keyboard Tab can focus permitted signal links; focus visibly highlights the full label box.
6. Non-permitted/passive transition labels are not clickable and do not show pointer/focus affordance.
7. Activating a permitted label executes the same canonical Menu=FSM transition URL as before.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.