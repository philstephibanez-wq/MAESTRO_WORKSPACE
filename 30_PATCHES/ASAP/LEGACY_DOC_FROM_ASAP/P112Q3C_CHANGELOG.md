# P112Q3C — CHANGELOG

## Added

- Public API coverage matrix generator.
- Method-level matrix for framework public API.
- Unit/smoke/recipe reference detection.
- JSON/Markdown/HTML reports.
- Strict mode to prepare a future `NO PUBLIC METHOD WITHOUT TEST` contract.
- VS Code tasks for smoke, normal run and strict run.
- `.cmd` wrappers only.

## Fixed / clarified

- The robotized life recipe is not presented as unit-test coverage.
- Unit coverage is now separated from integration and recipe coverage.

## Validation in sandbox

```text
php -l tools/coverage/p112q3c_public_api_coverage_matrix.php
php -l tools/smoke/p112q3c_public_api_coverage_matrix_smoke.php
P112Q3C_PUBLIC_API_COVERAGE_MATRIX_SMOKE_OK
```
