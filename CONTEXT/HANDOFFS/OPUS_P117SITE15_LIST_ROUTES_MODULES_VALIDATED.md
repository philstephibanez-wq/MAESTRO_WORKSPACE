# OPUS — P117SITE15 list-routes/list-modules validated

Date: 2026-06-20

## Status

P117SITE15B is validated by runtime smoke on the user's Windows workstation.

## Runtime evidence

The OPUS runner added and validated the following Composer inspection commands:

- `composer opus:list-routes -- skeleton`
- `composer opus:list-modules -- skeleton`

Smoke result markers observed:

```text
CHECK_LIST_ROUTES_HEADER=OK
CHECK_LIST_ROUTES_HOME=OK
CHECK_LIST_ROUTES_PAGES=OK
CHECK_LIST_ROUTES_ARTICLES=OK
CHECK_LIST_ROUTES_RUBRIQUES=OK
CHECK_LIST_ROUTES_DOCUMENTATION=OK
CHECK_LIST_MODULES_HEADER=OK
CHECK_LIST_MODULES_HOME=OK
CHECK_LIST_MODULES_PAGES=OK
CHECK_LIST_MODULES_ARTICLES=OK
CHECK_LIST_MODULES_RUBRIQUES=OK
CHECK_LIST_MODULES_DOCUMENTATION=OK
P117SITE15_LIST_ROUTES_MODULES_SMOKE_OK
CHECK_CLEANUP=OK
P117SITE15B_LIST_ROUTES_MODULES_SMOKE_FIX_OK
P117SITE15B_FINAL_CLEANUP=OK
```

## Generated route output contract

Current generated skeleton route output:

```text
[ROUTE] home.index / -> Home :: application/modules/Home/templates/pages/index.score
[ROUTE] pages.index /pages -> Pages :: application/modules/Pages/templates/pages/index.score
[ROUTE] articles.index /articles -> Articles :: application/modules/Articles/templates/pages/index.score
[ROUTE] rubriques.index /rubriques -> Rubriques :: application/modules/Rubriques/templates/pages/index.score
[ROUTE] documentation.index /documentation -> Documentation :: application/modules/Documentation/templates/pages/index.score
```

## Generated module output contract

Current generated skeleton module output:

```text
[MODULE] Home enabled=yes root=application/modules/Home default_template=application/modules/Home/templates/pages/index.score title="Home"
[MODULE] Pages enabled=yes root=application/modules/Pages default_template=application/modules/Pages/templates/pages/index.score title="Pages"
[MODULE] Articles enabled=yes root=application/modules/Articles default_template=application/modules/Articles/templates/pages/index.score title="Articles"
[MODULE] Rubriques enabled=yes root=application/modules/Rubriques default_template=application/modules/Rubriques/templates/pages/index.score title="Rubriques"
[MODULE] Documentation enabled=yes root=application/modules/Documentation default_template=application/modules/Documentation/templates/pages/index.score title="Documentation"
```

## Cleanup contract

`sites/skeleton/` remains a generated artefact only and must not be versioned. The smoke removed it successfully.

## Local OPUS files to commit

The user's OPUS working tree shows:

```text
 M composer.json
 M framework/Opus/Console/OpusConsoleApplication.php
?? DOC/P117SITE15B_LIST_ROUTES_MODULES_SMOKE_FIX.md
?? DOC/P117SITE15_LIST_ROUTES_MODULES.md
?? framework/Opus/Console/Command/ListModulesCommand.php
?? framework/Opus/Console/Command/ListRoutesCommand.php
?? tools/smoke_p117site15_list_routes_modules.py
```

These files belong to the P117SITE15 commit.

## Next recommended milestone

P117SITE16 should add creation commands only after the inspection commands are committed:

- `opus:create-module`
- `opus:create-page`
- `opus:create-rubric`

Each command must preserve strict OPUS contracts: configuration-driven generation, module/page/rubric responsibilities, `.score` templates, i18n resources, no local renderer duplication, no generated `sites/skeleton` left behind.
