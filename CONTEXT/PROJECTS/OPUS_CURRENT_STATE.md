# OPUS CURRENT STATE

Last updated: 2026-07-24.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `79f261854ee06a9f828fec389adca77d57323d00`
- Current remote milestone: P117U + HF1 + HF2 + HF3 + HF4 + HF6
- Owner local state observed: HF7R1 applied and running, not yet committed on `OPUS/master`
- Owner local repo: `H:/OPUS`

## Framework identity

OPUS is a generic framework, not an application.

OWASYS is an application built with OPUS. Its SCORE pages are its frontend. Secured REST + Composer is its backend. Created sites are independent OPUS applications.

## Binding contracts

- `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7R1_CONTINUITY_REBUILD_SPEC_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7R1_RUNTIME_CHECKPOINT_SPEC_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_ALL_CONCRETE_CLASSES_COMPONENT_CONTRACT_SPEC_P117M.md`
- `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`

## Active artifact stack

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7R1
```

HF5 remains superseded.

## Remote versus local state

The remote `OPUS/master` remains at HF6. Public Composer aliases delegate to `Opus\Composer\ComposerScripts::run`.

The owner local runtime shows HF7R1 behavior:

- Creation entry visible from Applications;
- standard OPUS applications projected into Registry;
- application profile projected as Registry kind;
- obsolete direct Registry-to-Build behavior no longer visible in the Applications surface;
- backend and frontend running on the expected local ports.

The remote is intentionally unchanged until owner runtime gates are complete.

## Concrete framework class contract

Every named concrete class under `Opus/**/*.php` must directly implement its homonymous interface. That interface directly extends:

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

The exhaustive tokenizer gate must still be executed on the complete owner tree after HF7R1. No final claim of exhaustive conformance is made before that gate.

## Application standard

All OPUS applications are:

- Singleton;
- autonomous under `sites/<application>/`;
- FSM-module-first;
- I18n/browser-locale aware;
- deny-by-default ACL;
- SSO/Auth0-proxy and bastion ready through generic OPUS contracts;
- backend-first;
- SCORE-only rendered;
- free of UI-producing `echo` and mixed PHP/HTML views;
- usable without mandatory JavaScript;
- instrumented by Logger and Profiler.

A generic requirement is proposed as an OPUS evolution before any local application implementation.

## Configuration boundary

Configuration is read through OPUS `File` and parsed through the explicit parser selected by `StructuredFileLoader`:

```text
JSON -> Json
XML -> Xml
YAML/YML -> Yaml
```

Direct local configuration reads and silent parser fallback are forbidden.

## OWASYS boundary

Every business write crosses:

```text
SCORE frontend
-> FSM + I18n + ACL + SSO
-> secured typed REST
-> backend execution FSM
-> allow-listed Composer command
-> typed service/provider
-> structured result
-> ViewModel
-> SCORE
```

No OWASYS business logic belongs under `Opus/`.

## HF7R1 runtime checkpoint

The visual evidence confirms:

```text
create application entry visible
candidates = 1
canonical applications = 1
duplicate identifiers = 0
ignored roots = 0
Singleton conforming = 1
Singleton non-conforming = 0
```

The Registry projection confirms:

```text
application = OPUS OWASYS
status = discovered
profile = fullstack
kind = standard-opus-application
root = sites/owasys
locale = fr-FR
id = owasys
conformity = OwasysApplication
```

The current application remains unset until `registry.select` is invoked by the owner action.

## REST + Composer evidence

The supplied backend log contains five successful `registry.sync` operations. Every execution follows:

```text
execution.received
-> execution.validated
-> command.started : owasys:registry-sync
-> command.succeeded : exit_code=0, stderr_bytes=0
-> execution.succeeded : fsm_state=succeeded
```

No backend error, stderr output or failed FSM transition appears in the supplied log.

## Workflow under validation

```text
Registry
-> Creation
-> choose frontend/backend/fullstack
-> REST site.create
-> Composer opus:create-site
-> OPUS scaffold
-> Registry synchronize/select
-> Build
```

Failure stays in Creation. Cancellation returns to Registry.

## Diagnostics

```text
Backend log  : sites/owasys/var/logs/rcp-backend.log
Frontend log : sites/owasys/var/logs/owasys-frontend.log
Profiler     : sites/owasys/var/profiler/<trace_id>.json
```

No secret or raw sensitive parameter is recorded.

## Current differential

- ZIP: `opus_owasys_p117u_hf7r1_application_creation_profiles.zip`
- SHA-256: `16b8006dae07b88555c7149fa14bb4f9a1230e47f5d32f973933e0597dcb7858`
- changed paths: 45
- delivery mode: installable differential ZIP

No new corrective ZIP is justified by the current evidence because no defect is reproduced.

## Launch surface

```text
START_OWASYS_BACKEND.cmd
START_OWASYS_FRONTEND.cmd
```

The backend route is `/api/v1`; the OWASYS client targets `http://127.0.0.1:8792/api/v1/executions`.

## Pending

1. run the exhaustive P117M tokenizer gate and complete lint/parsing;
2. validate `/fr-FR/applications/new`;
3. validate Creation cancellation;
4. validate controlled Creation failures and correlated frontend/backend traces;
5. create `hf7r1-frontend-check`;
6. create `hf7r1-backend-check`;
7. create `hf7r1-fullstack-check`;
8. validate Registry selection and Build transition;
9. validate structural conformance of all three generated sites;
10. validate no-JavaScript, password, Auth0, HTTPS, bastion and platform gates;
11. commit OPUS after owner acceptance;
12. decide separately whether `sites/owasys_old` can be removed.
