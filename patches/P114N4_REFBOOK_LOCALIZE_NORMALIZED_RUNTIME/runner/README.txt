P114N4_REFBOOK_LOCALIZE_NORMALIZED_RUNTIME_WORKSPACE_APPLY

Fix:
- P114N3 localized the raw ASAP snapshot too early.
- That caused missing translation errors on raw technical fields like snapshot.contract.technical_truth = PHP Reflection.
- P114N4 localizes the normalized RefBook runtime manifest instead.

Workspace rule:
- Runner, backups, reports stay under H:\MAESTRO_WORKSPACE\patches\P114N4_REFBOOK_LOCALIZE_NORMALIZED_RUNTIME.
- No patch/report/tool files are written inside H:\ASAP or H:\ASAP_REF_BOOK.
