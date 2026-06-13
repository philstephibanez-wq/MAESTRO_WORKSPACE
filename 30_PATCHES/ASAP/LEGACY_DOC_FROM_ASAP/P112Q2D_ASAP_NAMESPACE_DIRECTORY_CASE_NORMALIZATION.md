# P112Q2D — ASAP Namespace Directory Case Normalization

## Purpose

P112Q2D normalizes the remaining uppercase namespace/directory segments classified by P112Q2A2 as:

`RISKY_NAMESPACE_AND_DIRECTORY_RENAME`

## Scope

This step handles all remaining namespace-case renames except the English domain rename `BDD -> Database`.

Examples:

- `ACL` -> `Acl`
- `CONTROLLER` -> `Controller`
- `FSM` -> `Fsm`
- `I18N` -> `I18n`
- `REST` -> `Rest`
- `SMTP` -> `Smtp`
- `XML` -> `Xml`

`JS` becomes `Javascript`.

## Excluded

`BDD -> Database` is excluded because it is not just case normalization. It is an English domain rename and must be handled separately.

## Contract

- No fallback directory.
- No legacy namespace alias.
- No runtime autoload magic.
- Directory case is forced through a temporary intermediate path for Windows/Git.
- Runtime namespace/path references are updated.
- Recipes from Q2C, Q2B1, and Q1 are rerun as regression checks.

## Runner

`H:\ASAP\tools\automation\p112q2d_namespace_directory_case_normalization_recipe_runner.cmd`
