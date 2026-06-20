# OPUS — P117SITE13 status

Date: 2026-06-20
Status: VALIDATED

## Validated runtime result

`P117SITE13B_CREATE_SITE_SMOKE_CLEANUP` has passed.

Success markers observed from user runtime:

```text
CHECK_GENERATOR_SCORE_RENDERER=OK
CHECK_PUBLIC_SCORE_RENDERER=OK
CHECK_HOME_RAW_SLOT_TEMPLATE=OK
CHECK_HOME_RENDERED=OK
CHECK_IGNORE_NOT_RENDERED=OK
CHECK_RAW_RUBRIC_CARDS=OK
CHECK_CLEANUP=OK
P117SITE13B_CREATE_SITE_SMOKE_CLEANUP_OK
```

## Meaning

The OPUS generated-site pipeline now has a non-versioned skeleton smoke gate:

- generate `sites/skeleton`
- validate the generated site
- confirm real `.score` renderer usage
- confirm ignore block behavior
- confirm raw HTML slot behavior
- clean generated skeleton after the test

This closes the regression that previously allowed a generated `public/index.php` to use `opus_render_score` instead of `Opus\Template\ScoreTemplateRenderer`.

## Source policy

`sites/skeleton/` remains generated output and must not be committed as source.

## Next target

P117SITE14 — OPUS generated-site documentation and composer workflow:

- user-facing map: route -> module -> template -> i18n -> assets
- composer commands for list/create module/page/rubric
- docs for `.score` syntax including escaped variables, raw slots and ignore blocks
- remove any remaining documentation references that imply JSON page layout is the source of truth

