# P112Q2H2 — Database Config Loader Options Guard

## Purpose

P112Q2H2 removes the warning emitted when a database configuration has no `<options>` node.

## Cause

`DatabaseConfigLoader` iterated over `$xml->options->option`.

When `<options>` was absent, PHP emitted:

`foreach() argument must be of type array|object, null given`

## Fix

The loader now uses XPath:

`options/option`

Missing `<options>` returns an empty list.

## Contract

- Missing `<options>` is valid.
- Empty option names still fail explicitly.
- No provider fallback is introduced.
