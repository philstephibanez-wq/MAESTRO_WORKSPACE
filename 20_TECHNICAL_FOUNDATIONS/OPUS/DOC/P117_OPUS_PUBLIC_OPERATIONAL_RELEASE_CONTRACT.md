# P117 — OPUS Public Operational Release Contract

Status: active planning contract
Date: 2026-06-16
Scope: OPUS, OPUS_REF_BOOK, SERVER_LINUX, MO_KB, MAESTRO_V5_REAPER, MAESTRO_WORKSPACE

## Ultimate objective

Return to music composition as quickly as possible by making OPUS operational, documented, deployable, and usable again by KB and Maestro.

## Product objective

OPUS must be deliverable as a public PHP framework with integrated security and useful developer documentation.

This release is not a RefBook cosmetic effort.

## Current repository state at P117 start

```text
OPUS
- root: H:\OPUS
- branch: master
- head: ecec857 P116C5S_ADD_ROUTER_BREADCRUMB_BUILDER
- state: clean according to user git status

OPUS_REF_BOOK
- root: H:\OPUS_REF_BOOK
- branch: main
- head: 5d98059 P116C5U_FIX_REFBOOK_FIXED_SHELL_BREADCRUMB_CSS
- state: clean according to user git status

MAESTRO_WORKSPACE
- root: H:\MAESTRO_WORKSPACE
- branch: master
- head before P117A0: 4295fda P116C5U_UPDATE_HANDOFF_FIXED_SHELL
- state: clean according to user git status
```

## P117 release gates

### P117A — OPUS operational runtime and security baseline

Required:

- OPUS boots from its official entry point.
- Autoload uses the official OPUS runtime path.
- `var` remains restricted to `var/cache` and `var/logs`.
- MVC pipeline is demonstrable.
- ScoreTemplate rendering is demonstrable.
- FSM gate is demonstrable.
- ACL gate is demonstrable.
- API identity / SSO-style token and scope gate is specified and demonstrable.
- TLSTSAR Report output exists for validation.

### P117B — Developer documentation

Required:

- Quickstart.
- Create a site.
- Create a route.
- Create a controller.
- Build a ViewModel.
- Render a `.score` page.
- Secure a route with FSM and ACL.
- Expose an API endpoint with identity/token/scope checks.
- Understand TLSTSAR with Report.
- Deploy on Linux.
- API reference as appendix only.

Every documented method must explain:

- purpose;
- normal caller;
- when to use;
- parameters and meaning;
- return value and meaning;
- explicit errors;
- example;
- related workflow or recipe;
- generated report when applicable.

### P117C — Linux deployment

Required:

- Debian stable preferred.
- Minimal installation documented.
- HTTPS before public exposure.
- No public admin surface.
- Frameworks separated from exposed sites.
- Explicit paths.
- Logs and backup policy.

### P117D — Return to KB and Maestro

Required:

- OPUS readiness consumed by KB planning.
- OPUS readiness consumed by Maestro planning.
- No RefBook cosmetic work blocks KB/Maestro after P117B minimum documentation is valid.

## Security positioning

OPUS is not positioned as a Laravel clone.

OPUS is a strict, secure-by-contract framework with an official request pipeline:

```text
Request
-> Site resolution
-> Router
-> FSM gate
-> ACL gate
-> API identity / token / scope gate when applicable
-> Controller
-> ViewModel
-> ScoreTemplate
-> Response
-> Audit / Report
```

## TLSTSAR definition

```text
Trace -> Load -> Secure -> Transform -> Store -> Audit -> Report
```

`Report` is mandatory.

A validation without an exploitable report is not valid.

Reports belong in MAESTRO_WORKSPACE, not in OPUS product roots.

## Non-negotiable rules

- No silent fallback.
- No hidden alternate path.
- No invented documentation content.
- No empty public documentation sections.
- No broad refactor without explicit validation.
- No source root pollution with patch runners or temporary reports.
- No documentation-first detour that blocks OPUS runtime and KB/Maestro return.

## Immediate next gate

```text
P117A1_OPUS_RUNTIME_SMOKE_AND_VAR_AUDIT
```

This gate must establish the operational runtime baseline before modifying product behavior.
