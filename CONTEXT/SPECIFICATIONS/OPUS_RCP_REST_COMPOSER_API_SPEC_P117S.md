# OPUS P117S — API REST RCP / COMPOSER

Date: 2026-07-23
Status: binding architecture specification
Supersedes: P117R implementation artifacts and any interpretation that exposes smokes, audits or arbitrary technical commands through Composer

## 1. Purpose

P117S establishes the canonical remote-command boundary used by OWASYS.

OWASYS is only the interactive web UI. Every OWASYS business operation that executes or mutates persistent state is submitted to a generic OPUS REST API, which maps a typed, allow-listed operation to an existing public Composer command.

```text
OWASYS SCORE form
-> browser locale
-> SSO identity
-> deny-by-default ACL
-> FSM signal and guards
-> typed REST execution request
-> generic OPUS RCP REST server
-> allow-listed public Composer script
-> bin/opus
-> typed OPUS or application command provider
-> structured result
-> OWASYS ViewModel
-> SCORE
```

There is no local execution fallback in OWASYS.

## 2. Composer boundary

Composer has exactly two product responsibilities in OPUS:

1. install OPUS and its declared dependencies;
2. expose stable user commands for creating, inspecting, serving and administering OPUS applications.

The root `composer.json` must not expose:

- smoke tests;
- audits;
- recipes;
- CI helpers;
- development reports;
- arbitrary shell commands;
- free-form process execution;
- a second technical command catalog dedicated to OWASYS.

Smokes, audits and recipes remain internal files invoked directly by development or CI tooling. They are not public Composer scripts.

Composer scripts delegate to `bin/opus`; Composer contains no business logic.

Canonical examples:

```text
composer opus:create-application -- my-app --write
composer opus:create-site -- my-site --write
composer opus:add-language -- my-site fr-BE --write
composer opus:create-page -- my-site blog archive /blog/archive --write
composer opus:create-rubric -- my-site news /news --write
composer opus:validate-site -- my-site
composer opus:list-routes -- my-site
composer opus:serve-site -- my-site
```

## 3. REST RCP resource model

The primary REST resource is an execution.

```text
POST /v1/executions
GET  /v1/executions/{execution_id}
GET  /v1/operations
GET  /v1/status
```

The API accepts a stable operation identifier and typed arguments. It never accepts an executable, Composer script name, shell fragment, working directory, absolute target path or environment override from the browser.

Example request shape:

```json
{
  "contract": "OPUS_RCP_REST_EXECUTION_REQUEST_V1",
  "operation": "site.create",
  "correlation_id": "...",
  "actor": {
    "subject": "...",
    "roles": ["developer"],
    "provider": "auth0-proxy"
  },
  "arguments": {
    "site_id": "my-site",
    "write": true
  }
}
```

The server maps `site.create` to the public Composer script `opus:create-site`. The mapping is framework-owned and loaded from structured configuration.

## 4. Security

The default deployment is HTTPS. Plain HTTP is allowed only on an actual loopback endpoint for local development.

Authentication modes are framework contracts. The first supported modes are:

- environment bearer for local or controlled service-to-service execution;
- trusted Auth0 proxy/bastion identity, authenticated with a server-side shared secret or future certificate-bound mechanism.

The command side revalidates:

- request authentication;
- actor identity shape;
- deny-by-default role authorization;
- operation allow-list membership;
- typed argument constraints;
- execution lifecycle;
- target identifiers and relative paths.

Secrets must never appear in:

- URL or query string;
- Composer or PHP command-line arguments;
- process listing;
- logs or profiler payloads;
- exception text;
- browser-visible raw process output;
- committed configuration;
- differential ZIP metadata.

Secret request fields travel only in the protected HTTP body and then through protected standard input to `bin/opus`.

## 5. FSM execution lifecycle

Every REST execution is driven by a framework FSM with explicit states, at minimum:

```text
received
-> authenticated
-> authorized
-> dispatching
-> succeeded | failed
```

Unknown transitions fail explicitly. No state is inferred silently.

OWASYS also keeps its presentation FSM authoritative. The remote execution lifecycle does not replace the OWASYS navigation and form FSM; both layers remain synchronized through typed results.

## 6. OPUS framework placement

Generic components belong to OPUS, including:

- REST server and client;
- request authentication;
- typed identity;
- execution state machine;
- execution store;
- Composer operation registry;
- Composer process executor;
- public console application;
- application command-provider dispatcher;
- generic generated-site runtime and scaffold plan.

