# P117W R45B2A4W — Structural FSM fan-out + functional change_app

State: OWNER VALIDATION REQUIRED

## Baseline

Required OPUS HEAD:

`0313e5892abcf9788c5b2e083b98cdb224a1e453` — A4T owner-validated baseline.

A4W supersedes invalid A4V. A4V failed before writes because an exact serialized body-text anchor for `transitionSvg()` did not match the actual A4T PHP source.

## Delivery-engine correction

A4W contains no renderer body-text anchors.

The runner:

1. requires exact A4T HEAD and clean tracked worktree;
2. compares `Opus/Fsm/Diagram.class.php` to `git show HEAD:<path>` after EOL normalization;
3. compares `sites/owasys-front/config/fsm.json` semantically to HEAD via `File` + `StructuredFileLoader` and recursive canonicalization;
4. locates `renderSvg`, `layout`, `renderTransition` and `transitionSvg` using PHP `token_get_all()`;
5. replaces each method by method identity and balanced tokenized braces;
6. uses zero exact serialized method-body anchors.

## Generic OPUS renderer correction

`Opus/Fsm/Diagram.class.php`:

- compact fan-out grid when the current/layout-root projection contains the root plus at least four direct destination states;
- maximum three destination rows per column;
- current/root state remains visual rank 0;
- each non-self outgoing transition obtains a source lane and target lane;
- signal label lanes are separated vertically in high-outdegree compact projections;
- self-loops retain distinct loop geometry;
- signal labels receive bounded SVG background/hitboxes;
- actionable signal links wrap the hitbox and text;
- one SVG edge per canonical transition;
- fallback ranked renderer remains for non-fan-out graphs;
- no JavaScript, GraphViz or external process;
- no state-command links introduced;
- SVG attestation: `data-opus-fsm-routing="lane-aware-fanout-v2"`.

## Canonical OWASYS FSM correction

`sites/owasys-front/config/fsm.json`:

- all ten canonical `change_app` transitions gain existing action `clear_current_app`;
- target state remains `registry`;
- the effect stays inside the existing FSM action dispatcher;
- Menu = FSM contract remains unchanged.

## Pre-write validation

Before tracked writes A4W performs:

- candidate `Diagram.class.php` PHP lint;
- synthetic 9-target + 2-self-loop native SVG smoke test;
- exact routing marker check;
- 9/9 actionable signal-link check;
- bounded diagram geometry check;
- exact assertion that all nine direct signal labels have nine distinct Y lanes;
- exact count of ten `change_app` transitions and ten `clear_current_app` actions.

After writes it validates runtime FSM parsing through `StructuredFileLoader` and `git diff --check`. Failures roll back tracked sources.

## Artifact

`opus_p117w_r45b2a4w_fsm_fanout_change_app.zip`

ZIP SHA-256:

`dacca7fee45b4fd2247a507de6222f4c5153962aa0db2851762cbf18fcb193da`

Contained runner:

`tools/apply_p117w_r45b2a4w_fsm_fanout_change_app.php`

Runner SHA-256:

`af82f064e2716d0c09bcb9c0396a64a43185a03e80f8adb10faba9595f984bbb`

Pre-delivery validation:

- runner PHP lint: success;
- all replacement-method PHP syntax lint: success;
- heredoc/nowdoc markers: 0.

## Owner validation

1. Extract A4W into `H:\OPUS`.
2. Run the A4W apply tool.
3. Success must include `PATCH_ENGINE=PHP_TOKEN_METHOD_REPLACEMENT`, `TEXT_BODY_ANCHORS=0`, `CHANGE_APP_TRANSITIONS=10/10`, `TRACKED_DIFFS=2/2` and `A4W_SMOKE_OK:...:signal_lanes=9/9:links=9/9`.
4. Run Composer optimized autoload and lint `Opus\Fsm\Diagram.class.php`.
5. Restart owasys-front.
6. On Applications with a current app selected, `change_app` must clear the current application while remaining in registry/Applications.
7. Diagram outgoing signal labels must use separated lanes and remain clickable.
8. Validate Menu = FSM and A4T cross-module I18n remain intact.
9. Delete the one-shot A4W tool before owner commit/push.

The assistant does not commit or push OPUS/OWASYS.