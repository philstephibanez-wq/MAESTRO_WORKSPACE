# OPUS CURRENT STATE

Last updated: 2026-07-26.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `21650601d7025706d4f7008ec0d0028d8cbe9c9d`
- Owner local repo: `H:/OPUS`
- HF10A: committed, functionally rejected
- HF10B: installed, runtime rejected, not accepted

## Framework identity

OPUS is a generic framework. OWASYS is an OPUS application whose UI is SCORE and whose business mutations cross secured REST then allow-listed Composer commands.

## Canonical architecture

```text
frontend  = application/shared + application/front
backend   = application/shared + application/back
fullstack = application/shared + application/front + application/back
```

Target physical layout:

```text
application/shared
application/shared/i18n/default
application/shared/i18n/modules/<module>
application/front/default
application/front/modules/<module>
application/back/modules/<module>
application/back/api
```

`application/full` is forbidden.

## HF10B delivery

```text
ZIP     : opus_p117v_hf10b_owasys_physical_front_back_runtime_bootstrap.zip
SHA-256 : 20803dd76b72bbed4704655e782fbf29cd79d7e2f01652a2ef0a6faa46f588ef
BASE    : 21650601d7025706d4f7008ec0d0028d8cbe9c9d
STATUS  : INSTALLED / RUNTIME REJECTED / NOT ACCEPTED
```

## Shared layer evidence

The ZIP directly contains:

```text
application/shared/Application.php
application/shared/RuntimeInterface.php
```

The migration command is responsible for creating/copying:

```text
application/shared/i18n/default
application/shared/i18n/modules/<module>
```

The frontend SCORE error page and trace identifier prove that the front bootstrap loaded the shared runtime interface and shared Singleton composition root. They do not prove that every shared catalogue/module is complete or valid.

## Backend evidence

The supplied backend log contains:

```text
trace_id     = 911f9e7f8708bf84
message      = process.starting
runtime_mode = back
host         = 127.0.0.1
port         = 8792
```

This proves process separation and immediate backend log creation. It does not prove any REST request, Composer execution or backend FSM transition.

## Frontend failure

```text
URL      : http://localhost:8000/fr-FR/
result   : OWASYS_FRONT_RUNTIME_FAILED
trace_id : 5f52a28017dc564d
```

The public error code is generic because the original exception message does not match the safe public error-code grammar.

Exact cause requires:

```text
sites/owasys/var/logs/owasys-frontend.log
sites/owasys/var/profiler/front/5f52a28017dc564d.json
```

Required fields:

- error_code;
- exception_class;
- exception_file;
- exception_line;
- profiler event sequence.

## Current correction gate

No new cause patch is authorized before the exact frontend trace is read. A blind correction would violate the source-of-truth contract.

The next differential must:

1. fix the exact traced cause;
2. validate the complete shared I18n tree;
3. validate every migrated front module;
4. execute real front and back runtime smoke tests;
5. validate route isolation;
6. validate secured REST through Composer;
7. preserve Singleton, FSM, I18n, ACL, SSO/Auth0 proxy, SCORE, Logger and Profiler;
8. remain a direct differential ZIP superposable at `H:/OPUS`.

## Framework class contract

Every concrete class under `Opus/**/*.php` directly implements its homonymous interface. Every homonymous interface directly extends:

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

## Application contracts

- Singleton;
- FSM-module-first;
- browser-locale I18n with explicit diagnosed fallback;
- ACL deny-by-default;
- SSO/Auth0 proxy and bastion ready;
- SCORE-only UI;
- no UI-producing echo;
- no mixed PHP/HTML;
- configuration through `File` and `StructuredFileLoader` to `Json`, `Xml` or `Yaml`;
- Logger and Profiler mandatory;
- no silent fallback.

## Owner commands required now

```cmd
cd /d H:\OPUS
findstr /C:"5f52a28017dc564d" sites\owasys\var\logs\owasys-frontend.log
type sites\owasys\var\profiler\front\5f52a28017dc564d.json
dir /s /b sites\owasys\application\shared
```

## Cleanup

No deletion is authorized before runtime acceptance. Preserve:

```text
sites/owasys_old
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
sites/owasys/var/runtime
```
