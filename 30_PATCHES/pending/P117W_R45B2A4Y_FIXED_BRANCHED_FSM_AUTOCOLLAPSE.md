# P117W R45B2A4Y — Fixed branched FSM + native menu autocollapse

State: OWNER VALIDATION REQUIRED

## Baseline

Required OPUS HEAD:

`fcffa3c16c75126208a480382f9efb36be170110` — A4W.

A4X is owner-rejected and must not be used as a baseline.

## Owner visual contract

The diagram must look and behave like a real readable FSM, not a linear workflow:

- fixed geometry;
- starts from canonical logical beginning `initial_state = login` / Connexion;
- branched graph with real paths, returns and loops;
- current state never becomes the layout root and never moves nodes;
- current state is highlighted only;
- OPUS/OWASYS graphical charter remains in force;
- signal labels remain readable and routed by the A4W renderer;
- no invented state or transition.

## A4Y projection

`OwasysFsmDiagramBuilder` now builds a fixed branched logical skeleton from canonical transitions only.

States are presented in stable logical order:

`login, registry, account, creation, data, structure, security, workflows, source, build`.

Displayed canonical edges are:

- `login --login_success--> registry`
- `login --password_change_required--> account`
- `account --password_changed--> registry`
- `registry --create_new_app--> creation`
- `registry --select_app--> data`
- `registry --open_account--> account`
- `creation --application_created--> data`
- `creation --cancel_creation--> registry`
- `data --open_structure--> structure`
- `data --open_security--> security`
- `data --open_workflows--> workflows`
- `data --open_source--> source`
- `data --open_build--> build`
- `data --change_app--> registry`

Every tuple is resolved back to exactly one real canonical transition before rendering; missing or ambiguous edges are blocking errors.

The renderer call uses:

- canonical `initial_state` as fixed `layoutRoot`;
- `currentState` only as current/highlight argument;
- non-compact ranked layout to obtain a classic spaced FSM rather than A4X linearization.

## Menu autocollapse

`navigation.score` keeps native exclusive `<details name="owasys-fsm-navigation">` grouping:

- no JavaScript;
- no forced `open` on current state;
- opening one menu closes another in supporting browsers;
- active state remains styled via `is-active` / `aria-current`.

## Direct differential artifact

`opus_p117w_r45b2a4y_fixed_branched_fsm_autocollapse.zip`

SHA-256:

`cda226fc22b605300ae6fe0d770fb09fe91b76285951b98e347a3eb391a69def`

Complete final-path files only:

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`

File SHA-256:

- `FsmDiagramBuilder.php`: `1a122515a8534a26d19632cc4fc1eefee4a9899b1cad1761e731337d65c21788`
- `navigation.score`: `e26533576487649d79aa48ebc067de7c64fd8cdcb3243df8e909709ffaa9acb8`
- `fsm-diagram.score`: `2cae61df24d0b7007d1e6f0487aae0634f1ebfcaa40699590098d917a40dc229`

## Pre-delivery validation actually executed

- `php -l FsmDiagramBuilder.php`: success;
- direct ZIP contains exactly the 3 final-path files above;
- no patcher/apply script;
- no JavaScript introduced;
- fixed initial-state layout root present;
- current state is not used as layout root;
- projection contains multiple real branches (`login`, `registry`, `data` fan-outs), not a linear chain;
- native autocollapse marker present;
- A4Y revision marker present.

## Owner acceptance

After extraction/restart:

1. diagram always begins at Connexion/login;
2. diagram retains the same positions on Applications, Creation, Data, Structure, Security, Workflows, Source, Build and Account;
3. current state only changes highlight;
4. graph is visibly branched like a normal FSM, not linear;
5. signals/arrows are readable under the OPUS theme;
6. menus autocollapse;
7. Menu = FSM, A4T I18n, A4W lane rendering and A4W change_app FSM action remain intact.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.