# P112Q3C — ASAP Public API Unit Coverage Matrix

## Role

Create an observable coverage matrix for the public ASAP framework API before adding large batches of unit tests.

## Contract

```text
ASAP framework only
Read-only scan of source/tests/recipes
No dependency installation
No framework behavior change
No fake proof of unit coverage
No silent fallback
```

## What the tool does

`tools/coverage/p112q3c_public_api_coverage_matrix.php` scans the local repository and reports:

- framework symbols under `framework/Asap`;
- public methods on classes, interfaces, traits and enums;
- likely unit-test references under `tests`;
- smoke references under `tools/smoke`;
- recipe references under `tools/recipes`;
- source RefBook tags;
- method docblock presence;
- coverage candidate status.

## Status values

| Status | Meaning |
|---|---|
| `UNIT_CANDIDATE` | A local test file references both the class/symbol and the method name. |
| `INTEGRATION_ONLY` | A smoke or recipe references the class or method, but no unit candidate was detected. |
| `MISSING_TEST_REFERENCE` | No test, smoke or recipe reference was detected. |

## Important limitation

This matrix detects references. It is not a proof that each behavior is asserted.

That distinction is intentional. The next step must use this matrix to add real unit tests method by method, not to generate fake green tests.

## Reports

The generator writes timestamped and `latest.*` reports under:

```text
var/reports/p112q3c_public_api_coverage/
```

Generated formats:

```text
latest.json
latest.md
latest.html
```

## Commands

Smoke:

```cmd
cd /d H:\ASAP
tools\smoke\run_p112q3c_public_api_coverage_matrix_smoke.cmd
```

Generate matrix:

```cmd
cd /d H:\ASAP
tools\coverage\run_p112q3c_public_api_coverage_matrix.cmd
```

Strict mode, expected to fail until all public methods have unit candidates:

```cmd
cd /d H:\ASAP
tools\coverage\run_p112q3c_public_api_coverage_matrix_strict.cmd
```

## VS Code tasks

Added tasks:

```text
ASAP · Smoke P112Q3C Public API Coverage Matrix
ASAP · Coverage P112Q3C Public API Matrix
ASAP · Coverage P112Q3C Strict No Missing Unit
```

## Next step

`P112Q3D_ASAP_UNIT_TEST_BASELINE_FROM_MATRIX` should add real unit tests domain by domain, starting with the secure-by-design core:

```text
FSM
ACL
Routing
Security
HTTP
Controller
Renderer
I18N
Database
LSTSA
Mail
```
