# Project Index — MAESTRO WORKSPACE

## Global development contract

- Binding specification: `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
- Execution addendum: `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md`
- HF7R1 runtime checkpoint: `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7R1_RUNTIME_CHECKPOINT_SPEC_2026-07-24.md`
- Current handoff: `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
- Governance and handoffs are written directly to `MAESTRO_WORKSPACE`.
- OPUS/OWASYS source corrections are delivered only as source-grounded differential ZIPs.
- No source of truth means no patch.

## OPUS

- Repository: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `79f261854ee06a9f828fec389adca77d57323d00`
- Current remote committed state: HF6
- Owner local state observed: HF7R1 applied and running, not yet committed
- OPUS is a framework, not an application.
- Composer user callback: `Opus\Composer\ComposerScripts::run`.
- Generic application profiles: `frontend`, `backend`, `fullstack`.
- Every concrete framework class must implement its homonymous interface extending the four mandatory markers.
- Configuration crosses `File` and explicit `Json`, `Xml` or `Yaml` parsers through `StructuredFileLoader`.
- Browser locale negotiation is provided by OPUS I18n.
- Logger and Profiler are mandatory.

## OWASYS

- OWASYS is an application built with OPUS under `sites/owasys/`.
- Current SCORE pages are its frontend.
- Secured REST plus Composer is its backend.
- Created sites are independent OPUS applications.
- Backend target: `127.0.0.1:8792`.
- Frontend target: `127.0.0.1:8000`.
- Backend log: `sites/owasys/var/logs/rcp-backend.log`.
- Frontend workflow log: `sites/owasys/var/logs/owasys-frontend.log`.
- Profiler traces: `sites/owasys/var/profiler/<trace_id>.json`.
- Every business command and persistent mutation crosses secured typed REST then an allow-listed Composer command.
- OWASYS remains UI/orchestration only and contains no framework-generic implementation under `Opus/`.

## OPUS application standard

Every OPUS application is:

- Singleton;
- FSM-module-first;
- I18n and browser-locale aware;
- deny-by-default ACL;
- SSO/Auth0-proxy and bastion ready through generic OPUS contracts;
- backend-first;
- SCORE-only rendered;
- free of UI-producing `echo`;
- free of mixed PHP/HTML views;
- functional without mandatory JavaScript;
- instrumented by Logger and Profiler.

A non-business-specific requirement is proposed as an OPUS evolution before any local application implementation.

## Application creation

Canonical FSM path under validation:

```text
Registry -> Creation -> frontend/backend/fullstack -> REST -> Composer -> Registry select -> Build
```

The direct `Registry -> Build` path inherited from `owasys_old` is rejected. The actual mutation is the typed REST operation `site.create`.

## HF7R1 runtime checkpoint

The owner evidence confirms:

```text
Create entry visible
Candidates = 1
Canonical applications = 1
Duplicate identifiers = 0
Ignored roots = 0
Singleton conforming = 1
Singleton non-conforming = 0
```

OWASYS is projected as:

```text
fullstack
standard-opus-application
sites/owasys
fr-FR
owasys
discovered
OwasysApplication
```

The backend log confirms five successful `registry.sync` executions. Every command `owasys:registry-sync` terminates with `exit_code=0`, `stderr_bytes=0` and execution FSM state `succeeded`.

## Current differential

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7R1
```

HF5 is superseded.

### HF7R1 installable record

- ZIP: `opus_owasys_p117u_hf7r1_application_creation_profiles.zip`
- SHA-256: `16b8006dae07b88555c7149fa14bb4f9a1230e47f5d32f973933e0597dcb7858`
- changed paths: 45
- mode: installable differential ZIP

No new corrective ZIP is produced at the runtime checkpoint because no defect is reproduced.

## CMD command policy

- Cleanup and launch commands are supplied for the VS Code CMD terminal.
- Command blocks contain executable commands only.
- No prompt, comments, expected output, diagnostics or `exit /b` are included.
- `sites/owasys_old` must not be deleted before explicit owner approval.

Current launchers:

```text
START_OWASYS_BACKEND.cmd
START_OWASYS_FRONTEND.cmd
```

The OWASYS REST client targets `http://127.0.0.1:8792/api/v1/executions`.

## Other repositories reviewed

### MAESTRO

- Repository: `philstephibanez-wq/Maestro`.
- Current work remains independent MAESTRO/MERT development.
- The strict MAESTRO contract, source-of-truth and no-fallback rules remain applicable.

### Maestro KB Engine

- Repository: `philstephibanez-wq/Maestro_KB_Engine`.
- Current handoff source remains separated under `H:/MO_HANDOFF/CURRENT.md` according to its latest committed state.

### Maestro KB Extranet

- Repository: `philstephibanez-wq/Maestro_KB_Extranet`.
- Current front handoff integration remains aligned with `H:/MO_HANDOFF/CURRENT.md` according to its latest committed state.

## Canonical resume documents

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7R1_CONTINUITY_REBUILD_SPEC_2026-07-24.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7R1_RUNTIME_CHECKPOINT_SPEC_2026-07-24.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF7R1_RUNTIME_CHECKPOINT_2026-07-24.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Resume order

1. Run the exhaustive P117M tokenizer gate and full lint/parsing.
2. Open `/fr-FR/applications/new`.
3. Validate Creation cancellation to Registry.
4. Validate controlled Creation errors and trace correlation.
5. Create `hf7r1-frontend-check`.
6. Create `hf7r1-backend-check`.
7. Create `hf7r1-fullstack-check`.
8. Validate Registry selection and Build transition.
9. Validate generated application conformance.
10. Validate password/no-JavaScript/Auth0/HTTPS/bastion/platform gates.
11. Commit OPUS after owner acceptance.
12. Decide separately whether `sites/owasys_old` can be removed.
