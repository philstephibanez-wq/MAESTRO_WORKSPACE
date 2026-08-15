# P117W R45B2A4L — FSM semantic theme tokens

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
OPUS base: `155357f3f34fb35cd3a732b4ef57737251d8c0e7` (`opus_p117w_r45b2a4k_verified_signal_fsm`)

## Owner visual acceptance of A4K

The owner validated the signal-driven FSM surface as structurally clean: current state as context, outgoing signals as controls, passive target states, compact diagram. Remaining issue is color coherence only.

## Root cause

`OPUS_FSM_Diagram::svgDefinitions()` still hardcodes renderer colors (`#6ce3ff`, `#a78bfa`, `#fbbf24`, etc.) while OWASYS already exposes theme tokens such as `--ow-panel`, `--ow-text`, `--ow-muted`, `--ow-accent`, `--ow-ok`, `--ow-warn`, and `--ow-danger`.

A local OWASYS recolor alone would violate the generic-first rule. The OPUS renderer must expose semantic FSM color roles first; applications/themes then map those roles.

## Correction

### Generic OPUS renderer

`Opus/Fsm/Diagram.class.php` uses semantic CSS variables with backward-compatible fallbacks:

- `--opus-fsm-text`
- `--opus-fsm-muted`
- `--opus-fsm-node-bg`
- `--opus-fsm-node-border`
- `--opus-fsm-current-bg`
- `--opus-fsm-current-border`
- `--opus-fsm-focus`
- `--opus-fsm-signal`
- `--opus-fsm-state-text`
- `--opus-fsm-edge`
- `--opus-fsm-return`
- `--opus-fsm-loop`
- `--opus-fsm-label`
- `--opus-fsm-label-halo`
- `--opus-fsm-marker`
- `--opus-fsm-nmi-bg`
- `--opus-fsm-nmi`

Default/fallback values preserve renderer compatibility outside OWASYS.

### OWASYS theme adapter

`sites/owasys-front/www/asset/css/fsm-native.css` maps semantic OPUS roles to existing OWASYS tokens:

- current state -> `--ow-ok`;
- actionable signal -> `--ow-accent`;
- passive state/edge -> panel/muted roles;
- focus/self-loop -> `--ow-warn`;
- NMI -> `--ow-danger`.

No FSM geometry, state relation, signal relation, I18n, ACL, SCORE structure, or navigation behavior changes in A4L.

### Cache

`ScorePageRenderer.php` changes the FSM CSS cache key to `p117w-r45b2a4l`.

## Delivery

Artifact: `opus_p117w_r45b2a4l_fsm_theme_tokens.zip`
SHA-256: `5a8a562dd4f5d71324ce778a525e8d48f748c6403cfa36f8e71ef6fa07850169`

Entry:

- `tools/apply_p117w_r45b2a4l_fsm_theme_tokens.php`

Runner requirements:

- exact A4K Git HEAD;
- exact Git blob fingerprints for the three target files;
- pre-write PHP lint;
- rollback after write failure;
- success requires all three tracked diffs.
