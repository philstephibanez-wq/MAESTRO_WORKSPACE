# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart from this file without relying on hidden conversation memory.

## Permanent delivery rule — contract-first, no bricolage

```text
NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
SLOWER IS ACCEPTABLE; WASTING USER TIME IS NOT.
```

Every future delivery must be contract-first. Do not try to please the user with quick fixes, improvised visual tweaks, isolated-page patches, local hacks, intrusive browser launches, or ad hoc runners when the correct work is architectural or contractual.

For OPUS / ASAP-style work, sites must be treated as applications with modules, routes, controllers, services, view models, templates, resources, I18N/theme contracts, and FSM/transition contracts when present. If the application contract is missing or inconsistent, the next step is audit and alignment plan, not a patch.

ASAP-derived application principle to preserve in OPUS: an application has common parts inherited by all modules, and each module owns only its business-specific ACL, helpers, CSS/assets, JavaScript, local/I18N, models/services, controllers, views/view-models and `.score` templates. Common parts must be factored in the application/framework common layer, not duplicated in every module.

ScoreTemplate is mandatory for OPUS application/site rendering: no `.score` template means no conforming OPUS page.

Canonical decision: `CONTEXT/DECISIONS/ADR_20260619_CONTRACT_FIRST_NO_BRICOLAGE.md`.

## Current validated state — P117SITE9

OPUS is now the source of truth for its system sites.

```text
OPUS root      : H:\OPUS
OPUS GitHub    : philstephibanez-wq/OPUS
Workspace root : H:\MAESTRO_WORKSPACE
```

Integrated OPUS sites:

```text
RefBook  : H:\OPUS\sites\opus-refbook
Log&Play : H:\OPUS\sites\logandplay
```

Local UwAmp bindings:

```text
refbook.opus.localhost -> H:\OPUS\sites\opus-refbook\public
logandplay.localhost   -> H:\OPUS\sites\logandplay\public
localhost              -> UwAmp default page
```

Former standalone local roots are historical only and must not be recreated:

```text
H:\OPUS_REF_BOOK
H:\LOGANDPLAY.ORG
```

The autonomous GitHub repositories for those former roots were removed by the user. Future work must target `H:\OPUS\sites\...`.

Validated OPUS commits:

```text
6eb7a1d P117SITE7_REFBOOK_INTEGRATED_IN_OPUS
96d2f7a P117SITE8_LOGANDPLAY_INTEGRATED_IN_OPUS
```

## Immediate next work

```text
1. P117SITE12 — audit and align OPUS site application contracts before any further patch.
2. Define the common OPUS site structure from the real OPUS/ASAP contract.
3. Align Log&Play and RefBook as applications, not isolated pages.
4. Enforce modules with inherited common resources plus business-specific module resources.
5. Enforce ScoreTemplate .score rendering for all OPUS pages.
6. Then correct browser/runtime symptoms only after the application contract is coherent.
```

## Current source-of-truth rule

```text
OPUS code and OPUS-owned sites : philstephibanez-wq/OPUS
Workspace context              : philstephibanez-wq/MAESTRO_WORKSPACE
No direct work on removed roots : H:\OPUS_REF_BOOK, H:\LOGANDPLAY.ORG
```

## Active repositories / projects

| Repository / Project | Role | Current state |
|---|---|---|
| MAESTRO_WORKSPACE | Contracts, decisions, handoffs | Updated for OPUS system site integration, contract-first/no-bricolage rule, and ASAP module inheritance model |
| OPUS | Framework core + integrated system sites | RefBook and Log&Play integrated under `sites/`; site contracts require P117SITE12 alignment |
| MAESTRO_V5 | REAPER/Lua music assistant | Active, not publicly exposed |
| MO_KB_DAEMON | Music KB backend/workers | Active private, not publicly exposed |
| MO_KB_FRONT | KB front/backoffice | To align later |

## Required reading for details

```text
CONTEXT/DECISIONS/ADR_20260619_CONTRACT_FIRST_NO_BRICOLAGE.md
CONTEXT/DECISIONS/ADR_20260618_OPUS_SYSTEM_SITES_INTEGRATED.md
CONTEXT/HANDOFFS/P117SITE9_OPUS_SITE_INTEGRATION_WORKSPACE_UPDATE.md
CONTEXT/PROJECTS/PROJECT_INDEX.md
CONTEXT/PROJECTS/LOGANDPLAY.md
CONTEXT/HANDOFFS/P117_20260617_OPUS_LINUX_BASELINE_SMTP_NTP.md
CONTEXT/HANDOFFS/P117_20260617_OPUS_LINUX_DNS_SECURITY_UFW.md
CONTEXT/HANDOFFS/P117_OPUS_PUBLIC_OPERATIONAL_RELEASE.md
```

## Command policy reminder

Commands must always be labeled by environment:

```text
[PC WINDOWS - DEV]
[PC WINDOWS - PowerShell Administrateur]
[PC WINDOWS - NAVIGATEUR]
[SERVEUR LINUX - PRÉPROD]
```
