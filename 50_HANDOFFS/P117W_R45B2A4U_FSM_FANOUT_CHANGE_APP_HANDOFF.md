# P117W R45B2A4U — Handoff

State: OWNER VALIDATION REQUIRED

## Proven baseline

A4T is owner-validated and committed in OPUS as:

`0313e5892abcf9788c5b2e083b98cdb224a1e453`

The owner confirms that the current result is globally the intended model: Menu = FSM is visible and usable, cross-module French labels render, and the native diagram is functional.

## Remaining owner observations

1. Diagram readability: outgoing signal labels remain too grouped/overlapping.
2. Applications submenu: `change_app` has no observable effect while already in registry/Applications.

## Root causes

### Diagram

`OPUS_FSM_Diagram` compact layout currently keeps all direct destinations in one BFS target column. Transition lane spread is calculated only for transitions sharing the exact same `(from,to)` pair. Many distinct outgoing signals therefore share one narrow source/label corridor.

### change_app

`/applications` resolves to `change_app`, and the menu correctly renders it as actionable. But `t_change_app__from__registry` is a `registry -> registry` self-transition without an action, so the same page/context is rendered again. The existing FSM action `clear_current_app` is the missing semantic effect.

## A4U delivery

Artifact:

`opus_p117w_r45b2a4u_fsm_fanout_change_app.zip`

SHA-256:

`008e85898eb3d2e5df3497205ff1bc137ce2256c750cd0a8773ecfc0cfe0fa93`

Contained tool:

`tools/apply_p117w_r45b2a4u_fsm_fanout_change_app.php`

Tool SHA-256:

`26b068626cdd0204a5d4299624ec8ae76332684e5c7efbab427467955bce7e8c`

The runner intentionally contains no heredoc/nowdoc syntax. It was successfully linted before packaging and rejects any base other than exact A4T HEAD/source blobs.

## Tracked changes produced by the runner

- `Opus/Fsm/Diagram.class.php`
  - generic compact fan-out grid;
  - source/target edge lanes;
  - larger label spacing between multiple same-pair signals;
  - bounded SVG signal-label hitboxes;
  - routing attestation `lane-aware-fanout-v1`.

- `sites/owasys-front/config/fsm.json`
  - all ten `change_app` transitions gain canonical action `clear_current_app`.

No menu registry is added. No direct state command is introduced. No business side-effect is injected outside the FSM dispatcher.

## Required owner sequence

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4u_fsm_fanout_change_app.zip"
php tools\apply_p117w_r45b2a4u_fsm_fanout_change_app.php
composer dump-autoload -o
php -l Opus\Fsm\Diagram.class.php
composer opus:dev-server -- owasys-front
```

Expected apply gates include:

- `OPUS_P117W_R45B2A4U_APPLY_OK`
- `DIAGRAM_LAYOUT=COMPACT_FANOUT_GRID`
- `DIAGRAM_EDGE_ROUTING=SOURCE_AND_TARGET_LANES`
- `CHANGE_APP_ACTION=clear_current_app`
- `CHANGE_APP_TRANSITIONS=10/10`
- `TRACKED_DIFFS=2/2`
- `A4U_SMOKE_OK:...`

## Runtime acceptance

On `/fr-FR/applications` with a selected application:

- Applications remains the current FSM state;
- opening its submenu shows outgoing signals;
- clicking `change_app` clears the current application context through the FSM action dispatcher;
- no direct state navigation is used;
- diagram target states are wrapped instead of one very tall target column;
- signal labels no longer overlap in one narrow corridor;
- clickable diagram signals retain a visible hitbox;
- I18n behavior from A4T remains intact.

Delete the one-shot A4U tool before the OPUS commit. Owner commits/pushes OPUS only after validation.

The assistant does not commit or push OPUS/OWASYS.