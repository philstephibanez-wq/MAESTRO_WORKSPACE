# OPUS — P117SITE14 generated-site workflow docs delivered

Date: 2026-06-20
Project: OPUS / MAESTRO_WORKSPACE
Status: RUNNER_DELIVERED_PENDING_USER_RUNTIME

## Delivered milestone

`P117SITE14_GENERATED_SITE_WORKFLOW_DOCS_RUNNER` has been delivered for local OPUS validation.

The runner is intended to update OPUS with the generated-site user workflow contract:

- route -> module -> template -> i18n -> assets;
- generated `START_HERE.md` explains how to modify a page without touching framework internals;
- generated module README files explain the module edit path;
- generated sites keep `sites/skeleton/` as a temporary artifact, not a versioned source directory;
- `.score` rendering remains owned by `ScoreTemplateRenderer`;
- `{{ value }}` is escaped, `{{{ value }}}` is an explicit raw HTML slot;
- `[[ ignore ]] ... [[ endignore ]]` is documented as a source-only non-rendered block.

## Validation expected from user runtime

Expected success markers:

```text
CHECK_START_HERE_WORKFLOW=OK
CHECK_MODULE_README_WORKFLOW=OK
CHECK_PUBLIC_SCORE_RENDERER=OK
CHECK_CLEANUP=OK
P117SITE14_GENERATED_SITE_WORKFLOW_SMOKE_OK
P117SITE14_GENERATED_SITE_WORKFLOW_DOCS_OK
```

## Previous stable base

- P117SITE12Q1: `ScoreTemplateRenderer` and `[[ignore]]` validated.
- P117SITE13B: generated-site smoke and cleanup gate validated.
