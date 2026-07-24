# MAESTRO_WORKSPACE HANDOFF — OPUS / OWASYS P117U HF7 APPLICATION CREATION PROFILES

Date: 2026-07-24
Status: differential prepared; isolated framework, FSM, REST and Registry fixtures green; owner Windows/browser creation retest pending
Applies after: P117U + HF1 + HF2 + HF3 + HF4 + HF6
OPUS remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`

## Runtime state entering HF7

HF6 is confirmed operational in the owner environment. `registry.sync` completed through:

```text
OWASYS frontend -> secured REST -> Composer -> OWASYS command provider
```

The backend process returned exit code `0` and the execution FSM ended in `succeeded`.

The remaining visible defect was functional navigation: `create_new_app` still pointed directly to Build/Validate.

## Historical regression confirmed

`sites/owasys_old` already contained the same incorrect behavior. Its creation event transitioned directly from Registry to Build and described the action as opening Build & Validate in creation mode.

The current OWASYS FSM repeated this behavior and coupled it to the obsolete `registry.creation.start` command.

HF7 does not copy the old implementation.

## Canonical workflow

```text
Registry
-> create_new_app
-> Creation
-> choose frontend/backend/fullstack
-> REST site.create
-> Composer opus:create-site
-> OPUS profile-aware scaffold
-> Registry synchronize
-> Registry select
-> application_created
-> Build and validation
```

Failure remains in Creation. Cancellation returns to Registry.

## Framework evolution

The generic OPUS scaffold supports three profiles through the existing `SiteScaffoldPlan`:

```text
frontend
backend
fullstack
```

CLI/Composer usage:

```text
composer opus:create-site -- <id> --profile=<profile> --write
```

The profile is optional for direct backward-compatible CLI use and defaults to `fullstack`. OWASYS REST requires it explicitly.

Generated sites declare `OPUS_APPLICATION_PROFILE_V1`, their matching `kind`, profile capabilities and standard Singleton/FSM/I18n/ACL/SSO/SCORE metadata.

No OWASYS business command is added to the framework.

## OWASYS evolution

New application-owned module:

```text
sites/owasys/application/creation/
```

The module provides:

- SCORE-only profile-selection form;
- REST-only creation model;
- FSM-driven controller;
- base-language I18n catalogs for every configured browser language.

OWASYS performs no local site write and launches no process. All creation writes cross the secured REST backend then Composer.

## Obsolete boundary removed

Removed from the active differential:

```text
registry.creation.start
owasys:registry-creation-start
owasys:registry:creation:start
start_creation_flow
```

Starting a wizard is no longer represented as a backend business mutation. The actual mutation is `site.create` after validated user input.

## Registry behavior

The application command provider projects canonical standard OPUS sites into Registry snapshots and maps `application_profile.type` to Registry `kind`.

A newly generated standard site can therefore be synchronized, selected through `registry.select`, persisted by the existing repository boundary and stored in the OWASYS session before entering Build.

## ACL / I18n / SCORE

- creation is authenticated;
- deny-by-default ACL controls `creation:open` and `creation:write`;
- browser locale is preserved;
- regional locale fallback crosses the OPUS I18n catalog loader;
- all visible output is SCORE-rendered;
- no UI-producing `echo` and no mixed HTML/PHP view is introduced.

## Logger and Profiler

HF4 remains mandatory for backend traces.

The frontend creation lifecycle additionally uses the existing OPUS Logger and Profiler:

```text
sites/owasys/var/logs/owasys-frontend.log
sites/owasys/var/profiler/<trace_id>.json
```

No credentials, tokens, HMAC values or raw REST parameters are logged or profiled.

## HF7 artifact

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

No new root directory, smoke, audit, test, report, README, manifest, cache or temporary file.

## Concrete framework contracts

Modified concrete framework classes remain paired with their homonymous four-marker interfaces:

- `OpusConsoleApplication`;
- `SiteCommandService`;
- `SiteScaffoldPlan`;
- `FullstackApplicationScaffoldPlan`.

No new concrete OPUS class is introduced.

## Validation completed

Green:

- PHP lint;
- JSON parse;
- ZIP integrity;
- Composer user-command-only check;
- interface/four-marker check;
- profile option forwarding through console and RCP argument catalog;
- frontend/backend/fullstack scaffold fixtures;
- generated PHP/JSON validation for all profiles;
- generated-site validator fixtures for all profiles;
- creation model REST fixture;
- standard application Registry discovery fixture;
- FSM registry/creation/build path and failure loop;
- no obsolete creation-start operation;
- no config-read bypass;
- no UI-producing echo.

## Mandatory application order

```text
P117U
HF1
HF2
HF3
HF4
HF6
HF7
```

HF5 remains superseded and requires no rollback if already present.

## Owner retest

1. stop frontend and backend;
2. extract HF7;
3. regenerate optimized Composer autoload;
4. validate OWASYS site and routes;
5. start backend on `127.0.0.1:8792`;
6. verify `/api/v1/status`;
7. start frontend on `127.0.0.1:8000`;
8. open Applications and choose Create new application;
9. verify the Creation state and three profile choices;
10. create a disposable profile application;
11. verify Registry selection and transition to Build;
12. inspect trace-correlated diagnostics only on failure.

## Permanent rules

OPUS IS A FRAMEWORK, NOT AN APPLICATION.
OWASYS IS AN APPLICATION BUILT WITH OPUS.
NO OWASYS BUSINESS IMPLEMENTATION UNDER `Opus/`.
APPLICATION CREATION IS FSM-DRIVEN.
ALL CREATION WRITES CROSS SECURED REST THEN COMPOSER.
LOGGER AND PROFILER ARE MANDATORY.
NO SILENT FALLBACK.
NO DELIVERY ROOT POLLUTION.
