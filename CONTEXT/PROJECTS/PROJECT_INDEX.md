# Project Index — MAESTRO WORKSPACE

## Checkpoint canonique courant — 2026-08-03

- OPUS `master` : `07756d41d171fec1758722874adaa889a931026e`.
- Acquis : R45A3, R45A2 et R46B15.
- Livrable owner actif : R45B1, gate de conformité des profils.
- Prochain développement après validation owner : R45B2, runtime REST générique et corrélation fullstack.
- OWASYS courant : deux applications autonomes `owasys-front` et `owasys-back`.
- Le handoff courant et `OPUS_CURRENT_STATE.md` priment sur les checkpoints historiques conservés plus bas.


## Global development contract

- Binding specification: `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
- Execution addendum: `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md`
- HF8 specification: `CONTEXT/SPECIFICATIONS/OPUS_P117U_HF8_GENERATED_SITE_I18N_EU_UK_DIAGNOSTICS_SPEC_2026-07-24.md`
- HF9 specification: `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF9_CREATION_FORM_LAYOUT_SPEC_2026-07-24.md`
- Current handoff: `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
- Governance and handoffs are written directly to `MAESTRO_WORKSPACE`.
- OPUS/OWASYS source corrections are delivered only as source-grounded differential ZIPs.
- No source of truth means no patch.

## OPUS

- Repository: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `f9d01dca6644f41c10b85fd6da47eb8c21bf15b6`
- Current remote state: HF7 and HF8 committed
- OPUS is a framework, not an application.
- Generic application profiles: `frontend`, `backend`, `fullstack`.
- Generated applications receive 24 official EU languages plus Ukrainian.
- Browser locale negotiation crosses OPUS I18n with explicit fallback.
- Generated applications use mandatory Logger and Profiler.
- Every concrete framework class must implement its homonymous interface extending the four mandatory markers.
- Configuration crosses `File` and explicit `Json`, `Xml` or `Yaml` parsers through `StructuredFileLoader`.

## OWASYS

- OWASYS is an application built with OPUS under `sites/owasys/`.
- SCORE pages are its frontend.
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

Canonical FSM path:

```text
Registry -> Creation -> frontend/backend/fullstack -> REST site.create -> Composer opus:create-site -> Registry select -> Build
```

The direct `Registry -> Build` path inherited from `owasys_old` is rejected.

## Runtime checkpoint

Owner evidence confirms:

```text
Applications route active
Creation entry visible
Candidates = 1
Canonical applications = 1
Duplicate identifiers = 0
Ignored roots = 0
Singleton conforming = 1
Singleton non-conforming = 0
OWASYS discovered as fullstack standard-opus-application
Creation route accessible
```

The backend log contains seven successful `registry.sync` executions. Every `owasys:registry-sync` command ends with `exit_code=0`, `stderr_bytes=0` and FSM `succeeded`. No `site.create` operation has yet been submitted.

## HF9 layout correction

The Creation form is functionally present, but the profile cards overlap because the dedicated SCORE classes have no CSS rules at the current OPUS head.

HF9 adds a Creation-only stylesheet and conditional asset loading.

```text
ZIP     : opus_owasys_p117u_hf9_creation_form_layout.zip
SHA-256 : 1db0628b87961e098df9500924a496548ea2029702628eb8012c9313636505f0
PATHS   : 3
BASE    : f9d01dca6644f41c10b85fd6da47eb8c21bf15b6
```

Paths:

```text
sites/owasys/application/creation/controllers/CreationController.php
sites/owasys/application/default/layouts/layout.score
sites/owasys/www/asset/css/creation.css
```

HF9 changes no business command, REST operation, Composer command, FSM transition or class under `Opus/`.

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
4. `CONTEXT/SPECIFICATIONS/OPUS_P117U_HF8_GENERATED_SITE_I18N_EU_UK_DIAGNOSTICS_SPEC_2026-07-24.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF9_CREATION_FORM_LAYOUT_SPEC_2026-07-24.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF9_CREATION_FORM_LAYOUT_2026-07-24.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Resume order

1. Confirm `H:\OPUS` is clean at `f9d01dca6644f41c10b85fd6da47eb8c21bf15b6`.
2. Install HF9.
3. Lint the modified controller.
4. Start OWASYS backend and frontend.
5. Force-reload `/fr-FR/applications/new`.
6. Validate desktop and mobile Creation layout.
7. Validate Cancel to Registry.
8. Submit one controlled application creation.
9. Validate REST, Composer, Registry select and Build.
10. Validate Logger and Profiler correlation.
11. Run the exhaustive P117M tokenizer gate.
12. Commit OPUS after owner acceptance.
13. Decide separately whether `sites/owasys_old` can be removed.
