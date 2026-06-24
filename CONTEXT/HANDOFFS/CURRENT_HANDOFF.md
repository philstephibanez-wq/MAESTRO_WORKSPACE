# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart from this file without relying on hidden conversation memory.

## Permanent delivery rule — contract-first, no bricolage

```text
NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
SLOWER IS ACCEPTABLE; WASTING USER TIME IS NOT.
```

Future deliveries must be contract-first. Do not use quick visual hacks, isolated-page patches, ad hoc runners, hidden fallbacks, or file moves that bypass official responsibilities.

For OPUS / ASAP-style work, sites are applications with modules, routes, controllers, services, view models, templates, resources, I18N/theme contracts, and FSM/transition contracts when present. If the application contract is missing or inconsistent, the next step is audit and alignment plan, not a patch.

## Permanent OPUS Score-first MVC data contract

OPUS is an applicative web framework. Its rendered product is HTML produced by `.score` templates, not layout encoded in PHP or JSON.

```text
Data source
  -> Provider / Repository / Adapter
  -> Business service
  -> Validation / transformation / enrichment
  -> ViewModel
  -> .score template
  -> HTML
```

Rules:

```text
No PHP HTML assembly.
No JSON layout disguised as data.
No template querying databases, APIs or files directly.
No controller doing business rendering.
No service rendering HTML.
No module page without .score.
No manual page creation outside OPUS generators.
```

Canonical decisions:

```text
CONTEXT/DECISIONS/ADR_20260619_CONTRACT_FIRST_NO_BRICOLAGE.md
CONTEXT/DECISIONS/ADR_20260619_OPUS_COMPOSER_GENERATORS_AND_KB_FRONT_SITES.md
CONTEXT/DECISIONS/ADR_20260619_OPUS_SCORE_FIRST_MVC_SOURCE_AGNOSTIC_DATA.md
```

## Current validated OPUS state — P6B

```text
OPUS root      : H:\OPUS
OPUS GitHub    : philstephibanez-wq/OPUS
Workspace root : H:\MAESTRO_WORKSPACE
Workspace repo : philstephibanez-wq/MAESTRO_WORKSPACE
```

Validated OPUS runtime cleanup:

```text
545b40b P6A_REMOVE_LEGACY_RUNTIME_BOUNDARY
20febaa P6A_REMOVE_RESIDUAL_LEGACY_AUTOLOADER_NEW2
470a755 P6A_FIX_LEGACY_REMOVAL_SMOKE_CONTRACT
05fbe29 P6B_ARCHIVE_P6A_MIGRATION
```

Runtime state:

```text
Opus/Legacy removed from Git and disk.
Opus/Runtime/Application.php is active.
Opus/Runtime/Bootstrap.php remains stable.
www/index.php is Composer-only.
tools/archive/p6_migrations/apply_p6a_remove_legacy_runtime_boundary.py is archived and recognized by the tools layout smoke.
```

Validated checks:

```text
P3B_OPUS_TOOLS_LAYOUT_SMOKE_OK
P5B_CURRENT_RUNTIME_LAYOUT_SMOKE_OK
P5E_BOOTSTRAP_READINESS_AUDIT_OK
P5G_LEGACY_AUTOLOADER_BOOTSTRAP_BRIDGE_AUDIT_OK
P5H_BOOTSTRAP_MOVE_DESIGN_AUDIT_OK
git status clean
```

Important regression guard:

```text
H:\OPUS\Opus\Legacy must not be recreated.
Any runtime reference to Opus/Legacy is a P6 regression unless it is explicitly historical inside tools/archive or documentation.
```

Specific handoff:

```text
CONTEXT/HANDOFFS/P6B_20260624_OPUS_LEGACY_REMOVED.md
```

## Integrated OPUS sites

```text
RefBook  : H:\OPUS\sites\opus-refbook
Log&Play : H:\OPUS\sites\logandplay
```

Former standalone local roots are historical only and must not be recreated:

```text
H:\OPUS_REF_BOOK
H:\LOGANDPLAY.ORG
```

## Immediate next work

```text
1. P6C_SELECT_NEXT_RUNTIME_CLEANUP_TARGET.
2. Do not touch Bootstrap again unless a new audit proves a blocker.
3. Preferred P6C choices:
   - create/rename permanent P6 runtime smoke/audit for Composer-only www and no Opus/Legacy;
   - archive or supersede stale legacy-oriented P5 audits only after replacement guards exist;
   - clean historical docs that still mention legacy paths as active state;
   - continue OPUS site/generator contract only after runtime cleanup target is chosen.
4. Keep workspace and CURRENT_HANDOFF updated at every validated delivery step.
```

## Repository write policy

```text
MAESTRO_WORKSPACE : assistant may write directly to GitHub for contracts, ADRs, handoffs and project context updates when the user asks to memorize/record/update workspace.
OPUS              : no direct assistant write/commit/push; local runners only, then user validates and commits/pushes.
All repositories  : no direct mutation outside the explicitly authorized scope.
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
| MAESTRO_WORKSPACE | Contracts, decisions, handoffs | Updated for OPUS P6B legacy runtime removal |
| OPUS | Framework core + integrated system sites | Runtime P6B clean: no Opus/Legacy, Composer-only www, Runtime/Application active |
| KB_FRONT_OFFICE | Future public/controlled KB site | Must be OPUS site/application, generated through OPUS generators and rendered through Score-first MVC pipeline |
| KB_BACK_OFFICE | Future administrative KB site | Must be OPUS site/application, generated through OPUS generators and rendered through Score-first MVC pipeline |
| MAESTRO_V5 | REAPER/Lua music assistant | Active, not publicly exposed |
| MO_KB_DAEMON | Music KB backend/workers | Active private, not publicly exposed |
| MO_KB_FRONT | Historical/current KB front/backoffice context | To be split/aligned toward KB_FRONT_OFFICE and KB_BACK_OFFICE OPUS sites |

## Required reading for details

```text
CONTEXT/HANDOFFS/P6B_20260624_OPUS_LEGACY_REMOVED.md
CONTEXT/DECISIONS/ADR_20260619_CONTRACT_FIRST_NO_BRICOLAGE.md
CONTEXT/DECISIONS/ADR_20260619_OPUS_COMPOSER_GENERATORS_AND_KB_FRONT_SITES.md
CONTEXT/DECISIONS/ADR_20260619_OPUS_SCORE_FIRST_MVC_SOURCE_AGNOSTIC_DATA.md
CONTEXT/DECISIONS/ADR_20260618_OPUS_SYSTEM_SITES_INTEGRATED.md
CONTEXT/PROJECTS/PROJECT_INDEX.md
CONTEXT/PROJECTS/LOGANDPLAY.md
```

## Command policy reminder

Commands must always be labeled by environment:

```text
[PC WINDOWS - DEV]
[PC WINDOWS - PowerShell Administrateur]
[PC WINDOWS - NAVIGATEUR]
[SERVEUR LINUX - PRÉPROD]
```
