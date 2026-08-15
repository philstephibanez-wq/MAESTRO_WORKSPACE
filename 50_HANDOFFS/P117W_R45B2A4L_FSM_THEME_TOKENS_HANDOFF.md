# P117W R45B2A4L — Handoff

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
Base OPUS: `155357f3f34fb35cd3a732b4ef57737251d8c0e7`

## Context

A4K is visually accepted by the owner for FSM structure/interaction. A4L changes colors only and must not alter FSM semantics or layout.

## Delivery

Artifact: `opus_p117w_r45b2a4l_fsm_theme_tokens.zip`
SHA-256: `5a8a562dd4f5d71324ce778a525e8d48f748c6403cfa36f8e71ef6fa07850169`

Entry:

- `tools/apply_p117w_r45b2a4l_fsm_theme_tokens.php`

## Owner commands

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4l_fsm_theme_tokens.zip"
php tools\apply_p117w_r45b2a4l_fsm_theme_tokens.php
```

Expected markers:

```text
OPUS_P117W_R45B2A4L_APPLY_OK
FSM_COLOR_MODEL=SEMANTIC_THEME_TOKENS
FSM_CURRENT_STATE=OW_OK
FSM_ACTION_SIGNAL=OW_ACCENT
FSM_PASSIVE_STATE=OW_PANEL_MUTED
FSM_NMI=OW_DANGER
FSM_FOCUS=OW_WARN
CSS_CACHE_KEY=p117w-r45b2a4l
GIT_REQUIRED_DIFFS=3/3
```

Then:

```cmd
composer dump-autoload -o
php -l Opus\Fsm\Diagram.class.php
php -l sites\owasys-front\application\default\services\ScorePageRenderer.php
composer opus:dev-server -- owasys-front
```

## Visible acceptance

- current state remains structurally identical but uses OWASYS `--ow-ok` semantics;
- actionable signals use `--ow-accent`;
- passive states and normal edges use panel/muted theme roles;
- focus/self-loop uses `--ow-warn`;
- NMI uses `--ow-danger`;
- no purple hard-coded return-edge palette in OWASYS mapping;
- signal controls, state boxes, translations, FSM transition set and geometry remain unchanged from A4K.

After owner validation:

```cmd
del tools\apply_p117w_r45b2a4l_fsm_theme_tokens.php
git status --short
```

Assistant does not commit or push OPUS/OWASYS. Owner validates then commits/pushes.
