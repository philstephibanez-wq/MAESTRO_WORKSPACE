# Handoff R8B7C

R8B7C supersedes R8B7B.

Validation target:
- 38 selectable locales including `en-EN`.
- `en-EN` displays England flag (St George's Cross).
- Locale selector order is deterministic and grouped by language, sorted by native language/display name.
- `menu.application` exists explicitly in every selectable regional locale.
- No fallback is used for this key.

Expected owner flow: clean baseline gate, apply `R8B7C.zip`, validate JSON/PHP/diff, launch OWASYS front and inspect selector.
