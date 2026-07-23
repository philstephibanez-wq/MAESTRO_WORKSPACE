# MAESTRO_WORKSPACE HANDOFF — OPUS / OWASYS P117S REST COMPOSER API

Date: 2026-07-23
Status: governance committed; differential ZIP prepared; isolated validation green; owner Windows/Composer/browser validation pending
Source OPUS head: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`

## Binding specification

`CONTEXT/SPECIFICATIONS/OPUS_RCP_REST_COMPOSER_API_SPEC_P117S.md`

P117S supersedes every P117R code artifact. P117R confused the public Composer command surface with technical smoke/audit aliases and produced rejected root pollution.

## Differential artifact

- ZIP: `opus_owasys_p117s_rest_composer_api.zip`
- SHA-256: `acb79eec5cc0ce4023e79e53963f203a2c143b78fa754a4411036170f3c4220e`
- Files: 58
- Bytes: 65,973
- Base: OPUS `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Only root entry: `composer.json`
- OPUS repository was not written directly by the assistant

ZIP integrity was verified and no corrupt entry was found.

## Composer contract restored

Composer has only two product responsibilities:

1. install OPUS and dependencies;
2. expose stable user OPUS commands.

The delivered `composer.json` contains no smoke or audit alias.

Public commands include:

```text
opus
opus:create-application
opus:create-site
opus:owasys-create
opus:owasys-export
opus:add-language
opus:serve-site
opus:validate-site
opus:list-routes
opus:create-page
opus:create-rubric
opus:security:admin-password-change
opus:registry-sync
opus:registry-select
opus:registry-clear
opus:registry-creation-start
```

Every script delegates to `bin/opus`.

## REST RCP architecture

```text
OWASYS SCORE UI
-> browser locale
-> SSO identity
-> ACL
-> OWASYS FSM
-> POST /v1/executions
-> generic OPUS REST RCP server
-> REST authentication
-> delegated actor validation
-> RCP execution FSM
-> operation allow-list
-> public Composer script
-> bin/opus
-> OPUS service or application command provider
-> structured JSON result
-> OWASYS projection/ViewModel
-> SCORE
```

REST routes:

```text
GET  /v1/status
GET  /v1/operations
POST /v1/executions
GET  /v1/executions/{execution_id}
```

Plain HTTP is accepted only for loopback local development. Remote endpoints require HTTPS.

## Generic OPUS components

P117S adds generic OPUS contracts for:

- public console application;
- site/application user-command service;
- application archive exporter;
- administrator-password command service;
- application command-provider dispatcher;
- canonical OPUS application scaffold;
- generated site runtime;
- Composer operation registry;
- Composer executor;
- RCP execution FSM;
- RCP identity and request authentication;
- REST execution store, server and client.

Every new concrete framework class implements a homonymous interface extending the four standard markers.

Existing modified framework classes remain behind their existing homonymous four-marker interfaces:

- `Opus\Http\Response`;
- `Opus\Fsm\FsmProcessor`;
- `Opus\Fsm\FsmSiteLoader`.

## Composer-generated OPUS applications

The Composer scaffold is rebuilt on the current module-first contract.

It generates:

- `application/default` common bootstrap/layout/I18n;
- `application/<module>` functional modules;
- no `application/states` directory;
- Singleton application composition root;
- `fsm-module-first` configuration;
- deny-by-default ACL;
- session plus Auth0-proxy SSO configuration;
- canonical OPUS I18n JSON catalogs;
- browser locale negotiation;
- SCORE layouts and templates;
- minimal `www/index.php` delegating to `application/default/bootstrap.php`;
- public assets only under `www/asset`.

The validation command rejects forbidden `application/states`, missing modules, missing SCORE/view files, invalid ACL/SSO/FSM contracts and invalid Singleton bootstraps.

## Configuration boundary

`FsmProcessor` and `FsmSiteLoader` were corrected so FSM configuration crosses `StructuredFileLoader` rather than direct `file_get_contents()` plus `json_decode()`.

Generated site, REST, RCP, Composer-operation, ACL, SSO, route and locale configuration crosses OPUS File/structured parsers.

## SCORE and output

- generated application interface is rendered only through SCORE;
- OWASYS public front controller is reduced to a minimal bootstrap include;
- `Opus\Http\Response` writes through `php://output` and contains no `echo` token;
- generated application PHP files contain no UI-producing `echo` and no mixed PHP/HTML views.

## OWASYS command migration

Migrated through REST RCP then Composer:

- application/site creation;
- site validation;
- route listing;
- language creation;
- page creation;
- rubric creation;
- application export;
- administrator-password change;
- Registry synchronization and snapshot;
- persisted application selection;
- persisted current-application clearing;
- application-creation-flow start.

