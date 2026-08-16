# P117W R45B2A4U — FSM fan-out readability + functional change_app

State: OWNER VALIDATION REQUIRED

## Baseline

OPUS owner baseline:

`0313e5892abcf9788c5b2e083b98cdb224a1e453` — `opus_p117w_r45b2a4t_direct_fsm_menu_i18n`

A4T is owner-validated and establishes the retained contract:

- Menu = FSM;
- one state = one menu state/context;
- outgoing signals = submenu commands for the source state;
- state entries do not directly perform transitions;
- diagram = another functional projection of the same FSM;
- cross-module FSM/menu I18n is state-module/target-module owned.

## Owner-observed defects

### 1. Diagram signals are too grouped

The generic `OPUS_FSM_Diagram` compact renderer currently assigns all direct destinations discovered from the layout root to a single BFS rank/column. On the Applications/registry state, many outgoing transitions therefore terminate in a tall single target column.

Edge spreading is also calculated only per exact `(from,to)` pair. Distinct outgoing destinations still leave the same source port and their labels occupy the same narrow corridor.

This is a generic OPUS renderer defect, not an OWASYS-only styling defect.

### 2. `change_app` has no observable effect on Applications

`routes.json` maps `/applications` to the FSM signal `change_app`.

The canonical transition `t_change_app__from__registry` is `registry -> registry` and currently has no actions. Therefore the signal is rendered as actionable, but when already on Applications it reloads the same resource/state while preserving the current application context. The owner correctly observes this as a non-functional command.

The existing canonical action `clear_current_app` already performs the required stateful effect through the FSM action dispatcher. No side-effect outside FSM is permitted.

## Required correction

### Generic OPUS `Opus/Fsm/Diagram.class.php`

- add a compact fan-out layout when a supplied layout root has at least four direct destinations and the projected graph consists of that root plus those destinations;
- keep the current/root state at visual rank 0;
- wrap destinations into a bounded grid (maximum three rows per target column);
- route distinct outgoing transitions through source and target lanes rather than one common center port;
- retain distinct per-pair spread for multiple signals sharing the same source/target pair;
- give each signal label a bounded background/hitbox so the signal remains readable and clickable over edge geometry;
- retain one SVG edge per canonical transition;
- no JavaScript, GraphViz or external process;
- no state-command links introduced;
- expose SVG attestation `data-opus-fsm-routing="lane-aware-fanout-v1"`.

The fallback ranked renderer remains unchanged for graphs that do not satisfy the fan-out projection conditions.

### Canonical OWASYS FSM `sites/owasys-front/config/fsm.json`

For every one of the ten canonical `change_app` transitions, add the existing action:

`clear_current_app`

This makes `change_app` semantically observable while keeping all effects inside the FSM dispatcher. The signal still targets `registry`; only its missing action contract is corrected.

## Artifact

`opus_p117w_r45b2a4u_fsm_fanout_change_app.zip`

ZIP SHA-256:

`008e85898eb3d2e5df3497205ff1bc137ce2256c750cd0a8773ecfc0cfe0fa93`

Contained runner SHA-256:

`26b068626cdd0204a5d4299624ec8ae76332684e5c7efbab427467955bce7e8c`

The differential ZIP contains only:

`tools/apply_p117w_r45b2a4u_fsm_fanout_change_app.php`

The runner contains no heredoc/nowdoc syntax, is linted before delivery, verifies exact A4T HEAD/blob bases, lints the candidate generic renderer before any tracked write, executes a synthetic 9-target fan-out SVG smoke test, validates all ten `change_app` actions, writes atomically and rolls back on failure.

## Owner validation

1. Extract the ZIP into `H:\OPUS`.
2. Run the A4U apply script.
3. Success must report `TRACKED_DIFFS=2/2`, `CHANGE_APP_TRANSITIONS=10/10` and `A4U_SMOKE_OK`.
4. Run `composer dump-autoload -o`.
5. Lint `Opus\Fsm\Diagram.class.php`.
6. Restart `owasys-front`.
7. On `/fr-FR/applications`, open Applications submenu and click `change_app` while an application is selected: current application context must be cleared and the registry state must remain active.
8. Validate the diagram: direct target states must be wrapped into a compact fan-out grid; outgoing signal labels must no longer overlap/group in one narrow corridor; labels remain clickable when their menu projection is actionable.
9. Validate at least one additional state with several outgoing signals.
10. Validate Menu=FSM and A4T I18n behavior remain unchanged.
11. Owner commits/pushes OPUS only after validation and deletes the one-shot tool before commit.

The assistant does not commit or push OPUS/OWASYS.