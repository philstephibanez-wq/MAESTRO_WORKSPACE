# P117 — OPUS Public Operational Release Handoff

Date: 2026-06-16
Status: active handoff

## Decision

The project pivots from RefBook cosmetic work to OPUS public operational release.

OPUS must become operational, documented, secure, deployable on Linux, and then usable by KB and Maestro as fast as possible.

Ultimate objective: return to music composition.

## Repository state at P117 start

```text
OPUS
- root: H:/OPUS
- branch: master
- head: ecec857 P116C5S_ADD_ROUTER_BREADCRUMB_BUILDER
- state: clean according to user git status

OPUS_REF_BOOK
- root: H:/OPUS_REF_BOOK
- branch: main
- head: 5d98059 P116C5U_FIX_REFBOOK_FIXED_SHELL_BREADCRUMB_CSS
- state: clean according to user git status

MAESTRO_WORKSPACE
- root: H:/MAESTRO_WORKSPACE
- branch: master
- head before P117A0: 4295fda P116C5U_UPDATE_HANDOFF_FIXED_SHELL
- state: clean according to user git status
```

## P117A0 delivered in MAESTRO_WORKSPACE

Commits:

```text
255bb05 P117A0_FIX_OPUS_PROJECT_CONTRACT
91adc6e P117A0_FIX_OPUS_REF_BOOK_PROJECT_CONTRACT
6a8b602 P117A0_ADD_OPUS_PUBLIC_RELEASE_CONTRACT
cae5da8 P117A0_ADD_OPUS_PUBLIC_RELEASE_HANDOFF
```

## P117A0B delivered in MAESTRO_WORKSPACE

Commit:

```text
4a58bbc P117A0B_DEFINE_FSM_ACL_SSO_CONTROL_PLANE
```

Decision:

```text
OPUS is an MVC controlled by an explicit FSM/ACL/SSO-like control plane, like an application micro-computer.
```

## P117A0C delivered in MAESTRO_WORKSPACE

Commits:

```text
5a5471d P117A0C_SEPARATE_SECURITY_CONTROL_AND_LSTSAR_TOOL
f2e0547 P117A0C_FIX_OPUS_LAYER_SEPARATION_CONTRACT
```

Decision:

```text
LSTSAR/TLSTSAR is a secured data-driven utility class.
It is not the OPUS security layer.
```

Correct separation:

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
- administrator dashboard
```

Rule:

```text
The control plane protects tools and business utilities.
Tools and business utilities never become the control plane.
```

## Corrected project contracts

- `20_TECHNICAL_FOUNDATIONS/OPUS/PROJECT_CONTRACT.md`
- `20_TECHNICAL_FOUNDATIONS/OPUS_REF_BOOK/PROJECT_CONTRACT.md`
- `20_TECHNICAL_FOUNDATIONS/OPUS/DOC/P117_OPUS_PUBLIC_OPERATIONAL_RELEASE_CONTRACT.md`

The previous OPUS and OPUS_REF_BOOK project contracts were stale and still referenced ASAP / ASAP_REF_BOOK naming. They are corrected in P117A0.

## P117 scope

```text
P117A — OPUS runtime + FSM/ACL/SSO-like security control plane
P117B — Developer documentation useful for public release
P117C — Linux server deployment
P117D — Return to KB and Maestro
```

## OPUS positioning

OPUS is a strict secure-by-contract PHP framework, not a Laravel clone and not a class inventory.

OPUS is an FSM/ACL/SSO-like driven secure MVC framework.

Core pipeline:

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

## Data-driven site objective

OPUS must provide tools to generate and manage a new site from correct configuration and data.

The expected workflow is:

```text
site configuration
-> route declarations
-> FSM/ACL/SSO-like policy declarations
-> controller/view/template bindings
-> generator validation
-> generated or validated site skeleton
-> smoke validation report in MAESTRO_WORKSPACE
```

Invalid or incomplete configuration must stop with explicit diagnostics.

## Administrator dashboard objective

OPUS must provide or support an administrator dashboard for site operators.

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

## Notifications

Blocked states may emit alerts through configured channels such as mail, dashboard, webhook, or internal API.

Notifications are operations/observability. They are not LSTSAR/TLSTSAR and are not the security layer.

## LSTSAR/TLSTSAR

Current project wording may still reference `TLSTSAR`; the concept is a secured data-driven utility class, not the OPUS security layer.

```text
Trace -> Load -> Secure -> Transform -> Store -> Audit -> Report
```

`Report` is mandatory for LSTSAR/TLSTSAR operations.

Reports belong in MAESTRO_WORKSPACE, not in OPUS source roots.

## P117A1 result observed by user

Status: FAIL.

The OPUS official entry point does not boot yet.

Observed blocker:

```text
Opus/Autoload/Autoloader is not resolved by the official OPUS entry point.
```

Observed var tree remains structurally acceptable:

```text
var contains cache and logs.
var/cache contains .gitkeep and opus.
var/logs contains .gitkeep and opus_runtime.log.
```

## Next gate

```text
P117A1B_FIX_OPUS_OFFICIAL_AUTOLOAD_BOOT
```

Goal:

- repair the official OPUS boot path;
- resolve the OPUS autoloader without hidden fallback;
- keep var restricted to cache and logs;
- rerun the runtime smoke;
- produce a new explicit validation report.

## User command after pulling workspace

```cmd
cd /d H:\MAESTRO_WORKSPACE
git pull
```