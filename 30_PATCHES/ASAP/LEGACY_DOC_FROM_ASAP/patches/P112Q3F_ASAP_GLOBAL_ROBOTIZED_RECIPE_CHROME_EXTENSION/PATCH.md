# P112Q3F — ASAP Global Robotized Recipe + Chrome Extension

## Scope

Repository target: `H:\ASAP`.

## Added

- `tools/recipes/p112q3f_asap_global_robotized_recipe.php`
- `tools/recipes/run_p112q3f_asap_global_robotized_recipe.cmd`
- `tools/smoke/p112q3f_asap_global_robot_chrome_extension_smoke.php`
- `tools/smoke/run_p112q3f_asap_global_robot_chrome_extension_smoke.cmd`
- `tools/chrome_extension/asap_runtime_robot/*`

## Updated

- `tools/recipes/asap_global_regression_recipe.php`
  - adds `P112Q3F_SMOKE` to the global delivery gate.

## Contract

The Chrome extension is a local developer robot only.
It has no broad host permission and no network fetch behavior.
