# OPUS / OWASYS P117U HF7 — APPLICATION CREATION PROFILES

Date: 2026-07-24
Status: binding hotfix/evolution specification
Applies after: P117U + HF1 + HF2 + HF3 + HF4 + HF6
OPUS remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`

## 1. Architectural identity

```text
OPUS = generic framework
OWASYS = application built with OPUS
OWASYS current SCORE pages = frontend
secured REST + Composer = OWASYS backend
created sites = independent OPUS applications
```

OPUS is not an application.

## 2. Confirmed historical regression

Both `sites/owasys_old` and the current OWASYS navigation FSM contained the same incorrect transition:

```text
registry + create_new_app -> build
```

The old implementation described the action as opening Build & Validate in creation mode. The current implementation repeated the same direct transition and invoked an obsolete `registry.creation.start` command.

This behavior is rejected. Build/validation is not the application-type selection screen and must not be entered before an application has actually been generated and selected.

## 3. Canonical creation workflow

HF7 establishes:

```text
registry
-> create_new_app
-> creation
-> choose frontend | backend | fullstack
-> secured REST operation site.create
-> allow-listed Composer command opus:create-site
-> generic OPUS profile-aware scaffold
-> Registry synchronization
-> secured Registry selection through REST + Composer
-> application_created
-> build
```

Failure remains in `creation` through `application_creation_failed`. Cancellation returns to `registry`.

The FSM is the sole lifecycle source of truth. No route bypasses FSM, ACL or SSO.

## 4. OPUS framework evolution

The existing generic `SiteScaffoldPlan` becomes profile-aware. No parallel scaffold architecture is added.

Supported profiles:

```text
frontend
backend
fullstack
```

`SiteScaffoldPlan::forSite()` accepts an optional profile and defaults to `fullstack` for CLI/API backward compatibility.

The generic create command exposes:

```text
--profile=frontend|backend|fullstack
```

The generated `config/site.json` declares:

```json
"application_profile": {
  "contract": "OPUS_APPLICATION_PROFILE_V1",
  "type": "frontend|backend|fullstack",
  "capabilities": {}
}
```

It also declares matching `kind`, `blueprint`, `generated_by` and status metadata.

Profile module baselines:

```text
frontend  = home, architecture, router, modules, controllers, views, i18n
backend   = home, architecture, router, modules, controllers, models, i18n
fullstack = home, architecture, router, modules, controllers, views, models, i18n
```

All generated profiles remain:

- Singleton;
- FSM-module-first;
- browser-locale aware;
- deny-by-default ACL;
- SSO/Auth0-proxy ready;
- SCORE-rendered;
- free of UI-producing `echo` and mixed HTML/PHP views.

## 5. Framework class contract

HF7 modifies these existing concrete OPUS classes:

- `Opus\Console\OpusConsoleApplication`;
- `Opus\Console\Service\SiteCommandService`;
- `Opus\Scaffold\SiteScaffoldPlan`;
- `Opus\Scaffold\FullstackApplicationScaffoldPlan`.

Each continues to implement its homonymous interface. Every relevant interface extends:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

No new concrete framework class is introduced.

## 6. OWASYS creation module

OWASYS adds the application-owned module:

```text
sites/owasys/application/creation/
```

It contains:

- a SCORE creation form;
- an application controller;
- a REST projection model;
- explicit base-language I18n catalogs.

The form asks for:

1. application identifier;
2. profile: frontend, backend or fullstack.

The frontend performs no file write and runs no process. The model calls `site.create` through `RcpRestClient`. The backend validates typed arguments, invokes the public Composer command and returns a structured result.

## 7. Registry integration

The obsolete operation and command are removed:

```text
registry.creation.start
owasys:registry-creation-start
owasys:registry:creation:start
start_creation_flow
```

After successful generation, OWASYS synchronizes the Registry and selects the created application through the existing secured Registry operations.

The OWASYS command provider now projects canonical `OPUS_SITE_STANDARD_CONTRACT_CORE` applications into Registry snapshots. Application profile type becomes Registry `kind`. A standard application absent from SQLite may be selected from canonical discovery and is then persisted through the existing Registry repository boundary.

No framework class contains OWASYS Registry business logic.

## 8. ACL, SSO and locale

- `creation:open` and `creation:write` are granted to developer/admin through deny-by-default ACL;
- the creation controller requires an authenticated SSO identity;
- browser locale remains the default source;
- regional locales use explicit OPUS catalog fallback to their base-language creation catalog;
- all rendering crosses SCORE.

## 9. Logger and Profiler

HF4 remains mandatory for REST/Composer execution diagnostics.

HF7 additionally traces the OWASYS frontend creation workflow through the existing OPUS Logger and Profiler:

```text
sites/owasys/var/logs/owasys-frontend.log
sites/owasys/var/profiler/<trace_id>.json
```

Events include creation request, success and failure. Logs and traces exclude form values, secrets, tokens, HMAC values and process command lines. Failure rendering includes a correlation trace ID without exposing backend process output.

## 10. Configuration boundary

All modified/read configuration crosses OPUS `File` and `StructuredFileLoader` with explicit structured parsers. No direct local `file_get_contents`, `json_decode`, XML parser or YAML parser is introduced for configuration.

## 11. Differential artifact

- ZIP: `opus_owasys_p117u_hf7_application_creation_profiles.zip`
- SHA-256: `16e06b55f3cf2ffcc5118fe0e5c4f17cbc7b51fa437fd06f17bf3dc16ab48141`
- Files: 45
- ZIP bytes: 54,906
- Payload bytes: 176,634

Top-level entries:

```text
composer.json
Opus/
sites/
```

No new root directory, smoke, audit, test, report, README, manifest, cache or temporary file is included.

## 12. Validation completed

- PHP lint for all PHP files in the working differential;
- JSON parsing for all JSON files;
- ZIP content and integrity;
- framework/interface four-marker checks;
- no obsolete creation-start operation/alias/action remains in the differential;
- no smoke/audit/test/recipe Composer alias;
- no direct config parser bypass in the new creation module/provider;
- no UI-producing `echo` in the creation module;
- profile-aware CLI option forwarding;
- typed REST profile argument generation;
- frontend/backend/fullstack scaffold differences;
- generated PHP and JSON validity for all three profiles;
- generated-site validation for all three profiles;
- FSM transitions `registry -> creation -> build` and failure self-loop;
- creation model REST boundary fixture;
- standard-application Registry discovery fixture.

## 13. Mandatory order

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7
```

HF5 remains superseded.

## 14. Pending owner gates

- apply HF7;
- regenerate optimized Composer autoload;
- validate `composer opus:create-site -- <id> --profile=<profile>` on Windows;
- start backend then frontend;
- verify the new visual FSM route;
- create one disposable application for each profile;
- verify Registry selection and Build transition;
- validate creation failure rendering and trace correlation;
- validate no-JavaScript operation;
- validate Auth0 proxy, HTTPS, bastion and Windows/Linux parity.
