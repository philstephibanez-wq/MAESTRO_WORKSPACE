# OPUS CURRENT STATE

Last updated: 2026-07-23.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head / P117U base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Owner local repo: `H:/OPUS` only as a local detail

## Active milestone

P117U — canonical secured REST + Composer backend for the current OWASYS SCORE frontend.

- specification: `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`
- handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`

## Immutable separation

```text
OPUS = framework
OWASYS = OPUS application
OWASYS current pages = frontend
REST + Composer = OWASYS backend
Created sites = independent OPUS applications
```

Generic code contains no OWASYS identifier. OWASYS Registry/password implementations remain under `sites/owasys/`.

## Root contract

The owner-confirmed root admits only `.git`, `.github`, `application`, `Config`, `DOC`, `Opus`, `packages`, `runtime`, `scripts`, `sites`, `tools`, `vendor` and the existing declared root files.

Root `bin/`, lowercase root `config/`, root `public/` and any new top-level directory are forbidden.

## Differential

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `1ee231cbcbe9e5a4578aa6f50b7a83559f89b46f6916e93f682c50f360401e46`
- files: 55
- bytes: 69,473
- base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- top-level entries: `composer.json`, `Opus`, `scripts`, `sites`
- integrity verified
- OPUS not pushed directly

P117S and P117T are rejected. P117T violated the root with `bin/` and lowercase `config/`.

## Composer state

`composer.json` exposes user commands only and delegates to `scripts/opus.php`.

Generic OPUS commands cover create, language, validate, routes, page, rubric, export and serve. Application-owned commands are discovered through `sites/*/config/composer.commands.json`.

No smoke, audit, test or recipe alias remains.

## Framework evolution

P117U contains generic console, site service, application-command discovery, REST/RCP client/server, operation registry, Composer executor, execution FSM/store, Auth0 proxy provider, generated runtime and canonical scaffold components.

Every new concrete framework class implements its homonymous interface extending the four markers. Modified existing classes retain their existing homonymous interfaces.

`SiteScaffoldPlan` is the sole architecture. `FullstackApplicationScaffoldPlan` delegates to it. `ScaffoldWriter` uses atomic OPUS File writes.

`FsmProcessor`, `FsmSiteLoader`, `LocalPasswordSsoProvider` and `Response` are corrected for generic contracts, structured file boundaries and no-echo response emission.

## OWASYS state

The application remains Singleton, FSM/I18n/ACL/SSO driven and SCORE-rendered.

One public PHP entrypoint exists: `sites/owasys/www/index.php`. It delegates to `application/default/bootstrap.php`. The application Singleton selects REST or frontend routing.

The frontend Registry model is a REST projection and performs no SQLite access. Registry and password mutations are application-owned Composer commands executed backend-side.

Local service security uses bearer plus HMAC. The generic Auth0 proxy provider validates proxy/bastion address and secret before accepting identity headers.

## Generated application standard

Composer creates Singleton, FSM-module-first applications with `application/default + application/<module>`, `config`, `www`, browser locale, OPUS I18n, deny-by-default ACL, session/Auth0-proxy SSO and SCORE-only output. `application/states` and `public` are not generated.

## Configuration

Changed configuration reads use `File` plus `StructuredFileLoader` and explicit OPUS Json/Yaml/Xml parsers. No direct configuration `file_get_contents` or `json_decode` path remains in the differential.

## Validation

Green:

- root/ZIP contract;
- PHP lint;
- JSON parse;
- Composer catalogue;
- no generic OWASYS leakage;
- 21 concrete framework interface checks;
- canonical scaffold and actual atomic write;
- HMAC success, signature rejection, ACL rejection;
- execution FSM and Composer process/stdin;
- secret-free execution storage;
- Auth0 trusted/untrusted recipes.

Pending owner validation:

- Windows Composer/autoload;
- existing tools/recipes outside Composer aliases;
- Registry/password real data;
- browser/no-JavaScript;
- HTTPS/Auth0/bastion;
- Windows/Linux parity.

## `owasys_old`

Do not delete until explicit owner authorization after browser acceptance and reference scan.

## Roadmap

1. Apply P117U to clean OPUS base.
2. Remove rejected P117S/P117T paths only if previously extracted.
3. Run Composer validation/autoload and repository recipes.
4. Start backend and frontend with shared environment secrets.
5. Validate Registry, password, current pages, Auth0 and HTTPS.
6. Commit OPUS after owner acceptance.
7. Decide `owasys_old` separately.
8. Demo, User Book, Reference Book, LSTSAR, KB.