The OWASYS web Registry model no longer opens the SQLite repository. It consumes an in-memory projection returned by the Composer-side Registry command provider.

The command side alone opens the Registry repository and performs its mutations.

## Security

- no browser-supplied executable or Composer script;
- no free-form shell command;
- Composer process uses an argument array with shell bypass;
- operation and arguments come from structured allow-list configuration;
- bearer or Auth0-proxy authentication precedes authorization;
- delegated roles and providers are restricted by server configuration;
- command-side ACL is revalidated;
- execution identifiers reject replay;
- password payload travels in protected HTTP body and standard input, never process arguments;
- local development token is generated in ignored `.env.rcp.local`;
- no token or password is included in the ZIP.

## CMD helpers

Delivered under `bin/cmd`, never at OPUS root:

```text
CLEAN_P117R_REJECTED_RCP.cmd
CHECK_P117S_REST_COMPOSER.cmd
INIT_LOCAL_RCP_SECRET.cmd
START_OPUS_RCP_REST.cmd
START_OWASYS.cmd
CLEAN_LOCAL_RCP_SECRET.cmd
```

The P117R cleanup removes rejected framework files, tools and root-level delivery pollution.

## Validation completed

- PHP syntax validation for all 46 PHP files in the differential;
- JSON parsing for every differential JSON file;
- Composer catalogue static validation: no smoke or audit aliases;
- homonymous-interface/four-marker audit;
- scaffold functional recipe;
- site create/validate/language/page functional recipe;
- REST server execution recipe;
- delegated REST authentication recipe, including rejection of an unauthorized role;
- Composer executor recipe with a process-boundary fake Composer binary;
- public console dispatch recipe;
- application command-provider dispatcher recipe;
- OWASYS Registry provider and snapshot recipe;
- structured FSM loader/processor recipe;
- HTTP response stream recipe with no `echo` token;
- static rejection of direct OWASYS Registry repository access;
- static rejection of direct OWASYS password mutation;
- ZIP integrity and root-entry validation.

## Validation not performed

The artifact runtime has PHP 8.4 but no real Composer binary and cannot clone GitHub through DNS.

Therefore the following owner gates remain:

- real Composer validation and autoload on Windows;
- real nested Composer/stdin behavior;
- complete existing OPUS smoke suite;
- real local-password change through OWASYS;
- real Registry SQLite migration on the owner checkout;
- browser rendering and no-JavaScript acceptance;
- Auth0 proxy deployment test;
- HTTPS reverse-proxy/bastion deployment test;
- Windows/Linux parity.

No claim of target acceptance is made before those gates.

## Target commands

Apply the differential to clean OPUS `36a8570…`, then:

```cmd
cd /d H:\OPUS
bin\cmd\CLEAN_P117R_REJECTED_RCP.cmd
bin\cmd\CHECK_P117S_REST_COMPOSER.cmd
bin\cmd\INIT_LOCAL_RCP_SECRET.cmd
```

Terminal 1:

```cmd
cd /d H:\OPUS
bin\cmd\START_OPUS_RCP_REST.cmd
```

Terminal 2:

```cmd
cd /d H:\OPUS
bin\cmd\START_OWASYS.cmd
```

Direct Composer creation test:

```cmd
cd /d H:\OPUS
composer opus:create-application -- p117s-demo --write
composer opus:validate-site -- p117s-demo
composer opus:serve-site -- p117s-demo --host=127.0.0.1 --port=8793
```

Local-secret cleanup:

```cmd
cd /d H:\OPUS
bin\cmd\CLEAN_LOCAL_RCP_SECRET.cmd
```

## `owasys_old`

Do not delete `sites/owasys_old` yet. P117Q still uses it as an explicit rejected duplicate for canonical Registry integrity. Deletion requires owner browser acceptance, reference scan and explicit confirmation.

## Exact next work

1. Apply P117S on clean OPUS `36a8570…`.
2. Run the check CMD and paste the complete result.
3. Start REST agent and OWASYS in separate VS Code terminals.
4. Test Registry, password, create application and export through the real REST/Composer boundary.
5. Correct target-specific Composer or Windows issues without local fallback.
6. Run the full repository recipes.
7. Complete no-JavaScript/browser/Auth0/HTTPS acceptance.
8. Commit OPUS only after owner acceptance.
9. Decide `owasys_old` deletion separately.

## Permanent rules

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
NO DELIVERY FILE POLLUTION IN OPUS ROOT.
COMPOSER EXPOSES USER COMMANDS ONLY.
OWASYS IS WEB UI ONLY.
OWASYS BUSINESS OPERATIONS USE REST RCP THEN COMPOSER.
BACKEND FIRST.
SCORE FIRST.
SECRETS NEVER ENTER COMMAND-LINE ARGUMENTS OR LOGS.
