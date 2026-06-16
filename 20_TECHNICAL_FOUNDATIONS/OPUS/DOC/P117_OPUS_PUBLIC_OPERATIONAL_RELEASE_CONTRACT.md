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

OPUS is a strict, secure-by-contract, FSM/ACL/SSO-like driven MVC framework.

## OPUS core definition

OPUS is an MVC controlled by an explicit FSM/ACL/SSO-like control plane, like an application micro-computer.

```text
FSM = control unit / workflow processor
Route = incoming instruction
Current state = state register
Identity / SSO-like = actor and trust context
ACL = permission circuit
Controller = authorized execution peripheral
ViewModel = structured output memory
ScoreTemplate = display unit
TLSTSAR Report = execution trace and proof
```

## Official request control pipeline

No business route, API endpoint, controller action, rendering path, authorization path, or report path may bypass the control plane.

```text
Request
-> Bootstrap
-> Site resolution
-> Route resolution
-> Identity / SSO-like context
-> FSM decision
-> ACL authorization
-> API token / scope decision when applicable
-> Authorized controller action
-> ViewModel
-> ScoreTemplate or API response
-> TLSTSAR Audit
-> TLSTSAR Report
```

The FSM does not replace ACL or identity. It orchestrates them.

```text
FSM decides whether the action is possible in the current application state.
ACL decides whether the actor has permission to execute the action.
SSO-like identity decides who the actor is and what trust/scopes are attached.
```

## Public-route ergonomics rule

A simple public page must remain easy to create.

The developer may use a short declaration for simple routes, but OPUS must still map it to explicit internal control metadata.

```text
Public route declaration
-> standard public FSM state
-> standard anonymous identity context
-> standard public ACL policy
-> standard public report profile
```

Sensitive routes, admin routes, API routes, KB routes, and Maestro routes must declare the FSM/ACL/SSO-like control metadata explicitly.

## Data-driven site management objective

OPUS must provide tools to generate and manage a new site from correct configuration and data.

The target developer workflow is configuration-first:

```text
site configuration
-> route declarations
-> FSM/ACL/SSO-like policy declarations
-> controller/view/template bindings
-> generated or validated site skeleton
-> smoke report
```

The engine may "eat everything" only if the data and configuration are correct. Invalid or incomplete configuration must stop with an explicit diagnostic and report.

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
- No business route outside FSM/ACL/SSO-like control.
- No API endpoint outside identity/token/scope control.
- No public route without explicit standard public policy.
- No validated action without TLSTSAR Report.

## Immediate next gate

```text
P117A1_OPUS_RUNTIME_SMOKE_AND_VAR_AUDIT
```

This gate must establish the operational runtime baseline before modifying product behavior.
