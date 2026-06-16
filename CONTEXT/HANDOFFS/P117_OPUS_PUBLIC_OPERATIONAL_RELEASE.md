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

## P117A0 delivered in MAESTRO_WORKSPACE

Commits:

```text
255bb05 P117A0_FIX_OPUS_PROJECT_CONTRACT
91adc6e P117A0_FIX_OPUS_REF_BOOK_PROJECT_CONTRACT
6a8b602 P117A0_ADD_OPUS_PUBLIC_RELEASE_CONTRACT
```

This handoff is created by the following commit:

```text
P117A0_ADD_OPUS_PUBLIC_RELEASE_HANDOFF
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

Core pipeline:

```text
Request
-> Site resolution
-> Router
-> FSM gate
-> ACL gate
-> API identity / token / scope gate
-> Controller
-> ViewModel
-> ScoreTemplate
-> Response
-> Audit / Report
```

## TLSTSAR

```text
Trace -> Load -> Secure -> Transform -> Store -> Audit -> Report
```

`Report` is mandatory.

Reports belong in MAESTRO_WORKSPACE, not in OPUS source roots.

## Next gate

```text
P117A1_OPUS_RUNTIME_SMOKE_AND_VAR_AUDIT
```

Goal:

- verify OPUS boot through `H:\OPUS\index.php`;
- verify official autoload path;
- verify `H:\OPUS\var` contains only `cache` and `logs`;
- produce an explicit report in MAESTRO_WORKSPACE;
- no product behavior change yet.

## User command after pulling workspace

```cmd
cd /d H:\MAESTRO_WORKSPACE
git pull
```
