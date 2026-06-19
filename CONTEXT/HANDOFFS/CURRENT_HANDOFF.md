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

## Permanent OPUS Score-first MVC data contract

OPUS is an applicative web framework. Its primary rendered product is HTML produced by `.score` templates, not layout encoded in PHP or JSON.

```text
.score
= declarative HTML structure, visual composition, variables, loops, conditions, partials and components.

i18n
= translated strings, labels, interface text and simple starter copy.

data
= normalized data prepared for rendering, regardless of original source.
```

Data sources are source-agnostic. A module may receive data from file, JSON, XML, database, API, cache, KB, internal service, or any other explicit provider. The rendering layer must not care about the original source.

Mandatory MVC pipeline:

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

JSON, XML, BDD/API payloads and file-backed content are valid only as data sources or transport formats. They must be normalized by the framework before reaching `.score`.

Canonical decision:

```text
CONTEXT/DECISIONS/ADR_20260619_OPUS_SCORE_FIRST_MVC_SOURCE_AGNOSTIC_DATA.md
```

## Permanent OPUS site creation rule — Composer + generators

OPUS differs from ASAP mainly by using Composer for package/autoload orchestration and by avoiding external dependencies whenever possible.

No OPUS site, module, page, route, transition, locale, asset, or `.score` template may be created manually as an isolated file.

Creation must go through OPUS contractual generators, for example:

```text
composer opus -- create:site <site>
composer opus -- create:module <site> <module>
composer opus -- create:page <site> <module> <page>
composer opus -- create:route <site> <module> <page> <path>
composer opus -- create:transition <site> <module> <from-state> <signal> <to-state>
composer opus -- create:locale <site> <module> <locale>
composer opus -- create:asset <site> <module> <asset-type>
composer opus -- create:template <site> <module> <template-kind> <name>
```

External dependencies are exceptions only: explicit justification, license verification, version lock, security review, offline/local behavior review, no runtime network dependency, and user validation.

`KB_FRONT_OFFICE` and `KB_BACK_OFFICE` are future OPUS sites/applications. They must follow the OPUS application/module/generator/ScoreTemplate/MVC data contract and must not be built as bricolage pages or unrelated standalone UIs.

Canonical decisions:

```text
CONTEXT/DECISIONS/ADR_20260619_CONTRACT_FIRST_NO_BRICOLAGE.md
CONTEXT/DECISIONS/ADR_20260619_OPUS_COMPOSER_GENERATORS_AND_KB_FRONT_SITES.md
CONTEXT/DECISIONS/ADR_20260619_OPUS_SCORE_FIRST_MVC_SOURCE_AGNOSTIC_DATA.md
```

## Current validated state — P117SITE12

OPUS is now the source of truth for its system sites and is gaining a contractual Composer generator layer.

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

Validated OPUS commits from earlier integration:

```text
6eb7a1d P117SITE7_REFBOOK_INTEGRATED_IN_OPUS
96d2f7a P117SITE8_LOGANDPLAY_INTEGRATED_IN_OPUS
```

Recent P117SITE12 generator progress validated locally:

```text
create-site        : creates OPUS site skeleton with common layer, modules, routes and starter layout.
create-module      : creates a pre-populated module directory.
add-language       : incrementally adds a locale without recreating the site.
language selector  : autonym labels and persistent navigation language are required.
serve-site         : must serve an existing site; create-site must remain creation-only.
validate-site      : must verify OPUS site contract.
```

Important runtime note: if non-command text is pasted into CMD after a runner, CMD may print harmless errors such as `.score is not recognized`. The runner result must be read from the actual script output before those pasted prose lines.

## Immediate next work

```text
1. Finish P117SITE12M validation: serve-site + validate-site on the current skeleton.
2. P117SITE12N: bring the skeleton into the Score-first MVC data contract.
3. Remove layout/content hardcoding from resources/content JSON.
4. Keep starter HTML structure in .score templates.
5. Keep starter strings in i18n files.
6. Keep business/editorial/API/BDD/XML/file data source-agnostic through provider/service/view-model.
7. Then add list-sites/list-modules/list-languages.
8. Then create-route and route-based menu.
9. Then migrate Log&Play, RefBook, KB_FRONT_OFFICE and KB_BACK_OFFICE through generators/patches, never as manual pages.
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
| MAESTRO_WORKSPACE | Contracts, decisions, handoffs | Updated for contract-first, OPUS/ASAP module inheritance, ScoreTemplate, Composer/generator, KB front/back office, and Score-first MVC source-agnostic data rules |
| OPUS | Framework core + integrated system sites | RefBook and Log&Play integrated under `sites/`; P117SITE12 generator foundation underway |
| KB_FRONT_OFFICE | Future public/controlled KB site | Must be OPUS site/application, generated through OPUS generators and rendered through Score-first MVC pipeline |
| KB_BACK_OFFICE | Future administrative KB site | Must be OPUS site/application, generated through OPUS generators and rendered through Score-first MVC pipeline |
| MAESTRO_V5 | REAPER/Lua music assistant | Active, not publicly exposed |
| MO_KB_DAEMON | Music KB backend/workers | Active private, not publicly exposed |
| MO_KB_FRONT | Historical/current KB front/backoffice context | To be split/aligned toward KB_FRONT_OFFICE and KB_BACK_OFFICE OPUS sites |

## Required reading for details

```text
CONTEXT/DECISIONS/ADR_20260619_CONTRACT_FIRST_NO_BRICOLAGE.md
CONTEXT/DECISIONS/ADR_20260619_OPUS_COMPOSER_GENERATORS_AND_KB_FRONT_SITES.md
CONTEXT/DECISIONS/ADR_20260619_OPUS_SCORE_FIRST_MVC_SOURCE_AGNOSTIC_DATA.md
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
