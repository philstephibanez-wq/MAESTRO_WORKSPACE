# P117W R45B2A4V — Handoff

State: OWNER VALIDATION REQUIRED

## Why A4V exists

A4U did not modify OPUS. It failed before writes with:

`OPUS_P117W_R45B2A4U_FSM_BASE_MISMATCH:7ee711751848123c3038eb720412ace391848daa`

The required A4T HEAD and tracked-worktree cleanliness gates had already passed. The failing A4U gate compared normalized Git blob identity with raw checkout bytes and is superseded.

## Required baseline

OPUS HEAD must be exactly:

`0313e5892abcf9788c5b2e083b98cdb224a1e453`

A4V validates:

- clean tracked worktree;
- generic renderer text identical to HEAD after EOL normalization;
- OWASYS FSM configuration semantically identical to HEAD through `StructuredFileLoader` and recursive canonicalization.

Any real semantic divergence still stops the delivery before writes.

## Artifact

`opus_p117w_r45b2a4v_fsm_fanout_change_app.zip`

SHA-256:

`03770fff665477276808b6542b55db9107c654208ee1c42683a4c63927fc7895`

Contained tool:

`tools/apply_p117w_r45b2a4v_fsm_fanout_change_app.php`

Tool SHA-256:

`af7cd7888b4cf879cbdc46f1133fff8e5ffec42287dbbd7b064790a9da3d00ef`

Tool pre-delivery validation:

- PHP lint: success;
- heredoc/nowdoc markers: 0.

## Tracked outputs after successful apply

Only:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/config/fsm.json`

### Renderer

- compact bounded fan-out grid;
- source/target transition lanes;
- retained per-pair transition separation;
- readable/clickable signal-label hitboxes;
- native SVG only;
- no direct state command;
- attestation `lane-aware-fanout-v1`.

### FSM

All ten `change_app` transitions execute canonical existing action `clear_current_app`. The state target remains `registry`.

## Required owner sequence

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4v_fsm_fanout_change_app.zip"
php tools\apply_p117w_r45b2a4v_fsm_fanout_change_app.php
composer dump-autoload -o
php -l Opus\Fsm\Diagram.class.php
composer opus:dev-server -- owasys-front
```

Successful apply must include:

- `OPUS_P117W_R45B2A4V_APPLY_OK`
- `BASELINE_DIAGRAM=HEAD_TEXT_NORMALIZED_MATCH`
- `BASELINE_FSM=HEAD_SEMANTIC_MATCH`
- `DIAGRAM_LAYOUT=COMPACT_FANOUT_GRID`
- `DIAGRAM_EDGE_ROUTING=SOURCE_AND_TARGET_LANES`
- `DIAGRAM_SIGNAL_LABELS=BOUNDED_HITBOXES`
- `CHANGE_APP_ACTION=clear_current_app`
- `CHANGE_APP_TRANSITIONS=10/10`
- `TRACKED_DIFFS=2/2`
- `A4V_SMOKE_OK:...`

## Runtime acceptance

On Applications with `essai2` or another current application selected:

1. open the Applications state submenu;
2. click `change_app`;
3. current application context must become empty while FSM state remains registry/Applications;
4. menu and diagram continue to be two projections of the same FSM;
5. diagram signal paths/labels must no longer form the previous concentrated overlap corridor;
6. signal labels linked by actionable transitions remain clickable;
7. A4T I18n behavior remains intact.

Delete the one-shot A4V tool before the OPUS commit. Owner alone commits/pushes OPUS/OWASYS.

The assistant updates only MAESTRO_WORKSPACE directly.