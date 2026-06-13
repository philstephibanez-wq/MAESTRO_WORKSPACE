# P112Q2G Fix — Q2B1 Render Expectation After Cleanup

## Cause

P112Q2G correctly removed the decorative `Render` directory and kept `Renderer` as the official rendering domain.

The older Q2B1 regression recipe still expected `Render` to exist because Q2B1 originally normalized `RENDER -> Render`.

## Fix

The Q2B1 recipe now accepts both valid historical states:

- after Q2B1 only: `Render` exists;
- after Q2G cleanup: `Render` is absent and `Renderer` exists.

It still fails if `RENDER` exists.

## Contract

This fix does not rerun Q2G migration.

It resumes the partial Q2G state, reruns recipes, then commits the already-applied Q2G cleanup.
