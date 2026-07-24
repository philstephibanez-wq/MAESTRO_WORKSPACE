# OPUS CURRENT STATE

Last updated: 2026-07-24.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `f9d01dca6644f41c10b85fd6da47eb8c21bf15b6`
- Current remote milestone: P117U + HF1 + HF2 + HF3 + HF4 + HF6 + HF7 + HF8
- HF9 status: OWASYS presentation differential produced, not yet committed
- Owner local repo: `H:/OPUS`

## Framework identity

OPUS is a generic framework, not an application.

OWASYS is an application built with OPUS. Its SCORE pages are its frontend. Secured REST + Composer is its backend. Created sites are independent OPUS applications.

## Binding contracts

- `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_P117U_HF8_GENERATED_SITE_I18N_EU_UK_DIAGNOSTICS_SPEC_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF9_CREATION_FORM_LAYOUT_SPEC_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_ALL_CONCRETE_CLASSES_COMPONENT_CONTRACT_SPEC_P117M.md`
- `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`

## Active stack

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7 -> HF8 -> HF9 pending owner installation
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

HF9 adds no class under `Opus/` and modifies no existing framework class. The exhaustive P117M tokenizer gate remains mandatory before the next OPUS commit.

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

## HF8 committed state

The generic profile-aware scaffold now generates 25 base locales:

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

Locale resolution remains:

```text
explicit route locale
-> Accept-Language negotiation
-> explicit fr fallback with diagnostics
```

Generated applications create and use:

```text
var/logs/application.log
var/profiler/<trace_id>.json
```

through `Opus\Log\Logger` and `Opus\Profiler\Profiler`.

## Runtime evidence

The four owner screenshots confirm:

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
Creation route /fr-FR/applications/new accessible
```

The Creation form contains the site identifier, the frontend/backend/fullstack profiles and the Create/Cancel actions.

## REST + Composer evidence

The supplied backend log contains seven complete `registry.sync` executions. Every trace follows:

```text
execution.received
-> execution.validated
-> command.started : owasys:registry-sync
-> command.succeeded : exit_code=0, stderr_bytes=0
-> execution.succeeded : fsm_state=succeeded
```

No error, stderr output or failed FSM transition appears. No `site.create` operation has yet been submitted.

Observed Composer duration:

```text
minimum : 3603.440 ms
average : 4919.592 ms
maximum : 10261.340 ms
```

## HF9 reproduced defect

The Creation profile selector is structurally present but visually broken. The template uses:

```text
ow-creation-form
ow-form-field
ow-profile-selector
ow-profile-option
```

without dedicated rules in the current OWASYS stylesheets. The labels therefore inherit `.ow-card` while remaining inline, producing the overlap visible in the owner capture.

## HF9 differential

- ZIP: `opus_owasys_p117u_hf9_creation_form_layout.zip`
- SHA-256: `1db0628b87961e098df9500924a496548ea2029702628eb8012c9313636505f0`
- changed paths: 3
- base commit: `f9d01dca6644f41c10b85fd6da47eb8c21bf15b6`

Paths:

```text
sites/owasys/application/creation/controllers/CreationController.php
sites/owasys/application/default/layouts/layout.score
sites/owasys/www/asset/css/creation.css
```

HF9 is application presentation only. It does not alter REST, Composer, Registry, FSM transitions, I18n catalogs, ACL, SSO, Logger or Profiler.

## HF9 validation

```text
PHP lint controller             : OK
SCORE conditional balance      : OK
Chromium 1716 px                : 0 overlap, 0 overflow
Chromium 1100 px                : 0 overlap, 0 overflow
Chromium 760 px                 : 0 overlap, 0 overflow
Chromium 420 px                 : 0 overlap, 0 overflow
New concrete OPUS class         : none
UI echo added                   : none
Business backend changed        : no
```

## Launch surface

```text
START_OWASYS_BACKEND.cmd
START_OWASYS_FRONTEND.cmd
```

The backend route is `/api/v1`; the OWASYS client targets `http://127.0.0.1:8792/api/v1/executions`.

## Pending

1. install HF9 on a clean `f9d01dca6644f41c10b85fd6da47eb8c21bf15b6` tree;
2. lint the modified controller;
3. reload `/fr-FR/applications/new` without browser cache;
4. validate desktop and mobile layout;
5. validate Cancel to Registry;
6. submit one controlled creation;
7. validate REST, Composer, Registry select and Build;
8. validate correlated Logger and Profiler traces;
9. run the exhaustive P117M tokenizer gate;
10. commit OPUS after owner acceptance;
11. decide separately whether `sites/owasys_old` can be removed.
