# P114D1R — ASAP RefBook doc I18N smoke runner fix

Fixes the smoke runner working directory.

P114D1 extracted files correctly, but the `.cmd` moved only one directory up from `tools/smoke`, landing in `tools` instead of the ASAP repository root.

## Apply

```cmd
tar -xf "%USERPROFILE%\Downloads\P114D1R_ASAP_REFBOOK_DOC_I18N_SMOKE_RUNNER_FIX_DROP_IN.zip" -C "H:\ASAP"
tools\smoke\run_p114d1_refbook_doc_i18n_rest_lang_provider_smoke.cmd
```
