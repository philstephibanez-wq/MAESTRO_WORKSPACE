# OPUS P117SITE15 status — list-routes/list-modules

Date: 2026-06-20

## Current status

Validated on the user's Windows workstation via `P117SITE15B_LIST_ROUTES_MODULES_SMOKE_FIX_RUNNER`.

## What is now valid

- `composer opus:list-routes -- skeleton`
- `composer opus:list-modules -- skeleton`
- Generated site validation through `composer opus:validate-site -- skeleton`
- Smoke cleanup: `sites/skeleton/` is removed at the end.

## Important correction

The initial P117SITE15 smoke failed only because it expected the route name `home`, while the real generated route name is `home.index`.

The actual OPUS output is correct and now locked by P117SITE15B.

## OPUS working tree after validation

The local OPUS repository still has uncommitted P117SITE15 files:

```text
 M composer.json
 M framework/Opus/Console/OpusConsoleApplication.php
?? DOC/P117SITE15B_LIST_ROUTES_MODULES_SMOKE_FIX.md
?? DOC/P117SITE15_LIST_ROUTES_MODULES.md
?? framework/Opus/Console/Command/ListModulesCommand.php
?? framework/Opus/Console/Command/ListRoutesCommand.php
?? tools/smoke_p117site15_list_routes_modules.py
```

They should be committed before starting P117SITE16.

## Next action

Commit/push the OPUS P117SITE15 changes, then pull the updated MAESTRO_WORKSPACE locally.

## Next milestone proposal

P117SITE16: Composer creation commands for generated-site evolution:

- `opus:create-module`
- `opus:create-page`
- `opus:create-rubric`

Constraints remain: no renderer duplication, no generated site committed unless explicitly intended, cleanup after smoke, and strict data/processing/rendering separation.
