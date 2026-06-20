# OPUS P117SITE17B status — authoring error paths smoke fix

Status: DELIVERED

## Reason

The first P117SITE17 smoke failed on Windows because it checked for a lowercase `blog` directory after a valid `Blog` module existed. Windows path lookup is case-insensitive, so this was a smoke false positive rather than proof of a new lowercase directory write.

## Fix target

P117SITE17B updates the smoke so invalid identifiers do not collide by case with existing valid module names. It keeps the stricter no-partial-write checks for authoring errors.

## User validation required

Run the P117SITE17B runner and validate final marker:

```text
P117SITE17B_AUTHORING_ERROR_PATHS_SMOKE_FIX_OK
```

If validated, OPUS P117SITE17 can be marked as complete and committed/pushed locally.
