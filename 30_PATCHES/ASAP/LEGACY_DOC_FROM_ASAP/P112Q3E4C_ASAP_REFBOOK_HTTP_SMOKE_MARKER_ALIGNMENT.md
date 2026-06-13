# P112Q3E4C — ASAP RefBook HTTP smoke marker alignment

## Goal

Align the HTTP RefBook smoke test with the stable P112Q3E4 delivery marker after the Response live-symbol fix was folded back into the P112Q3E4 domain contract.

## Scope

- Updates only the P112Q3E4 HTTP smoke script marker check.
- Does not change HTTP runtime behavior.
- Does not change RefBook scanner behavior.
- Does not include generated `var/` reports or snapshots.

## Contract

The smoke must validate the canonical stable marker `P112Q3E4`, not the temporary corrective marker `P112Q3E4A`.

## Validation

Run:

```cmd
cd /d H:\ASAP
tests\Contract\run_refbook_http_metadata_contract_test.cmd
tools\smoke\run_p112q3e4_refbook_http_metadata_smoke.cmd
tools\refbook\run_p112q3e4_refbook_http_metadata_strict.cmd
tools\recipes\run_asap_global_regression_recipe.cmd
tools\recipes\run_p112q3e4_delivery_recipe.cmd
```
