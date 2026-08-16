# P117W R45B2A4V — FSM fan-out readability + functional change_app, corrected baseline gate

State: OWNER VALIDATION REQUIRED

## Baseline

Required OPUS HEAD:

`0313e5892abcf9788c5b2e083b98cdb224a1e453` — `opus_p117w_r45b2a4t_direct_fsm_menu_i18n`

A4V supersedes only the defective A4U delivery gate. The intended functional changes are unchanged.

## Root causes retained from A4U

### Diagram readability

The compact generic `OPUS_FSM_Diagram` ranks all direct destinations of the current/layout-root state into a narrow projection. Edge dispersion is primarily per exact `(from,to)` pair, so many distinct signals can share one source/label corridor.

### `change_app`

`/applications` resolves to canonical signal `change_app`. The `registry -> registry` transition is valid but had no action, so while already on Applications the signal had no observable stateful effect. The existing FSM action `clear_current_app` is the required effect and remains inside the FSM dispatcher.

## A4U delivery defect fixed by A4V

A4U accepted exact HEAD and a clean tracked worktree, then incorrectly rejected `fsm.json` by comparing a Git blob SHA against a SHA recomputed from raw working-tree bytes.

A4V removes that invalid raw-byte equivalence test.

Fail-closed baseline attestation is now:

1. exact required HEAD SHA;
2. Git tracked-worktree cleanliness;
3. `Opus/Fsm/Diagram.class.php` must equal `git show HEAD:<path>` after CRLF/CR normalization to LF;
4. `sites/owasys-front/config/fsm.json` must equal `git show HEAD:<path>` semantically:
   - both are read through `File` / `StructuredFileLoader`;
   - associative keys are recursively canonicalized;
   - list order is preserved;
   - canonical structured SHA-256 values must match.

Thus representation differences cannot falsely block a clean checkout, while any real semantic divergence still fails closed.

## Functional correction

### Generic OPUS renderer

`Opus/Fsm/Diagram.class.php`

- compact fan-out grid for current/layout-root projections with at least four direct destinations;
- root/current state remains at visual rank 0;
- direct destinations are wrapped with a maximum of three rows per target column;
- outgoing edges use distinct source and target lanes;
- same-pair transitions retain independent spread;
- each signal label gains a bounded SVG background/hitbox;
- clickable signal links remain transition links, never state links;
- one visual edge per canonical transition;
- no JavaScript, GraphViz or external process;
- SVG attestation: `data-opus-fsm-routing="lane-aware-fanout-v1"`.

### Canonical OWASYS FSM

`sites/owasys-front/config/fsm.json`

All ten canonical `change_app` transitions gain existing action:

`clear_current_app`

The next state remains `registry`. Menu = FSM remains unchanged.

## Artifact

`opus_p117w_r45b2a4v_fsm_fanout_change_app.zip`

ZIP SHA-256:

`03770fff665477276808b6542b55db9107c654208ee1c42683a4c63927fc7895`

Contained runner:

`tools/apply_p117w_r45b2a4v_fsm_fanout_change_app.php`

Runner SHA-256:

`af7cd7888b4cf879cbdc46f1133fff8e5ffec42287dbbd7b064790a9da3d00ef`

The runner was successfully linted before packaging and contains zero heredoc/nowdoc markers.

## Pre-write gates

A4V performs before any tracked write:

- baseline attestation described above;
- exact-anchor replacement checks for all generic renderer changes;
- candidate `Diagram.class.php` PHP lint;
- synthetic native SVG smoke test with nine direct targets plus two self-loops;
- smoke assertion for routing marker, signal-link count, label hitboxes and bounded geometry;
- exact count of ten `change_app` transitions;
- proof that all ten patched transitions contain `clear_current_app`.

Writes are atomic and rolled back on subsequent failure.

## Owner validation

1. Extract A4V into `H:\OPUS`.
2. Run the A4V apply tool.
3. Required success attestations include:
   - `BASELINE_DIAGRAM=HEAD_TEXT_NORMALIZED_MATCH`
   - `BASELINE_FSM=HEAD_SEMANTIC_MATCH`
   - `DIAGRAM_LAYOUT=COMPACT_FANOUT_GRID`
   - `DIAGRAM_EDGE_ROUTING=SOURCE_AND_TARGET_LANES`
   - `CHANGE_APP_TRANSITIONS=10/10`
   - `TRACKED_DIFFS=2/2`
   - `A4V_SMOKE_OK:...`
4. `composer dump-autoload -o`.
5. Lint `Opus\Fsm\Diagram.class.php`.
6. Restart `owasys-front`.
7. On `/fr-FR/applications` with a selected application, click `change_app` from the Applications state's submenu:
   - the current application context must clear;
   - the FSM state remains Applications/registry;
   - the operation occurs through the FSM action dispatcher.
8. Validate diagram readability on Applications and at least one other high-fan-out state.
9. Validate A4T cross-module I18n remains intact.
10. Delete the one-shot A4V tool before owner commit/push.

The assistant does not commit or push OPUS/OWASYS.