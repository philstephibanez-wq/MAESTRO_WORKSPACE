# OPUS P117SITE17 status

## Current state

P117SITE17_AUTHORING_ERROR_PATHS is delivered for local OPUS validation.

## Previous validated milestones

- P117SITE12Q1: real ScoreTemplateRenderer in generated skeleton, raw rubric slot, ignore blocks validated.
- P117SITE13B: create-site smoke and cleanup validated.
- P117SITE14: generated-site workflow documentation validated.
- P117SITE15B: `opus:list-routes` and `opus:list-modules` validated.
- P117SITE16: `opus:create-module`, `opus:create-page`, `opus:create-rubric` validated and pushed to OPUS as commit `4b5092e`.

## P117SITE17 target

Validate explicit error paths and zero partial writes for generated-site authoring commands:

- duplicate module;
- duplicate page;
- duplicate route path;
- duplicate rubric route path;
- invalid module/page/path;
- missing `--write`.

## Validation pending

Run the P117SITE17 runner in `H:\OPUS`, verify `P117SITE17_AUTHORING_ERROR_PATHS_OK`, then commit/push OPUS and update this status to VALIDATED.
