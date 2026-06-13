# P112Q3E3 Patch

## Modified framework files

- `framework/Asap/Routing/Router.php`
- `framework/Asap/Routing/RouteDefinition.php`
- `framework/Asap/Routing/RouteMatch.php`

## Added test and tooling files

- `tests/Contract/RefBookRoutingMetadataContractTest.php`
- `tests/Contract/run_refbook_routing_metadata_contract_test.cmd`
- `tools/smoke/p112q3e3_refbook_routing_metadata_smoke.php`
- `tools/smoke/run_p112q3e3_refbook_routing_metadata_smoke.cmd`
- `tools/refbook/p112q3e3_refbook_routing_metadata_audit.php`
- `tools/refbook/run_p112q3e3_refbook_routing_metadata_audit.cmd`
- `tools/refbook/run_p112q3e3_refbook_routing_metadata_strict.cmd`
- `tools/recipes/p112q3e3_delivery_recipe.php`
- `tools/recipes/run_p112q3e3_delivery_recipe.cmd`

## Modified recipe files

- `tools/recipes/asap_global_regression_recipe.php`

## Excluded generated artifacts

- `var/refbook/`
- `var/reports/`
