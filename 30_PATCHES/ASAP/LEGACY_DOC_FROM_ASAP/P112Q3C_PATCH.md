# P112Q3C — PATCH

## Scope

`ASAP` only.

## Added

- `tools/coverage/p112q3c_public_api_coverage_matrix.php`
- `tools/coverage/run_p112q3c_public_api_coverage_matrix.cmd`
- `tools/coverage/run_p112q3c_public_api_coverage_matrix_strict.cmd`
- `tools/smoke/p112q3c_public_api_coverage_matrix_smoke.php`
- `tools/smoke/run_p112q3c_public_api_coverage_matrix_smoke.cmd`
- `.vscode/tasks.json`
- `DOC/P112Q3C_ASAP_PUBLIC_API_UNIT_COVERAGE_MATRIX.md`
- `DOC/P112Q3C_PATCH.md`
- `DOC/P112Q3C_CHANGELOG.md`
- `DOC/P112Q3C_TODO.md`

## Not changed

- Framework runtime behavior.
- Router/FSM/ACL behavior.
- Apache/UwAmp configuration.
- Database.
- Composer dependencies.

## Runtime output

The coverage generator writes reports under:

```text
var/reports/p112q3c_public_api_coverage/
```
