# P112Q3E0 — Delivery Test Recipe Gate

This document summarizes the active MAESTRO_WORKSPACE delivery rule.

Every delivery must include:

```text
feature test
unit or contract test
smoke test
global regression recipe
observable report
strict ExitCode
```

A feature-specific success does not validate a delivery if the global regression recipe fails.

Recommended command pattern:

```cmd
cd /d <REPOSITORY_ROOT>
tools\smoke\run_<palier>_smoke.cmd
tests\<Domain>\run_<palier>_unit_or_contract_test.cmd
tools\recipes\run_<repo>_global_regression_recipe.cmd
```

Recommended final marker:

```text
<PALIER>_DELIVERY_RECIPE_OK
<REPO>_GLOBAL_REGRESSION_RECIPE_OK
ExitCode=0
```

For ASAP_REF_BOOK, schema generation is part of the tested documentation contract when relevant.
