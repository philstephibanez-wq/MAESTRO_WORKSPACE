# OPUS CURRENT STATE

Last updated: 2026-07-24.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `79f261854ee06a9f828fec389adca77d57323d00`
- Current committed milestone: P117U + HF1 + HF2 + HF3 + HF4 + HF6
- HF7 status: exact differential recovered and verified, not committed on `OPUS/master`
- Owner local repo: `H:/OPUS`

## Framework identity

OPUS is a generic framework, not an application.

OWASYS is an application built with OPUS. Its SCORE pages are its frontend. Secured REST + Composer is its backend. Created sites are independent OPUS applications.

## Binding contracts

- `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md`
- `CONTEXT/SPECIFICATIONS/OPUS_ALL_CONCRETE_CLASSES_COMPONENT_CONTRACT_SPEC_P117M.md`
- `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`

## Active artifact stack

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7
```

HF5 remains superseded.

## Confirmed committed state

HF6 is present at the current remote head. Public Composer aliases delegate to `Opus\Composer\ComposerScripts::run`.

The committed `composer.json` still contains the obsolete alias `owasys:registry-creation-start` because HF7 is not yet applied.

The current framework includes:

- generic Composer console and callback infrastructure;
- secured RCP/REST execution infrastructure;
- `File`, `Json`, `Xml`, `Yaml` and `StructuredFileLoader`;
- browser `Accept-Language` negotiation;
- Logger and Profiler contracts;
- homonymous four-marker interfaces for the reviewed concrete classes added after P117M.

## Concrete framework class contract

Every named concrete class under `Opus/**/*.php` directly implements its homonymous interface. That interface directly extends:

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

The comparison from P117M to the current head shows class/interface pairs for the new or modified framework classes in the active perimeter. The exhaustive tokenizer gate must still be executed on the complete owner tree after HF7.

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

## HF7 cause and workflow

Both `owasys_old` and current OWASYS transitioned `create_new_app` directly from Registry to Build/Validate. The current implementation also invoked an obsolete creation-start Registry command.

HF7 replaces that path with:

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

## HF7 artifact verified

- ZIP: `opus_owasys_p117u_hf7_application_creation_profiles.zip`
- SHA-256: `16e06b55f3cf2ffcc5118fe0e5c4f17cbc7b51fa437fd06f17bf3dc16ab48141`
- files: 45
- ZIP bytes: 54,906
- payload bytes: 176,634
- roots: `composer.json`, `Opus/`, `sites/`
- availability: recovered from the retained artifact library and materialized without reconstruction

Integrity ZIP, SHA-256, PHP lint for the differential PHP files and JSON parsing have been verified.

## Validated launch surface

```text
composer dump-autoload -o
composer opus:validate-site -- owasys
composer opus:list-routes -- owasys
composer opus:serve-site -- owasys --host=127.0.0.1 --port=8792
composer opus:serve-site -- owasys --host=127.0.0.1 --port=8000
```

The backend route is `/api/v1`; the OWASYS client targets `http://127.0.0.1:8792/api/v1/executions`.

## Pending

1. confirm the owner local tree is clean and based on the expected HF6 head;
2. apply HF7;
3. regenerate optimized autoload;
4. run the exhaustive P117M tokenizer gate and full lint;
5. validate OWASYS site and routes;
6. start backend then frontend;
7. validate Creation and the three profiles;
8. validate Registry selection, Build transition and correlated traces;
9. validate password, no-JavaScript, Auth0, HTTPS, bastion and platform gates;
10. commit OPUS after owner acceptance;
11. decide separately whether `sites/owasys_old` can be removed.
