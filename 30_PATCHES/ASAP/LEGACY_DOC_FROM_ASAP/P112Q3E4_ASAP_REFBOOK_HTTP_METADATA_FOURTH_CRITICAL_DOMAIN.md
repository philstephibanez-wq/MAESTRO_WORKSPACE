# P112Q3E4 — ASAP RefBook HTTP Metadata Fourth Critical Domain

## Scope

Apply the Reflection + Attributes RefBook contract to the ASAP `HTTP` domain.

Initial live source checked: `framework/Asap/Http/Request.php`.

## Contract

- Request path and method are explicit request-boundary data.
- HTTP objects do not route, authorize or render.
- RefBook metadata documents behavior, side effects and errors for every public method.
- Strict audit fails if the live HTTP domain contains undocumented symbols.

## Commands

```cmd
cd /d H:\ASAP
tests\Contractun_refbook_http_metadata_contract_test.cmd
tools\smokeun_p112q3e4_refbook_http_metadata_smoke.cmd
toolsefbookun_p112q3e4_refbook_http_metadata_strict.cmd
toolsecipesun_asap_global_regression_recipe.cmd
toolsecipesun_p112q3e4_delivery_recipe.cmd
```

## Expected

```text
P112Q3E4_REFBOOK_HTTP_METADATA_CONTRACT_UNIT_OK
P112Q3E4_REFBOOK_HTTP_METADATA_SMOKE_OK
P112Q3E4_REFBOOK_HTTP_METADATA_STRICT_OK
ASAP_GLOBAL_REGRESSION_RECIPE_OK
P112Q3E4_DELIVERY_RECIPE_OK
```
