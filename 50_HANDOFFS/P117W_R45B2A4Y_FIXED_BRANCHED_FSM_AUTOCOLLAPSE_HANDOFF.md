# P117W R45B2A4Y — Handoff

State: OWNER VALIDATION REQUIRED

## Baseline

OPUS HEAD must be:

`fcffa3c16c75126208a480382f9efb36be170110` — A4W.

A4X is rejected and must not be committed.

## What A4Y changes

A4Y restores the branched FSM visual character while making the graph fixed.

The diagram is no longer rebuilt around the current state and is not linearized. It is a stable logical FSM skeleton rooted at canonical `initial_state = login`.

Current state is supplied only to the OPUS renderer for highlight.

The fixed graph uses only real canonical transitions and contains real branches from Login, Applications and Data, plus real returns to Applications.

The existing A4W `OPUS_FSM_Diagram` renderer remains untouched, preserving OPUS visual tokens, arrow routing, node styling and signal labels.

## Autocollapse

The navigation partial uses native exclusive `<details name="owasys-fsm-navigation">` grouping and removes forced active-state opening. No JavaScript is added.

## Artifact

`opus_p117w_r45b2a4y_fixed_branched_fsm_autocollapse.zip`

SHA-256:

`cda226fc22b605300ae6fe0d770fb09fe91b76285951b98e347a3eb391a69def`

Files:

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`

No patcher. Complete final files only.

## Owner commands

Extract the ZIP at `H:\OPUS`, inspect Git status, lint `FsmDiagramBuilder.php`, run `git diff --check`, rebuild Composer autoload and restart owasys-front.

## Runtime acceptance

- Connexion/login is always the left/root logical beginning.
- Applications and Account branch from Connexion where the canonical FSM says so.
- Creation/Data branch from Applications.
- operational states branch from Data.
- returns such as `change_app`, `cancel_creation` and `password_changed` remain real FSM returns.
- navigation never changes node geometry.
- current page changes highlight only.
- menu panels autocollapse.

Owner alone commits/pushes OPUS/OWASYS.