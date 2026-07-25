# OPUS CURRENT STATE

Last updated: 2026-07-26.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `21650601d7025706d4f7008ec0d0028d8cbe9c9d`
- Owner local repo: `H:/OPUS`
- HF10A is committed at the current head but rejected functionally
- HF10B direct differential is produced; owner installation pending

## Framework identity

OPUS is a generic framework. OWASYS is an OPUS application whose UI is SCORE and whose business mutations cross secured REST then allow-listed Composer commands.

## Owner runtime evidence

The latest frontend trace records:

```text
runtime_mode = front
GET /fr-FR/applications
error_code = OPUS_RCP_CLIENT_TOKEN_NOT_CONFIGURED
```

The frontend fails before emitting REST. Therefore no backend request or backend execution log can exist in the rejected HF10A state.

## Canonical architecture

```text
frontend  = application/shared + application/front
backend   = application/shared + application/back
fullstack = application/shared + application/front + application/back
```

Physical OWASYS layout delivered by HF10B:

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

## Delivery contract

The active delivery is a direct differential ZIP superposed at `H:/OPUS`. It contains complete new or replacement files at final paths and no installer, payload, patch directory, staging area, report, log or full repository copy.

## Active differential

```text
ZIP     : opus_p117v_hf10b_owasys_physical_front_back_runtime_bootstrap.zip
SHA-256 : 20803dd76b72bbed4704655e782fbf29cd79d7e2f01652a2ef0a6faa46f588ef
BASE    : 21650601d7025706d4f7008ec0d0028d8cbe9c9d
FILES   : 19
```

HF10A is withdrawn as the active deliverable.

## Framework class contract

HF10B adds:

```text
Opus\Security\Runtime\RuntimeSecretStore
Opus\Security\Runtime\RuntimeSecretStoreInterface
```

The concrete class directly implements its homonymous interface. The interface directly extends:

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Modified concrete framework classes retain their homonymous interfaces:

```text
SiteCommandService
LayeredSiteCommandService
```

## Automatic runtime bootstrap

The owner launch commands remain direct Composer commands:

```text
composer opus:serve-site -- owasys --mode=back --host=127.0.0.1 --port=8792
composer opus:serve-site -- owasys --mode=front --host=127.0.0.1 --port=8000
```

No manual environment setup is required.

The OPUS site service reads the runtime secret policy through `File` and `StructuredFileLoader`, creates or reads one locked runtime-only secret store, and passes the same token/HMAC pair to both independently launched child processes.

```text
sites/owasys/var/runtime/rcp-secrets.json
```

The store is ignored by the existing `sites/*/var/*` Git rule. Secrets never enter Git, argv, Logger, Profiler or the ZIP.

## Runtime isolation

Front bootstrap loads only:

- shared Singleton/runtime contract;
- frontend default services/controllers;
- frontend functional modules;
- SCORE renderer and templates.

Back bootstrap loads only:

- shared Singleton/runtime contract;
- REST backend controller;
- backend runtime.

Front rejects API paths. Back rejects non-API paths.

## I18n

Catalogues are physically separated from presentation code:

```text
application/shared/i18n/default
application/shared/i18n/modules/<module>
```

OWASYS uses `LayeredApplicationTranslationRuntime`; locale selection remains explicit route locale, then browser `Accept-Language`, then explicit diagnosed fallback.

## Logger and Profiler

At process launch:

```text
front -> sites/owasys/var/logs/owasys-frontend.log
back  -> sites/owasys/var/logs/rcp-backend.log
```

Both receive `process.starting` before the PHP development server starts. REST, Composer and execution FSM events continue in `rcp-backend.log`.

Profiler roots:

```text
sites/owasys/var/profiler/front
sites/owasys/var/profiler/back
```

Frontend failures render through SCORE and include a trace identifier.

## Physical migration

HF10B includes the final-path command:

```text
sites/owasys/tools/cmd/MIGRATE_OWASYS_LAYOUT_HF10B.cmd
```

It copies existing OWASYS components into the new canonical roots, separates I18n catalogues, validates all mandatory targets and performs no deletion. Old roots remain inactive rollback material until owner runtime validation.

## Validation executed

```text
PHP lint                               : OK
site.json parse                        : OK
ZIP reopen and lint                    : OK
runtime secret creation and reuse      : OK
front/back process-start logs          : OK
physical migration simulation          : OK
physical split smoke                   : OK
forbidden ZIP entries                  : 0
```

Smoke marker:

```text
P117V_HF10B_OWASYS_PHYSICAL_SPLIT_SMOKE_OK
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

## Pending

1. verify owner HEAD `21650601d7025706d4f7008ec0d0028d8cbe9c9d` and clean worktree;
2. extract HF10B directly at repository root;
3. execute the migration CMD;
4. rebuild Composer autoload;
5. run lint, contractual audit and HF10B smoke;
6. launch back directly and verify immediate `rcp-backend.log`;
7. launch front directly and verify immediate `owasys-frontend.log`;
8. validate `/fr-FR/applications` and `/fr-FR/applications/new`;
9. validate REST -> Composer and correlated Profiler traces;
10. then provide CMD cleanup for inactive legacy application roots;
11. run the exhaustive P117M tokenizer gate;
12. owner commit/push after acceptance;
13. decide separately on `sites/owasys_old`.
