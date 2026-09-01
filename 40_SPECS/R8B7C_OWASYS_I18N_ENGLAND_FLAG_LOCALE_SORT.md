# R8B7C — OWASYS I18n England flag + locale selector ordering

## Baseline
OPUS HEAD: `3b69781797e254f7e955c018c51002801f22fec7`.

## Scope
R8B7C supersedes R8B7B.

- Keep explicit `menu.application` in every selectable regional locale.
- Keep newly selectable `en-EN`.
- Use England's St George's Cross for `en-EN`, not the Union Jack.
- Sort locale selector deterministically by native base-language name, then regional display name, grouping variants of the same language.
- No translation fallback is introduced.

## Delivery
Native differential ZIP `R8B7C.zip` only. Owner applies and validates locally; assistant does not commit OPUS/OWASYS.
