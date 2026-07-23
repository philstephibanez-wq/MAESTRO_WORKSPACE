# OWASYS P117U — CANONICAL REST + COMPOSER BACKEND

Date: 2026-07-23
Status: binding architecture specification
Supersedes: rejected P117S and P117T artifacts

## 1. Immutable separation

```text
OPUS = generic framework and generic user Composer commands
OWASYS = one OPUS application
OWASYS current SCORE pages = frontend
OWASYS secured REST + Composer layer = OWASYS backend
Sites created by OWASYS = independent OPUS applications
```

OWASYS business code must never be placed in `Opus/` or `scripts/`. Generic REST, RCP, Composer execution, FSM, I18n, ACL, SSO, File/parsers and site-generation capabilities belong to OPUS. Registry, OWASYS password workflow and OWASYS operation configuration remain under `sites/owasys/`.

## 2. Only admitted OPUS root

Admitted directories only:

```text
.git/
.github/
application/
Config/
DOC/
Opus/
packages/
runtime/
scripts/
sites/
tools/
vendor/
```

Admitted root files only:

```text
.gitignore
AGENTS.md
composer.json
composer.lock
composer.phar
LICENSE
README.md
```

Casing is contractual. Root `bin/`, lowercase root `config/`, root `public/` and every new top-level directory are forbidden. Executable PHP entrypoints belong under `scripts/`. Application configuration belongs under `sites/<site>/config/`.

## 3. Canonical site structure

```text
sites/<site>/
  application/
    default/
      bootstrap.php
      layouts/
      local/
      templates/
      views/
    <module>/
  config/
  www/
    index.php
    asset/
```

`www`, never `public`, is the public root. A site has one minimal `www/index.php`, delegating only to `application/default/bootstrap.php`. No second REST front controller or `www/api/index.php` is authorized.

Layouts belong under `application/default/layouts`. OWASYS renders its canonical layout from `application/default/layouts/layout.score`; obsolete `application/default/templates/layout.score` must be removed.

OWASYS REST and frontend routes pass through the same front controller. The application Singleton delegates `/api/v1/...` to the OWASYS API controller and all other routes to the current SCORE frontend.

## 4. Composer contract

Composer has exactly two product responsibilities:

1. install OPUS and declared dependencies;
2. expose stable user commands.

No smoke, audit, test, recipe, delivery check or report belongs in `composer.json`. All public scripts delegate to `scripts/opus.php`. Composer contains no business implementation.

Generic commands include site/application creation, language addition, site validation, route listing, page/rubric creation, export and local serving. OWASYS commands remain application-owned providers discovered through `sites/*/config/composer.commands.json`.

## 5. Mandatory execution chain

```text
OWASYS SCORE frontend
-> browser locale
-> SSO identity
-> deny-by-default ACL
-> OWASYS FSM
-> typed signed REST request
-> REST service authentication
-> delegated actor validation
-> REST execution FSM
-> operation allow-list
-> public Composer script
-> scripts/opus.php
-> generic OPUS service or OWASYS command provider
-> structured result
-> OWASYS ViewModel
-> SCORE rendering
```

No frontend business mutation, direct Registry write, direct password mutation, arbitrary shell command, browser-supplied Composer script, executable path, working directory or environment injection is authorized.

## 6. Mandatory local process topology

The secured REST boundary requires two independent processes in local development.

```text
127.0.0.1:8792 = OWASYS REST + Composer backend
127.0.0.1:8000 = OWASYS SCORE frontend
```

Both processes use the same canonical `sites/owasys/www/index.php`. HTTP routing selects REST `/api/v1/...` requests or normal frontend routes.

The frontend REST client endpoint is:

```text
http://127.0.0.1:8792/api/v1/executions
```

Both processes must load the same environment values:

- `OPUS_OWASYS_BACKEND_TOKEN`;
- `OPUS_OWASYS_BACKEND_HMAC`;
- `OPUS_OWASYS_AUTH0_PROXY_SECRET`.

The backend process must be started and its status resource verified before opening the frontend.

Starting the frontend process alone is an incomplete launch and produces the blocking error `OPUS_RCP_CONNECTION_FAILED`. No direct-local Registry or password fallback is authorized.

