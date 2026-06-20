# OPUS P117SITE18 — Authoring Commands DocBook Integration — DELIVERED

## Status

Delivered. Runtime validation pending user run.

## Goal

Integrate OPUS authoring command documentation into the official versioned Reference Book package rather than keeping it only as transient milestone notes.

## OPUS target

- Repository: `philstephibanez-wq/OPUS`
- Local root: `H:\OPUS`
- Required previous milestone commit verified on GitHub: `76274b29da72bf17a6b1e0306ddecebdefc5e216` (`P117SITE17_AUTHORING_ERROR_PATHS`).

## Runner

`P117SITE18_AUTHORING_COMMANDS_DOCBOOK_INTEGRATION_RUNNER.zip`

## Expected checks

- `CHECK_REFBOOK_PACKAGE_EXISTS=OK`
- `CHECK_REFBOOK_CONTENT_FILES=OK`
- `CHECK_MANIFEST_REFERENCE_BOOK_CONTENT=OK`
- `CHECK_REFERENCE_TOPIC_INDEX=OK`
- `CHECK_AUTHORING_COMMAND_MATRIX=OK`
- `CHECK_AUTHORING_WRITE_CONTRACT=OK`
- `CHECK_REFERENCE_TEXT_MENTIONS_COMMANDS=OK`
- `CHECK_README_LINKS_TOPIC=OK`
- `CHECK_NO_EMBEDDED_FRAMEWORK=OK`
- `CHECK_NO_TWIG_IN_REFBOOK_CONTENT=OK`
- `CHECK_NO_GENERATED_SITE_LEFT=OK`
- `P117SITE18_AUTHORING_COMMANDS_DOCBOOK_INTEGRATION_SMOKE_OK`
- `P117SITE18_AUTHORING_COMMANDS_DOCBOOK_INTEGRATION_OK`

## Contract

- Reference Book content belongs to `packages/opus-8.1.0-lysenko-reference-book/resources/reference/`.
- Markdown, Score, and JSON representations are generated as Reference Book content.
- The package manifest exposes `reference_book_content` metadata.
- No generated site is created.
- No framework code is copied into the Reference Book package.
- No Twig is introduced.
- No fallback is allowed.

## Next action

Run the provided runner, then commit/push OPUS only after smoke success.
