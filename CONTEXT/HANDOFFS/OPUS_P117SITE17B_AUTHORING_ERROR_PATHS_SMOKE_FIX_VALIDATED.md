# OPUS P117SITE17B — authoring error paths smoke fix validated

## Status

VALIDATED

## Validation evidence

The user ran RUN_P117SITE17B_AUTHORING_ERROR_PATHS_SMOKE_FIX.cmd successfully.

Validated final markers:

- P117SITE17_AUTHORING_ERROR_PATHS_SMOKE_OK
- CHECK_CLEANUP=OK
- P117SITE17B_AUTHORING_ERROR_PATHS_SMOKE_FIX_OK

## What was validated

P117SITE17B verifies explicit authoring command error paths and no partial writes:

- duplicate module error
- duplicate page template error
- duplicate page route path error
- duplicate rubric route path error
- invalid module id error
- invalid page id error
- invalid route path error
- missing --write error
- validation still passes after rejected operations
- generated skeleton cleanup is complete

## Important note

The original P117SITE17 failure was not an OPUS runtime defect. It was a Windows case-insensitive filesystem smoke false positive caused by checking lowercase blog after creating valid Blog. The P117SITE17B smoke uses 1Blog instead.

## OPUS commit target

Commit and push the validated OPUS files:

- framework/Opus/Console/Command/SiteScaffoldCommandSupport.php
- DOC/P117SITE17_AUTHORING_ERROR_PATHS.md
- DOC/P117SITE17B_AUTHORING_ERROR_PATHS_SMOKE_FIX.md
- tools/smoke_p117site17_authoring_error_paths.py
