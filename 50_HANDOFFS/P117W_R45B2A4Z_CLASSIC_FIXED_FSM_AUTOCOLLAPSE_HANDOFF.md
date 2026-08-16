# P117W R45B2A4Z — Handoff

State: OWNER VALIDATED — OPUS COMMITTED/PUSHED

## Accepted baseline

A4Z is now the accepted FSM/UI baseline.

Owner commit/push:

`0ce2dfa9a1c7175ac39f93b2ee017ed6e40643ac` — `opus_p117w_r45b2a4z_classic_fixed_fsm_autocollapse`.

A4X and A4Y remain rejected and must not be resurrected.

## What A4Z established

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

## Owner runtime validation — 2026-08-16

Owner explicitly validates:

- classic FSM appearance: accepted (`Enfin :)`);
- fixed logical start at Connexion/login;
- current state highlight only;
- visible branches/loops/backward returns;
- native menu autocollapse: `ok`.

Screenshot validation was performed on `/fr-FR/applications`, with Applications highlighted and no application selected.

## Continuation contract

Subsequent FSM/UI deliveries must preserve all A4Z invariants:

1. fixed topology and geometry across runtime states;
2. canonical initial state as visual beginning;
3. current state changes highlight only;
4. no linearization;
5. no current-state-centered fan-out;
6. classic readable FSM grammar with branches/returns/self-loops;
7. Menu = FSM;
8. native menu autocollapse;
9. no invented transitions;
10. A4W `change_app -> clear_current_app` remains functional.

Any future visual refinement must be incremental and must not regress the accepted A4Z topology.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.