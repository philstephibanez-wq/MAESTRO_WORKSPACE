# OWASYS P117U — CANONICAL REST + COMPOSER BACKEND

Date: 2026-07-23
Status: binding architecture specification
Supersedes: rejected P117S and P117T artifacts

## 1. Immutable product separation

```text
OPUS = generic framework and generic user Composer commands
OWASYS = one OPUS application
OWASYS current SCORE pages = frontend
OWASYS secured REST + Composer layer = OWASYS backend
Sites created by OWASYS = independent OPUS applications
```

OWASYS business code must never be placed in `Opus/`. Generic REST, RCP, Composer execution, FSM, I18n, ACL, SSO, File/parsers and site-generation capabilities belong to OPUS. Registry, OWASYS password workflow and OWASYS operation configuration remain under `sites/owasys/`.

## 2. Only admitted OPUS root

The OPUS repository root is closed. The only admitted directories are:

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

The only admitted root files are:

```text
.gitignore
AGENTS.md
composer.json
composer.lock
composer.phar
LICENSE
README.md
```

The casing is contractual. In particular:

- no root `bin/`;
- no root lowercase `config/`;
- no root `public/`;
- no new top-level directory;
- executable PHP entrypoints belong under existing `scripts/`;
- global configuration, when required, belongs under existing `Config/`;
- application configuration belongs under `sites/<site>/config/`.

## 3. Canonical site structure

Every OPUS application uses:

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

`www`, never `public`, is the public root. There is one minimal `www/index.php`, which only delegates to `application/default/bootstrap.php`. No second REST front controller or `www/api/index.php` is authorized.

OWASYS REST routes and frontend routes pass through the same canonical site front controller. The application Singleton delegates `/api/v1/...` to the OWASYS API controller and all other routes to the current SCORE frontend.

## 4. Composer contract

Composer has exactly two product responsibilities:

1. install OPUS and declared dependencies;
2. expose stable user commands.

No smoke, audit, test, recipe, delivery check or report belongs in `composer.json`.

All public scripts delegate to `scripts/opus.php`. Composer business implementation is forbidden.

Generic commands include site/application creation, language addition, site validation, route listing, page/rubric creation, export and local serving. OWASYS commands remain application-owned providers discovered through `sites/*/config/composer.commands.json`.

## 5. Mandatory OWASYS execution chain

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

## 6. Security

Local development may use HTTP only on loopback. Remote deployment requires HTTPS through the declared proxy/bastion boundary.

The local service contract uses independent bearer and HMAC secrets from environment variables. HMAC binds HTTP method, path, timestamp, nonce and complete JSON body. Expiry, clock skew, nonce/execution equality and replay are checked.

The backend revalidates operation roles. OWASYS command providers revalidate OWASYS ACL again before persistence.

Passwords and other secrets remain in the protected request body and Composer process standard input only. They must not enter URL, argv, process listing, logs, profiler payloads, exceptions, execution records, committed configuration or ZIP contents.

OPUS supplies a generic `Auth0ProxySsoProvider`; OWASYS configures trusted proxy/bastion addresses and secret/header contracts under its own `config/sso.json`.

## 7. Framework class contract

Every concrete class under `Opus/` implements a homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

Application-owned classes do not become framework classes merely because they use OPUS interfaces.

## 8. File and structured configuration boundary

Configuration files are read through `Opus\File\File` and parsed through `StructuredFileLoader`, selecting OPUS `Json`, `Yaml`/`Yml` or `Xml` by extension.

No direct `file_get_contents()` plus local JSON/XML/YAML parsing is authorized for configuration. No silent parser fallback is authorized.

Scaffold file writes cross `File::writeAtomic`. Generated configuration uses the OPUS JSON encoder.

## 9. Generated application contract

Composer-generated applications are immediately:

- Singleton;
- FSM-module-first;
- `application/default + application/<module>`;
- free of `application/states`;
- browser-locale aware;
- OPUS I18n based;
- deny-by-default ACL;
- session and Auth0-proxy SSO ready;
- SCORE-only;
- free of UI-producing `echo`;
- free of mixed HTML/PHP views;
- JavaScript-independent for required behavior.

`SiteScaffoldPlan` is the unique canonical plan. `FullstackApplicationScaffoldPlan` is only a compatibility adapter delegating to it; it must not define a second architecture.

## 10. Delivery rules

OPUS code is delivered as a differential ZIP. The assistant does not push OPUS code directly.

The ZIP contains no README, manifest, report, smoke, audit, check helper, cache or temporary file. It introduces no root outside the admitted OPUS root.

Cleanup and launch commands are supplied in the response as CMD blocks for the VS Code terminal.

## 11. Rejected artifacts

Do not apply:

- P117S: `opus_owasys_p117s_rest_composer_api.zip`, SHA-256 `acb79eec5cc0ce4023e79e53963f203a2c143b78fa754a4411036170f3c4220e`;
- P117T: `opus_owasys_p117t_backend_rest_composer.zip`, SHA-256 `ad1494d92f068789d8363b4b6a7a823ff7b6be189d36f66724f92fec91baf2c5`.

P117T is rejected because it introduced root `bin/` and root lowercase `config/`, both forbidden by the canonical OPUS root.

## 12. Acceptance

P117U is accepted only when:

1. ZIP top-level entries are only `composer.json`, `Opus/`, `scripts/`, `sites/`;
2. no `bin/`, root `config/`, root `public/` or new top-level path exists;
3. Composer contains user commands only;
4. no OWASYS identifier exists under `Opus/` or `scripts/`;
5. OWASYS business implementations remain under `sites/owasys/`;
6. the only OWASYS PHP file under `www/` is `www/index.php`;
7. all framework concrete-class interface gates pass;
8. PHP lint and JSON parsing pass;
9. scaffold generation and atomic writing pass;
10. HMAC, signature rejection, ACL rejection, execution FSM and Composer process boundary pass;
11. Auth0 proxy trusted/untrusted recipes pass;
12. real Windows Composer, Registry, password, browser/no-JavaScript and HTTPS/bastion gates pass in the owner environment.
