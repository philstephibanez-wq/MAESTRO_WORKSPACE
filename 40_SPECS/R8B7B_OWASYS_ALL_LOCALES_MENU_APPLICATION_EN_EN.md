# R8B7B — OWASYS all locales menu.application + en-EN

## Baseline
OPUS HEAD: `3b69781797e254f7e955c018c51002801f22fec7` (R8B6Z).

## Cause
The navigation FSM references `menu.application`, while exact regional catalogs do not all define that key. The visible result is the missing-translation marker in the Application menu entry. The correction must be transversal over every selectable locale and must not special-case French.

## Scope
- add an exact `menu.application` message to every configured regional catalog;
- add selectable locale `en-EN` with an exact English catalog;
- register `en-EN` in OWASYS locale metadata and map its UI flag to the existing English flag asset;
- preserve existing regional messages (`da-DK`, `en-IE`, `fr-FR`) while adding the missing menu key;
- no technical identifier translation.

## Contract
Missing translation behavior remains explicit. This slice does not authorize any new fallback mechanism. The broader no-fallback audit/remediation remains active separately.

## Acceptance
- site config lists 38 selectable locales including `en-EN`;
- each exact selectable catalog contains a non-empty `menu.application`;
- LocaleRegistry accepts and labels `en-EN`;
- PHP lint, JSON parsing and `git diff --check` pass;
- runtime locale selector exposes `en-EN` and menu Application is translated for each tested locale.
