# OPUS — P117SITE13 create-site smoke cleanup validated

Date: 2026-06-20
Project: OPUS / MAESTRO_WORKSPACE
Status: VALIDATED_RUNTIME_BY_USER

## Validated milestone

`P117SITE13B_CREATE_SITE_SMOKE_CLEANUP` is validated by runtime output from the user.

The smoke runner successfully executed the full generated-site lifecycle:

1. Confirmed the generator uses the real `Opus\Template\ScoreTemplateRenderer`.
2. Ran `composer dump-autoload`.
3. Generated `sites/skeleton` with `composer opus:create-site -- skeleton --write`.
4. Added languages: `en`, `de`, `es`, `it`, `pl`, `uk`, `cs`.
5. Ran `composer opus:validate-site -- skeleton` successfully.
6. Confirmed generated `public/index.php` uses `ScoreTemplateRenderer`.
7. Confirmed the home template uses raw HTML slot syntax for rubric cards.
8. Started a temporary runtime check on a free local port (`SELECTED_PORT=8792`).
9. Confirmed home page rendering works.
10. Confirmed `[[ignore]] ... [[endignore]]` is not rendered.
11. Confirmed rubric cards render as HTML, not escaped text.
12. Confirmed cleanup: generated `sites/skeleton` is removed after the smoke.

Runtime success marker:

```text
P117SITE13B_CREATE_SITE_SMOKE_CLEANUP_OK
```

## Current stable facts

- `sites/skeleton/` is an artifact, not a versioned source directory.
- The generator is the source of truth for skeleton creation.
- `ScoreTemplateRenderer` is the real `.score` engine.
- `opus_render_score` must not be regenerated in `SiteScaffoldPlan.php` or generated front controllers.
- `[[ignore]]` and `[[endignore]]` are valid `.score` ignore directives.
- Raw HTML slots must use triple braces, for example `{{{ home.rubric_cards }}}`.

## Warning observed

Python emitted a non-blocking warning in the smoke script:

```text
SyntaxWarning: 'return' in a 'finally' block
```

The smoke completed successfully despite the warning. Next cleanup should remove that warning from future runner scripts, but it is not a functional failure of OPUS.

## Recommended next step

P117SITE14 should formalize documentation and developer workflow around generated sites:

- route -> module -> controller/action -> `.score` template -> i18n -> assets
- create/edit a page without touching framework internals
- create/edit a module without hardcoded rendering logic
- list routes/modules via Composer commands

