# P117W R45B2A4N — Menu = FSM runtime fix handoff

State: OWNER VALIDATION REQUIRED

## Observed failure

After owner committed A4M (`b51a0693355f9cc3074bb1fdeb111f1f60d98dd0`), OWASYS front returned HTTP 500 with `OWASYS_FRONT_RUNTIME_FAILED` before the menu/diagram rendered.

## Root cause fixed

A4M incorrectly required the HTTP route used to emit a signal to equal the canonical route of `next_state`. That is not the OPUS routing contract. `OPUS_SIGNAL_ROUTES_V2` maps request routes to signals; the FSM transition independently owns the next state.

A4M also duplicated ACL evaluation in the diagram after the menu projection had already normalized it.

A4N removes both defects while preserving `Menu = FSM`.

## Artifact

`opus_p117w_r45b2a4n_menu_fsm_runtime_fix.zip`

SHA-256:

`ee5db334f122072105a4a4aaef313c253b50ac7174e7859b853c3695e4d42b91`

Expected base HEAD:

`b51a0693355f9cc3074bb1fdeb111f1f60d98dd0`

## Owner application sequence

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4n_menu_fsm_runtime_fix.zip"
php tools\apply_p117w_r45b2a4n_menu_fsm_runtime_fix.php
composer dump-autoload -o
php -l sites\owasys-front\application\default\services\NavigationBuilder.php
php -l sites\owasys-front\application\default\services\FsmDiagramBuilder.php
php -l sites\owasys-front\application\default\services\ScorePageRenderer.php
composer opus:dev-server -- owasys-front
```

## Expected patch output

- `OPUS_P117W_R45B2A4N_APPLY_OK`
- `FSM_MENU=STATE_CONTEXT_PLUS_SIGNAL_SUBMENUS`
- `FSM_STATE_DIRECT_URL=REMOVED`
- `SIGNAL_TRIGGER_ROUTE=INDEPENDENT_FROM_TARGET_STATE_ROUTE`
- `FSM_TARGET_STATE=TRANSITION_OWNED_ONLY`
- `FSM_ACL_PROJECTION=SINGLE_SOURCE_MENU`
- `FSM_DIAGRAM=CONSUMES_MENU_PROJECTION`
- `FSM_UI_REVISION=P117W_R45B2A4N`
- `GIT_REQUIRED_DIFFS=4/4`

The runner also prints a real route/target divergence proof from current OWASYS configuration. This proves the contract being corrected instead of merely removing a failing check.

## Validation

1. `/fr-FR` renders normally; no `OWASYS_FRONT_RUNTIME_FAILED`.
2. After authentication, every FSM state appears as a menu state entry according to the current `Menu = FSM` contract.
3. Opening a menu state reveals its outgoing signals as submenu items.
4. The state summary itself does not perform navigation.
5. Only actionable signals from the current state are links.
6. Signal URL is the HTTP endpoint that resolves to that signal; it is allowed to differ from target-state route.
7. Clicking an actionable signal invokes the transition and the FSM decides the arrival state.
8. Diagram shows the active-state outgoing transitions from the same normalized menu projection.
9. Diagram signal links match menu signal links for the current state.
10. Badge reads `menu = FSM · A4N`.
11. NMI remains out-of-band and is not a normal menu state/signal transition.

## Commit policy

Do not commit the one-shot patch runner. After successful owner validation:

```cmd
del tools\apply_p117w_r45b2a4n_menu_fsm_runtime_fix.php
git status --short
```

Owner commits/pushes OPUS. Assistant does not commit or push OPUS/OWASYS.