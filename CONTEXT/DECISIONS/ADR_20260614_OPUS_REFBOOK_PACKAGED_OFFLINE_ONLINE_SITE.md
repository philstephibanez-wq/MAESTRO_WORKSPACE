# ADR 2026-06-14 — OPUS RefBook packaged offline/online official site

## Status

Accepted.

## Context

The current OPUS RefBook stabilization work exposed a structural problem: the RefBook must not be treated as a detached documentation experiment, a static export, or a separate source of truth.

The user clarified the intended product vision:

```text
OPUS RefBook is a full website/application of OPUS.
It is delivered inside the OPUS package.
It runs thanks to OPUS.
It remains a site in its own right.
It can be consulted offline.
It can also be published online.
It can explicitly query GitHub to propose updates.
```

The active framework identity is already locked by ADR `ADR_20260614_OPUS_FRAMEWORK_IDENTITY.md`:

```text
Framework actif : OPUS Framework
Version cible : OPUS 8.1.0 "Lysenko"
ASAP : ancien nom historique, legacy uniquement
```

Therefore the RefBook must document OPUS live/runtime state and must not preserve active ASAP/Twig-era residue.

## Decision

Move the official RefBook source of truth into the OPUS package as a first-class OPUS site/application.

The RefBook must be an OPUS-consuming official site, not core framework internals.

Recommended target structure:

```text
OPUS/
├─ framework/
│  └─ Opus/                         # OPUS framework core
│
├─ sites/
│  └─ opus-refbook/                 # official OPUS RefBook site
│     ├─ public/                    # web entrypoint for local/published use
│     ├─ application/               # controllers, view models, services
│     ├─ resources/
│     │  ├─ score/                  # ScoreTemplate views only
│     │  ├─ i18n/                   # translations
│     │  ├─ css/                    # site CSS
│     │  └─ assets/                 # public assets
│     ├─ config/
│     │  ├─ local.php               # offline/local profile
│     │  ├─ published.php           # public/published profile
│     │  └─ update_sources.php      # explicit update-check sources
│     └─ manifest.opus-refbook.json
│
├─ tools/
│  └─ refbook/                      # build, smoke, publish, update checks
│
├─ tests/
├─ LICENSE
├─ NOTICE
├─ COPYRIGHT.md
└─ TRADEMARKS.md
```

## Product contract

### 1. RefBook is a real OPUS site

The RefBook must:

- run through OPUS routing/controllers/view-models/rendering;
- use ScoreTemplate as its view layer;
- use OPUS I18N contracts;
- use OPUS asset contracts;
- use OPUS diagnostics where appropriate;
- document OPUS with OPUS.

It must not be reduced to static Markdown, a generated dump, or an external documentation-only repository.

### 2. RefBook is packaged with OPUS

The OPUS package must include the RefBook site so that the installed package can document itself offline.

The packaged RefBook documents the installed OPUS version and must expose its local version clearly.

### 3. RefBook is offline-first

The RefBook must work without Internet access.

Internet absence must never break the local documentation site.

Allowed offline behavior:

```text
- show installed OPUS version;
- show installed RefBook version;
- show local documentation;
- show update-check status as unavailable/not checked;
- preserve all normal navigation.
```

Forbidden offline behavior:

```text
- blocking page load because GitHub is unreachable;
- hidden network dependency;
- silent fallback to stale online content;
- stack traces in public UI.
```

### 4. RefBook can be published online

The same RefBook source must support a published profile.

Example targets:

```text
https://opus.logandplay.org/
https://logandplay.org/opus/refbook/
```

Published mode must not expose local machine paths, debug traces, secrets, private diagnostics, development-only commands, or admin controls.

### 5. GitHub update checks are explicit and non-destructive

The RefBook may query GitHub to propose available updates, but only through a clear, explicit update-check contract.

Requirements:

- no mandatory online call to display local docs;
- no hidden destructive update;
- no automatic replacement without user confirmation;
- clear provenance;
- clear installed version vs latest available version;
- cache of the last update check where useful;
- explicit unavailable state if GitHub/network is not reachable.

Recommended manifest contract:

```json
{
  "schema": "OPUS_RELEASE_MANIFEST_V1",
  "opus_version": "8.1.0",
  "opus_codename": "Lysenko",
  "refbook_version": "8.1.0",
  "release_channel": "stable",
  "commit_sha": "...",
  "published_at": "...",
  "minimum_php_version": "...",
  "checksum": "...",
  "changelog_url": "...",
  "download_url": "..."
}
```

### 6. Open-source and authorship policy

The user wants to be able to make OPUS open source while preserving authorship, copyright, project identity and paternity.

Workspace consequence:

- OPUS must include explicit `LICENSE`, `NOTICE`, `COPYRIGHT.md` and `TRADEMARKS.md` files before public distribution finalization;
- RefBook pages must display copyright/attribution consistently;
- OPUS name/logo/brand policy must be separate from the code license;
- no license assumption may be hardcoded without an accepted licensing ADR.

A later dedicated licensing ADR must select the exact license(s) for code, documentation, branding and examples.

## Clean deliverable contract

OPUS RefBook active source must be clean and deliverable:

```text
0 *.twig in active RefBook source
0 Twig runtime dependency for RefBook rendering
0 Twig compatibility alias in active RefBook runtime
0 legacy/backup folder carrying old templates
0 .old / .bak / _legacy source kept as workaround
0 silent fallback
0 stale ASAP active wording
0 dead CSS override stack
```

Git history is the archive. The active workspace is the deliverable.

## Migration contract

The future migration from `OPUS_REF_BOOK` to `OPUS/sites/opus-refbook` must be done as a controlled migration, not as live patch accumulation.

Minimum migration gates:

1. freeze and audit the current OPUS_REF_BOOK state;
2. identify the local folder actually served by UwAmp;
3. remove all active Twig templates and references;
4. restore a stable RefBook layout contract;
5. fix I18N keys such as `symbol.role` at source;
6. create OPUS internal site target structure;
7. move only clean, necessary RefBook files;
8. add local smoke scripts;
9. add published-mode smoke scripts;
10. verify offline mode;
11. verify published profile does not expose local/dev data;
12. only then deprecate the external `OPUS_REF_BOOK` repository as source of truth.

## UI layout baseline for the next clean reset

The next RefBook UI reset must use this baseline, without incremental CSS patch stacking:

```text
<header>
  line 1: brand/logo/title left, search/theme/language controls right
  line 2: primary navigation menu only
</header>

<main class="content">
  page content only
</main>
```

No left menu/sidebar may be injected into the content area.

Long lists such as domains/symbols must be rendered as pages, panels, or controlled menus, not as overflowing header lists.

## Consequences

- `OPUS_REF_BOOK` must stop being the long-term source of truth.
- OPUS package becomes the canonical home for the RefBook application.
- The RefBook remains a site, not framework core code.
- Offline documentation is a required feature.
- Online publication is a supported deployment profile.
- GitHub update checks become explicit product functionality.
- No new RefBook UI patch should be accepted before the clean reset/audit phase.

## Canonical resume wording

```text
OPUS RefBook is the official OPUS documentation website/application.
It is packaged inside OPUS.
It runs thanks to OPUS.
It remains separate from OPUS framework core.
It works offline.
It can be published online.
It may explicitly check GitHub for updates.
The active RefBook source must be clean, Twig-free, fallback-free and deliverable.
```
