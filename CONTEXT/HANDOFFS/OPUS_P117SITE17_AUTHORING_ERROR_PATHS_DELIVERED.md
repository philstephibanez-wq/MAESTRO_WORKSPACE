# OPUS P117SITE17 - Authoring error paths delivered

## Status

DELIVERED.

## Scope

P117SITE17 hardens generated-site authoring commands by testing and documenting explicit refusal paths for:

- duplicate module;
- duplicate page template;
- duplicate route path;
- duplicate rubric route path without partial module creation;
- invalid module id;
- invalid page id;
- invalid route path;
- missing `--write`.

## OPUS target

Repository: `philstephibanez-wq/OPUS`

Local root expected by runner: `H:\OPUS`

## Runner

`P117SITE17_AUTHORING_ERROR_PATHS_RUNNER.zip`

Expected validation marker:

```text
P117SITE17_AUTHORING_ERROR_PATHS_OK
```

## Contract reminders

- `sites/skeleton` is a generated artifact and must be deleted by the smoke.
- No fallback silencieux.
- No partial writes on preflightable authoring failures.
- Generated site authoring commands must fail with explicit error codes.
