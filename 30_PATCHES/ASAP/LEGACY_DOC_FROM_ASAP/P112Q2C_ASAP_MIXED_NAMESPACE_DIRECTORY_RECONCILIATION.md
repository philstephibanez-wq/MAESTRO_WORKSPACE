# P112Q2C — ASAP Mixed Namespace Directory Reconciliation

## Purpose

P112Q2C handles the directories that P112Q2A2 classified as:

`RISKY_MIXED_NAMESPACE_SEGMENTS`

## Scope

Renamed and normalized:

- `HELPER` -> `Helper`
- `MENU` -> `Menu`
- `TEMPLATE` -> `Template`

Namespace normalization:

- `ASAP\HELPER` -> `ASAP\Helper`
- `ASAP\MENU` -> `ASAP\Menu`
- `ASAP\TEMPLATE` -> `ASAP\Template`

## Why this is separated

These directories already contained mixed namespace styles.

Examples from the audit:

- `ASAP\HELPER` and `ASAP\Helper`
- `ASAP\MENU` and `ASAP\Menu`
- `ASAP\TEMPLATE` and `ASAP\Template`

Because this is not a simple directory case-only rename, it is isolated from the safer Q2B1 step.

## Contract

- No fallback directory.
- No legacy namespace alias.
- No runtime autoload magic.
- Old namespace tokens are removed from runtime text files.
- Directory case is forced through a temporary intermediate path for Windows/Git.

## Verification

The recipe verifies:

- old directory segments are gone;
- new directory segments exist;
- old namespace/path tokens are not present in runtime text files;
- Q2B1 recipe still passes;
- Q1 Router attribute compiler recipe still passes.

## Runner

`H:\ASAP\tools\automation\p112q2c_mixed_namespace_directory_reconciliation_recipe_runner.cmd`
