# OPUS CURRENT STATE

Last updated: 2026-07-24.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`
- Owner local repo: `H:/OPUS`

## Framework identity

OPUS is a generic framework, not an application.

OWASYS is an application built with OPUS. Its current SCORE pages are its frontend. Secured REST + Composer is its backend. Created sites are independent OPUS applications.

## Active artifact stack

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7
```

HF5 remains superseded.

## Confirmed backend state

HF6 is operational in the owner environment. Registry synchronization completed through secured REST and Composer with process exit code `0` and execution FSM state `succeeded`.

## HF7 cause

Both `owasys_old` and current OWASYS transitioned `create_new_app` directly from Registry to Build/Validate. The current implementation also invoked an obsolete creation-start Registry command.

## HF7 workflow

```text
registry
-> creation
-> choose frontend/backend/fullstack
-> REST site.create
-> Composer opus:create-site
-> OPUS scaffold
-> Registry synchronize/select
-> build
```

Failure stays in Creation. Cancellation returns to Registry.

## OPUS profile support

The existing generic `SiteScaffoldPlan` is profile-aware:

```text
frontend
backend
fullstack
```

`SiteCommandService` and `OpusConsoleApplication` expose `--profile`. Direct CLI defaults to fullstack. The secured OWASYS REST operation requires an explicit profile.

Generated sites declare `OPUS_APPLICATION_PROFILE_V1`, matching kind/capabilities and remain Singleton, FSM-module-first, I18n/browser-locale aware, ACL deny-by-default, SSO/Auth0-proxy ready and SCORE-rendered.

Modified concrete framework classes retain their homonymous four-marker interfaces. No new concrete OPUS class is introduced.

## OWASYS creation module

Application-owned location:

```text
sites/owasys/application/creation/
```

The module contains a SCORE form, FSM controller, REST projection model and base-language I18n catalogs. It performs no direct site write or process execution.

Removed obsolete active artifacts:

```text
registry.creation.start
owasys:registry-creation-start
owasys:registry:creation:start
start_creation_flow
```

The Registry command provider projects canonical standard OPUS sites and maps application profile type to Registry kind. Created sites are selected through secured Registry commands before Build.

## Diagnostics

Backend:

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
```

Frontend creation:

```text
sites/owasys/var/logs/owasys-frontend.log
sites/owasys/var/profiler/<trace_id>.json
```

No secret or raw form parameter is recorded.

## HF7 artifact

- ZIP: `opus_owasys_p117u_hf7_application_creation_profiles.zip`
- SHA-256: `16e06b55f3cf2ffcc5118fe0e5c4f17cbc7b51fa437fd06f17bf3dc16ab48141`
- files: 45
- ZIP bytes: 54,906
- payload bytes: 176,634
- roots: `composer.json`, `Opus/`, `sites/`

## Validation

Green:

- PHP lint and JSON parse;
- ZIP integrity;
- Composer aliases contain no smoke/audit/test/recipe;
- profile CLI and RCP argument forwarding;
- frontend/backend/fullstack scaffold generation;
- generated file and generated-site validation;
- FSM creation transitions;
- creation model REST fixture;
- standard site Registry discovery;
- interface/four-marker checks;
- no obsolete creation-start operation;
- no UI echo/config-parser bypass.

## Pending

1. apply HF7 after HF6;
2. regenerate optimized autoload;
3. validate OWASYS site and routes;
4. start backend and frontend;
5. validate visual Creation state;
6. generate disposable frontend/backend/fullstack applications;
7. validate Registry selection and Build transition;
8. validate failure traces and remaining password/browser/Auth0/platform gates;
9. commit OPUS after owner acceptance.
