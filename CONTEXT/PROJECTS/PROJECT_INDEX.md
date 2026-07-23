# Project Index — MAESTRO WORKSPACE

## OPUS

- Repository: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`
- OPUS is the generic framework.
- Generic command entrypoint: `scripts/opus.php`.
- Every concrete framework class uses a homonymous four-marker interface.
- `OpusExceptionAwareInterface` and `OpusProfilerAwareInterface` are operational runtime contracts.
- Configuration uses `File` and explicit structured parsers.

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

## OWASYS

- OWASYS is one OPUS application.
- Current SCORE pages are its frontend.
- Secured REST plus Composer is its backend.
- Generated sites are independent OPUS applications.
- Backend: `127.0.0.1:8792`.
- Frontend: `127.0.0.1:8000`.
- Backend log: `sites/owasys/var/logs/rcp-backend.log`.
- Profiler traces: `sites/owasys/var/profiler/<trace_id>.json`.

## Mandatory artifacts

### P117U

SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`

### HF1

SHA-256: `e711af28142a5ad287569c5107b99d41065498ea3bed70ec13b977007ae605d2`

### HF2

SHA-256: `c26d32f3b1446c8bb65c668ab8c7c785783162855f8b5b02e57dd61e8e97f980`

### HF3

SHA-256: `f0860491df311a997d92c0a82796e7e11921911721bf02e3a8b45aece4ce6f17`

### HF4

- ZIP: `opus_owasys_p117u_hf4_logger_profiler_exitcode.zip`
- SHA-256: `2f48a42be49153a3c67186e26553f884c6401486e42a3747db9716d4fb1e1b07`
- Files: 7
- Payload bytes: 52,274

HF4 connects the existing Logger/Profiler to RCP, adds trace correlation, sanitizes process diagnostics and corrects Windows process exit-code resolution.

P117S and P117T remain rejected.

## Security gate

The tracked OWASYS runtime secret file was removed in OPUS commit `96884961248fc82bf5e13187a6ffcfffacb82d9f`.

Previously committed or pasted values must not be reused for nonlocal deployment.

## Canonical documents

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`
3. `CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF4_LOGGER_PROFILER_EXITCODE_SPEC.md`
4. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_P117U_HF4_LOGGER_PROFILER_EXITCODE_2026-07-24.md`
5. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Resume order

1. Apply P117U, HF1, HF2, HF3, HF4.
2. Regenerate Composer autoload.
3. Start backend and verify status.
4. Start frontend with the same local environment.
5. Reproduce Registry synchronization.
6. Inspect the trace-correlated log and profiler file.
7. Validate Registry/password/browser/Auth0 gates.
8. Commit OPUS after owner acceptance.
