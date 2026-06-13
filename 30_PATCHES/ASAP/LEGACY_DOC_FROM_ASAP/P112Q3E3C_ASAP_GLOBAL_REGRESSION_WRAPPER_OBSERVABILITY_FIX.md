# P112Q3E3C — ASAP global regression wrapper observability fix

## Scope

Correct the Windows wrapper used to run the ASAP global regression recipe.

## Problem observed on target

`php tools\recipes\asap_global_regression_recipe.php` prints the expected recipe output and exits with code 0, but `tools\recipes\run_asap_global_regression_recipe.cmd` is silent while returning exit code 0.

## Contract

The wrapper must:

- run from the ASAP repository root;
- execute `tools\recipes\asap_global_regression_recipe.php`;
- print the PHP recipe output;
- print `ExitCode=<value>`;
- return the same exit code as PHP;
- not block with `pause`.

## Runtime validation

```cmd
cd /d H:\ASAP
tools\recipes\run_asap_global_regression_recipe.cmd
echo GLOBAL_EXITCODE=%ERRORLEVEL%
```

Expected marker:

```text
ASAP_GLOBAL_REGRESSION_RECIPE_OK
ExitCode=0
GLOBAL_EXITCODE=0
```
