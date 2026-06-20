# OPUS P117SITE17B status — authoring error paths smoke fix

Status: VALIDATED

## Validation evidence

The user ran RUN_P117SITE17B_AUTHORING_ERROR_PATHS_SMOKE_FIX.cmd successfully.

Validated final markers:

- P117SITE17_AUTHORING_ERROR_PATHS_SMOKE_OK
- CHECK_CLEANUP=OK
- P117SITE17B_AUTHORING_ERROR_PATHS_SMOKE_FIX_OK

## Root cause resolved

The initial P117SITE17 failure was a Windows case-insensitive path smoke false positive: a valid Blog module made a lowercase blog check appear to exist. P117SITE17B changed the invalid module id test to 1Blog, preserving no-partial-write checks without case collision.

## OPUS local commit target

Commit and push these OPUS files after validation:

- framework/Opus/Console/Command/SiteScaffoldCommandSupport.php
- DOC/P117SITE17_AUTHORING_ERROR_PATHS.md
- DOC/P117SITE17B_AUTHORING_ERROR_PATHS_SMOKE_FIX.md
- tools/smoke_p117site17_authoring_error_paths.py
