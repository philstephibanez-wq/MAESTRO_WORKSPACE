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
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF5
```

HF5:

- ZIP: `opus_owasys_p117u_hf5_composer_working_directory.zip`
- SHA-256: `862d870b4e77de6fd74c391c4d1ca41a240419b7ea8bc33daebeb1aee9a8279b`
- files: 1
- ZIP bytes: 3,741

```text
Opus/Rcp/Composer/ComposerCommandExecutor.php
```

## HF5 cause

HF4 diagnostics proved that Composer found `owasys:registry-sync` but its child command could not open the generic framework entrypoint:

```text
scripts\opus.php
```

Both observed and closed process codes were `1`.

## HF5 correction

The generic Composer executor now passes:

```text
--working-dir=<validated absolute OPUS root>
```

The `proc_open` working directory remains the same validated root. No REST or application input can override it.

No OWASYS application file or business implementation is changed.

## Diagnostics state

HF4 remains active:

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
```

Logger/profiler traces remain sanitized and correlated with REST errors.

## Framework contracts

Every concrete class under `Opus/` implements its homonymous interface extending all four mandatory markers.

HF5 introduces no class or interface and preserves `ComposerCommandExecutorInterface`.

## Root contract

No root `bin/`, lowercase root `config/`, root `public/` or new top-level directory is authorized.

## Pending

1. apply HF5 after HF4;
2. regenerate optimized autoload;
3. start backend and verify `/api/v1/status`;
4. start frontend;
5. retest Registry synchronization;
6. inspect a new trace only if another error occurs;
7. validate remaining Registry, password, browser, Auth0 and platform gates;
8. commit OPUS after owner acceptance.
