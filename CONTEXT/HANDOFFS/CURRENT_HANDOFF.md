# CURRENT HANDOFF — MAESTRO WORKSPACE

Date: 2026-07-24

## Active milestone

P117U with mandatory HF1, HF2, HF3, HF4, HF6 and HF7.

```text
OPUS = generic framework
OWASYS = application built with OPUS
OWASYS current pages = SCORE frontend
secured REST + Composer = OWASYS backend
created sites = independent OPUS applications
```

OPUS is not an application.

## Source of truth

- OPUS repository: `philstephibanez-wq/OPUS`
- branch: `master`
- remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`
- HF7 specification: `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_SPEC.md`
- HF7 handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_2026-07-24.md`
- site contract: `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`

## Only admitted OPUS root

Directories:

```text
.git .github application Config DOC Opus packages runtime scripts sites tools vendor
```

Root files:

```text
.gitignore AGENTS.md composer.json composer.lock composer.phar LICENSE README.md
```

No root `bin/`, lowercase root `config/`, root `public/` or new root.

## Mandatory clean-base order

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7
```

HF5 is superseded. If already applied, it may remain; no rollback is required.

## Confirmed runtime state

HF6 is operational in the owner environment. `registry.sync` completed through REST and Composer with process exit code `0`; the backend execution FSM reached `succeeded`.

## Historical creation defect

`sites/owasys_old` and current OWASYS both contained:

```text
registry + create_new_app -> build
```

The old implementation already mislabeled Build/Validate as creation mode. This behavior is rejected and removed from the active workflow.

## HF7 canonical workflow

```text
Registry
-> create_new_app
-> Creation
-> choose frontend | backend | fullstack
-> REST site.create
-> Composer opus:create-site
-> generic OPUS profile-aware scaffold
-> Registry synchronize
-> Registry select
-> application_created
-> Build and validation
```

Failure remains in Creation. Cancellation returns to Registry.

## OPUS framework profile contract

The existing `SiteScaffoldPlan` supports:

```text
frontend
backend
fullstack
```

Direct CLI defaults to `fullstack` for backward compatibility. OWASYS REST requires an explicit profile.

Generated sites declare:

```text
OPUS_APPLICATION_PROFILE_V1
```

and remain Singleton, FSM-module-first, I18n/browser-locale aware, deny-by-default ACL, SSO/Auth0-proxy ready and SCORE-rendered.

Modified concrete OPUS classes retain homonymous interfaces extending all four mandatory markers. HF7 introduces no new concrete framework class.

## OWASYS application boundary

The creation workflow belongs under:

```text
sites/owasys/application/creation/
```

The frontend collects the application ID and profile. It performs no direct file write and launches no process. The mutation crosses secured REST then Composer.

Obsolete creation-start artifacts are removed:

```text
registry.creation.start
owasys:registry-creation-start
owasys:registry:creation:start
start_creation_flow
```

The Registry command provider projects canonical `OPUS_SITE_STANDARD_CONTRACT_CORE` sites and maps profile type to Registry kind. New applications are selected through the existing secured Registry operation before Build.

## ACL / I18n / SCORE

- authenticated creation workflow;
- deny-by-default `creation:open` / `creation:write`;
- browser locale preserved;
- base-language creation catalogs loaded through OPUS I18n;
- SCORE-only UI;
- no UI-producing echo or mixed PHP/HTML view.

## Logger and Profiler

Backend diagnostics from HF4 remain mandatory:

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
```

HF7 adds frontend creation lifecycle diagnostics:

```text
sites/owasys/var/logs/owasys-frontend.log
sites/owasys/var/profiler/<trace_id>.json
```

No parameters, credentials, tokens or HMAC values are logged or profiled.

## HF7 artifact

- ZIP: `opus_owasys_p117u_hf7_application_creation_profiles.zip`
- SHA-256: `16e06b55f3cf2ffcc5118fe0e5c4f17cbc7b51fa437fd06f17bf3dc16ab48141`
- files: 45
- ZIP bytes: 54,906
- payload bytes: 176,634

Top-level entries:

```text
composer.json
Opus/
sites/
```

No new root directory, smoke, audit, test, report, README, manifest, cache or temporary file.

## Validation completed

Green:

- PHP lint and JSON parse;
- ZIP integrity;
- Composer user-command-only aliases;
- framework homonymous four-marker interfaces;
- profile CLI and RCP argument forwarding;
- distinct frontend/backend/fullstack scaffold fixtures;
- generated PHP/JSON and generated-site validation for all profiles;
- FSM Registry/Creation/Build transitions and failure loop;
- creation model REST fixture;
- standard-site Registry discovery fixture;
- no obsolete creation-start operation;
- no direct configuration parser bypass;
- no UI-producing echo in creation.

## Pending owner gates

- apply HF7;
- regenerate optimized Composer autoload;
- validate OWASYS site/routes;
- start backend then frontend;
- verify the new Creation state visually;
- create disposable frontend, backend and fullstack applications;
- verify Registry selection and Build transition;
- validate failure rendering and trace correlation;
- validate password, no-JavaScript, Auth0, HTTPS, bastion and Windows/Linux parity.

## Permanent rules

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
ONLY THE OWNER-CONFIRMED OPUS ROOT IS ADMITTED.
COMPOSER EXPOSES USER COMMANDS ONLY.
OPUS IS A FRAMEWORK, NOT AN APPLICATION.
OWASYS IS AN APPLICATION BUILT WITH OPUS.
NO OWASYS BUSINESS IMPLEMENTATION UNDER `Opus/`.
ALL OWASYS BUSINESS WRITES CROSS SECURED REST THEN COMPOSER.
LOGGER AND PROFILER ARE MANDATORY.
EVERY CONCRETE OPUS CLASS IS EXCEPTION-AWARE AND PROFILER-AWARE.
SECRETS NEVER ENTER GIT, ARGV, LOGS, PROFILER PAYLOADS OR DELIVERY ARTIFACTS.
SCORE AND BACKEND-FIRST ARE MANDATORY.
