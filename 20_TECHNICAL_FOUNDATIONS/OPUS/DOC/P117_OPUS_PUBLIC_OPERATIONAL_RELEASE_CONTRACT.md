# P117 — OPUS Public Operational Release Contract

Status: active planning contract
Date: 2026-06-16
Scope: OPUS, OPUS_REF_BOOK, SERVER_LINUX, MO_KB, MAESTRO_V5_REAPER, MAESTRO_WORKSPACE

## Ultimate objective

Return to music composition as quickly as possible by making OPUS operational, documented, deployable, and usable again by KB and Maestro.

## Product objective

OPUS must be deliverable as a public PHP framework with integrated secure-by-design control, useful developer documentation, Linux deployment guidance, and data-driven site generation/management tools.

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

### P117A — OPUS operational runtime and secure control baseline

Required:

- OPUS boots from its official entry point.
- Autoload uses the official OPUS runtime path.
- `var` remains restricted to `var/cache` and `var/logs`.
- MVC pipeline is demonstrable.
- ScoreTemplate rendering is demonstrable.
- FSM control gate is demonstrable.
- ACL gate is demonstrable.
- Identity / authentication / SSO-like token and scope gate is specified and demonstrable.
- Fail-closed blocked states are specified and demonstrable.
- Admin alert event model is specified for blocked states.
- Native OPUS administrator dashboard ViewModels are specified and demonstrable.
- LSTSAR/TLSTSAR remains a secured utility class, not the security layer.

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
- Use LSTSAR/TLSTSAR as a data-driven utility class when relevant.
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
- generated report when applicable to that method or tool.

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
Authentication = proof of identity
ACL = permission circuit
Controller = authorized execution peripheral
ViewModel = structured output memory
ScoreTemplate = display unit
Observability = logs, audit events, reports, notifications
LSTSAR/TLSTSAR = secured data-driven utility class, not security layer
```

## Strict layer separation

OPUS must not mix responsibilities between layers.

```text
CONTROL PLANE
- FSM
- ACL
- SSO-like identity
- authentication
- authorization
- scopes
- blocked states

MVC RUNTIME
- site resolution
- route resolution
- controllers
- ViewModels
- ScoreTemplate
- HTTP/API responses

TOOLS / BUSINESS UTILITIES
- LSTSAR/TLSTSAR
- site generators
- loaders
- transformers
- stores
- KB tools
- Maestro tools

