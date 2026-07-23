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

Generic code contains no OWASYS identifier. Registry/password implementations remain under `sites/owasys/`.

## Root contract

The owner-confirmed root admits only `.git`, `.github`, `application`, `Config`, `DOC`, `Opus`, `packages`, `runtime`, `scripts`, `sites`, `tools`, `vendor` and the declared root files.

Root `bin/`, lowercase root `config/`, root `public/` and every new top-level directory are forbidden.

## Differential

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`
- files: 57
- bytes: 73,261
- base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- top-level entries: `composer.json`, `Opus`, `scripts`, `sites`
- integrity verified
- OPUS not pushed directly

P117S and P117T are rejected. P117T violated the root with `bin/` and lowercase `config/`.

## Mandatory HF1

Owner runtime failure:

`Undefined constant Opus\Fsm\FsmProcessor::SUPPORTED_CONTRACTS`

Cause: `FsmProcessor::validateFsm()` referenced a nonexistent constant while the class declared `CANONICAL_CONTRACTS`.

HF1:

- ZIP: `opus_owasys_p117u_hf1_fsm_contract.zip`
- SHA-256: `e711af28142a5ad287569c5107b99d41065498ea3bed70ec13b977007ae605d2`
- file: `Opus/Fsm/FsmProcessor.php`

The corrected processor validates canonical contracts and generic versioned application contracts matching `<VENDOR>_<NAME>_FSM_V<n>`. The runtime construction recipe with `OWASYS_NAVIGATION_FSM_V1` passes. HF1 must be applied after P117U.

## Composer state

`composer.json` exposes user commands only and delegates to `scripts/opus.php`.

Generic OPUS commands cover create, language, validate, routes, page, rubric, export and serve. Application-owned commands are discovered through `sites/*/config/composer.commands.json`.

No smoke, audit, test or recipe alias remains.

## Framework evolution

P117U contains generic console, site service, application-command discovery, REST/RCP client/server, operation registry, Composer executor, execution FSM/store, Auth0 proxy provider, generated runtime and canonical scaffold components.

Every new concrete framework class implements its homonymous four-marker interface. Modified existing classes retain their existing interfaces.

`SiteScaffoldPlan` is the sole architecture. `FullstackApplicationScaffoldPlan` delegates to it. `ScaffoldWriter` uses atomic OPUS File writes.

`FsmProcessor`, `FsmSiteLoader`, `LocalPasswordSsoProvider` and `Response` are corrected for generic contracts, structured file boundaries and no-echo response emission.

## OWASYS state

OWASYS declares `OPUS_SITE_STANDARD_CONTRACT_CORE` with role `standard-opus-application`. Its signal routes and FSM are validated from the paths declared in `site.json`, while generated sites retain their stricter generated-route contract.

The application remains Singleton, FSM/I18n/ACL/SSO driven and SCORE-rendered.

One public PHP entrypoint exists: `sites/owasys/www/index.php`, delegating to `application/default/bootstrap.php`.

Canonical layout: `sites/owasys/application/default/layouts/layout.score`. The obsolete `application/default/templates/layout.score` must be removed after applying P117U.

The frontend Registry model performs no SQLite access. Registry and password mutations are application-owned Composer commands executed backend-side.

Local service security uses bearer plus HMAC. The generic Auth0 proxy provider validates proxy/bastion address and secret before accepting identity headers.

## Generated application standard

Composer creates Singleton, FSM-module-first applications with `application/default + application/<module>`, `config`, `www`, browser locale, OPUS I18n, deny-by-default ACL, session/Auth0-proxy SSO and SCORE-only output. `application/states` and `public` are not generated.

## Configuration

Changed configuration reads use `File` plus `StructuredFileLoader` and explicit OPUS Json/Yaml/Xml parsers. No direct configuration `file_get_contents` or `json_decode` path remains in the differential.

## Validation

Green:

- root/ZIP contract;
- PHP lint: 49 P117U files plus HF1;
- JSON parse: 7 files;
- Composer catalogue;
- no generic OWASYS leakage;
- 21 concrete framework interface checks;
- one OWASYS public PHP entrypoint;
- canonical scaffold and actual atomic write;
- standard-application validation with signal routes and declared FSM;
- HF1 runtime construction with `OWASYS_NAVIGATION_FSM_V1`;
- HMAC success, signature rejection, ACL rejection;
- execution FSM and Composer process/stdin;
- secret-free execution storage;
- Auth0 trusted/untrusted recipes.

Pending owner validation:

- restart OWASYS after HF1;
- Windows Composer/autoload;
- existing tools/recipes outside Composer aliases;
- Registry/password real data;
- browser/no-JavaScript;
- HTTPS/Auth0/bastion;
- Windows/Linux parity.

## `owasys_old`

Do not delete until explicit owner authorization after browser acceptance and reference scan.

## Roadmap

1. Apply HF1 over the extracted P117U tree.
2. Restart OWASYS and continue browser validation.
3. Run Composer validation/autoload and repository recipes.
4. Validate Registry, password, current pages, Auth0 and HTTPS.
5. Commit OPUS after owner acceptance.
6. Decide `owasys_old` separately.
7. Demo, User Book, Reference Book, LSTSAR, KB.
