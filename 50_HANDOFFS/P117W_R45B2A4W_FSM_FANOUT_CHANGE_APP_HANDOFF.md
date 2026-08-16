# P117W R45B2A4W — Handoff

State: OWNER VALIDATION REQUIRED

## Baseline

OPUS basis: `0313e5892abcf9788c5b2e083b98cdb224a1e453` (`opus_p117w_r45b2a4t_direct_fsm_menu_i18n`).

A4V remains invalid/superseded; it failed before tracked writes.

## A4W direct artifact

`opus_p117w_r45b2a4w_direct_fsm_fanout_change_app.zip`

SHA-256:

`265c0d29e8d26d1520319ddeb63f7c27806cc9a20d3c638274db68dbe2adabc2`

The ZIP contains exactly two complete tracked files at final paths:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/config/fsm.json`

There is no A4W patcher or apply script.

## Functional content

Renderer:

- compact fan-out grid for high-outdegree current states;
- maximum three target rows per visual column;
- lane-aware source/target ports;
- separated signal labels;
- bounded clickable signal hitboxes;
- native SVG only;
- `lane-aware-fanout-v2` attestation.

FSM:

- 10/10 `change_app` transitions use existing action `clear_current_app`;
- next state remains `registry`;
- no side effect outside FSM;
- Menu = FSM unchanged.

## Verified artifact facts

- extracted renderer PHP lint: success;
- extracted FSM JSON decode: success;
- `change_app` action proof: 10/10;
- ZIP contents: 2/2.

These are validation RESULTS, not terminal commands.

## Mandatory CMD presentation rule

README-FIRST now explicitly states that any CMD/PowerShell block intended for copy/paste contains executable commands only. Never put prompt text, expected output, validation result, comments or diagnostics inside a command block.

The owner previously copied non-command validation-result lines from an assistant block and CMD attempted to execute them. That incident does not invalidate the A4W ZIP; it invalidates the previous command presentation.

## Owner sequence

Use only executable commands to extract A4W, inspect Git status, lint `Diagram.class.php`, validate the ten `change_app` transitions, run `git diff --check`, rebuild autoload and restart owasys-front.

Runtime acceptance on `/fr-FR/applications`:

1. page renders normally;
2. `change_app` clears selected application while state remains Applications/registry;
3. outgoing signal labels are visibly separated;
4. signal hitboxes remain clickable;
5. Menu = FSM remains state entry + corresponding signal submenu;
6. A4T cross-module I18n remains valid.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.