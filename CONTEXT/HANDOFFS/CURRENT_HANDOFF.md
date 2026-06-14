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
- OPUS may live under a readable local web root such as `H:\UwAmp\www\OPUS`, but only `sites/*/public/` may be exposed by Apache.
- OPUS delivered core keeps useful roots such as `sites/`, `packages/`, `config/`, `var/` even when they are mostly empty.
- `tests/` is development-only and must not be included in delivery artifacts.
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
- `c5e6ad57c66e0d4a639c255fe1c902d7eb4522ec` — `P116C4D_ADD_OPUS_PACKAGE_INSTALLER`
- `e5d258d51fca6fa0a936be40074699e77dde65f1` — `P116C4D_ADD_OPUS_PACKAGE_INSTALL_CONTRACT`
- `e8b6eb5f932178f9d58e4407cb030ab97d69da95` — `P116C4E_ADD_OPUS_SITES_ROOT_README`
- `0e36bf0957869e1ad1c82873ce4d9a002eea31cc` — `P116C4E_ADD_OPUS_CONFIG_README`
- `84bb4e9c2feaccf730cf607539ff88d930a6b07f` — `P116C4E_ADD_OPUS_EXAMPLE_CONFIG`
- `b35ad68f4cfa0b72d886de2a01006a8d19adada2` — `P116C4E_ADD_OPUS_VAR_README`
- `0f3e857c2f18bfb7398aa88add264af173b5d33f` — `P116C4E_ADD_OPUS_VAR_CACHE_PLACEHOLDER`
- `d0af0392669bbe5a6206b593726f9dbdb6d7797a` — `P116C4E_ADD_OPUS_VAR_LOGS_PLACEHOLDER`
- `846d3571ac0ed88995dcbd7449161035326f0a1a` — `P116C4E_ADD_OPUS_VAR_TMP_PLACEHOLDER`
- `db605c2972a05fd8aea205a4d707911dff6212a8` — `P116C4E_ADD_OPUS_DELIVERY_PROFILE`
- `9db03f2fcead3647f116100bd3a2f747d8953b42` — `P116C4E_ADD_OPUS_DELIVERY_LAYOUT_VALIDATOR`
- `dfbd10c3e4eeffdbcfe6f272768b8f00994174cc` — `P116C4E_UPDATE_OPUS_README_DELIVERY_TOPOLOGY`
- `41dba27519bc91c4f47a21ada4a81a59eaab3725` — `P116C4E_UPDATE_PACKAGE_INSTALL_CONTRACT_SITES_ROOT`
- `01a0f63652400cf590abbd1a6040a2bb7867fa8a` — `P116C4E_UPDATE_PACKAGES_README_SITES_ROOT`

## Latest relevant MAESTRO_WORKSPACE commits

- `6e14f1bc6a3f8a91a98b376c16e7ed17405d4470` — `P116C3O_OPUS_SHARED_CORE_PACKAGES_NO_DUPLICATION_ADR`
- `855a6cb7e8f310139166e2f5b8938dafdc6101a8` — `P116C3O_UPDATE_README_SHARED_CORE_TOPOLOGY`
- `3fa08450fa536e21663fc4c363fc8bf49c1e6451` — `P116C3O_UPDATE_PROJECT_INDEX_SHARED_CORE_TOPOLOGY`
- `012a641f144d99286635ad88d006c155dbdd646b` — `P116C4C_WORKSPACE_ALWAYS_UPDATED_DELIVERY_HANDOFF_ADR`
- `c09107e96682b4a45e76f2abf6c54e04eb0bfce6` — `P116C4C_ADD_CURRENT_WORKSPACE_HANDOFF`
- `5735ddda62fc611d2164192626402f83acd764c9` — `P116C4C_UPDATE_README_MANDATORY_HANDOFF`
- `97376d36c233a50e04a10500113062924e1b3f89` — `P116C4C_UPDATE_PROJECT_INDEX_MANDATORY_HANDOFF`
- `9f390b8424411fedb75a04fdd67e596a713e3321` — `P116C4D_UPDATE_HANDOFF_OPUS_PACKAGE_INSTALLER`
- `2793c54d8f0726b077c1d376fab5d81215eaaa62` — `P116C4E_UPDATE_HANDOFF_OPUS_DELIVERY_TOPOLOGY`
- `THIS_COMMIT` — `P116C4E_UPDATE_HANDOFF_SELF_REFERENCE`

## Next safe step

Run local verification on OPUS, then continue with scorie audits before importing any RefBook content.

Recommended local checks:

```cmd
cd /d H:\UwAmp\www\OPUS
git pull --ff-only
php tools\validate_opus_packages.php
php tools\validate_opus_delivery_layout.php --root=H:\UwAmp\www\OPUS --mode=dev
php tools\install_opus_package.php --package=opus-refbook --target=H:\UwAmp\www\OPUS\sites\opus-refbook --opus-root=H:\UwAmp\www\OPUS --dry-run
```

Then audit `OPUS_REF_BOOK` for Twig, backups, legacy names, CSS overrides, and broken i18n before migration.

## Explicit blockers / unknowns

- The OPUS package validator has not been executed on the user's local clone by the assistant.
- The OPUS delivery layout validator has not been executed on the user's local clone by the assistant.
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