## 7. Security

Local development may use HTTP only on loopback. Remote deployment requires HTTPS through the declared proxy/bastion boundary.

The local service contract uses independent bearer and HMAC secrets from environment variables. HMAC binds HTTP method, path, timestamp, nonce and complete JSON body. Expiry, clock skew, nonce/execution equality and replay are checked.

The backend revalidates operation roles. OWASYS command providers revalidate OWASYS ACL before persistence.

Passwords and other secrets remain in the protected request body and Composer process standard input only. They must not enter URL, argv, process listing, logs, profiler payloads, exceptions, execution records, committed configuration or ZIP contents.

OPUS supplies a generic `Auth0ProxySsoProvider`; OWASYS configures trusted proxy/bastion addresses and secret/header contracts under its own `config/sso.json`.

## 8. Framework class contract

Every concrete class under `Opus/` implements a homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

Application-owned classes do not become framework classes merely because they use OPUS interfaces.

## 9. File and configuration boundary

Configuration files are read through `Opus\File\File` and parsed through `StructuredFileLoader`, selecting OPUS `Json`, `Yaml`/`Yml` or `Xml` by extension.

No direct `file_get_contents()` plus local JSON/XML/YAML parsing is authorized for configuration. No silent parser fallback is authorized. Scaffold writes cross `File::writeAtomic`; generated configuration uses the OPUS JSON encoder.

## 10. Application validation

The generic validator accepts:

- `generated-opus-application`, using the generated route registry contract;
- `standard-opus-application`, used by OWASYS and validated through its declared signal-route registry and FSM path.

The FSM path is resolved from `site.json`, not hardcoded. Both roles remain subject to the same canonical roots, Singleton, module-directory, ACL deny-by-default, SSO, SCORE layout and no-`application/states` requirements.

## 11. Generated application contract

Composer-generated applications are immediately Singleton, FSM-module-first, `application/default + application/<module>`, browser-locale aware, OPUS I18n based, deny-by-default ACL, session/Auth0-proxy SSO ready, SCORE-only, free of UI-producing `echo`, free of mixed HTML/PHP and JavaScript-independent for required behavior.

`SiteScaffoldPlan` is the unique canonical plan. `FullstackApplicationScaffoldPlan` is only a compatibility adapter delegating to it.

## 12. Delivery

OPUS code is delivered as a differential ZIP. The assistant does not push OPUS code directly.

The ZIP contains no README, manifest, report, smoke, audit, check helper, cache or temporary file and introduces no root outside the admitted OPUS root.

Authoritative base artifact:

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`
- Files: 57
- Bytes: 73,261

Mandatory hotfix:

- ZIP: `opus_owasys_p117u_hf1_fsm_contract.zip`
- SHA-256: `e711af28142a5ad287569c5107b99d41065498ea3bed70ec13b977007ae605d2`

## 13. Rejected artifacts

Do not apply P117S or P117T. P117T is rejected because it introduced root `bin/` and lowercase root `config/`.

## 14. Acceptance

P117U is accepted only when:

1. ZIP top-level entries are only `composer.json`, `Opus/`, `scripts/`, `sites/`;
2. no root `bin/`, lowercase `config/`, `public/` or new top-level path exists;
3. Composer contains user commands only;
4. no OWASYS identifier exists under `Opus/` or `scripts/`;
5. OWASYS business implementations remain under `sites/owasys/`;
6. the only OWASYS PHP file under `www/` is `www/index.php`;
7. OWASYS uses `application/default/layouts/layout.score`;
8. all framework concrete-class interface gates pass;
9. PHP lint and JSON parsing pass;
10. scaffold generation and atomic writing pass;
11. standard and generated OPUS site validation recipes pass;
12. HMAC, signature rejection, ACL rejection, execution FSM and Composer process boundary pass;
13. Auth0 proxy trusted/untrusted recipes pass;
14. backend status on port `8792` succeeds before frontend validation;
15. Registry/password flows pass through REST then Composer;
16. real Windows browser/no-JavaScript and HTTPS/bastion gates pass.