OWASYS may contain application-specific command providers for OWASYS domain operations, but it must not contain a generic REST, Composer, SSH or process-execution implementation.

SSH may later be added only as an optional generic OPUS transport adapter. It is not the primary P117S transport and must obey the same typed allow-list.

## 7. Contractual interfaces

Every new or modified concrete framework class must implement its homonymous interface.

That interface extends directly:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The exhaustive P117M component audit remains mandatory.

Application-owned concrete classes should also have explicit homonymous contracts. They must not weaken the framework rule.

## 8. Configuration boundary

All OPUS, site, REST, RCP, ACL, SSO, FSM, route, locale and command-provider configuration is read through `Opus\File\File` and parsed through the selected OPUS JSON, YAML/YML or XML parser using `StructuredFileLoader`.

Direct `file_get_contents()` plus local JSON/XML/YAML parsing is forbidden for configuration.

No format fallback is allowed.

## 9. Generated application contract

Composer-created applications must be conformant immediately after generation.

They use:

```text
sites/<site>/
  application/
    default/
      bootstrap.php
      Application.php
      layouts/
      local/
      navigation/
      templates/
      views/
    <module>/
      acl/
      helpers/
      javascript/
      local/
      models/
      templates/
      views/
  config/
  www/
    index.php
    asset/
```

`application/states` is forbidden.

The generated application must provide:

- Singleton composition root;
- `fsm-module-first` dispatch;
- browser locale negotiation;
- OPUS I18n catalogs;
- deny-by-default ACL;
- session and Auth0 proxy SSO boundaries;
- SCORE-only HTML rendering;
- minimal `www/index.php` delegating to `application/default/bootstrap.php`;
- no UI-producing `echo` in application code;
- no PHP/HTML mixed view;
- no JavaScript-owned routing, permissions, layout or state.

## 10. OWASYS migration

All persistent OWASYS operations cross REST RCP and Composer, including:

- application/site create and export;
- language, page and rubric creation;
- Registry synchronization;
- application selection persistence;
- clearing persisted current-application context;
- starting application creation flow;
- password bootstrap, reset and change;
- structure, source, build and Git mutations when those surfaces are restored;
- future Auth0 proxy and bastion administration.

OWASYS may retain read projections in its web process. It may not write SQLite, files, Git state, credentials or generated application state directly.

## 11. Delivery policy

Governance files are written directly to MAESTRO_WORKSPACE on GitHub.

OPUS and OWASYS code is delivered only as a differential ZIP against the exact declared OPUS commit. The assistant does not push OPUS code directly.

The ZIP must not pollute the OPUS root. `composer.json` may be the only root-level entry when it is legitimately modified. Delivery notes, reports, manifests, CMD helpers and audits must not be placed at OPUS root.

CMD launch and cleanup helpers belong under a dedicated product directory such as `bin/cmd`.

## 12. Acceptance gates

P117S is acceptable only when:

1. Composer contains only public user OPUS commands;
2. no smoke or audit alias remains in Composer;
3. `bin/opus` can create a complete conformant OPUS application;
4. the generated tree is module-first and contains no `application/states`;
5. generated UI is SCORE-only and the public entrypoint is minimal;
6. browser locale negotiation and canonical OPUS I18n catalogs work;
7. REST accepts only typed allow-listed operations;
8. REST authentication, ACL and FSM gates execute before Composer;
9. OWASYS web code performs no direct persistent mutation for migrated operations;
10. passwords and tokens never enter command-line arguments or output;
11. configuration uses File plus StructuredFileLoader;
12. all new framework concrete classes satisfy homonymous four-marker interfaces;
13. PHP lint, structured-config validation, static architecture audit and ZIP integrity pass;
14. real Windows Composer execution and browser acceptance are completed by the owner;
15. no rejected P117R artifact remains in the target checkout.

## 13. Permanent rules

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
NO DELIVERY FILE POLLUTION IN OPUS ROOT.
COMPOSER EXPOSES USER COMMANDS ONLY.
OWASYS IS WEB UI ONLY.
OWASYS BUSINESS MUTATIONS USE REST RCP THEN COMPOSER.
BACKEND FIRST.
SCORE FIRST.
JAVASCRIPT IS PROGRESSIVE ENHANCEMENT ONLY.
SECRETS NEVER ENTER COMMAND-LINE ARGUMENTS OR LOGS.
