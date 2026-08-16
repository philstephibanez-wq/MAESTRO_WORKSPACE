# P117W R45B2A4Z — Handoff

State: OWNER VALIDATION REQUIRED

## Baseline

OPUS HEAD must remain:

`fcffa3c16c75126208a480382f9efb36be170110` — A4W.

A4X and A4Y are rejected and must not be committed.

## What A4Z changes

A4Z keeps the A4W native OPUS SVG renderer but changes the OWASYS projection so it reads as a classic state-machine diagram rather than a ranked workflow.

The graph is fixed from canonical `initial_state = login` / Connexion. Runtime current state is passed only for node highlight.

The fixed projection includes:

- authentication branch and login/password self-loops;
- registry branch and registry failure loop;
- creation branch, creation failure loop and cancel return;
- main application fan-out from Data;
- representative self-loops on operational states;
- real long `change_app` returns to Applications/registry;
- real logout return toward Connexion/login.

All displayed edges are resolved back to exact canonical transitions in `config/fsm.json` before render. No transition is invented.

## Menu autocollapse

Native exclusive `<details name="owasys-fsm-navigation">` remains. No JavaScript and no forced active-state open.

## Artifact

`opus_p117w_r45b2a4z_classic_fixed_fsm_autocollapse.zip`

SHA-256:

`9435ce5b017751b2fce0591715bf34b6890344ad2b445cf9d413a404557149dd`

Files:

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`

No patcher. Complete final-path files only.

## Owner command sequence

Extract the direct ZIP at `H:\OPUS`, inspect Git status, lint `FsmDiagramBuilder.php`, run `git diff --check`, rebuild optimized autoload and restart `owasys-front`.

## Runtime acceptance

- Connexion/login remains the fixed beginning on every page.
- Graph positions never change with navigation.
- Current state is highlight only.
- The graph contains visible branches, loops and backward returns like a conventional FSM.
- Menu remains autocollapsed/exclusive.
- A4W generic renderer and `change_app -> clear_current_app` behavior remain baseline.

Owner alone commits/pushes OPUS/OWASYS.