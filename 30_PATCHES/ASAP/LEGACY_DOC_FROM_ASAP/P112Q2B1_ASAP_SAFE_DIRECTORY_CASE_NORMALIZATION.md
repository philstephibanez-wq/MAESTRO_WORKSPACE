# P112Q2B1 — ASAP Safe Directory Case Normalization

## Purpose

P112Q2B1 normalizes only the directory segments classified as safe by P112Q2A2.

## Scope

Renamed directories:

- `ROUTING` -> `Routing`
- `SITE` -> `Site`
- `URL` -> `Url`
- `RENDER` -> `Render`

## Why this is safe

The audited namespace segments for `ROUTING`, `SITE`, and `URL` already used the target modern namespace form:

- `ASAP\Routing`
- `ASAP\Site`
- `ASAP\Url`

`RENDER` had no PHP namespace rows and is treated as a directory-case-only normalization.

## Non-goals

This step does not rename risky namespace/domain directories.

Excluded examples:

- `ACL`
- `BDD`
- `FSM`
- `I18N`
- `TEMPLATE`
- `MENU`
- `HELPER`
- `CONTROLLER`
- `ROUTER`
- `VIEW`
- `XML`

## Contract

- No silent fallback.
- No runtime alias path.
- Directory case is changed through an intermediate temporary directory to be safe on Windows/Git.
- Text references are updated after the directory rename.
- Router attribute compiler recipe is rerun to detect regressions.

## Runner

`H:\ASAP\tools\automation\p112q2b1_safe_directory_case_normalization_recipe_runner.cmd`
