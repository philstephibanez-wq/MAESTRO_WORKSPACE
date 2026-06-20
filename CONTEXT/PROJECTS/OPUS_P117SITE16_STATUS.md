# OPUS P117SITE16 status

## Current status

DELIVERED — pending local validation.

## Milestone

`P117SITE16_CREATE_PAGE_MODULE_RUBRIC_COMMANDS`

## Goal

Add Composer authoring commands for generated OPUS sites after the successful P117SITE15 route/module inspection commands.

## Commands under validation

- `opus:create-module`
- `opus:create-page`
- `opus:create-rubric`

## Required validation markers

- `CHECK_CREATE_MODULE_COMMAND=OK`
- `CHECK_CREATE_PAGE_COMMAND=OK`
- `CHECK_CREATE_RUBRIC_COMMAND=OK`
- `CHECK_VALIDATE_AFTER_WRITES=OK`
- `CHECK_LIST_ROUTES_AFTER_WRITES=OK`
- `CHECK_LIST_MODULES_AFTER_WRITES=OK`
- `CHECK_CLEANUP=OK`
- `P117SITE16_CREATE_PAGE_MODULE_RUBRIC_COMMANDS_OK`

## Cleanup contract

`sites/skeleton` must not remain in Git status after the smoke.
