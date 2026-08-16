# P117W R45B2A4AE — Handoff

State: OWNER VALIDATION REQUIRED

## Purpose

Reduce the remaining visual entanglement of the fixed OWASYS FSM after A4AD without changing canonical FSM semantics.

Owner feedback after A4AD: Account/Password is better, but the diagram remains too tangled and `cancel_creation` appears unconnected.

## Required baseline

A4AE applies after A4AD.

Do not remove A4AD files from the working tree. A4AE changes only the generic FSM renderer, the OWASYS fixed-diagram projection, the FSM CSS and its cache revision.

## Artifact

`opus_p117w_r45b2a4ae_fsm_traceable_routing.zip`

SHA-256:

`9a06348fe770a9d27d2cc5098f7cc2f834bcf46d781ebe02347f1518724d0ad0`

Files:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/www/asset/css/fsm-native.css`

## Contract after extraction

- fixed graph remains rooted at `login`;
- current state remains highlight-only;
- Account and Password remain separate A4AD states;
- Menu = FSM remains authoritative;
- current-state action URLs still come only from NavigationBuilder/A4AB semantics;
- one displayed canonical `data --change_app--> registry` edge represents the universal `change_app + registry` semantic action;
- `change_app` remains executable from any current state where that semantic action is permitted;
- opposite A↔B transitions use separate visual corridors;
- long returns are routed outside the principal workflow corridor;
- moved labels receive a visible leader to their edge anchor;
- cyan still means currently actionable;
- no JavaScript and no GraphViz are introduced.

## Validation already executed

- PHP lint: `Diagram.class.php` OK;
- PHP lint: `FsmDiagramBuilder.php` OK;
- PHP lint: `ScorePageRenderer.php` OK;
- framework interface implementation preserved;
- 11-state synthetic A4AD projection rendered successfully;
- 26 projected transition labels;
- 0 label/label overlap;
- 0 label/state overlap;
- 3 moved labels receive explicit leaders;
- 1 outer forward branch;
- 2 outer return branches;
- approximate sampled edge crossings reduced from 42 to 7 versus the previous projection;
- exactly one fixed `change_app -> registry` representative.

## Owner validation sequence

1. Extract A4AE at `H:\OPUS` over the existing A4AD working tree.
2. Verify the expected four A4AE files are modified in addition to the already-uncommitted A4AD files.
3. Lint Diagram, FsmDiagramBuilder and ScorePageRenderer.
4. Run `git --no-pager diff --check`.
5. Rebuild Composer autoload.
6. Restart `owasys-front`.
7. Open `/fr-FR/applications` and inspect the entire fixed FSM.
8. Confirm Account / Password remains semantically separated.
9. Confirm `cancel_creation` has an unmistakable visual path back to Applications.
10. Confirm `create_new_app` and `cancel_creation` are individually traceable.
11. Confirm there is only one displayed `change_app` representative.
12. From Applications, Account, Creation, Data, Structure, Security, Workflows, Sources/Git and Build, verify `change_app` still works wherever permitted by the canonical FSM.
13. Verify `logout` still works wherever permitted.
14. Verify cyan labels/paths remain restricted to currently actionable transitions and remain keyboard-focusable.
15. Verify no label covers a state box and no two labels overlap.
16. Verify menu autocollapse is unchanged.

Do not mark A4AE complete before owner browser validation.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.
