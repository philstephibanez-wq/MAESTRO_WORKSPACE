# P117W R45B2A4Z — Classic fixed FSM + native menu autocollapse

State: OWNER VALIDATION REQUIRED

## Baseline

Required OPUS HEAD:

`fcffa3c16c75126208a480382f9efb36be170110` — A4W.

A4X and A4Y are owner-rejected and must not be used as baselines.

## Owner visual contract

The diagram must read visually like a real finite-state machine:

- fixed geometry independent from current state;
- starts from canonical `initial_state = login` / Connexion;
- current state is highlight only;
- visible forward branches;
- visible backward returns;
- visible representative self-loops;
- signal labels stay attached to real transitions;
- no linearization;
- no current-state-centered fan-out;
- OPUS/OWASYS graphical charter retained;
- Menu = FSM remains the source of labels/actionability.

## A4Z projection

A4Z uses the existing native `OPUS_FSM_Diagram` renderer and supplies a fixed classic FSM projection selected exclusively from canonical `sites/owasys-front/config/fsm.json` transitions.

Stable states:

`login, registry, account, creation, data, structure, security, workflows, source, build`.

The projection contains real canonical categories:

- entry/authentication: `login_success`, `login_failed`, `password_change_required`, `password_change_failed`, `password_changed`;
- registry: `registry_action_failed`, `create_new_app`, `select_app`, `open_account`;
- creation: `application_creation_failed`, `application_created`, `cancel_creation`;
- application fan-out: `open_structure`, `open_security`, `open_workflows`, `open_source`, `open_build`;
- representative self-loops on data/structure/security/workflows/source/build;
- long real `change_app` returns from operational states to registry;
- real `logout` return from build to login.

Every configured tuple is resolved to exactly one canonical transition before rendering. Missing or ambiguous tuples are blocking errors.

The renderer call uses canonical `initial_state` as fixed layout root and passes runtime `currentState` only for current-node styling.

## Menu autocollapse

`navigation.score` keeps native exclusive HTML `<details name="owasys-fsm-navigation">` grouping:

- no JavaScript;
- no forced `open` on active state;
- one menu panel open at a time in supporting browsers;
- active state remains styled while collapsed.

## Direct differential artifact

`opus_p117w_r45b2a4z_classic_fixed_fsm_autocollapse.zip`

SHA-256:

`9435ce5b017751b2fce0591715bf34b6890344ad2b445cf9d413a404557149dd`

Complete final-path files only:

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`

File SHA-256:

- `FsmDiagramBuilder.php`: `a825cea91c4422ae0bb2c76d1c21109c6bc0c2a636e8f1bb05409329b291956b`
- `navigation.score`: `e26533576487649d79aa48ebc067de7c64fd8cdcb3243df8e909709ffaa9acb8`
- `fsm-diagram.score`: `2208a4aecda400ed0da51445daf2375a743322e39838f1e94084380383a7ceeb`

## Pre-delivery validation actually executed

- `php -l FsmDiagramBuilder.php`: success;
- direct ZIP contains exactly the three complete final-path files above;
- no patcher/apply script;
- no JavaScript introduced;
- fixed initial-state root present;
- current state is not used as layout root;
- projection contains real self-loop, branch, backward-return and logout-return signals;
- native menu autocollapse marker present;
- A4Z revision marker present.

## Owner acceptance

After extraction/restart:

1. Connexion/login is always the logical beginning;
2. node geometry remains identical across pages;
3. current state changes highlight only;
4. the diagram visibly reads as a classic FSM, with loops/returns/branches, not as a linear workflow or org-chart;
5. signal labels remain readable under the OPUS theme;
6. menus autocollapse;
7. A4W `change_app -> clear_current_app`, A4T I18n and Menu = FSM remain intact.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.