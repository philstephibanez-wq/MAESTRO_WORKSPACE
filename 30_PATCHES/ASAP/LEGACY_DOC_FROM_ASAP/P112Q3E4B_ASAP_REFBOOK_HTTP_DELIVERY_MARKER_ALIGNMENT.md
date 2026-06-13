# P112Q3E4B — ASAP RefBook HTTP delivery marker alignment

## Purpose

Align the live-symbol fix metadata with the stable P112Q3E4 HTTP contract marker.

## Context

P112Q3E4A correctly covered the live `ASAP\Http\Response` symbol found by strict audit.
The strict audit passed after that fix, but the unit contract still failed because method-level metadata used `P112Q3E4A` while the HTTP domain contract expects all HTTP metadata introduced by this palier to use `P112Q3E4`.

## Contract

- Reflection remains source of truth for signatures.
- RefBook attributes carry functional documentation only.
- The live-symbol fix is part of the P112Q3E4 HTTP domain baseline.
- No fallback, alias, or relaxed test is introduced.

## Modified files

- `framework/Asap/Http/Response.php`

## Expected validation

```cmd
cd /d H:\ASAP
tests\Contract\run_refbook_http_metadata_contract_test.cmd
tools\smoke\run_p112q3e4_refbook_http_metadata_smoke.cmd
tools\refbook\run_p112q3e4_refbook_http_metadata_strict.cmd
tools\recipes\run_asap_global_regression_recipe.cmd
tools\recipes\run_p112q3e4_delivery_recipe.cmd
```

Expected final markers:

```text
P112Q3E4_REFBOOK_HTTP_METADATA_CONTRACT_UNIT_OK
P112Q3E4_REFBOOK_HTTP_METADATA_SMOKE_OK
P112Q3E4_REFBOOK_HTTP_METADATA_STRICT_OK
ASAP_GLOBAL_REGRESSION_RECIPE_OK
P112Q3E4_DELIVERY_RECIPE_OK
```
