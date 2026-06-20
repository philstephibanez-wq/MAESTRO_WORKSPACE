# OPUS — P117SITE15 status

## Current status

Delivered, pending local execution and validation by the user.

## Scope

`P117SITE15_LIST_ROUTES_MODULES`

Adds read-only Composer inspection commands:

```text
composer opus:list-routes -- <site-id>
composer opus:list-modules -- <site-id>
```

## Dependencies

Validated before this milestone:

```text
P117SITE12Q1 ScoreTemplateRenderer and [[ignore]] validated
P117SITE13B create-site smoke cleanup validated
P117SITE14 generated site workflow docs validated
```

## Expected result after execution

```text
P117SITE15_LIST_ROUTES_MODULES_OK
```

## Cleanup rule

`sites/skeleton` must be deleted by the smoke and must not appear in `git status --short`.

## Next logical milestone

After P117SITE15 validation: add creation helpers for user-facing site evolution, likely `opus:create-page` or `opus:create-rubric`, while preserving the route -> module -> template -> i18n -> assets contract.
