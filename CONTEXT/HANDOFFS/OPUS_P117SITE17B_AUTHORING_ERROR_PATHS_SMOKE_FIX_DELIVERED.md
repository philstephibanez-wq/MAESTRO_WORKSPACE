# OPUS P117SITE17B — Authoring error paths smoke fix delivered

Status: DELIVERED

## Context

P117SITE17 introduced the authoring error-path smoke for OPUS Composer commands, but the first smoke produced a false failure on Windows when checking the lowercase path `application/modules/blog` after a valid `Blog` module had already been created.

On Windows, the filesystem is case-insensitive, so `blog` resolves to the existing `Blog` directory. The command behavior itself had already returned the expected explicit error for the invalid module id.

## Delivered fix

P117SITE17B rewrites only the smoke/doc layer:

- uses an invalid module id that cannot collide by case with an existing module;
- keeps validation of duplicate module, duplicate page, duplicate route path, duplicate rubric path, invalid page id, invalid route path, and missing `--write`;
- verifies that no partial filesystem/config writes occur after expected authoring errors;
- cleans `sites/skeleton` before and after the smoke.

## Validation expectation

Expected final marker:

```text
P117SITE17B_AUTHORING_ERROR_PATHS_SMOKE_FIX_OK
```

Do not mark P117SITE17 validated until this smoke passes on the user's Windows OPUS checkout.
