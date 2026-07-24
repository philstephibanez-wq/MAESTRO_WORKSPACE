# OPUS CURRENT STATE

Last updated: 2026-07-24.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `79f261854ee06a9f828fec389adca77d57323d00`
- Current committed milestone: P117U + HF1 + HF2 + HF3 + HF4 + HF6
- HF7 status: documented differential, not committed on `OPUS/master`
- Owner local repo: `H:/OPUS`

## Framework identity

OPUS is a generic framework, not an application.

OWASYS is an application built with OPUS. Its current SCORE pages are its frontend. Secured REST + Composer is its backend. Created sites are independent OPUS applications.

## Binding development contract

`CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`

This contract requires:

- source-of-truth and contract review before every patch;
- differential ZIP delivery for OPUS/OWASYS code;
- homonymous four-marker interfaces for every concrete OPUS class;
- Singleton/FSM/I18n/ACL/SSO/SCORE applications;
- browser locale as default locale source;
- configuration through File and explicit JSON/XML/YAML parsers;
- secured REST then Composer for every OWASYS business mutation;
- mandatory Logger and Profiler.

## Active artifact stack

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7
```

HF5 remains superseded.

## Confirmed committed state

HF6 is present at the current remote head. Public Composer aliases delegate to `Opus\Composer\ComposerScripts::run`.

The committed `composer.json` still contains the obsolete creation-start alias because HF7 is not yet applied.

The current code includes:

- generic Composer console and callback infrastructure;
- secured RCP/REST execution infrastructure;
- `File`, `Json`, `Xml`, `Yaml` and `StructuredFileLoader`;
- browser `Accept-Language` negotiation;
- Logger and Profiler contracts;
- homonymous four-marker interfaces for the reviewed concrete classes added after P117M.

## Concrete framework class contract

Every named concrete class under `Opus/**/*.php` implements directly its homonymous interface.

Every homonymous interface extends directly:

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

The real PHP tree is the source of truth. Historical RefBook catalogs do not attest current conformity.

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

Configuration is read through OPUS `File` and parsed through the explicit OPUS parser selected by `StructuredFileLoader`:

```text
JSON -> Json
XML -> Xml
YAML/YML -> Yaml
```

Direct local configuration reads and silent parser fallback are forbidden.

## OWASYS boundary

OWASYS is the application UI and orchestration layer.

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

HF7 workflow remains:

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

## Diagnostics

Backend:

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
```

Frontend workflows:

```text
sites/owasys/var/logs/owasys-frontend.log
sites/owasys/var/profiler/<trace_id>.json
```

No secret or raw sensitive parameter is recorded.

## HF7 artifact record

- ZIP documented: `opus_owasys_p117u_hf7_application_creation_profiles.zip`
- SHA-256 documented: `16e06b55f3cf2ffcc5118fe0e5c4f17cbc7b51fa437fd06f17bf3dc16ab48141`
- files: 45
- ZIP bytes: 54,906
- payload bytes: 176,634
- roots: `composer.json`, `Opus/`, `sites/`
- availability: not present in GitHub or the supplied attachment

No replacement OPUS/OWASYS code ZIP may be fabricated from the specification alone.

## Validated frontend command surface

```text
composer dump-autoload -o
composer opus:validate-site -- owasys
composer opus:list-routes -- owasys
composer opus:serve-site -- owasys --host=127.0.0.1 --port=8000
```

The committed Composer scripts do not expose a public backend-start alias. The real owner launcher must be recovered or a generic OPUS launcher must be specified before use.

## Pending

1. recover the original HF7 ZIP or exact HF7 source tree;
2. confirm the local owner base and divergence from `79f261854ee06a9f828fec389adca77d57323d00`;
3. apply or regenerate HF7 only from that exact source base;
4. regenerate optimized autoload;
5. validate OWASYS site and routes;
6. start the secured backend with its real contractual launcher;
7. start the SCORE frontend;
8. validate Creation and the three profiles;
9. validate Registry selection, Build transition and correlated traces;
10. validate password, no-JavaScript, Auth0, HTTPS, bastion and platform gates;
11. commit OPUS after owner acceptance;
12. decide separately whether `sites/owasys_old` can be removed.
