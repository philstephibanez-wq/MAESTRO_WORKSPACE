# P116C — RefBook ScoreTemplate and live OPUS catalog

## Status

PLANNED / IN PROGRESS.

## Contract

OPUS_REF_BOOK must no longer depend on Twig templates or stale generated symbol indexes for OPUS framework classes.

## Target

- Use the native OPUS ScoreTemplate renderer.
- Replace `.twig` RefBook templates with `.score` templates.
- Consume OPUS live runtime catalog data exposed by `Opus\Documentation\RuntimeClassCatalog`.
- Keep OPUS as the source of truth for framework classes.
- Never display `UNCLASSIFIED` for OPUS framework symbols.
- Fail explicitly when a domain cannot be resolved.

## Forbidden

- No Twig dependency.
- No Symfony dependency.
- No persistent JSON/index/cache as class truth.
- No fallback category such as `unclassified`, `unknown`, `misc`, or `other`.
