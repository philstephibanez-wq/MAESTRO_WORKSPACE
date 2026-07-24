# OPUS CURRENT STATE

Last updated: 2026-07-24.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `79f261854ee06a9f828fec389adca77d57323d00`
- Current remote milestone: P117U + HF1 + HF2 + HF3 + HF4 + HF6
- Owner local state observed: HF7R1 applied and running, not yet committed on `OPUS/master`
- HF8 status: differential produced, not yet installed by owner
- Owner local repo: `H:/OPUS`

## Framework identity

OPUS is a generic framework, not an application.

OWASYS is an application built with OPUS. Its SCORE pages are its frontend. Secured REST + Composer is its backend. Created sites are independent OPUS applications.

## Binding contracts

- `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7R1_CONTINUITY_REBUILD_SPEC_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7R1_RUNTIME_CHECKPOINT_SPEC_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_P117U_HF8_GENERATED_SITE_I18N_EU_UK_DIAGNOSTICS_SPEC_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_ALL_CONCRETE_CLASSES_COMPONENT_CONTRACT_SPEC_P117M.md`
- `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`

## Active artifact stack

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7R1 -> HF8
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

HF8 is based on the real profile-aware `SiteScaffoldPlan.php` from the HF7 differential. It is intentionally not pushed to OPUS.

## Concrete framework class contract

Every named concrete class under `Opus/**/*.php` must directly implement its homonymous interface. That interface directly extends:

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

HF8 modifies only the existing `SiteScaffoldPlan` class. It introduces no new concrete framework class and preserves `SiteScaffoldPlanInterface`.

The exhaustive tokenizer gate must still be executed on the complete owner tree after HF8 installation. No final claim of exhaustive repository conformance is made before that gate.

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

## HF8 generated application I18n

The owner approved the generic framework evolution.

The scaffold now generates exactly:

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

for the default scope and every module of the `frontend`, `backend` and `fullstack` profiles.

The locale strategy is:

```text
explicit route locale
-> Accept-Language negotiation
-> explicit fr fallback with diagnostics
```

Regional browser tags such as `fr-FR`, `de-DE` and `uk-UA` resolve to supported base locales through the existing OPUS `BrowserLocaleNegotiator`.

## HF8 generated application diagnostics

Generated applications declare and create:

```text
var/logs/application.log
var/profiler/<trace_id>.json
```

The generated Singleton application class uses `Opus\Log\Logger` and `Opus\Profiler\Profiler` and correlates:

```text
request.received
request.completed
request.failed
```

No sensitive form value, secret, token, password, HMAC or command line is added to diagnostics.

## Workflow under validation

```text
Registry
-> Creation
-> choose frontend/backend/fullstack
-> REST site.create
-> Composer opus:create-site
-> OPUS scaffold with 25 locales and diagnostics
-> Registry synchronize/select
-> Build
```

Failure stays in Creation. Cancellation returns to Registry.

## Diagnostics

OWASYS:

```text
Backend log  : sites/owasys/var/logs/rcp-backend.log
Frontend log : sites/owasys/var/logs/owasys-frontend.log
Profiler     : sites/owasys/var/profiler/<trace_id>.json
```

Generated application:

```text
Log          : sites/<application>/var/logs/application.log
Profiler     : sites/<application>/var/profiler/<trace_id>.json
```

## Current differentials

### HF7R1 applied locally

- ZIP: `opus_owasys_p117u_hf7r1_application_creation_profiles.zip`
- SHA-256: `16b8006dae07b88555c7149fa14bb4f9a1230e47f5d32f973933e0597dcb7858`
- changed paths: 45

### HF8 pending owner installation

- ZIP: `opus_p117u_hf8_generated_site_i18n_eu_uk_diagnostics.zip`
- SHA-256: `6f5d68f23d94d048a0fc43b696397dfe643dd8dc1510cfc33147152ceda7a9f6`
- changed paths: 1
- target: `Opus/Scaffold/SiteScaffoldPlan.php`
- required base file SHA-256: `a68f57c7de7f934363cd76ba8c726f732bf83c9a8575fcf88cdb2d8f68877a74`

## Launch surface

```text
START_OWASYS_BACKEND.cmd
START_OWASYS_FRONTEND.cmd
```

The backend route is `/api/v1`; the OWASYS client targets `http://127.0.0.1:8792/api/v1/executions`.

## Pending

1. verify the owner base file SHA-256;
2. install HF8;
3. run Composer optimized autoload;
4. run complete PHP lint/parsing and the exhaustive P117M tokenizer gate;
5. validate Creation and cancellation;
6. create one application for each profile;
7. verify 25 default catalogs and 25 catalogs per generated module;
8. validate `fr-FR`, `de-DE`, `uk-UA` and explicit fallback;
9. validate generated application Logger and Profiler;
10. validate Registry selection and Build transition;
11. validate no-JavaScript, password, Auth0, HTTPS, bastion and platform gates;
12. commit OPUS after owner acceptance;
13. decide separately whether `sites/owasys_old` can be removed.
