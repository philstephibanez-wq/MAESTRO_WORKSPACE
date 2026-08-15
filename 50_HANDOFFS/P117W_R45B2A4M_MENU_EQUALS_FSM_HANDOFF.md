# P117W R45B2A4M — MENU = FSM — Handoff

State: OWNER VALIDATION REQUIRED

## Artifact

- `opus_p117w_r45b2a4m_menu_equals_fsm.zip`
- SHA-256: `9f63d581ba7d7b2fcd4c5e2790d5b4ba1e00463e9e5d586d5f36cba6ed5cbd98`
- Audited OPUS base: `2c45610fe33aff1f12d263837272e042d467f523`

## Owner sequence

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4m_menu_equals_fsm.zip"
php tools\apply_p117w_r45b2a4m_menu_equals_fsm.php
composer dump-autoload -o
php -l Opus\Fsm\Diagram.class.php
php -l sites\owasys-front\application\default\services\NavigationBuilder.php
php -l sites\owasys-front\application\default\controllers\RuntimeController.php
php -l sites\owasys-front\application\default\services\FsmDiagramBuilder.php
php -l sites\owasys-front\application\default\services\ScorePageRenderer.php
composer opus:dev-server -- owasys-front
```

## Acceptance

1. Every FSM state exposed by the navigation machine is represented as a menu state entry; the state entry itself does not transition.
2. Expanding a state shows the outgoing FSM signals attached to that source state.
3. Only signals from the current state that resolve through `OPUS_SIGNAL_ROUTES_V2` are clickable GET controls.
4. Clicking an actionable signal performs a route that resolves back to that exact signal; state targets are never clicked directly.
5. Non-current and non-GET signals remain visible but passive, so the menu remains an inspectable FSM without allowing invalid transitions.
6. Signal target labels preserve locale/I18n.
7. Diagram state nodes are passive.
8. Diagram signal labels are clickable iff the same current-state menu signal is actionable.
9. Diagram is built from the active-state slice of the exact normalized menu projection; there is no duplicate navigation registry.
10. Diagram layout is rooted on the current state without changing the canonical initial state.
11. Current state is highlighted consistently in menu and diagram.
12. NMI stays out-of-band.
13. ACL and current-application availability remain preserved.

## Git gate

The runner must leave exactly the eight required tracked files modified and print `GIT_REQUIRED_DIFFS=8/8`. Owner validates visually and functionally, deletes the one-shot runner before commit, then commits/pushes OPUS.

The assistant does not commit or push OPUS/OWASYS.