# OWASYS P117T — REST + COMPOSER BACKEND SPECIFICATION

Date: 2026-07-23
Status: binding architecture specification
Supersedes: rejected P117S delivery artifact

## 1. Product boundary

OWASYS is split into two explicit layers:

```text
OWASYS current SCORE pages = frontend
OPUS REST API + Composer commands = backend
```

The current OWASYS pages remain the server-rendered frontend. They collect intent, use browser locale, SSO, deny-by-default ACL and the OWASYS FSM, then call the secured REST backend. They do not execute persistent business operations themselves.

The backend is generic OPUS infrastructure plus application-owned command providers. It accepts typed operation identifiers, invokes allow-listed public Composer scripts, delegates to `bin/opus`, and returns structured results.

## 2. Composer contract

Composer has exactly two OPUS product responsibilities:

1. install OPUS and its declared dependencies;
2. expose stable user commands for creating and administering OPUS applications.

`composer.json` must contain no smoke, audit, recipe, delivery check, report or arbitrary technical command.

Every public Composer script delegates to `bin/opus`. Composer contains no business implementation.

The CLI must be sufficient to create an OPUS application, add languages, create pages and rubrics, validate, inspect routes, serve and export without OWASYS.

## 3. Mandatory execution pipeline

```text
OWASYS SCORE frontend
-> browser locale negotiation
-> SSO identity
-> deny-by-default ACL
-> OWASYS FSM transition and guards
-> typed REST request
-> backend bearer + HMAC authentication
-> delegated identity validation
-> backend execution FSM
-> operation allow-list
-> public Composer script
-> bin/opus
-> typed OPUS service or application command provider
-> structured result
-> OWASYS ViewModel
-> SCORE rendering
```

There is no local web fallback and no direct frontend mutation.

## 4. REST resource

The minimum API surface is:

```text
GET  /v1/status
POST /v1/executions
```

The execution request contains a versioned contract, execution identifier, operation identifier, delegated SSO actor, typed parameters, issue time and expiry.

The API must never accept:

- a shell command;
- a Composer script name supplied by the browser;
- an executable path;
- a working-directory override;
- an absolute target path;
- environment-variable injection;
- unrestricted command options.

## 5. Backend placement

Generic REST, RCP, authentication, execution FSM, Composer registry and Composer executor classes belong to `Opus/`.

The OWASYS REST public entrypoint belongs to the existing OWASYS site under:

```text
sites/owasys/www/api/index.php
```

OWASYS backend and operation configuration belongs under:

```text
sites/owasys/config/
```

No new global `public/` root is authorized.

## 6. Security

Local development may use HTTP only on loopback. Any remote deployment requires HTTPS.

The default backend transport uses two independent environment secrets:

- bearer token for service authentication;
- HMAC key binding HTTP method, request path, timestamp, nonce and complete JSON body.

The nonce equals the execution identifier. Requests outside the configured clock skew, replayed execution identifiers, invalid signatures, unknown operations and unauthorized roles are rejected.

Passwords and other secrets are transmitted only in the protected request body and process standard input. They must never enter URLs, command-line arguments, process listings, logs, profiler events, exceptions, committed configuration or the differential ZIP.

Auth0 proxy and bastion support remain behind generic OPUS authentication and transport contracts. SSH is not the primary transport; it may be added later only as an optional generic OPUS adapter using the same typed allow-list.

## 7. Frontend responsibilities

The current OWASYS pages may only:

- render with SCORE;
- negotiate browser locale through OPUS I18n;
- authenticate through OPUS SSO;
- apply ACL and FSM navigation/guards;
- collect typed form input;
- call the REST backend through the generic OPUS REST client;
- map structured results to ViewModels and localized SCORE output.

The frontend must not open the Registry database, call credential mutation providers, write application files, run Composer, run PHP tools, execute Git or construct shell commands.

## 8. Backend responsibilities

The backend must:

- reauthenticate the calling service;
- verify HMAC integrity, timestamp and nonce;
- validate the delegated actor and allowed providers/roles;
- reapply operation ACL;
- run an explicit execution FSM;
- map the operation to a declared Composer script;
- validate every typed argument against its contract;
- execute Composer through a controlled argument array;
- transfer sensitive command input through standard input;
- return stable codes, message keys and structured results;
- persist only secret-free execution records.

## 9. Framework class contract

Every new concrete framework class must implement its homonymous interface. That interface extends:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

This applies to console, application runtime, scaffold, Composer, RCP, REST, security and execution-FSM classes.

## 10. Application standard

Applications created by Composer must be compliant immediately:

- Singleton architecture;
- `application/default + application/<module>`;
- FSM-module-first dispatch;
- browser-locale detection;
- OPUS I18n catalogs;
- deny-by-default ACL;
- session and Auth0-proxy SSO boundaries;
- SCORE-only rendered HTML;
- no UI-producing `echo`;
- no mixed HTML/PHP view;
- JavaScript only as progressive enhancement;
- minimal public entrypoint.

## 11. Configuration

All configuration files are read through `Opus\File\File` and parsed through the selected OPUS JSON, YAML/YML or XML parser via `StructuredFileLoader`.

Direct configuration reads using `file_get_contents`, local `json_decode`, ad hoc XML parsing or silent parser fallback are forbidden.

## 12. Delivery policy

OPUS code is not pushed directly by the assistant. Framework and OWASYS code is delivered as a differential ZIP for owner application, validation, commit and push.

The ZIP must contain no delivery README, manifest, report, smoke, audit, recipe or temporary file.

The only file directly at OPUS root may be the existing `composer.json`. No new top-level directory is authorized by this milestone.

Cleanup and launch instructions are supplied as CMD command blocks for the VS Code terminal, not as root delivery files.

## 13. Rejection record

`opus_owasys_p117s_rest_composer_api.zip` with SHA-256 `acb79eec5cc0ce4023e79e53963f203a2c143b78fa754a4411036170f3c4220e` is rejected.

Reasons:

- new global `public/rcp` tree;
- embedded delivery audit and check helpers;
- excessive unrelated delivery footprint;
- conflict with the no-root-pollution rule.

It must not be applied.

## 14. Acceptance criteria

P117T is accepted only when:

1. Composer exposes only user OPUS commands;
2. Composer can create a compliant application without OWASYS;
3. no smoke or audit alias exists in `composer.json`;
4. no delivery file or new global public root is introduced;
5. OWASYS pages remain the SCORE frontend;
6. every OWASYS business mutation crosses secured REST then Composer;
7. the backend accepts typed operations only;
8. bearer, HMAC, expiry, nonce/replay and ACL checks pass;
9. secret input never reaches argv or persistent execution records;
10. generic concrete classes satisfy the homonymous four-marker contract;
11. configuration uses File plus explicit structured parsers;
12. generated applications satisfy Singleton/FSM/I18n/ACL/SSO/SCORE/browser-locale rules;
13. PHP lint, JSON validation, ZIP integrity and root-layout checks pass;
14. Windows Composer, browser, Registry, password, Auth0/HTTPS and no-JavaScript tests pass on the owner environment.
