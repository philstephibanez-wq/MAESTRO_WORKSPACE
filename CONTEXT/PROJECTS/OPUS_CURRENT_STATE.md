# OPUS CURRENT STATE

Last updated: 2026-07-25.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `41f77ad7187c0facb125a5737b62d10928809e66`
- Current committed milestone: P117U + HF1 + HF2 + HF3 + HF4 + HF6 + HF7 + HF8 + HF9 + HF9R1
- HF10 status: differential produced, owner installation pending
- Owner local repo: `H:/OPUS`

## Framework identity

OPUS is a generic framework, not an application.

OWASYS is an application built with OPUS. Its SCORE pages are its frontend. Secured REST + Composer is its backend. Created sites are independent OPUS applications.

## Binding contracts

- `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_P117U_HF10_APPLICATION_SURFACES_RUNTIME_MODES_SPEC_2026-07-25.md`
- `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117U_HF10_APPLICATION_SURFACES_RUNTIME_MODES_2026-07-25.md`
- `CONTEXT/SPECIFICATIONS/OPUS_ALL_CONCRETE_CLASSES_COMPONENT_CONTRACT_SPEC_P117M.md`
- `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`

## Active stack

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7 -> HF8 -> HF9 -> HF9R1 -> HF10 pending owner installation
```

HF5 remains superseded.

## Concrete framework class contract

Every named concrete class under `Opus/**/*.php` must directly implement its homonymous interface. That interface directly extends:

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

HF10 adds:

```text
Opus/Application/Structure/ApplicationStructure.php
Opus/Application/Structure/ApplicationStructureInterface.php
```

The class implements its homonymous interface and the interface extends all four markers. Modified framework classes retain their existing homonymous interfaces. The exhaustive P117M tokenizer gate remains an owner gate.

## Canonical application structure

```text
frontend  = application/shared + application/front
backend   = application/shared + application/back
fullstack = application/shared + application/front + application/back
```

`application/full` is forbidden.

### shared

Contracts, domain, DTOs, common configuration, common I18n, Singleton composition and Logger/Profiler correlation.

### front

Presentation modules, frontend controllers, ViewModels, SCORE templates/views, navigation and presentation ACL.

### back

API modules, REST controllers, services, providers, allow-listed Composer commands, backend ACL and persistence.

## Application standard

All OPUS applications are:

- Singleton;
- autonomous under `sites/<application>/`;
- FSM-module-first;
- I18n/browser-locale aware;
- deny-by-default ACL;
- SSO/Auth0-proxy and bastion ready;
- backend-first;
- SCORE-only for UI;
- free of UI-producing `echo` and mixed PHP/HTML views;
- usable without mandatory JavaScript;
- instrumented by Logger and Profiler.

## Configuration boundary

Configuration is read through OPUS `File` and parsed through `StructuredFileLoader` with the explicit parser:

```text
JSON -> Json
XML -> Xml
YAML/YML -> Yaml
```

Direct local configuration reads and silent parser fallback remain forbidden.

## Runtime surfaces

HF10 makes runtime mode explicit:

```text
--mode=front
--mode=back
```

The process role no longer depends on the port. The front process refuses backend routes and the back process refuses frontend routes.

Local convention:

```text
front : 127.0.0.1:8000
back  : 127.0.0.1:8792
```

Production uses reverse proxy HTTPS 443 with separate internal pools/processes. Internal ports remain configurable and are never the security boundary.

## Generated applications after HF10

```text
application/shared/Application.php
application/shared/bootstrap.php
application/shared/layouts
application/shared/local
application/front/modules/<module>
application/back/modules/<module>
```

Routes declare `surface=front|back`. Front routes render SCORE. Back routes return structured JSON. FSM state identifiers are qualified by surface.

The 25 base locales remain:

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

Locale resolution remains explicit route locale, then `Accept-Language`, then diagnosed French fallback.

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

## Current runtime defect

Owner state before HF10:

```text
/fr-FR/applications/new : OK
/fr-FR/applications     : HTTP 500
runtime log             : absent
```

HF10 adds the missing runtime observability:

```text
sites/owasys/var/logs/owasys-runtime.log
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
X-Opus-Trace-Id
```

HF10 does not claim the HTTP 500 cause is fixed before the trace is captured.

## OWASYS physical migration

The front/back process boundary is introduced in HF10.

The physical move of the existing OWASYS tree is explicitly:

```text
owasys-physical-migration-pending
```

HF10B will migrate the tree after the HTTP 500 trace becomes available. No unverified bulk move is performed.

## HF10 differential

```text
ZIP     : opus_p117u_hf10_application_surfaces_runtime_modes.zip
SHA-256 : 5ca8ddbb1e765ec9a63393cbdb2d70a95e17e0e62b39027e0f921854c0174721
BASE    : 41f77ad7187c0facb125a5737b62d10928809e66
```

The installable differential includes:

- guarded installer with exact HEAD/blob checks;
- new framework structure contract and interface;
- scaffold/runtime/I18n/console/service transformations;
- OWASYS mode and diagnostic boundary;
- real front/back CMD launchers;
- smoke test `P117U_HF10_APPLICATION_SURFACES_SMOKE_OK`.

## Launch surface after HF10

```text
sites\owasys\tools\cmd\START_OWASYS_FRONT.cmd
sites\owasys\tools\cmd\START_OWASYS_BACK.cmd
```

Equivalent Composer commands:

```text
composer opus:serve-site -- owasys --mode=front --host=127.0.0.1 --port=8000
composer opus:serve-site -- owasys --mode=back --host=127.0.0.1 --port=8792
```

## Pending

1. apply HF10 to the exact clean base;
2. obtain the HF10 smoke success marker;
3. start back then front using explicit modes;
4. reproduce `/fr-FR/applications`;
5. collect `request.failed` and `trace_id` if the HTTP 500 remains;
6. produce HF10B physical OWASYS migration from that source of truth;
7. test frontend/backend/fullstack generation;
8. validate route surface rejection in both processes;
9. run the exhaustive P117M tokenizer gate;
10. commit and push OPUS after owner acceptance;
11. decide separately whether `sites/owasys_old` can be removed.
