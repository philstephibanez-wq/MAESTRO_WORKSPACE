# OPUS CURRENT STATE

Last updated: 2026-07-26.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `4fb3a92605f14d84b8060ff36fde78828da49273`
- Owner local repo: `H:/OPUS`
- HF10A: committed, functionally rejected
- HF10B: committed/applied, runtime rejected, architecture superseded
- P117W: dual autonomous OWASYS applications required

## Framework identity

OPUS is a generic framework. OWASYS is a distributed system composed of two autonomous OPUS applications connected through secured REST.

## Canonical OWASYS architecture

```text
sites/owasys/front
sites/owasys/back
sites/owasys/shared
```

`front` and `back` are autonomous OPUS applications. `shared` is not an application.

## Front application

```text
sites/owasys/front/
  application/default/
  application/<module>/
  config/
  www/
  var/
```

Singleton:

```text
OwasysFrontApplication
OwasysFrontApplicationInterface
```

Mandatory contracts:

- Singleton;
- frontend FSM;
- browser-locale I18n;
- ACL deny-by-default;
- SSO/Auth0 proxy;
- bastion-aware identity propagation;
- SCORE-only rendering;
- secured REST client;
- Logger and Profiler;
- no local business mutation;
- no local Composer execution.

## Back application

```text
sites/owasys/back/
  application/default/
  application/<module>/
  config/
  www/
  var/
```

Singleton:

```text
OwasysBackApplication
OwasysBackApplicationInterface
```

Mandatory contracts:

- Singleton;
- backend execution FSM;
- API I18n/locale negotiation;
- ACL deny-by-default;
- service identity, Auth0 delegation and bastion policy;
- secured REST server;
- allow-listed Composer execution;
- typed services/providers;
- Logger and Profiler;
- no UI rendering.

## Shared source contract

```text
sites/owasys/shared/
  contracts/
  schemas/
  defaults/
  i18n-source/
  deployment/
```

`shared` contains no:

- Singleton;
- bootstrap;
- server;
- secret;
- `var` state;
- Logger runtime;
- Profiler runtime;
- dependency on a shared filesystem between deployments.

It contains versioned DTO contracts, REST schemas, operation identifiers, non-secret defaults, common I18n sources and deployment compatibility manifests.

## Separate bastions

Front and back may be installed on two distinct bastions.

Each deployment artifact embeds its own immutable snapshot of required common contracts and defaults. Runtime file sharing between bastions is forbidden.

Required manifest fields:

```text
shared_contract_version
shared_contract_sha256
api_contract_version
minimum_opus_version
```

The application fails explicitly when expected versions are incompatible.

Secrets are injected separately on each bastion through deployment variables, local secret files outside Git, machine identity, mTLS certificates or a secret manager.

## Network flow

```text
Browser
  -> HTTPS/Auth0 proxy
  -> OWASYS Front bastion
  -> secured REST HTTPS/mTLS/HMAC
  -> OWASYS Back bastion
  -> backend FSM
  -> allow-listed Composer
  -> typed service/provider
```

The backend is not directly exposed to the browser. The frontend cannot perform business writes outside the declared REST operation catalogue.

## Distributed observability

Front:

```text
sites/owasys/front/var/logs/owasys-front.log
sites/owasys/front/var/profiler/<trace_id>.json
```

Back:

```text
sites/owasys/back/var/logs/owasys-back.log
sites/owasys/back/var/profiler/<trace_id>.json
```

Distributed requests propagate:

```text
trace_id
request_id
actor_subject
front_event_id
back_execution_id
```

No secret is logged or profiled.

## HF10B runtime evidence

Frontend trace:

```text
trace_id        = 5f52a28017dc564d
runtime_mode     = front
exception_class  = RuntimeException
exception_file   = H:/OPUS/Opus/Fsm/FsmSiteLoader.php
exception_line   = 193
```

The current `FsmSiteLoader` requires `default_root = application/default`. HF10B attempted to model a single site with `application/front/default`, which conflicts with the canonical site contract. Two autonomous sites each restore a canonical `application/default` root.

Backend evidence:

```text
trace_id     = 911f9e7f8708bf84
message      = process.starting
runtime_mode = back
port         = 8792
```

This proves process startup only. REST, Composer and backend FSM execution remain unvalidated.

## Framework class contract

Every concrete class under `Opus/**/*.php` directly implements its homonymous interface. Every homonymous interface directly extends:

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

## Configuration boundary

Every config file is read through OPUS `File` and parsed through `StructuredFileLoader` using `Json`, `Xml` or `Yaml`. Direct local parsing and silent fallback remain forbidden.

## Delivery contract

The next delivery is a direct differential ZIP superposed at `H:/OPUS`. It must contain complete files at final paths and no installer, payload, patch directory, staging area, report, log or complete repository copy.

It must create two separately deployable application artifacts and validate a two-bastion simulation.

## Pending P117W

1. create `sites/owasys/front` as a complete OPUS site;
2. create `sites/owasys/back` as a complete OPUS site;
3. create two independent Singletons and interfaces;
4. create independent config, FSM, ACL, SSO, Logger and Profiler stacks;
5. convert `shared` into a non-runtime versioned contract source;
6. add separate Composer launch identities/commands;
7. package front and back independently;
8. validate compatibility manifests and hashes;
9. validate browser -> front -> REST -> back -> Composer;
10. validate propagated `trace_id`;
11. run real runtime tests on two separate roots;
12. run exhaustive P117M tokenizer gate;
13. owner commit/push after acceptance.

## Cleanup

No deletion is authorized before P117W runtime acceptance. Preserve:

```text
sites/owasys_old
sites/owasys/var
sites/owasys/application/shared
sites/owasys/application/front
sites/owasys/application/back
```
