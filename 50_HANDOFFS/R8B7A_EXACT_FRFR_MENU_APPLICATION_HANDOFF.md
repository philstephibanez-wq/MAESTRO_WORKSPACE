# Handoff R8B7A — Exact fr-FR Application menu label

## Required OPUS baseline

`3b69781797e254f7e955c018c51002801f22fec7`

## Differential delivery

One complete file only:

- `sites/owasys-front/application/default/local/fr-FR.json`

## Expected runtime evidence

Reload an authenticated `/fr-FR/...` OWASYS page.
The visible menu must read:

`Applications | Application | Sources de données | Navigation | Sécurité | Sources et Git | Construction et validation`

Missing EFSM labels that genuinely have no exact `fr-FR` translation must continue to show `⚠ <id>`; they are not silently substituted.

## Stop conditions

- baseline mismatch;
- dirty worktree before application;
- invalid JSON;
- `git diff --check` failure;
- any HTTP 500/regression;
- any reappearance of locale/application fallback.
