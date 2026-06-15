# OPUS Runtime Autoloader and var Contract

Status: active contract
Date: 2026-06-16
Scope: OPUS, OPUS_REF_BOOK, MAESTRO_WORKSPACE

## Decision

OPUS is the clean product/runtime repository. Development artifacts, diagnostics, audits, temporary files, generated reports, recipes, and migration helpers belong to MAESTRO_WORKSPACE, not to OPUS var.

## Entry point

OPUS/index.php is the unique OPUS runtime entry point.

There must be no root autoload.php script. The autoloader is a framework class under framework/Opus/Autoload and is called by index.php.

## Autoloader

The OPUS autoloader is a framework runtime service. It is not a loose script and it does not belong in tools.

The autoloader must:

- load OPUS framework classes through the official framework classmap cache;
- rebuild the classmap cache when required;
- write runtime cache files only under OPUS/var/cache;
- write runtime logs only under OPUS/var/logs;
- fail explicitly when cache generation or loading is impossible;
- never use silent fallback behavior.

## Strict OPUS var contract

Only these two runtime directories are allowed under OPUS/var:

```text
var/cache
var/logs
```

The following paths are forbidden inside OPUS/var and must live in MAESTRO_WORKSPACE if they are still useful:

```text
var/tmp
var/audit
var/generated
var/lstsa
var/recipes
var/refbook
var/write_refbook_entrypoint.py
```

Recommended workspace destinations:

```text
MAESTRO_WORKSPACE/var/opus/tmp
MAESTRO_WORKSPACE/var/opus/audit
MAESTRO_WORKSPACE/var/opus/generated
MAESTRO_WORKSPACE/var/opus/lstsa
MAESTRO_WORKSPACE/var/opus/recipes
MAESTRO_WORKSPACE/var/opus/refbook
MAESTRO_WORKSPACE/tools/opus
```

## OPUS_REF_BOOK contract

OPUS_REF_BOOK is an application/client of OPUS. It must not invent a parallel OPUS runtime bootstrap, cache system, or log system.

It may have its own application files, but OPUS runtime bootstrap/cache/log responsibilities must remain in OPUS.

## Validation rule

Any OPUS runtime audit must fail if OPUS/var contains anything other than cache and logs.

Any generated development artifacts found under OPUS/var must be migrated to MAESTRO_WORKSPACE before the OPUS repository is considered clean.
