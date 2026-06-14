# ADR 2026-06-14 — OPUS delivery packaging profile

## Status

Accepted.

## Context

The workspace coordinates several sub-projects: OPUS, OPUS RefBook, Maestro, KB and publication tooling.

The user clarified the intended OPUS delivery model:

```text
At delivery time, propose a clean OPUS core package.
Offer OPUS_REF_BOOK as an optional official package.
Consider OPUS_USER_GUIDE as another optional package.
```

This complements `ADR_20260614_OPUS_REFBOOK_PACKAGED_OFFLINE_ONLINE_SITE.md`: the RefBook remains an OPUS-powered official site, but it must not pollute the minimal OPUS core distribution.

## Decision

OPUS delivery must be organized into explicit packages/profiles.

```text
OPUS                         mandatory clean core package
OPUS_REF_BOOK                 optional official documentation website package
OPUS_USER_GUIDE               optional end-user guide package, to be confirmed
```

## Package contracts

### OPUS core package

The OPUS core package is the mandatory deliverable.

It must contain the framework and only the files required to run, test and distribute OPUS cleanly.

Required properties:

```text
- clean framework source
- no active Twig RefBook residue
- no dead RefBook CSS overrides
- no legacy/backup workaround folders
- no generated trash
- no hidden fallback
- explicit LICENSE / NOTICE / COPYRIGHT / TRADEMARKS before public release
```

### OPUS_REF_BOOK optional package

The RefBook package is an optional official OPUS site package.

It must:

```text
- run thanks to OPUS;
- remain a real website/application;
- work offline when installed locally;
- be publishable online;
- optionally check GitHub for updates through an explicit non-destructive contract;
- document the installed OPUS version clearly;
- remain clean: zero active Twig, zero legacy backups, zero runtime fallback.
```

It must not be bundled into the minimal OPUS core unless the selected release profile explicitly includes it.

### OPUS_USER_GUIDE optional package

The User Guide is a candidate optional package.

Its purpose is different from the RefBook:

```text
RefBook      technical/reference documentation for OPUS internals and APIs
User Guide   guided human documentation for users, installation, workflows and examples
```

The User Guide may later become:

```text
OPUS_USER_GUIDE
```

It must not be mixed with the RefBook unless a later ADR explicitly decides a unified documentation site.

## Release profile examples

```text
OPUS_CORE_ONLY
- OPUS

OPUS_WITH_REFBOOK
- OPUS
- OPUS_REF_BOOK

OPUS_FULL_DOCUMENTED
- OPUS
- OPUS_REF_BOOK
- OPUS_USER_GUIDE
```

## Consequences

- OPUS must stay deliverable as a clean core package.
- RefBook can be packaged with OPUS without becoming mandatory core runtime bloat.
- User Guide is recognized as a separate optional documentation product.
- Packaging scripts must make selected profiles explicit.
- Public release artifacts must not contain dormant legacy/Twig/backups/trash.

## Canonical wording

```text
At delivery time, OPUS is shipped as a clean core package.
OPUS_REF_BOOK is an optional official OPUS-powered documentation website package.
OPUS_USER_GUIDE is an optional future user-facing guide package.
Each package must be clean, explicit and deliverable.
```
