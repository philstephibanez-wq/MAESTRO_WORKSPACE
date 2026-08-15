# P117W R45B2A4M — MENU = FSM — Handoff

State: OWNER VALIDATION REQUIRED

## Artifact

- `opus_p117w_r45b2a4m_menu_equals_fsm.zip`
- SHA-256: `18177ac11b86a7ee328c259234fb109bf0dbe8ad5fbaeb70611255aed534dd51`
- Audited OPUS base: `2c45610fe33aff1f12d263837272e042d467f523`

## Owner sequence

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4m_menu_equals_fsm.zip"
php tools\apply_p117w_r45b2a4m_menu_equals_fsm.php
composer dump-autoload -o
php -l sites\owasys-front\application\default\services\NavigationBuilder.php
php -l sites\owasys-front\application\default\controllers\RuntimeController.php
php -l sites\owasys-front\application\default\services\FsmDiagramBuilder.php
php -l sites\owasys-front\application\default\services\ScorePageRenderer.php
composer opus:dev-server -- owasys-front
```

## Acceptance

1. Main menu entries represent FSM states, not direct navigation links.
2. Expanding a state displays its outgoing FSM signals as that state's submenu.
3. Only signals from the current state that resolve through `OPUS_SIGNAL_ROUTES_V2` are clickable.
4. Clicking an actionable signal performs the route that resolves back to that exact FSM signal.
5. Non-current signals remain visible but passive; no transition can be fired from the wrong source state.
6. State entries themselves never perform a transition.
7. Diagram state nodes are passive.
8. Diagram signal labels are clickable iff the same menu signal is actionable.
9. Diagram and menu use the same normalized projection; no duplicate navigation registry exists.
10. Current state is highlighted consistently in menu and diagram.
11. NMI stays out-of-band.
12. Locale, ACL and current-application availability remain preserved.

## Git gate

The runner must leave exactly the seven required tracked files modified and print `GIT_REQUIRED_DIFFS=7/7`. Owner validates visually and functionally, deletes the one-shot runner before commit, then commits/pushes OPUS.

The assistant does not commit or push OPUS/OWASYS.