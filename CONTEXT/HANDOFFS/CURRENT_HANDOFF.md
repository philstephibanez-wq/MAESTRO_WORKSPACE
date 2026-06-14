# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

This file is the canonical resume card for a fresh chat.

A new chat must be able to restart from this file without relying on hidden conversation memory.

## Current priority

P116C4 — OPUS packaging and RefBook migration foundation.

## Active repositories

| Repository | Role | Current state |
|---|---|---|
| MAESTRO_WORKSPACE | Global contracts, decisions, handoffs | Canonical coordination layer |
| OPUS | Framework core and official optional package skeletons | Active implementation target |
| OPUS_REF_BOOK | Transitional RefBook repository | Not long-term source of truth |
| MAESTRO_V5 | REAPER/Lua music assistant | Active, not current priority |
| MO_KB_DAEMON | Music KB backend/workers | Active, not current priority |
| MO_KB_FRONT | KB front/backoffice | To align later |

## Latest architecture decisions

- OPUS is the active framework name. ASAP is historical only.
- OPUS core must be clean and mandatory.
- OPUS_REF_BOOK is an official optional package/site, not a duplicated framework.
- OPUS_USER_GUIDE is a future optional package separate from the technical RefBook.
- OPUS core is shared once; packages/sites must not copy `framework/Opus`.
- OPUS licensing intent: copyright Philippe Stéphane Ibanez, source-available, free non-commercial use, commercial license with royalties, not OSI open source unless future decision changes it.
- License/usage metering may exist only as RGPD-by-design license authority / usage meter / royalty engine, with no hidden telemetry.
- Every delivery must update this workspace handoff when project state changes.

## Latest relevant OPUS commits

- `777390e804fcc0d0044bab18c27f6af2da2aa568` — `P116C4A_ADD_OPUS_LICENSE_INTENT`
- `ce0b6bc2c5f9814a58af20abe4e131d94c67a1bf` — `P116C4A_UPDATE_PACKAGES_LICENSE_INHERITANCE`
- `1789133fa77e1efb7740aeec1b076ea8db74c100` — `P116C4A_UPDATE_OPUS_README_LICENSE_INTENT`
- `89b953928c2ec7c0f5ca7bb6b090a0f1b01ec855` — `P116C4B_STRENGTHEN_REFBOOK_PACKAGE_LICENSE_MANIFEST`
- `c27c3f8b9867d739380e60ddd9b242af662f474d` — `P116C4B_STRENGTHEN_USER_GUIDE_PACKAGE_LICENSE_MANIFEST`
- `931ae7572fbe313fbaba61aa7d946af31383f6dd` — `P116C4B_ADD_OPUS_PACKAGE_MANIFEST_CONTRACT`
- `3775263daa474e54cae32b4dae44454a34695a66` — `P116C4B_ADD_OPUS_PACKAGE_SCHEMA`
- `844079472871135c8bc21dcbcc06ec4e076c9659` — `P116C4B_ADD_OPUS_PACKAGE_VALIDATOR`
- `cdc9daf574b22a48b45243a6525bcd61bd0179cc` — `P116C4B_UPDATE_PACKAGES_README_MANIFEST_VALIDATION`
- `274a43f8b2fc9c6f57c94f96a484d45f9b27af90` — `P116C4B_UPDATE_OPUS_README_PACKAGE_VALIDATION`
- `c5e6ad57c66e0d4a639c255fe1c902d7eb4522ec` — `P116C4D_ADD_OPUS_PACKAGE_INSTALLER`
- `e5d258d51fca6fa0a936be40074699e77dde65f1` — `P116C4D_ADD_OPUS_PACKAGE_INSTALL_CONTRACT`
- `bee6b2396de731927645f693bc663d3eaa53c773` — `P116C4D_UPDATE_OPUS_README_PACKAGE_INSTALLER`
- `3515e075a1f67d9a96acb52fb0b2e1d59b8b59b2` — `P116C4D_UPDATE_PACKAGES_README_INSTALLER`

## Latest relevant MAESTRO_WORKSPACE commits

- `6e14f1bc6a3f8a91a98b376c16e7ed17405d4470` — `P116C3O_OPUS_SHARED_CORE_PACKAGES_NO_DUPLICATION_ADR`
- `855a6cb7e8f310139166e2f5b8938dafdc6101a8` — `P116C3O_UPDATE_README_SHARED_CORE_TOPOLOGY`
- `3fa08450fa536e21663fc4c363fc8bf49c1e6451` — `P116C3O_UPDATE_PROJECT_INDEX_SHARED_CORE_TOPOLOGY`
- `012a641f144d99286635ad88d006c155dbdd646b` — `P116C4C_WORKSPACE_ALWAYS_UPDATED_DELIVERY_HANDOFF_ADR`
- `c09107e96682b4a45e76f2abf6c54e04eb0bfce6` — `P116C4C_ADD_CURRENT_WORKSPACE_HANDOFF`
- `5735ddda62fc611d2164192626402f83acd764c9` — `P116C4C_UPDATE_README_MANDATORY_HANDOFF`
- `97376d36c233a50e04a10500113062924e1b3f89` — `P116C4C_UPDATE_PROJECT_INDEX_MANDATORY_HANDOFF`

## Next safe step

Run local verification on OPUS, then continue with scorie audits before importing any RefBook content.

Recommended local checks:

```cmd
cd /d H:\path\to\OPUS
git pull --ff-only
php tools\validate_opus_packages.php
php tools\install_opus_package.php --package=opus-refbook --target=H:\UwAmp\www\OPUS_REF_BOOK --opus-root=H:\OPUS --dry-run
```

Then audit `OPUS_REF_BOOK` for Twig, backups, legacy names, CSS overrides, and broken i18n before migration.

## Explicit blockers / unknowns

- The OPUS package validator has not been executed on the user's local clone by the assistant.
- The OPUS package installer dry-run has not been executed on the user's local clone by the assistant.
- The current `OPUS_REF_BOOK` repository is transitional and known to contain broken/scorie state from prior attempts.
- The final legal `LICENSE` and `COMMERCIAL_LICENSE` texts are not drafted/finalized yet; only `LICENSE_INTENT.md` and workspace ADRs exist.

## Fresh chat starter

Use this prompt in a new chat:

```text
On reprend depuis MAESTRO_WORKSPACE.
Lis d'abord README.md, CONTEXT/HANDOFFS/CURRENT_HANDOFF.md et CONTEXT/PROJECTS/PROJECT_INDEX.md.
Priorité actuelle : P116C4 — OPUS packaging et migration propre du RefBook.
Respect strict : 0 fallback silencieux, pas de patch sans source de vérité, workspace mis à jour à chaque livraison.
```
