# OPUS P117SITE16 — Create page/module/rubric commands delivered

## Status

DELIVERED — pending local OPUS runtime validation.

## Scope

This handoff records the delivery of the OPUS generated-site authoring command milestone.

## Delivered commands

- `composer opus:create-module -- <site-id> <ModuleId> --title "Title" --write`
- `composer opus:create-page -- <site-id> <ModuleId> <page-id> <path> --title "Title" --write`
- `composer opus:create-rubric -- <site-id> <ModuleId> <path> --title "Title" --write`

## Contract

- Commands are explicit write commands and require `--write` to mutate the generated site.
- Commands fail loudly on invalid site, module, page, path, route, template, or JSON contracts.
- Commands operate only inside `sites/<site-id>`.
- Generated site remains an artifact; `sites/skeleton` must be removed by the smoke cleanup.
- Generated pages follow the route -> module -> `.score` template -> i18n/assets workflow.

## Validation expected

The runner must:

1. Patch OPUS Composer/console command registration.
2. Write create-module/page/rubric command classes and shared command support.
3. Run PHP syntax checks.
4. Generate `sites/skeleton`.
5. Execute the three new Composer commands.
6. Validate the generated site.
7. Check route/module inspection output.
8. Remove `sites/skeleton`.

## Next state

Pending user runtime output for `P117SITE16_CREATE_PAGE_MODULE_RUBRIC_COMMANDS_RUNNER`.
