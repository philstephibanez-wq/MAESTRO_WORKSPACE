# OPUS_REF_BOOK — Project Contract

## Source root

```text
H:\OPUS_REF_BOOK
```

## Role

OPUS_REF_BOOK is the documentation application for OPUS. It is a client of OPUS, not the OPUS runtime itself.

Its purpose is to help a developer understand, install, use, secure, deploy and extend OPUS.

## Permanent contracts

- OPUS_REF_BOOK must not invent a parallel OPUS runtime bootstrap, cache system, log system, router, security gate, or source of truth.
- OPUS_REF_BOOK must not present an API inventory as the primary developer documentation.
- OPUS_REF_BOOK must prioritize practical developer workflows: create a site, create a route, create a controller, render a ScoreTemplate page, secure a route, expose an API endpoint, deploy on Linux.
- Every method reference must explain purpose, context, parameters, return values, errors, examples, and related workflow when the source information exists.
- If required documentation data is missing, OPUS_REF_BOOK must expose an explicit documentation audit item, not invent a fallback section.
- Empty public sections are forbidden.
- Mermaid diagrams are allowed only when they explain a real OPUS flow, especially MVC, security pipeline, FSM transitions, or deployment.

## Public documentation target

The public documentation must start with:

```text
Why OPUS
Quickstart
Create a site
Create a route
Create a controller
Render a ScoreTemplate page
Secure with FSM + ACL
Use API / SSO-style tokens and scopes
Understand TLSTSAR + Report
Deploy on Linux
API reference appendix
```

## Current priority

```text
P117_OPUS_PUBLIC_OPERATIONAL_RELEASE
```

OPUS_REF_BOOK is not the project driver until OPUS runtime and public developer documentation gates are validated.
