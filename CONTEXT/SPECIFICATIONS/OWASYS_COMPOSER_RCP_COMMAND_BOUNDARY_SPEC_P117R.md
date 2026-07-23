# OWASYS P117R — COMPOSER / RCP COMMAND BOUNDARY SPECIFICATION

Date: 2026-07-23
Status: binding architecture specification

## 1. Purpose

OWASYS is exclusively the interactive graphical application-management surface for OPUS.

OWASYS must not own, duplicate or execute application-management, framework-management, security-administration, filesystem, build, export, source-control or credential mutation logic.

Every operation initiated from OWASYS must cross the following mandatory boundary:

```text
OWASYS SCORE form
-> authenticated request
-> SSO identity
-> deny-by-default ACL
-> FSM signal and guards
-> immutable command intent
-> RCP request
-> allow-listed Composer command
-> OPUS command handler
-> structured result
-> OWASYS ViewModel
-> SCORE rendering
```

The identifier `RCP` is retained exactly as the project term. No alternate local execution path, shell fallback or in-process mutation is authorized.

## 2. Absolute rule

All executable operations exposed by OWASYS are Composer commands invoked through RCP.

This includes, without limitation:

- site creation, preview, validation, update, migration, duplication and removal;
- application structure draft, preview, apply and rollback;
- source read/write workflows when they mutate state;
- build preview, build, package and export;
- Registry synchronization and write operations;
- selection or reconciliation operations that persist application context outside the web session;
- Git status mutations, staging and commit;
- cache, generated file and obsolete-tree cleanup;
- configuration writes;
- user bootstrap;
- administrator password creation, reset and change;
- SSO provider administration;
- ACL or role administration;
- future Auth0 proxy and bastion administration;
- diagnostic, repair and migration operations;
- any future action that changes persistent or external state.

A GET-only read projection may be produced by OPUS services, but OWASYS must not implement the underlying domain logic itself.

## 3. OWASYS responsibilities

OWASYS may only:

- collect user intent through SCORE-rendered forms;
- validate presentation-level shape before dispatch;
- display dry-run and preview information returned by the command layer;
- request explicit confirmation for destructive or credential-sensitive operations;
- submit a typed command intent through the RCP client;
- display progress, success, warning and failure states returned by RCP;
- keep navigation, authorization and command lifecycle synchronized through FSM;
- localize all visible labels and messages through OPUS I18n.

OWASYS must never:

- instantiate a mutating repository, writer, exporter, builder or credential provider to perform an operation;
- call password mutation APIs directly;
- call filesystem write functions for domain operations;
- execute `proc_open`, `exec`, `shell_exec`, `system`, `passthru` or backticks;
- construct a free-form command line;
- invoke a PHP tool directly as an alternative to Composer;
- bypass RCP when the RCP service is unavailable;
- silently downgrade to an in-process implementation;
- expose a generic terminal or arbitrary command field.

## 4. Composer command contract

The root `composer.json` is the public command catalog.

Each operation has one stable, allow-listed Composer script identifier. Recommended naming:

```text
opus:site:create
opus:site:validate
opus:site:build
opus:site:export
opus:site:structure:preview
opus:site:structure:apply
opus:source:preview
opus:source:write
opus:git:stage
opus:git:commit
opus:registry:sync
opus:security:user:bootstrap
opus:security:admin-password:change
opus:security:admin-password:reset
opus:security:sso:configure
opus:maintenance:cleanup
```

Each Composer script delegates to a typed PHP command handler. The handler owns validation, authorization re-checks, dry-run, confirmation-token verification, mutation, audit and structured output.

Composer script aliases must not contain platform-specific shell chains. The PHP handler must be portable on supported Windows and Linux environments.

## 5. RCP request contract

Every RCP request is a structured envelope containing at least:

- contract version;
- command identifier;
- correlation identifier;
- authenticated actor identifier;
- actor roles and trusted identity claims required by policy;
- target application identifier;
- immutable typed arguments;
- execution mode: `preview`, `apply` or `status`;
- confirmation token when required;
- request timestamp and expiry;
- integrity/authentication material defined by the RCP transport contract.

Forbidden request content:

- arbitrary executable strings;
- shell fragments;
- working-directory overrides supplied by the browser;
- absolute target paths supplied by the browser;
- Composer script names supplied directly by an untrusted form field;
- environment-variable injection;
- unbounded command options.

The RCP server maps a stable operation identifier to an allow-listed Composer script. The client never selects an executable path.

## 6. RCP response contract

Every response is structured and contains at least:

- contract version;
- correlation identifier;
- command identifier;
- status: `accepted`, `preview`, `running`, `succeeded`, `rejected` or `failed`;
- stable result/error code;
- localized-message key and structured parameters;
- dry-run or mutation summary;
- changed-resource list without secret values;
- audit reference;
- timestamps;
- retryability indicator.

Raw stack traces, secrets, passwords, tokens and unrestricted process output must never be returned to the browser.

