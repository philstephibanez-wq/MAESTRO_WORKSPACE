# P117W R45B2A4W — direct delivery handoff

State: OWNER VALIDATION REQUIRED

## Proven baseline

OPUS baseline is:

`0313e5892abcf9788c5b2e083b98cdb224a1e453` — `opus_p117w_r45b2a4t_direct_fsm_menu_i18n`

A4U and A4V failed before tracked writes. No A4U/A4V tracked OPUS change is part of the baseline.

The owner has already validated the retained functional model from A4T:

- Menu = FSM;
- one FSM state = one menu state/context;
- outgoing signals = submenu commands;
- states do not directly trigger transitions;
- diagram = another functional projection of the same FSM;
- cross-module menu/FSM I18n works.

## A4W delivery model

A4W intentionally contains no apply tool.

Artifact:

`opus_p117w_r45b2a4w_direct_fsm_fanout_change_app.zip`

SHA-256:

`265c0d29e8d26d1520319ddeb63f7c27806cc9a20d3c638274db68dbe2adabc2`

Exact ZIP members:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/config/fsm.json`

Extraction replaces only these two complete final files. This removes the prior anchor/token mutation failure class from the owner workflow.

Final file hashes:

- Diagram: `fb643144999d5b791b27108db8ff4620b217f763d7ed3f35b9014c556c73b3d2`
- FSM: `5537f19d34ab0488e5a5010dc6a522ec846f76de44b923851aa8ecb2cf3707c3`

## Functional changes

### Diagram

Generic `OPUS_FSM_Diagram` uses compact fan-out routing for current-state projections with four or more direct targets:

- bounded target grid, max three rows per target column;
- source and target lanes;
- distinct signal label lanes;
- bounded label backgrounds/hitboxes;
- linked labels remain transition/signal commands;
- SVG marker `lane-aware-fanout-v2`;
- fallback ranked renderer retained elsewhere.

### change_app

All ten canonical `change_app` transitions add existing action `clear_current_app` while retaining `next_state = registry`.

Thus Applications -> `change_app` clears the application context through the FSM dispatcher without turning the state itself into a command.

## Pre-delivery validation

- final Diagram PHP lint: OK;
- JSON parse: OK;
- change_app action proof: 10/10;
- no other FSM semantic change;
- synthetic diagram smoke: `A4W_SMOKE_OK:1340x500:signal_lanes=9/9:links=9/9`;
- ZIP member list: exactly 2/2 final files.

## Required owner sequence

```cmd
cd /d H:\OPUS
git rev-parse HEAD
git status --short
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4w_direct_fsm_fanout_change_app.zip"
git status --short
php -l Opus\Fsm\Diagram.class.php
php -r "$f=json_decode(file_get_contents('sites/owasys-front/config/fsm.json'),true,512,JSON_THROW_ON_ERROR);$n=0;foreach($f['transitions'] as $t){if(($t['signal']??'')==='change_app'){++$n;if(!in_array('clear_current_app',$t['actions']??[],true)){throw new RuntimeException($t['id']);}}}echo 'CHANGE_APP='.$n.PHP_EOL;"
composer dump-autoload -o
composer opus:dev-server -- owasys-front
```

Before extraction, HEAD must be A4T and tracked worktree must be clean. After extraction, expected tracked diffs are Diagram + FSM only.

## Runtime acceptance

- Applications submenu remains a submenu of the Applications FSM state;
- clicking `change_app` with an application selected clears current application context and remains in registry/Applications;
- diagram signals are spatially separated instead of grouped in one narrow corridor;
- targets wrap into multiple rows/columns when appropriate;
- signal hitboxes remain clickable;
- Menu = FSM remains the single navigation model;
- A4T I18n remains intact.

Owner alone commits/pushes OPUS after validation. Assistant updates MAESTRO_WORKSPACE only.