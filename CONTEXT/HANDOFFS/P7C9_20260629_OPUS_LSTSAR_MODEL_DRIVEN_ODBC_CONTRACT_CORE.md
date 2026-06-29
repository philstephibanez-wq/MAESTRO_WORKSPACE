# P7C9 — 2026-06-29 — OPUS LSTSAR model-driven ODBC contract core

## Status

Validated in OPUS, pushed and tagged.

## OPUS references

- Repository: `philstephibanez-wq/OPUS`
- Latest OPUS commit: `5ef51d1`
- Functional LSTSAR model-driven ODBC contract commit: `68a7023`
- Tag: `OPUS_P7_LSTSAR_MODEL_DRIVEN_ODBC_CONTRACT_CORE`

## Important user correction

The user clarified the exact LSTSAR meaning and expected architecture:

```text
LSTSAR = Load / Securize / Transform / Store / Archive / Report
```

The implementation must respect the six explicit stage files originally prepared by the user:

```text
Opus/Lstsar/01_Load.php
Opus/Lstsar/02_Secure.php
Opus/Lstsar/03_Transform.php
Opus/Lstsar/04_Store.php
Opus/Lstsar/05_Archive.php
Opus/Lstsar/06_Report.php
```

Do not collapse this into an opaque generic pipeline that hides these stages.

## Validated scope

`P7_LSTSAR_MODEL_DRIVEN_ODBC_CONTRACT_CORE` establishes the model-driven, ODBC-oriented LSTSAR contract.

Validated components:

- `LstsarStageName`
- `LstsarStageInterface`
- `LstsarStageResult`
- `LstsarConfig`
- `LstsarContext`
- `LstsarBackofficeDeclaration`
- concrete stage files:
  - `01_Load.php`
  - `02_Secure.php`
  - `03_Transform.php`
  - `04_Store.php`
  - `05_Archive.php`
  - `06_Report.php`
- `LstsarEngine` stage catalog updated for the six-stage architecture.

Validated guarantees:

- source ODBC and destination ODBC endpoints are declared separately;
- source and destination `TableModel` objects are carried in context;
- source/destination mapping is explicit;
- secure stage can reject execution;
- transform stage maps source fields to destination fields;
- store stage validates the destination model surface contractually;
- archive and report stages exist as first-class stages;
- backoffice declaration can describe future source/destination/model/mapping configuration;
- legacy LSTSAR contract smoke stays green;
- ODBC Model refinement and ODBC CRUD/UI smokes stay green.

## Validation evidence

Observed smokes:

- `P7_LSTSAR_MODEL_DRIVEN_ODBC_CONTRACT_CORE_SMOKE_OK`
- `P7_LSTSAR_CONTRACT_CORE_SMOKE_OK`
- `P7_ODBC_MODEL_REFINEMENT_CORE_SMOKE_OK`
- `P7_ODBC_EXPLORER_CRUD_UI_CORE_SMOKE_OK`
- `P7_ODBC_EXPLORER_CRUD_CORE_SMOKE_OK`

Final OPUS state after push/tag:

```text
5ef51d1 (HEAD -> master, tag: OPUS_P7_LSTSAR_MODEL_DRIVEN_ODBC_CONTRACT_CORE, origin/master, origin/HEAD) Update workspace status for P7 LSTSAR model-driven ODBC contract core
68a7023 P7 add LSTSAR model-driven ODBC contract core
1cb3a77 (tag: OPUS_P7_ODBC_MODEL_REFINEMENT_CORE) Update workspace status for P7 ODBC Model refinement core
1d07d80 P7 add ODBC Model refinement core
b9f47d9 (tag: OPUS_P7_ODBC_EXPLORER_CRUD_UI_CORE) Fix workspace status for P7 ODBC Explorer CRUD UI core
```

## Local cleanup still needed

After the tag, OPUS local working tree still had one untracked patch helper:

```text
?? tools/patches/apply_p7_lstsar_model_driven_odbc_contract_core.php
```

This file should be removed locally unless explicitly needed. It was not part of the committed milestone.

Recommended local cleanup:

```cmd
cd /d H:\OPUS
del tools\patches\apply_p7_lstsar_model_driven_odbc_contract_core.php
git status --short --branch
```

## Next milestone

Next possible milestone:

```text
P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE
```

This should implement the real engine execution using the six stages, ODBC source/destination, source/destination models, mapping, archive and report.

The future backoffice target should become a package/application for declaring source models, destination models, mappings and run configuration.
