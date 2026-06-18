# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart from this file without relying on hidden conversation memory.

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
1. P117SITE10 — clean workspace references and optional Apache backup cleanup.
2. RefBook HEAD handling — make curl -I / HTTP HEAD return a clean response.
3. Local UwAmp IPv6 policy — plain curl may prefer IPv6 and timeout; use curl.exe -4 for validation until fixed.
4. Continue OPUS public/preprod hardening and Cloudflare path after workspace is clean.
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
| MAESTRO_WORKSPACE | Contracts, decisions, handoffs | Updated for OPUS system site integration |
| OPUS | Framework core + integrated system sites | RefBook and Log&Play integrated under `sites/` |
| MAESTRO_V5 | REAPER/Lua music assistant | Active, not publicly exposed |
| MO_KB_DAEMON | Music KB backend/workers | Active private, not publicly exposed |
| MO_KB_FRONT | KB front/backoffice | To align later |

## Required reading for details

```text
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
