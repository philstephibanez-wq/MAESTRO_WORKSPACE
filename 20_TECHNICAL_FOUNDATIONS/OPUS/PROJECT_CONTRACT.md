# OPUS — Project Contract

## Source root

```text
H:\OPUS
```

## Role

OPUS is the product/runtime PHP framework used as a technical foundation for public sites, documentation, KB services, and Maestro-related applications.

OPUS is not a temporary patch workspace and is not a report store.

## Permanent contracts

- OPUS must remain an operational product repository.
- OPUS runtime must boot through the official entry point `H:\OPUS\index.php`.
- OPUS must keep source code, runtime cache, runtime logs, documentation source, and tests separated.
- OPUS must use explicit paths and explicit contracts.
- OPUS must not use silent fallback, hidden compatibility bridges, or guessed roots.
- OPUS must expose clear errors when a required capability is missing.
- OPUS must keep development artifacts, patch runners, audits, generated reports, and temporary diagnostics in `H:\MAESTRO_WORKSPACE`, not in OPUS source roots.

## Public release target

OPUS public readiness requires:

- operational runtime;
- strict MVC pipeline;
- ScoreTemplate rendering;
- integrated security gates: FSM, ACL, API identity, SSO-style tokens and scopes;
- TLSTSAR chain including Report;
- developer documentation that explains usage, parameters, returns, errors and examples;
- Linux deployment documentation;
- validation reports stored in MAESTRO_WORKSPACE.

## TLSTSAR contract

For OPUS public release, TLSTSAR means:

```text
Trace -> Load -> Secure -> Transform -> Store -> Audit -> Report
```

`Report` is mandatory. Every audit, patch, validation, or release gate must produce an explicit, exploitable report in MAESTRO_WORKSPACE.

## Relation to other projects

- OPUS_REF_BOOK is a client/application of OPUS documentation. It must not replace OPUS runtime contracts.
- SERVER_LINUX hosts OPUS-powered public applications and documentation; it must not expose framework internals directly.
- MO_KB and Maestro depend on OPUS being operational and documented.

## Current priority

```text
P117_OPUS_PUBLIC_OPERATIONAL_RELEASE
```

Ultimate objective: return to KB and Maestro quickly, then return to music composition.
