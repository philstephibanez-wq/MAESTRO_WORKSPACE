# OPUS CURRENT STATE

Last updated: 2026-07-23.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head / P117S differential base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Owner local development repo: `H:/OPUS` only as a local detail

## Active milestone

P117S — generic OPUS REST RCP API invoking the public Composer user-command surface. OWASYS remains only the web UI.

Binding specification:

`CONTEXT/SPECIFICATIONS/OPUS_RCP_REST_COMPOSER_API_SPEC_P117S.md`

Current handoff:

`CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_RCP_REST_COMPOSER_P117S_2026-07-23.md`

## Baseline

P117Q remains the latest OPUS commit and provides OWASYS Singleton, browser/regional locale policy, synchronized FSM navigation, SCORE rendering, ACL/SSO and canonical Registry discovery.

P117S is delivered as a differential and has not been pushed directly to OPUS.

## Authoritative P117S differential

- ZIP: `opus_owasys_p117s_rest_composer_api.zip`
- SHA-256: `acb79eec5cc0ce4023e79e53963f203a2c143b78fa754a4411036170f3c4220e`
- Files: 58
- Bytes: 65,973
- Base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Only root entry: `composer.json`
- ZIP integrity verified

Every P117R code artifact is rejected and superseded.

## Composer contract

Composer serves only:

1. OPUS/dependency installation;
2. stable user OPUS commands.

No smoke, audit, recipe or arbitrary technical command belongs in `composer.json`.

All public scripts delegate to `bin/opus`.

P117S restores create application/site, OWASYS create/export, add language, serve/validate, route list, page/rubric create, password change and Registry administration commands.

## REST RCP command boundary

```text
OWASYS SCORE UI
-> browser locale
-> SSO
-> ACL
-> OWASYS FSM
-> typed REST execution
-> RCP authentication
-> delegated actor validation
-> RCP execution FSM
-> allow-listed Composer script
-> bin/opus
-> typed OPUS/application command handler
-> structured result
-> OWASYS projection/ViewModel
-> SCORE
```

The API exposes execution resources at `/v1` and never accepts a browser-supplied executable, script name, shell fragment, working directory or absolute target path.

HTTP is local-loopback only. Remote deployment requires HTTPS.

## Framework implementation

Generic OPUS components cover:

- console application and services;
- application command-provider dispatcher;
- canonical application scaffold;
- generated site runtime;
- Composer operation registry and executor;
- RCP identity, authentication and execution FSM;
- REST store, server and client.

Every new concrete framework class has a homonymous interface extending the four standard markers.

Modified framework classes `Response`, `FsmProcessor` and `FsmSiteLoader` retain their existing homonymous four-marker interfaces.

## Generated application standard

Composer now generates applications conforming immediately to the current site contract:

- Singleton runtime;
- `application/default + application/<module>`;
- `application/states` forbidden;
- FSM-module-first;
- browser locale detection;
- OPUS I18n catalogs;
- deny-by-default ACL;
- session plus Auth0-proxy SSO boundaries;
- SCORE-only HTML;
- minimal public entrypoint;
- no UI-producing `echo`;
- no mixed HTML/PHP view.

## OWASYS state

Migrated through REST/Composer:

- create application/site;
- validate site;
- list routes;
- add language;
- create page/rubric;
- export application;
- change administrator password;
- synchronize Registry and return its snapshot;
- persist selected application;
- clear persisted application context;
- start application-creation flow.

The OWASYS web Registry model no longer opens its SQLite repository. The Composer-side OWASYS command provider is the only layer that opens the repository and performs Registry persistence.

## Configuration contract

Configuration crosses OPUS `File` and `StructuredFileLoader`, using explicit JSON/YAML/YML/XML parsers. `FsmProcessor` and `FsmSiteLoader` no longer read JSON configuration directly.

## Security

- no free-form command;
- no shell-string fallback;
- Composer process uses an argument array and shell bypass;
- allow-listed operation and typed arguments;
- bearer/Auth0-proxy authentication before ACL;
- delegated roles/providers restricted by server configuration;
- password body through HTTPS and process standard input only;
- no secret in arguments, URLs, logs, exceptions or ZIP;
- local token lives only in ignored `.env.rcp.local`.

## Validation

Isolated recipes green for PHP syntax, JSON, contracts/interfaces, scaffold, site commands, REST server, authentication, Composer executor, console dispatch, application provider dispatch, Registry snapshot/provider, structured FSM and stream output without `echo`.

Pending owner validation:

- real Windows Composer/autoload/stdin;
- complete existing repository recipes;
- real Registry and password workflows;
- browser and no-JavaScript acceptance;
- Auth0/HTTPS/bastion deployment;
- Windows/Linux parity.

## `owasys_old`

Do not delete `sites/owasys_old` yet. It remains P117Q's rejected duplicate reference until owner browser acceptance, reference scan and explicit confirmation.

## Locked roadmap

1. Apply P117S to clean OPUS `36a8570…`.
2. Run `bin\cmd\CHECK_P117S_REST_COMPOSER.cmd`.
3. Start REST and OWASYS in separate VS Code terminals.
4. Validate real commands and browser flows.
5. Correct target issues without fallback.
6. Commit OPUS after owner acceptance.
7. Decide `owasys_old` deletion separately.
8. Official OPUS demo.
9. User Book.
10. Reference Book.
11. LSTSAR.
12. KB.
