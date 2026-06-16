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

Consequence:

```text
No business route, API endpoint, controller action, rendering path, authorization path, or report path may bypass the control plane.
```

## Corrected project contracts

- `20_TECHNICAL_FOUNDATIONS/OPUS/PROJECT_CONTRACT.md`
- `20_TECHNICAL_FOUNDATIONS/OPUS_REF_BOOK/PROJECT_CONTRACT.md`
- `20_TECHNICAL_FOUNDATIONS/OPUS/DOC/P117_OPUS_PUBLIC_OPERATIONAL_RELEASE_CONTRACT.md`

The previous OPUS and OPUS_REF_BOOK project contracts were stale and still referenced ASAP / ASAP_REF_BOOK naming. They are corrected in P117A0.

## P117 scope

```text
P117A — OPUS runtime + security + TLSTSAR Report
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
-> FSM decision
-> ACL authorization
-> API token / scope decision when applicable
-> Authorized controller action
-> ViewModel
-> ScoreTemplate or API response
-> TLSTSAR Audit
-> TLSTSAR Report
```

## Data-driven site objective

OPUS must provide tools to generate and manage a new site from correct configuration and data.

The expected workflow is:

```text
site configuration
-> route declarations
-> FSM/ACL/SSO-like policy declarations
-> controller/view/template bindings
-> generated or validated site skeleton
-> smoke report
```

Invalid or incomplete configuration must stop with explicit diagnostics and a report.

## TLSTSAR

```text
Trace -> Load -> Secure -> Transform -> Store -> Audit -> Report
```

`Report` is mandatory.

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
