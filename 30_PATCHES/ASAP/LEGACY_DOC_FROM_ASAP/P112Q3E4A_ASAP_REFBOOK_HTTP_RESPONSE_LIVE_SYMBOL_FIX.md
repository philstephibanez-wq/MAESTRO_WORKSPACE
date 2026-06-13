# P112Q3E4A — ASAP RefBook HTTP Response Live Symbol Fix

## Scope

The P112Q3E4 strict audit found the real HTTP domain contains two classes, not one:

- `ASAP\Http\Request`
- `ASAP\Http\Response`

This fix documents `Response` with RefBook attributes and updates the HTTP contract test/smoke to the real live surface.

## Contract

- `Request` remains the normalized request-boundary object.
- `Response` remains the response representation/emission object.
- HTTP remains separate from `Routing`: no router logic is moved into HTTP.
- The fix does not add fallback behavior.
- The fix does not create new routing/root/utils classes.

## Commands

```cmd
cd /d H:\ASAP
tests\Contract\run_refbook_http_metadata_contract_test.cmd
tools\smoke\run_p112q3e4_refbook_http_metadata_smoke.cmd
tools\refbook\run_p112q3e4_refbook_http_metadata_strict.cmd
tools\recipes\run_asap_global_regression_recipe.cmd
tools\recipes\run_p112q3e4_delivery_recipe.cmd
```

## Expected

```text
P112Q3E4_REFBOOK_HTTP_METADATA_CONTRACT_UNIT_OK
P112Q3E4_REFBOOK_HTTP_METADATA_SMOKE_OK
P112Q3E4_REFBOOK_HTTP_METADATA_STRICT_OK
ASAP_GLOBAL_REGRESSION_RECIPE_OK
P112Q3E4_DELIVERY_RECIPE_OK
```

Expected strict surface:

```text
Classes=2 PublicMethods=7
ClassMetadataMissing=0 MethodMetadataMissing=0
Violations=0 LoadErrors=0
```
