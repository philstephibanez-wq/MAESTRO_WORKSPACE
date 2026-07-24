# Project Index — MAESTRO WORKSPACE

## OPUS

- Repository: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`
- OPUS is a framework, not an application.
- Direct CLI entrypoint: `scripts/opus.php`.
- Composer user-command callback: `Opus\Composer\ComposerScripts::run`.
- Every concrete framework class has a homonymous interface extending the four mandatory markers.
- `OpusExceptionAwareInterface` and `OpusProfilerAwareInterface` are operational runtime contracts.
- Configuration uses `File` and explicit structured parsers.

## OWASYS

- OWASYS is an application built with OPUS.
- Current SCORE pages are its frontend.
- Secured REST plus Composer is its backend.
- Generated sites are independent OPUS applications.
- Application Composer aliases are declared in `sites/owasys/config/composer.commands.json`.
- Backend: `127.0.0.1:8792`.
- Frontend: `127.0.0.1:8000`.
- Backend log: `sites/owasys/var/logs/rcp-backend.log`.
- Profiler traces: `sites/owasys/var/profiler/<trace_id>.json`.

## OPUS root

Allowed directories only:

```text
.git .github application Config DOC Opus packages runtime scripts sites tools vendor
```

Allowed root files only:

```text
.gitignore AGENTS.md composer.json composer.lock composer.phar LICENSE README.md
```

No root `bin/`, lowercase root `config/`, root `public/` or new top-level path.

## Mandatory clean-base artifacts

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6
```

HF5 is superseded.

### HF6

- ZIP: `opus_owasys_p117u_hf6_composer_autoload_callback.zip`
- SHA-256: `d482f4b352c958557e63095f5eacb5fdd9fcbb783853dd2c6202c16ccf79505c`
- Files: 4
- ZIP bytes: 3,332

HF6 removes relative `@php scripts/opus.php` Composer subprocesses. Public Composer aliases invoke an autoloaded generic framework callback. Application mappings remain application-owned configuration.

P117S and P117T remain rejected.

## Canonical resume documents

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/OPUS_P117U_HF6_COMPOSER_AUTOLOAD_CALLBACK_SPEC.md`
3. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117U_HF6_COMPOSER_AUTOLOAD_CALLBACK_2026-07-24.md`
4. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Resume order

1. Apply HF6 after HF4.
2. Regenerate optimized autoload.
3. Start backend and verify status.
4. Start frontend with the same local environment.
5. Retest Registry synchronization.
6. Inspect correlated diagnostics only if another failure occurs.
7. Validate remaining Registry/password/browser/Auth0 gates.
8. Commit OPUS after owner acceptance.
