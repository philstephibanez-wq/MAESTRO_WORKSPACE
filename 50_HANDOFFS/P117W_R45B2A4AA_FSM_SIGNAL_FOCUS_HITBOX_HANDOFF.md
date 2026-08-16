# P117W R45B2A4AA — Handoff

State: OWNER VALIDATION REQUIRED

## Baseline

OPUS:

`0ce2dfa9a1c7175ac39f93b2ee017ed6e40643ac` — A4Z classic fixed FSM + autocollapse.

A4Z is accepted and must not be reworked in this step.

## Scope

A4AA is presentation-only and changes exactly one OWASYS front asset:

`sites/owasys-front/www/asset/css/fsm-native.css`

The generic renderer already creates `<a class="fsm-signal-link">` only when a transition link exists. A4Z's diagram builder creates a transition link only when the corresponding Menu=FSM signal is `actionable === true`.

A4AA therefore does not alter transition permission logic. It makes the existing permitted transition link visually and ergonomically explicit.

## Required behavior

- permitted signal label: cyan and pointer cursor;
- entire SVG label rectangle is clickable;
- hover: cyan filled highlight + halo;
- keyboard focus/focus-visible: same strong cyan highlight;
- passive/non-permitted label: no link affordance;
- no JavaScript;
- A4Z topology, fixed layout, current-state highlight and autocollapse unchanged.

## Artifact

`opus_p117w_r45b2a4aa_fsm_signal_focus_hitbox.zip`

SHA-256:

`fff5b2daf522065dfc61250ed863c10360e3d4da24fd11a90b0cf1eec5cd116a`

Single complete final-path file:

- `sites/owasys-front/www/asset/css/fsm-native.css`

CSS SHA-256:

`3c373c863b9be86612d58a0d08f076131c528d8848d310ec867239cfa498af54`

## Owner validation

Extract the ZIP over `H:\OPUS`, inspect Git status/diff, restart owasys-front if needed, and hard-refresh the browser if the previous CSS asset is cached.

Acceptance:

1. graph is visually identical to accepted A4Z except signal affordance;
2. permitted/current-state transition labels are cyan and clickable;
3. the complete label box responds to the mouse;
4. hover visibly highlights the box cyan;
5. Tab focus reaches permitted SVG links and visibly highlights them;
6. passive labels remain non-interactive;
7. activation follows the canonical transition URL and FSM semantics.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.