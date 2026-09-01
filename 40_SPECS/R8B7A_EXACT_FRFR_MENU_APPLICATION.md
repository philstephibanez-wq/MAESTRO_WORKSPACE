# R8B7A — Exact fr-FR Application menu label

Date: 2026-09-01
Status: READY FOR OWNER VALIDATION

## Baseline

OPUS HEAD: `3b69781797e254f7e955c018c51002801f22fec7` (`R8B6Z`).

## Cause

`sites/owasys-front/config/fsm.json` exposes the visible navigation state `application` with label key `menu.application`.
The exact active catalog `sites/owasys-front/application/default/local/fr-FR.json` does not define `menu.application`.
Because runtime locale fallback is forbidden and disabled, the UI correctly renders the missing-translation marker instead of borrowing another catalog.

## Correction

Add the exact key:

`menu.application` = `Application`

to the exact `fr-FR` default catalog.

No fallback, base-language inheritance, locale substitution or host-application substitution is introduced.

## Acceptance

- `/fr-FR/...` main menu displays `Application` between `Applications` and `Sources de données`.
- Existing missing EFSM translations remain rendered as `⚠ <technical-id>`.
- PHP/runtime architecture is unchanged.
- JSON validates and `git diff --check` is clean.