## 7. Credential and administrator-password operations

Administrator password bootstrap, reset and change are command operations and must use Composer through RCP.

OWASYS must not call `SsoManager::changePassword()`, `LocalPasswordSsoProvider::changePassword()` or any equivalent mutation method directly.

Credential requirements:

- HTTPS or an equivalently protected authenticated RCP transport;
- password fields excluded from logs, traces, profiler payloads, audit detail and exception messages;
- no password in URL, query string, command-line argument, process listing or Composer script name;
- secret input passed through a protected request body or protected standard input mechanism defined by RCP;
- confirmation and current-password checks performed by the command handler;
- password policy loaded from OPUS configuration;
- successful audit records contain actor, subject, command, time and result but never secret material;
- failed operations return stable error codes only;
- memory copies cleared where technically possible after use;
- no committed credential store or generated secret in the differential delivery.

## 8. Configuration loading

All command, site, ACL, SSO and RCP configuration files are read through `Opus\File\File` and parsed through the selected OPUS JSON, YAML/YML or XML parser via `Opus\File\StructuredFileLoader`.

Direct `file_get_contents()` plus local JSON/XML/YAML parsing is forbidden for application configuration.

No silent format fallback is authorized.

## 9. Framework placement

Generic command, Composer-dispatch, RCP envelope, RCP client/server, audit and result contracts belong to the OPUS framework.

OWASYS contains only application-specific presentation adapters and ViewModel mapping.

Any new concrete OPUS framework class must implement its homonymous interface. That interface extends directly:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The P117M-R1 exhaustive component audit remains mandatory.

## 10. FSM, ACL and SSO

No command can be submitted outside the authoritative pipeline:

```text
request
-> browser/regional locale
-> SSO identity
-> ACL deny-by-default
-> route signal
-> FSM transition and guards
-> RCP command submission
-> command lifecycle transition
-> ViewModel
-> SCORE
```

The command handler revalidates authorization. Browser-side state and OWASYS session state are not sufficient authorization.

Auth0 proxy and bastion implementations remain behind the OPUS SSO and RCP boundaries.

## 11. Rendering

OWASYS remains SCORE-only:

- no UI-producing `echo`;
- no mixed PHP/HTML view;
- no JavaScript command router;
- no JavaScript-owned permissions or command state;
- JavaScript is progressive enhancement only;
- final status and error rendering is server-side.

## 12. Migration rule

Existing direct mutations are contract violations and must be migrated operation by operation.

Known current violation to remove first:

- the account password FSM action calls the local runtime security password mutation path directly.

Migration sequence:

1. inventory every OWASYS POST action and mutating service call;
2. define the stable Composer command catalog;
3. define the RCP transport and envelope contracts;
4. implement generic OPUS command/RCP framework classes with homonymous interfaces;
5. implement typed command handlers;
6. replace OWASYS direct mutations with RCP command intents;
7. add static and runtime gates forbidding direct mutation paths;
8. validate preview/apply lifecycle, ACL, SSO, FSM, I18n and SCORE;
9. remove obsolete local mutation code only after parity is proven;
10. keep `sites/owasys_old` as a rejected reference root until the owner authorizes deletion.

## 13. Security gates

The implementation must reject:

- unknown command identifiers;
- commands not declared in the Composer command catalog;
- arbitrary Composer arguments;
- command execution without authenticated RCP identity;
- expired or replayed requests;
- missing confirmation token for destructive operations;
- target paths outside the canonical selected application;
- attempts to mutate `.git`, secrets or authentication stores outside the specific authorized command;
- direct OWASYS calls to mutating framework services;
- direct OWASYS process execution;
- plaintext secret logging.

## 14. Git and delivery policy

Governance and handoff files are written directly to `MAESTRO_WORKSPACE` on GitHub.

OPUS code is not pushed directly by the assistant. OPUS and OWASYS changes are delivered as a differential ZIP for local application, validation, commit and push by the owner.

Cleanup and launch commands are supplied as CMD commands for the VS Code terminal.

## 15. Acceptance criteria

P117R is complete only when:

1. every mutating OWASYS action is inventoried;
2. every operation has a stable allow-listed Composer command;
3. all command submissions cross RCP;
4. OWASYS contains no direct persistent mutation implementation;
5. administrator password bootstrap/reset/change cross Composer and RCP;
6. no secret appears in command-line arguments, logs or output;
7. generic command/RCP classes live in OPUS and satisfy P117M-R1;
8. configuration uses `File` plus the selected structured parser;
9. ACL and SSO are revalidated by command handlers;
10. command lifecycle is driven by FSM;
11. all visible output is localized and rendered through SCORE;
12. no shell fallback or arbitrary command execution exists;
13. Windows and Linux command execution paths are portable;
14. PHP lint, JSON/YAML/XML validation, P117M-R1 audit and `git diff --check` pass;
15. browser validation confirms that OWASYS remains only the interactive graphical surface.
