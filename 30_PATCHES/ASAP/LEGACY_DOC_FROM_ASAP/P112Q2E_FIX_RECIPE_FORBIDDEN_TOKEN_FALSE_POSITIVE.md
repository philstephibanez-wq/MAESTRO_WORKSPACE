# P112Q2E Fix — Recipe Forbidden Token False Positive

## Cause

The P112Q2E migration correctly renamed `BDD` to `Database`.

The recipe failed because its own forbidden-token list had been rewritten during the migration and started checking the valid modern path token `/Database/`.

## Fix

The recipe now builds legacy forbidden tokens dynamically.

It checks the old `BDD` tokens only and does not flag valid `Database` paths.

## Contract

This fix does not rerun the migration.

It resumes the partial P112Q2E state, reruns the corrected recipe, and commits the applied migration.
