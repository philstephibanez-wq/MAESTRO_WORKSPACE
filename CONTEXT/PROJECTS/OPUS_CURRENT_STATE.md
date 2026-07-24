# OPUS CURRENT STATE

Last updated: 2026-07-24.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`
- Owner local repo: `H:/OPUS`

## Framework identity

OPUS is a generic framework, not an application.

OWASYS is an application built with OPUS. Its current SCORE pages are its frontend. Secured REST + Composer is its backend. Sites created through OWASYS are independent OPUS applications.

## Active artifact stack

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6
```

HF5 is superseded and is not required on a clean base.

## HF6

- ZIP: `opus_owasys_p117u_hf6_composer_autoload_callback.zip`
- SHA-256: `d482f4b352c958557e63095f5eacb5fdd9fcbb783853dd2c6202c16ccf79505c`
- files: 4
- ZIP bytes: 3,332

```text
composer.json
Opus/Composer/ComposerScriptsInterface.php
Opus/Composer/ComposerScripts.php
sites/owasys/config/composer.commands.json
```

## HF6 cause

Post-HF5 Logger/Profiler evidence showed the same error twice:

```text
Could not open input file: scripts\opus.php
```

Composer found `owasys:registry-sync`, but the Composer script definition still depended on a relative subprocess path.

## HF6 correction

Every public Composer alias now invokes the generic autoloaded callback:

```text
Opus\Composer\ComposerScripts::run
```

The callback derives the OPUS root from its own file location. It resolves framework aliases generically and application aliases from application-owned configuration through `File` and `StructuredFileLoader`.

The direct CLI entrypoint `scripts/opus.php` remains available but is no longer invoked as a relative Composer subprocess.

## Separation

The generic callback contains no OWASYS name or command.

OWASYS owns its alias map in `sites/owasys/config/composer.commands.json`; business implementations remain under `sites/owasys/application/`.

## Framework contract

The new concrete `ComposerScripts` class implements `ComposerScriptsInterface`, which extends all four mandatory markers.

## Diagnostics state

HF4 remains active:

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
```

No execution failure is swallowed.

## Root contract

No root `bin/`, lowercase root `config/`, root `public/` or new top-level directory is authorized.

## Pending

1. apply HF6 after HF4;
2. regenerate optimized autoload;
3. start backend and verify `/api/v1/status`;
4. start frontend;
5. retest Registry synchronization;
6. inspect a new trace only if another error occurs;
7. validate remaining Registry, password, browser, Auth0 and platform gates;
8. commit OPUS after owner acceptance.
