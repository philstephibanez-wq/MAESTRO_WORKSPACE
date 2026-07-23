# Project Index — MAESTRO WORKSPACE

## OPUS

- Repository: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`
- OPUS is a framework, not an application.
- Generic command entrypoint: `scripts/opus.php`.
- Every concrete framework class has a homonymous interface extending the four mandatory markers.
- `OpusExceptionAwareInterface` and `OpusProfilerAwareInterface` are operational runtime contracts.
- Configuration uses `File` and explicit structured parsers.

## OWASYS

- OWASYS is an application built with OPUS.
- Current SCORE pages are its frontend.
- Secured REST plus Composer is its backend.
- Generated sites are independent OPUS applications.
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

## Mandatory artifacts

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF5
```

### HF5

- ZIP: `opus_owasys_p117u_hf5_composer_working_directory.zip`
- SHA-256: `862d870b4e77de6fd74c391c4d1ca41a240419b7ea8bc33daebeb1aee9a8279b`
- Files: 1
- ZIP bytes: 3,741
- Path: `Opus/Rcp/Composer/ComposerCommandExecutor.php`

HF5 is a generic framework correction. It forces Composer to execute with the validated absolute OPUS project root, so `scripts/opus.php` resolves correctly. No OWASYS application file is modified.

P117S and P117T remain rejected.

## Canonical resume documents

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/OPUS_P117U_HF5_COMPOSER_WORKING_DIRECTORY_SPEC.md`
3. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117U_HF5_COMPOSER_WORKING_DIRECTORY_2026-07-24.md`
4. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Resume order

1. Apply HF5 after HF4.
2. Regenerate optimized autoload.
3. Start backend and verify status.
4. Start frontend with the same local environment.
5. Retest Registry synchronization.
6. Inspect correlated diagnostics only if another failure occurs.
7. Validate remaining Registry/password/browser/Auth0 gates.
8. Commit OPUS after owner acceptance.
