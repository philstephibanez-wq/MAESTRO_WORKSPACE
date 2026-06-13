# P112Q3C — TODO

## User-side validation

- Run P112Q3C smoke.
- Run P112Q3C matrix generator.
- Open `var/reports/p112q3c_public_api_coverage/latest.html`.
- Review domains with many `MISSING_TEST_REFERENCE` rows.

## Next palier

`P112Q3D_ASAP_UNIT_TEST_BASELINE_FROM_MATRIX`

Recommended order:

1. FSM unit tests.
2. ACL unit tests.
3. Routing unit tests.
4. Security gate unit tests.
5. HTTP request unit tests.
6. Controller dispatcher contract tests.
7. Renderer/template tests.
8. I18N tests.
9. Database and LSTSA tests.
10. Mail recipe/unit bridge tests.

## Not now

- Do not make strict mode blocking until the missing-test list has been reviewed.
- Do not generate fake assertion-free tests just to make the matrix green.
