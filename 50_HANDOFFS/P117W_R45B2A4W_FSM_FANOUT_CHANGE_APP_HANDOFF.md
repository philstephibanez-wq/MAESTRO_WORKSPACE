# P117W R45B2A4W — Handoff

State: OWNER VALIDATION REQUIRED

## Previous delivery status

A4V is invalid and superseded. It failed before any tracked OPUS write on:

`OPUS_P117W_R45B2A4V_ANCHOR_INVALID:transition-label-box:0`

The failure was caused by exact body-text anchoring, not by OPUS runtime state.

## Required baseline

OPUS HEAD must remain exactly:

`0313e5892abcf9788c5b2e083b98cdb224a1e453`

Tracked worktree must be clean. Untracked one-shot tools do not block the gate.

## A4W artifact

`opus_p117w_r45b2a4w_fsm_fanout_change_app.zip`

SHA-256:

`dacca7fee45b4fd2247a507de6222f4c5153962aa0db2851762cbf18fcb193da`

Contained tool:

`tools/apply_p117w_r45b2a4w_fsm_fanout_change_app.php`

Tool SHA-256:

`af82f064e2716d0c09bcb9c0396a64a43185a03e80f8adb10faba9595f984bbb`

## What changed in delivery mechanics

A4W does not search for serialized method bodies. It tokenizes the exact local HEAD source with PHP `token_get_all()`, finds four private/public methods by method name and balanced braces, then replaces complete method implementations structurally:

- `renderSvg`
- `layout`
- `renderTransition`
- `transitionSvg`

Therefore representation escaping and whitespace inside old method bodies cannot produce another A4V-style anchor failure.

## Functional outputs

Only two tracked files change:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/config/fsm.json`

Renderer:

- bounded compact fan-out grid;
- max three target rows per column;
- source/target edge lanes;
- distinct high-outdegree signal label lanes;
- bounded clickable signal hitboxes;
- native SVG only;
- attestation `lane-aware-fanout-v2`.

FSM:

- 10/10 `change_app` transitions execute existing `clear_current_app` action;
- next state remains registry;
- no side-effect outside FSM.

## Required owner sequence

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4w_fsm_fanout_change_app.zip"
php tools\apply_p117w_r45b2a4w_fsm_fanout_change_app.php
composer dump-autoload -o
php -l Opus\Fsm\Diagram.class.php
composer opus:dev-server -- owasys-front
```

Successful apply must contain:

- `OPUS_P117W_R45B2A4W_APPLY_OK`
- `BASELINE_DIAGRAM=HEAD_TEXT_NORMALIZED_MATCH`
- `BASELINE_FSM=HEAD_SEMANTIC_MATCH`
- `PATCH_ENGINE=PHP_TOKEN_METHOD_REPLACEMENT`
- `TEXT_BODY_ANCHORS=0`
- `DIAGRAM_LAYOUT=COMPACT_FANOUT_GRID`
- `DIAGRAM_EDGE_ROUTING=LANE_AWARE_FANOUT_V2`
- `CHANGE_APP_TRANSITIONS=10/10`
- `TRACKED_DIFFS=2/2`
- `A4W_SMOKE_OK:...:signal_lanes=9/9:links=9/9`

## Runtime acceptance

On `/fr-FR/applications` with a selected application:

1. open Applications state submenu;
2. click `change_app`;
3. current application context clears through the FSM dispatcher;
4. state remains registry/Applications;
5. diagram target states are wrapped into a bounded grid;
6. outgoing signal labels are visibly separated, not concentrated in one corridor;
7. actionable diagram signal hitboxes remain clickable;
8. Menu = FSM and A4T I18n remain unchanged.

Delete the A4W one-shot tool before owner commit. Owner alone commits/pushes OPUS/OWASYS.