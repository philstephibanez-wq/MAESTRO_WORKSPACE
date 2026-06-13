# P112Q2J3 — ASAP Recipe Live Movie Dashboard

## Role

Turn the visible HTTP life recipe dashboard into a live movie dashboard instead of a static proof page.

## Contract

The dashboard must expose `ASAP_LIVE_MOVIE_DASHBOARD_OK` and show the recipe as a moving scenario:

- Live timeline with pending/running/done states.
- Polling of `/recipe-state` every few hundred milliseconds.
- Current actor and current action.
- Progress bar.
- HTTP transcript.
- MailRobot inbox.
- LSTSAR event stream.
- Final hold in visible-browser mode so the user can see the run finish.

## Non-regression

This keeps the P112Q2J2 assertions intact and adds a richer visible movie layer. The automatic verdict still comes from deterministic HTTP, mail, LSTSAR and report assertions, not from manual browser inspection.

## Expected markers

- `ASAP_LIVE_MOVIE_DASHBOARD_OK`
- `ASAP_RECIPE_DASHBOARD_RICH_OK`
- `ASAP_GLOBAL_RECIPE_OK`

## Files

- `tools/recipes/life/scenarios/HttpMailLifeRobotScenario.php`
- `tools/recipes/RUN_ASAP_FULL_RECIPE_VISIBLE_BROWSER.cmd`
- `tools/recipes/manifest/asap_feature_manifest.php`

Contract keyword: polling
