# P112Q3E3 — ASAP RefBook ROUTING Metadata Third Critical Domain

## Scope

This delivery applies the Reflection + Attributes RefBook contract to the ASAP `ROUTING` domain.

## Contract

- PHP Reflection remains the technical source of truth for signatures.
- `AsapRefBookClass` owns class-level functional documentation.
- `AsapRefBookMethod` owns public method-level behavior metadata.
- `RefBookInspectableInterface` marks every ROUTING public symbol intended for RefBook inspection.
- Strict domain audit fails when any ROUTING class or public method lacks metadata.
- Global regression recipe includes P112Q3E3 unit and smoke steps.

## Runtime validation commands

```cmd
cd /d H:\ASAP
tests\Contractun_refbook_routing_metadata_contract_test.cmd
tools\smokeun_p112q3e3_refbook_routing_metadata_smoke.cmd
toolsefbookun_p112q3e3_refbook_routing_metadata_strict.cmd
toolsecipesun_asap_global_regression_recipe.cmd
toolsecipesun_p112q3e3_delivery_recipe.cmd
```

## Expected markers

- `P112Q3E3_REFBOOK_ROUTING_METADATA_CONTRACT_UNIT_OK`
- `P112Q3E3_REFBOOK_ROUTING_METADATA_SMOKE_OK`
- `P112Q3E3_REFBOOK_ROUTING_METADATA_STRICT_OK`
- `ASAP_GLOBAL_REGRESSION_RECIPE_OK`
- `P112Q3E3_DELIVERY_RECIPE_OK`
