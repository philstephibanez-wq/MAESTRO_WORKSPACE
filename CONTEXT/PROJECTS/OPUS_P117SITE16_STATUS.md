# OPUS P117SITE16 status

## Current status

VALIDATED — local OPUS runtime smoke passed.

## Milestone

`P117SITE16_CREATE_PAGE_MODULE_RUBRIC_COMMANDS`

## Goal

Add Composer authoring commands for generated OPUS sites after the successful P117SITE15 route/module inspection commands.

## Validated commands

- `opus:create-module`
- `opus:create-page`
- `opus:create-rubric`

## Runtime validation markers observed

- `CHECK_CREATE_MODULE_COMMAND=OK`
- `CHECK_CREATE_PAGE_COMMAND=OK`
- `CHECK_CREATE_RUBRIC_COMMAND=OK`
- `CHECK_VALIDATE_AFTER_WRITES=OK`
- `CHECK_LIST_ROUTES_AFTER_WRITES=OK`
- `CHECK_LIST_ROUTES_RUBRIC_AFTER_WRITES=OK`
- `CHECK_LIST_MODULES_AFTER_WRITES=OK`
- `CHECK_LIST_MODULES_RUBRIC_AFTER_WRITES=OK`
- `CHECK_CLEANUP=OK`
- `P117SITE16_CREATE_PAGE_MODULE_RUBRIC_COMMANDS_OK`

## Generated proof points

- `Blog` module was created through `opus:create-module`.
- `Blog archive` page was created through `opus:create-page`.
- `News` rubric/module was created through `opus:create-rubric`.
- `opus:list-routes` reported `blog.archive /blog/archive` and `news.index /news`.
- `opus:list-modules` reported `Blog` and `News`.

## Cleanup contract

`sites/skeleton` must not remain in Git status after the smoke. The runner reported `CHECK_CLEANUP=OK`.

## OPUS local files to commit

- `composer.json`
- `framework/Opus/Console/OpusConsoleApplication.php`
- `framework/Opus/Console/Command/SiteScaffoldCommandSupport.php`
- `framework/Opus/Console/Command/CreateModuleCommand.php`
- `framework/Opus/Console/Command/CreatePageCommand.php`
- `framework/Opus/Console/Command/CreateRubricCommand.php`
- `DOC/P117SITE16_CREATE_PAGE_MODULE_RUBRIC_COMMANDS.md`
- `tools/smoke_p117site16_create_page_module_rubric_commands.py`

## Next milestone

`P117SITE17` should harden the authoring commands with conflict/error-path smokes and documentation/reference-book alignment.
