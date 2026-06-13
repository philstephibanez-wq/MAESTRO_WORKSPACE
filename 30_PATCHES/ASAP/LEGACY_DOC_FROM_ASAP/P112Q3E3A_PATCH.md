# P112Q3E3A PATCH

## Modified files

- `framework/Asap/Routing/AttributeRouteProvider.php`
- `framework/Asap/Routing/ClassIndex.php`
- `framework/Asap/Routing/Route.php`
- `framework/Asap/Routing/RouteCompilerException.php`
- `framework/Asap/Routing/RouteManifestCompiler.php`
- `tests/Contract/RefBookRoutingMetadataContractTest.php`
- `tools/smoke/p112q3e3_refbook_routing_metadata_smoke.php`

## Validation

Run on target:

```cmd
cd /d H:\ASAP
tests\Contract\run_refbook_routing_metadata_contract_test.cmd
tools\smoke\run_p112q3e3_refbook_routing_metadata_smoke.cmd
tools\refbook\run_p112q3e3_refbook_routing_metadata_strict.cmd
tools\recipes\run_asap_global_regression_recipe.cmd
tools\recipes\run_p112q3e3_delivery_recipe.cmd
```
