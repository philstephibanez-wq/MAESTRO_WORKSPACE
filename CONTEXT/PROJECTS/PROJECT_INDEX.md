# Project Index — MAESTRO WORKSPACE

## Global development contract

- Binding specification: `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
- Governance and handoffs are written directly to `MAESTRO_WORKSPACE`.
- OPUS/OWASYS source corrections are delivered only as source-grounded differential ZIPs.
- No source of truth means no patch.

## OPUS

- Repository: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `79f261854ee06a9f828fec389adca77d57323d00`
- Current committed state: HF6
- HF7: documented but not committed and its original artifact is not available in GitHub
- OPUS is a framework, not an application.
- Composer user callback: `Opus\Composer\ComposerScripts::run`.
- Generic application profiles specified by HF7: `frontend`, `backend`, `fullstack`.
- Every concrete framework class implements its homonymous interface extending the four mandatory markers.
- Configuration crosses `File` and explicit `Json`, `Xml` or `Yaml` parsers through `StructuredFileLoader`.
- Browser locale negotiation is provided by OPUS I18n.
- Logger and Profiler are mandatory.

## OWASYS

- OWASYS is an application built with OPUS.
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

Canonical FSM path specified by HF7:

```text
Registry -> Creation -> frontend/backend/fullstack -> REST -> Composer -> Registry select -> Build
```

The direct `Registry -> Build` path inherited from `owasys_old` is rejected.

Obsolete creation-start Registry operations and Composer aliases are removed by HF7. The actual mutation is the typed REST operation `site.create`.

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

### HF7 record

- ZIP: `opus_owasys_p117u_hf7_application_creation_profiles.zip`
- SHA-256: `16e06b55f3cf2ffcc5118fe0e5c4f17cbc7b51fa437fd06f17bf3dc16ab48141`
- files: 45
- ZIP bytes: 54,906
- payload bytes: 176,634
- roots: `composer.json`, `Opus/`, `sites/`
- current availability: absent from GitHub and from the supplied attachment

HF7 adds profile-aware generic OPUS scaffolding and the OWASYS application-owned SCORE/FSM creation workflow. No replacement code archive may be reconstructed from the specification alone.

## CMD command policy

- Cleanup and launch commands are supplied for the VS Code CMD terminal.
- Command blocks contain executable commands only.
- No prompt, comments, expected output, diagnostics or `exit /b` are included.
- `sites/owasys_old` must not be deleted before explicit owner approval.

Current validated frontend command surface:

```text
composer dump-autoload -o
composer opus:validate-site -- owasys
composer opus:list-routes -- owasys
composer opus:serve-site -- owasys --host=127.0.0.1 --port=8000
```

No committed public Composer alias currently starts the REST backend. Its real owner launcher must be recovered or introduced through an explicit generic OPUS evolution.

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
3. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_SPEC.md`
4. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_2026-07-24.md`
5. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Resume order

1. Recover the original HF7 differential or the exact HF7 working source tree.
2. Confirm the local owner base and divergence from `79f261854ee06a9f828fec389adca77d57323d00`.
3. Apply or regenerate HF7 only from that exact source base.
4. Regenerate optimized autoload.
5. Validate OWASYS site and routes.
6. Start the secured backend with its real contractual launcher.
7. Start the SCORE frontend.
8. Validate Creation and the three profiles.
9. Validate generated applications, Registry selection and Build transition.
10. Inspect correlated logs/profiler only on failure.
11. Validate password/no-JavaScript/Auth0/HTTPS/bastion/platform gates.
12. Commit OPUS after owner acceptance.
13. Decide separately whether `sites/owasys_old` can be removed.
