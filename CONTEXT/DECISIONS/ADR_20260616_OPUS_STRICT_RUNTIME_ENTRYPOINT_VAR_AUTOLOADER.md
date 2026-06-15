# ADR 2026-06-16 — OPUS strict runtime entrypoint, framework autoloader and var contract

## Status

Accepted.

## Context

OPUS is the framework runtime product. The MAESTRO_WORKSPACE repository is the coordination layer for development state, handoffs, diagnostics, generated artifacts and temporary work.

A regression risk was identified during OPUS RefBook work: runtime concerns were mixed with development and diagnostic storage. The legacy ASAP autoload mechanism was not an optional utility; it was part of the runtime contract. OPUS must preserve that role explicitly.

## Decision

OPUS has exactly one product runtime entrypoint:

```text
H:\OPUS\index.php
```

There must be no root `autoload.php` script. The autoloader is a framework class under:

```text
H:\OPUS\framework\Opus\Autoload\...
```

`index.php` calls the framework autoloader. The autoloader is responsible for checking its classmap cache and rebuilding it when necessary.

OPUS product runtime `var/` is strictly limited to:

```text
H:\OPUS\var\cache
H:\OPUS\var\logs
```

No other directory or file is allowed under `H:\OPUS\var`.

The autoloader and runtime checks must fail explicitly if the contract is violated. No silent fallback is allowed.

## Workspace storage decision

Development, audit, generated, recipe, temporary and RefBook transition artifacts do not belong in OPUS product runtime storage.

If needed, they belong in MAESTRO_WORKSPACE, for example:

```text
H:\MAESTRO_WORKSPACE\var\opus\tmp
H:\MAESTRO_WORKSPACE\var\opus\audit
H:\MAESTRO_WORKSPACE\var\opus\generated
H:\MAESTRO_WORKSPACE\var\opus\lstsa
H:\MAESTRO_WORKSPACE\var\opus\recipes
H:\MAESTRO_WORKSPACE\var\opus\refbook
```

Development scripts and recipes that are not part of product runtime belong under:

```text
H:\MAESTRO_WORKSPACE\tools\opus\...
```

## Consequences

- OPUS may write runtime cache payloads only below `var/cache`.
- OPUS may write runtime logs only below `var/logs`.
- OPUS RefBook must consume OPUS through the official OPUS runtime contract; it must not reinvent a parallel bootstrap.
- `var/tmp`, `var/audit`, `var/generated`, `var/lstsa`, `var/recipes`, `var/refbook`, and ad hoc writer scripts are forbidden inside `H:\OPUS\var`.
- Any future delivery or patch touching OPUS runtime must validate this contract before changing UI or optional packages.

## Immediate implementation target

```text
P116C5N_RESTORE_OPUS_INDEX_AUTOLOADER_STRICT_VAR_LOGS
```

The implementation must restore:

```text
index.php -> Opus\Autoload\Autoloader -> var/cache + var/logs
```

and must provide an explicit runtime audit for:

```text
OPUS_INDEX_ENTRYPOINT_OK
OPUS_AUTOLOAD_CACHE_REBUILD_OK
OPUS_RUNTIME_LOG_WRITE_OK
OPUS_STRICT_VAR_CONTRACT_OK
```
