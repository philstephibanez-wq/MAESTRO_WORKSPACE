# Project Index — MAESTRO WORKSPACE

## OPUS

- Repository: `philstephibanez-wq/OPUS`
- Branch: `master`
- Remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`
- OPUS is a framework, not an application.
- Direct CLI entrypoint: `scripts/opus.php`.
- Composer user callback: `Opus\Composer\ComposerScripts::run`.
- Generic application profiles: `frontend`, `backend`, `fullstack`.
- Every concrete framework class has a homonymous interface extending the four mandatory markers.
- Configuration crosses `File` and explicit structured parsers.

## OWASYS

- OWASYS is an application built with OPUS.
- Current SCORE pages are its frontend.
- Secured REST plus Composer is its backend.
- Created sites are independent OPUS applications.
- Backend: `127.0.0.1:8792`.
- Frontend: `127.0.0.1:8000`.
- Backend log: `sites/owasys/var/logs/rcp-backend.log`.
- Frontend workflow log: `sites/owasys/var/logs/owasys-frontend.log`.
- Profiler traces: `sites/owasys/var/profiler/<trace_id>.json`.

## Application creation

Canonical FSM path:

```text
Registry -> Creation -> frontend/backend/fullstack -> REST -> Composer -> Registry select -> Build
```

The direct `Registry -> Build` path inherited from `owasys_old` is rejected.

Obsolete creation-start Registry operations and Composer aliases are removed. The actual mutation is the typed REST operation `site.create`.

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
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7
```

HF5 is superseded.

### HF7

- ZIP: `opus_owasys_p117u_hf7_application_creation_profiles.zip`
- SHA-256: `16e06b55f3cf2ffcc5118fe0e5c4f17cbc7b51fa437fd06f17bf3dc16ab48141`
- files: 45
- ZIP bytes: 54,906
- payload bytes: 176,634
- roots: `composer.json`, `Opus/`, `sites/`

HF7 adds profile-aware generic OPUS scaffolding and the OWASYS application-owned SCORE/FSM creation workflow. No new concrete framework class is introduced.

P117S and P117T remain rejected.

## Canonical resume documents

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_SPEC.md`
3. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_2026-07-24.md`
4. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Resume order

1. Apply HF7 after HF6.
2. Regenerate optimized autoload.
3. Validate OWASYS site and routes.
4. Start backend and verify status.
5. Start frontend.
6. validate the Creation state and three profiles.
7. validate generated applications, Registry selection and Build transition.
8. inspect correlated logs/profiler only on failure.
9. validate password/no-JavaScript/Auth0/platform gates.
10. commit OPUS after owner acceptance.
