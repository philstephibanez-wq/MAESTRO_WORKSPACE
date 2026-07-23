# OPUS CURRENT STATE

Last updated: 2026-07-23.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head / P117T differential base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Owner local development repo: `H:/OPUS` only as a local detail

## Active milestone

P117T — secured REST + Composer backend for the existing OWASYS SCORE frontend.

Binding specification:

`CONTEXT/SPECIFICATIONS/OWASYS_BACKEND_REST_COMPOSER_SPEC_P117T.md`

Current handoff:

`CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_BACKEND_REST_COMPOSER_P117T_2026-07-23.md`

## Product split

```text
Current OWASYS SCORE pages = frontend
OPUS REST API + Composer = backend
```

The frontend owns browser locale, SSO, ACL, FSM, ViewModels and SCORE rendering. It performs no persistent business mutation.

The backend authenticates signed typed requests, validates the delegated actor, applies an execution FSM and operation ACL, invokes an allow-listed public Composer script through `bin/opus`, and returns a structured result.

## Rejected P117S

The following artifact is rejected and must not be applied:

- `opus_owasys_p117s_rest_composer_api.zip`
- SHA-256 `acb79eec5cc0ce4023e79e53963f203a2c143b78fa754a4411036170f3c4220e`

It introduced a global `public/rcp` tree and embedded delivery audit/check files.

## Authoritative P117T differential

- ZIP: `opus_owasys_p117t_backend_rest_composer.zip`
- SHA-256: `ad1494d92f068789d8363b4b6a7a823ff7b6be189d36f66724f92fec91baf2c5`
- Files: 49
- Bytes: 64,460
- Base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Only file directly at root: `composer.json`
- Top-level entries: `Opus`, `bin`, `config`, `sites`, `composer.json`
- No README, manifest, report, smoke, audit, check helper or global `public` tree
- ZIP integrity verified
- OPUS repository not written directly by the assistant

## Composer contract

Composer serves only:

1. OPUS/dependency installation;
2. stable user OPUS commands through `bin/opus`.

No smoke, audit, recipe or arbitrary technical command belongs in `composer.json`.

P117T restores user commands for create application/site, OWASYS create/export, add language, serve/validate, list routes, create page/rubric, administrator-password change and Registry administration.

## REST backend

Minimum endpoints:

```text
GET  /v1/status
POST /v1/executions
```

Placement:

- `sites/owasys/www/api/index.php`
- `sites/owasys/config/backend.rest.json`
- `sites/owasys/config/backend.operations.json`
- `sites/owasys/config/rcp.json`

No new global public root exists.

## Security

- loopback HTTP only for local development;
- HTTPS required remotely;
- bearer token plus HMAC environment secrets;
- HMAC binds method, path, timestamp, nonce and complete body;
- nonce equals execution identifier;
- expiry, clock skew and replay checked;
- delegated roles/providers restricted;
- operation ACL reapplied backend-side;
- no browser-supplied executable, shell, Composer script, working directory or absolute target path;
- passwords remain in request body and process standard input only.

## Framework implementation

Generic OPUS components cover console, application command-provider dispatch, site services, compliant scaffold, generated runtime, Composer registry/executor, RCP identity/authentication/FSM and REST client/server/store.

Every new concrete framework class implements its homonymous interface extending the four standard markers.

Modified `Response`, `FsmProcessor`, `FsmSiteLoader` and `LocalPasswordSsoProvider` retain their existing homonymous interfaces.

## Generated application standard

Composer creates applications that are immediately:

- Singleton;
- `application/default + application/<module>`;
- FSM-module-first;
- browser-locale aware;
- OPUS I18n based;
- deny-by-default ACL;
- session/Auth0-proxy SSO ready;
- SCORE only;
- without UI-producing `echo`;
- without mixed HTML/PHP views.

## OWASYS frontend migration

The current pages remain the frontend.

Password change and Registry synchronize/select/clear/creation-start cross the generic REST client. The web Registry model no longer opens persistent storage. The Composer-side OWASYS command provider owns Registry persistence.

## Configuration

Configuration crosses `Opus\File\File` and `StructuredFileLoader`, using explicit JSON/YAML/YML/XML parsers. Direct local configuration parsing is forbidden.

## Validation

Green in isolated validation:

- PHP syntax;
- JSON parsing;
- Composer user-command-only check;
- root-layout and forbidden-delivery-name checks;
- homonymous-interface/four-marker checks;
- HMAC REST execution;
- invalid-signature and ACL rejection;
- allow-listed Composer/stdin boundary;
- execution FSM;
- application scaffold contract;
- ZIP integrity.

Pending owner validation:

- real Windows Composer/autoload/stdin;
- full existing repository recipes outside Composer aliases;
- actual Registry and password workflows;
- current frontend against backend;
- browser/no-JavaScript acceptance;
- Auth0 proxy, HTTPS and bastion;
- Windows/Linux parity.

## `owasys_old`

Do not delete `sites/owasys_old`. It remains P117Q's rejected duplicate reference until owner browser acceptance, reference scan and explicit confirmation.

## Locked roadmap

1. Apply P117T to clean OPUS `36a8570…`.
2. Remove only known rejected P117S artifacts if previously extracted.
3. Run Composer autoload and PHP/JSON checks.
4. Start backend and frontend in separate VS Code terminals with identical environment secrets.
5. Validate real Composer, Registry, password and browser flows.
6. Correct target issues without local fallback.
7. Commit OPUS after owner acceptance.
8. Decide `owasys_old` deletion separately.
9. Official demo, User Book, Reference Book, LSTSAR, KB.