OBSERVABILITY / OPERATIONS
- logs
- reports
- audits
- notifications
- native administrator dashboard
```

Rule:

```text
The control plane protects tools and business utilities.
Tools and business utilities never become the control plane.
```

## Official request control pipeline

No business route, API endpoint, controller action, rendering path, authorization path, generator action, dashboard action, or tool invocation may bypass the control plane.

```text
Request
-> Bootstrap
-> Site resolution
-> Route resolution
-> Identity / SSO-like context
-> Authentication decision
-> FSM decision
-> ACL authorization
-> API token / scope decision when applicable
-> Authorized controller action
-> Optional authorized tool invocation
-> ViewModel
-> ScoreTemplate or API response
-> Observability event / report when applicable
```

The FSM does not replace ACL or identity. It orchestrates the control context.

```text
FSM decides whether the action is possible in the current application state.
ACL decides whether the actor has permission to execute the action.
SSO-like identity decides who the actor is and what trust/scopes are attached.
```

## Fail-closed security rule

The FSM is central to security. If an unexpected, strange, incomplete, inconsistent, or suspicious situation occurs, OPUS must stop in an explicit blocked state.

Examples:

```text
UNKNOWN_ROUTE_BLOCKED
CONFIG_BLOCKED
AUTH_BLOCKED
ACL_BLOCKED
FSM_TRANSITION_BLOCKED
API_SCOPE_BLOCKED
INTEGRITY_BLOCKED
TOOL_INVOCATION_BLOCKED
```

No silent recovery, no hidden retry, no implicit permission, no guessed configuration, and no automatic unlock are allowed.

## Public-route ergonomics rule

A simple public page must remain easy to create.

The developer may use a short declaration for simple routes, but OPUS must still map it to explicit internal control metadata.

```text
Public route declaration
-> standard public FSM state
-> standard anonymous identity context
-> standard public ACL policy
-> standard public observability profile
```

Sensitive routes, admin routes, API routes, KB routes, Maestro routes, generator routes, and tool invocations must declare the FSM/ACL/SSO-like control metadata explicitly.

## Public error opacity rule

Public users must never receive technical, security, configuration, routing, authentication, authorization, FSM, ACL, API, filesystem, class, database, stack trace, or tool diagnostics.

The only public blocked-state message authorized for a generic site block is:

```text
Site temporairement bloqué.
Contactez le support.
```

All actionable detail must remain private to protected admin surfaces, internal logs, audit events, or secured support workflows.

## Data-driven site management objective

OPUS must provide tools to generate and manage a new site from correct configuration and data.

The target developer workflow is configuration-first:

```text
site configuration
-> route declarations
-> FSM/ACL/SSO-like policy declarations
-> controller/view/template bindings
-> generator validation
-> generated or validated site skeleton
-> smoke validation report in MAESTRO_WORKSPACE
```

The engine may "eat everything" only if the data and configuration are correct. Invalid or incomplete configuration must stop with an explicit diagnostic.

## Native administrator dashboard objective

OPUS must provide a native integrated administrator dashboard for site operators.

The dashboard is not an external add-on and is not an optional bypass surface. It is part of the OPUS operational product.

The dashboard is an OPUS application protected by the same FSM/ACL/SSO-like control plane.

It may expose authorized operations such as:

```text
ADMIN_VIEW_SITE_STATE
ADMIN_VIEW_BLOCKED_STATES
ADMIN_ACKNOWLEDGE_ALERT
ADMIN_RELOAD_CONFIG
ADMIN_RUN_SITE_AUDIT
ADMIN_UNLOCK_BLOCKED_SITE
ADMIN_REPLAY_FAILED_JOB
```

Each dashboard action must be a declared route/intention/transition/permission, not a bypass.

Dashboard ViewModels may expose actionable diagnostics to administrators only after the administrator route itself has passed the OPUS control plane.

Dashboard data must never be reused in public responses.

## Notifications

Blocked states may emit alerts through configured channels such as mail, dashboard, webhook, or internal API.

Notifications are operations/observability. They are not LSTSAR/TLSTSAR and are not the security layer.

Notifications must carry an event id or report id when available, plus the expected manual intervention.

## LSTSAR/TLSTSAR definition

Current project wording may still reference `TLSTSAR`; the concept is a secured data-driven utility class, not the OPUS security layer.

```text
Trace -> Load -> Secure -> Transform -> Store -> Audit -> Report
```

`Report` is mandatory for LSTSAR/TLSTSAR operations.

A LSTSAR/TLSTSAR validation without an exploitable report is not valid.

Workspace validation and release reports belong in MAESTRO_WORKSPACE, not in OPUS product roots.

## Documentation hygiene rule

OPUS root `DOC` is reserved for stable documentation entry points.

Per-gate smoke notes, validation reports, patch notes and runtime handoffs must not be accumulated directly under OPUS root `DOC`.

P117 runtime validation reports live in MAESTRO_WORKSPACE handoffs. If OPUS needs an internal pointer, it must be grouped under a dedicated subdirectory such as:

```text
DOC/patches/P117/
```

## Non-negotiable rules

- No silent fallback.
- No hidden alternate path.
- No invented documentation content.
- No empty public documentation sections.
- No broad refactor without explicit validation.
- No source root pollution with patch runners or temporary reports.
- No OPUS root `DOC` pollution with per-gate smoke notes.
- No documentation-first detour that blocks OPUS runtime and KB/Maestro return.
- No business route outside FSM/ACL/SSO-like control.
- No API endpoint outside identity/token/scope control.
- No public route without explicit standard public policy.
- No public technical diagnostic leakage.
- No authorized tool invocation outside FSM/ACL/SSO-like control.
- No dashboard action outside FSM/ACL/SSO-like control.
- No native dashboard data leak to public responses.
- No LSTSAR/TLSTSAR operation without its own Report.
- No release gate without a MAESTRO_WORKSPACE validation report.

## Runtime validated gates

```text
P117A1B_FIX_OPUS_OFFICIAL_AUTOLOAD_BOOT
P117A2_OPUS_PUBLIC_ROUTE_MVC_SMOKE
P117A3_FSM_BLOCKED_STATE_EVENT_MODEL
P117A4_ADMIN_BLOCKED_STATE_DASHBOARD_VIEWMODEL
P117A5_NATIVE_ADMIN_DASHBOARD_ROUTE_SMOKE
P117A6_NATIVE_ADMIN_DASHBOARD_RENDERED_RESPONSE_SMOKE
P117A7_NATIVE_ADMIN_DASHBOARD_SCREEN_STRUCTURE_SMOKE
P117A8_NATIVE_ADMIN_DASHBOARD_ACTION_CONTROL_SMOKE
```

## Immediate next gate

```text
P117A9_NATIVE_ADMIN_DASHBOARD_ACTION_AUDIT_SMOKE
```

This gate must prove that authorized native administrator dashboard actions emit protected audit/observability data and that denied callers still receive only the public opaque support response.
