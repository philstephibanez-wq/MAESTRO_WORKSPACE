# P117W R45B2A4W — Direct FSM fan-out + functional change_app

State: OWNER VALIDATION REQUIRED

## Baseline

OPUS source basis:

`0313e5892abcf9788c5b2e083b98cdb224a1e453` — `opus_p117w_r45b2a4t_direct_fsm_menu_i18n`.

A4W supersedes invalid A4V. A4V failed before tracked writes on a text-body replacement anchor.

## Delivery contract

A4W is a direct differential ZIP. It contains no patcher and no one-shot apply tool.

Artifact:

`opus_p117w_r45b2a4w_direct_fsm_fanout_change_app.zip`

ZIP SHA-256:

`265c0d29e8d26d1520319ddeb63f7c27806cc9a20d3c638274db68dbe2adabc2`

Contained final-path files only:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/config/fsm.json`

File SHA-256:

- `Opus/Fsm/Diagram.class.php`: `fb643144999d5b791b27108db8ff4620b217f763d7ed3f35b9014c556c73b3d2`
- `sites/owasys-front/config/fsm.json`: `5537f19d34ab0488e5a5010dc6a522ec846f76de44b923851aa8ecb2cf3707c3`

## Generic OPUS renderer correction

`Opus/Fsm/Diagram.class.php`:

- compact high-outdegree fan-out grid around the current/layout-root state;
- maximum three destination rows per column;
- current/root state remains visual rank 0;
- distinct source and target ports for outgoing non-self transitions;
- separated signal label lanes;
- bounded SVG label backgrounds/hitboxes;
- actionable signal links wrap the hitbox and text;
- one visual edge per canonical transition;
- fallback ranked renderer retained for non-fan-out graphs;
- no JavaScript, GraphViz or external process;
- no state-command navigation introduced;
- SVG attestation `data-opus-fsm-routing="lane-aware-fanout-v2"`.

## Canonical OWASYS FSM correction

`sites/owasys-front/config/fsm.json`:

- all ten `change_app` transitions execute the existing FSM action `clear_current_app`;
- all ten still target `registry`;
- effect remains inside the canonical FSM action dispatcher;
- Menu = FSM remains unchanged.

## Pre-delivery validation actually executed

- ZIP contains exactly 2/2 expected files;
- `php -l Opus/Fsm/Diagram.class.php`: success on extracted artifact;
- JSON decode of `fsm.json`: success;
- exact runtime-style proof: `CHANGE_APP=10`, with `clear_current_app` present on every `change_app` transition;
- ZIP SHA and both file SHA values recorded above.

## Command-presentation incident

A previous assistant message incorrectly put pre-delivery validation results such as `CHANGE_APP_ACTION_PROOF=10/10`, `A4W_SMOKE_OK:...` and `ZIP_CONTENTS=2/2` in a code block that the owner copied as CMD commands. Those lines are not commands and must never be executed.

This is a delivery-instruction defect, not an A4W artifact defect. README-FIRST item 8 is now strengthened globally: every CMD/PowerShell copy block contains executable commands only; prompts, expected outputs, comments and diagnostics remain outside command blocks.

## Owner validation

Extract the direct ZIP into `H:\OPUS`, lint the renderer, verify the ten `change_app` transitions, run `git diff --check`, rebuild optimized autoload, restart owasys-front and validate runtime behavior.

Acceptance:

1. `/fr-FR/applications` renders normally;
2. with a current app selected, clicking signal `change_app` clears current application and remains in registry/Applications;
3. menu remains FSM state + signal submenu driven;
4. diagram direct outgoing signals use visibly separated lanes and do not overlap in one corridor;
5. clickable signal labels remain actionable;
6. A4T cross-module I18n remains intact.

The assistant does not commit or push OPUS/OWASYS. Owner alone validates, commits and pushes.