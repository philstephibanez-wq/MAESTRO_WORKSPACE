# OPUS — P117SITE14 generated-site workflow docs validated

Date: 2026-06-20
Project: OPUS / MAESTRO_WORKSPACE
Status: VALIDATED_RUNTIME

## Validated milestone

`P117SITE14_GENERATED_SITE_WORKFLOW_DOCS_RUNNER` has been executed successfully in the user's OPUS runtime.

The runner updates OPUS with the generated-site user workflow contract:

- route -> module -> template -> i18n -> assets;
- generated `START_HERE.md` explains how to modify a page without touching framework internals;
- generated module README files explain the module edit path;
- generated sites keep `sites/skeleton/` as a temporary artifact, not a versioned source directory;
- `.score` rendering remains owned by `ScoreTemplateRenderer`;
- `{{ value }}` is escaped, `{{{ value }}}` is an explicit raw HTML slot;
- `[[ ignore ]] ... [[ endignore ]]` is documented as a source-only non-rendered block.

## Runtime evidence

The user run produced:

```text
CHECK_START_HERE_WORKFLOW=OK
CHECK_MODULE_README_WORKFLOW=OK
CHECK_PUBLIC_SCORE_RENDERER=OK
CHECK_CLEANUP=OK
P117SITE14_GENERATED_SITE_WORKFLOW_SMOKE_OK
P117SITE14_GENERATED_SITE_WORKFLOW_DOCS_OK
```

## OPUS local changes expected before commit

```text
 M framework/Opus/Scaffold/SiteScaffoldPlan.php
?? DOC/
?? tools/smoke_p117site14_generated_site_workflow.py
```

`sites/skeleton/` must not appear in `git status --short` after smoke cleanup.

## Previous stable base

- P117SITE12Q1: `ScoreTemplateRenderer` and `[[ignore]]` validated.
- P117SITE13B: generated-site smoke and cleanup gate validated.

## Next milestone

P117SITE15 should add Composer introspection commands for generated sites, starting with:

```text
opus:list-routes
opus:list-modules
```
