# OPUS P117SITE15 — List routes/modules delivered

## Status

Delivered to user as a runner package.

## Milestone

`P117SITE15_LIST_ROUTES_MODULES`

## Purpose

Add read-only OPUS Composer inspection commands for generated sites:

```text
composer opus:list-routes -- <site-id>
composer opus:list-modules -- <site-id>
```

## Contract

- Commands are read-only.
- Commands inspect existing generated sites only.
- No site creation, repair, or DB mutation is performed by the list commands.
- `opus:list-routes` reads `application/config/routes.json` and verifies module/template links.
- `opus:list-modules` reads `application/config/modules.json` plus module `module.json` files.
- Smoke generates `sites/skeleton`, validates the site, runs both commands, verifies output, and removes the generated site.

## Files patched by runner

```text
composer.json
framework/Opus/Console/OpusConsoleApplication.php
framework/Opus/Console/Command/ListRoutesCommand.php
framework/Opus/Console/Command/ListModulesCommand.php
DOC/P117SITE15_LIST_ROUTES_MODULES.md
tools/smoke_p117site15_list_routes_modules.py
```

## Expected markers

```text
CHECK_LIST_ROUTES_HEADER=OK
CHECK_LIST_ROUTES_CONTENT=OK
CHECK_LIST_MODULES_HEADER=OK
CHECK_LIST_MODULES_CONTENT=OK
CHECK_CLEANUP=OK
P117SITE15_LIST_ROUTES_MODULES_SMOKE_OK
P117SITE15_LIST_ROUTES_MODULES_OK
```

## Notes

This milestone follows validated P117SITE13B and P117SITE14. `sites/skeleton` remains a generated artifact and must not be committed.
