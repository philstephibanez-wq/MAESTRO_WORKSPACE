# P117W R45B2A4W — direct FSM fan-out readability + functional change_app

State: OWNER VALIDATION REQUIRED

## Baseline

Required OPUS owner baseline:

`0313e5892abcf9788c5b2e083b98cdb224a1e453` — `opus_p117w_r45b2a4t_direct_fsm_menu_i18n`

A4U and A4V both failed before tracked writes. A4W therefore starts from the exact A4T GitHub source and replaces the failed mutation-runner delivery model with a direct complete-file differential ZIP.

## Delivery contract

The ZIP contains exactly two complete files at their final OPUS paths:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/config/fsm.json`

There is no apply script, no body-text anchor, no `str_replace`, no token replacement and no source mutation stage on the owner checkout. Extraction itself applies the differential files, as explicitly allowed by `README-FIRST.md`.

## Root cause 1 — diagram signal clustering

The A4T generic compact renderer uses BFS ranks. In the current-state projection, many direct targets therefore share one target rank/column. Transition spreading is primarily per exact `(from,to)` pair, so distinct outgoing destinations can still share the same source/label corridor.

### Generic OPUS correction

`Opus/Fsm/Diagram.class.php` now:

- exposes SVG attestation `data-opus-fsm-routing="lane-aware-fanout-v2"`;
- detects compact projections consisting of the layout-root/current state plus at least four direct target states;
- keeps the root/current state at visual rank 0;
- wraps direct targets into a bounded grid with at most three rows per target column;
- allocates source and target ordinals/totals across all visible non-self transitions;
- routes high-fanout forward transitions through distinct signal lanes;
- preserves per-pair spread for multiple transitions sharing the same source/target;
- increases self-loop separation;
- renders every signal label with a bounded SVG background/hitbox;
- wraps the whole label hitbox in the existing transition link when actionable;
- retains one visual edge per canonical transition;
- keeps the ranked fallback layout for projections not matching the compact fan-out conditions;
- introduces no JavaScript, GraphViz or external process and no state-command links.

## Root cause 2 — change_app had no observable effect in registry

`/applications` resolves to `change_app`. The canonical `registry -> registry` transition is valid, but A4T had no action on the ten `change_app` transitions, so the same state/context was rendered again while the current application remained selected.

### Canonical FSM correction

In `sites/owasys-front/config/fsm.json`, all ten canonical `change_app` transitions now include the already existing FSM action:

`clear_current_app`

The destination remains `registry`. The effect therefore remains inside the FSM action dispatcher; Menu = FSM is unchanged.

## Validation performed before packaging

- final `Diagram.class.php`: PHP lint OK;
- FSM JSON parsed successfully;
- exact proof `change_app` transitions = `10/10` with `clear_current_app`;
- semantic comparison proves no FSM change beyond those ten action additions;
- synthetic native SVG smoke test: root + 9 direct targets + 2 self-loops;
- smoke output: `A4W_SMOKE_OK:1340x500:signal_lanes=9/9:links=9/9`;
- ZIP content verified to exactly the two final files above.

## Artifact

`opus_p117w_r45b2a4w_direct_fsm_fanout_change_app.zip`

ZIP SHA-256:

`265c0d29e8d26d1520319ddeb63f7c27806cc9a20d3c638274db68dbe2adabc2`

Final file SHA-256:

- `Opus/Fsm/Diagram.class.php`: `fb643144999d5b791b27108db8ff4620b217f763d7ed3f35b9014c556c73b3d2`
- `sites/owasys-front/config/fsm.json`: `5537f19d34ab0488e5a5010dc6a522ec846f76de44b923851aa8ecb2cf3707c3`

## Owner acceptance

1. Confirm OPUS HEAD is A4T and tracked worktree is clean before extraction.
2. Extract the A4W direct ZIP into `H:\OPUS`.
3. `git status --short` must show exactly the two tracked files above modified (plus any untracked historical one-shot tools if not yet removed).
4. Lint `Opus\Fsm\Diagram.class.php`.
5. Verify all ten `change_app` transitions include `clear_current_app`.
6. Run Composer autoload and restart `owasys-front`.
7. On Applications with a current application selected, open the Applications state submenu and click `change_app`: current application context must clear while FSM state remains registry/Applications.
8. Validate diagram readability: direct target states are wrapped, outgoing signal lanes are separated, labels do not overlap in one corridor, and actionable signal hitboxes remain clickable.
9. Validate at least one additional high-fanout state.
10. Validate A4T cross-module I18n and Menu = FSM remain unchanged.
11. Owner commits/pushes OPUS only after runtime validation.

The assistant does not commit or push OPUS/OWASYS.