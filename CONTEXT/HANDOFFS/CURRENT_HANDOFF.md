# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-24

## Contrat global actif

Lire en premier :

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
```

Ce contrat est obligatoire pour toute correction, évolution, livraison et reprise MAESTRO / OPUS / OWASYS.

## Périmètre GitHub relu

Dépôts accessibles et inspectés sur leur branche courante :

```text
philstephibanez-wq/MAESTRO_WORKSPACE
philstephibanez-wq/OPUS
philstephibanez-wq/Maestro
philstephibanez-wq/Maestro_KB_Engine
philstephibanez-wq/Maestro_KB_Extranet
```

La relecture a couvert les heads distants, les contrats et handoffs actifs, les derniers différentiels significatifs et les fichiers OPUS nécessaires à la validation des règles demandées. Elle ne remplace pas un clone local exhaustif ni les validations runtime owner.

## Active milestone

P117U with mandatory HF1, HF2, HF3, HF4, HF6 and pending HF7.

```text
OPUS = generic framework
OWASYS = application built with OPUS
OWASYS current pages = SCORE frontend
secured REST + Composer = OWASYS backend
created sites = independent OPUS applications
```

OPUS is not an application.

## Source of truth

- OPUS repository: `philstephibanez-wq/OPUS`
- branch: `master`
- current remote head reviewed: `79f261854ee06a9f828fec389adca77d57323d00`
- current committed state: HF6
- HF7 specification: `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_SPEC.md`
- HF7 handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_2026-07-24.md`
- site contract: `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
- exhaustive class contract: `CONTEXT/SPECIFICATIONS/OPUS_ALL_CONCRETE_CLASSES_COMPONENT_CONTRACT_SPEC_P117M.md`

The former current-state reference `96884961248fc82bf5e13187a6ffcfffacb82d9f` is historical. It is not the current `OPUS/master` head.

## Delivery boundary

Governance files are written directly to `MAESTRO_WORKSPACE`.

OPUS and OWASYS source code are not pushed directly by the assistant. They are delivered as a differential ZIP only after the exact source base and real target files are available.

The documented HF7 ZIP is not present in GitHub or in the supplied attachment. It must not be reconstructed from prose. The supplied attachment only contains instructions for opening a new chat and does not contain the expected technical differential or handoff source.

## Only admitted OPUS root

Directories:

```text
.git .github application Config DOC Opus packages runtime scripts sites tools vendor
```

Root files:

```text
.gitignore AGENTS.md composer.json composer.lock composer.phar LICENSE README.md
```

No root `bin/`, lowercase root `config/`, root `public/` or new root.

## Mandatory clean-base order

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7
```

HF5 is superseded. If already applied, it may remain; no rollback is required.

## Confirmed committed state

The current OPUS head contains the generic Composer callback introduced by HF6. Public Composer aliases delegate to `Opus\Composer\ComposerScripts::run`.

The current committed `composer.json` still contains the obsolete OWASYS creation-start alias because HF7 has not been applied to `OPUS/master`.

The current implementation already contains:

- `File`, `Json`, `Xml`, `Yaml` and `StructuredFileLoader`;
- browser `Accept-Language` negotiation;
- homonymous four-marker interfaces for the reviewed concrete classes introduced after P117M;
- generic secured RCP/REST/Composer infrastructure;
- Logger and Profiler contracts.

## Exhaustive concrete-class rule

Every named concrete framework class under `Opus/**/*.php` must directly implement its homonymous interface.

That interface directly extends:

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Functional parent interfaces remain preserved. Constants, indirect inheritance or documentation metadata do not replace the four markers.

The audit must use the real PHP tree and `token_get_all()`, not a historical catalog or broad regular expressions.

## Application architecture rule

Every OPUS application remains:

- Singleton;
- autonomous under `sites/<application>/`;
- FSM-module-first;
- I18n/browser-locale aware;
- ACL deny-by-default;
- SSO/Auth0-proxy and bastion ready through generic OPUS contracts;
- backend-first;
- SCORE-only rendered;
- free of UI-producing `echo`;
- free of mixed PHP/HTML views;
- functional without mandatory JavaScript;
- instrumented by Logger and Profiler.

A generic need must be proposed as an OPUS framework evolution before any local application duplication. Owner decision is required before choosing a local implementation.

## Configuration boundary

All configuration crosses OPUS `File` and the explicit parser selected for the declared format:

```text
JSON -> Json
XML -> Xml
YAML/YML -> Yaml
```

`StructuredFileLoader` performs extension-based selection. Direct local configuration reads or silent parser fallback are forbidden.

## OWASYS application boundary

OWASYS is the web UI and application orchestration layer.

Every business command and persistent mutation crosses:

```text
SCORE UI
-> FSM + I18n + ACL + SSO
-> secured typed REST
-> bearer + HMAC authentication
-> backend execution FSM
-> allow-listed Composer command
-> typed OPUS service or OWASYS provider
-> structured result
-> ViewModel
-> SCORE rendering
```

No frontend file write, direct Registry mutation, direct process launch, free shell command or OWASYS business implementation under `Opus/` is allowed.

## Historical creation defect and pending HF7

Both `sites/owasys_old` and current OWASYS contained:

```text
registry + create_new_app -> build
```

This behavior remains rejected.

HF7 canonical workflow remains:

```text
Registry
-> create_new_app
-> Creation
-> choose frontend | backend | fullstack
-> secured REST site.create
-> Composer opus:create-site
-> generic OPUS profile-aware scaffold
-> Registry synchronize
-> Registry select
-> application_created
-> Build and validation
```

Failure remains in Creation. Cancellation returns to Registry.

The actual HF7 source files or original ZIP are required before a new OPUS/OWASYS code differential can be supplied.

## Logger and Profiler

Mandatory backend diagnostics:

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
```

Mandatory frontend workflow diagnostics:

```text
sites/owasys/var/logs/owasys-frontend.log
sites/owasys/var/profiler/<trace_id>.json
```

No parameters, credentials, passwords, tokens, HMAC values, sensitive request bodies or process command lines are logged or profiled.

## CMD rules

Cleanup and launch instructions are supplied as executable CMD commands for the VS Code terminal.

Command blocks contain commands only. They contain no prompt, comments, expected output, diagnostics or `exit /b`.

No command may delete `sites/owasys_old` until the owner has explicitly validated its obsolescence.

## Current validated launch surface

The committed OPUS console documents these frontend commands:

```text
composer dump-autoload -o
composer opus:validate-site -- owasys
composer opus:list-routes -- owasys
composer opus:serve-site -- owasys --host=127.0.0.1 --port=8000
```

No current public Composer alias for starting the REST backend is declared in the committed `composer.json`. A backend start command must be taken from the real HF6/HF7 owner runtime or added through an explicit generic OPUS evolution; it must not be guessed.

## Pending owner gates

1. recover the original HF7 artifact or exact HF7 source working tree;
2. verify local `H:/OPUS` is based on `79f261854ee06a9f828fec389adca77d57323d00` or record its exact divergence;
3. apply or regenerate HF7 from that exact base only;
4. regenerate optimized Composer autoload;
5. validate OWASYS site and routes;
6. start the secured REST backend using its real contractual launcher;
7. start the SCORE frontend;
8. verify Creation and frontend/backend/fullstack profiles;
9. verify Registry selection and Build transition;
10. validate password, no-JavaScript, Auth0, HTTPS, bastion and Windows/Linux parity;
11. commit and push OPUS only after owner acceptance;
12. decide separately whether `sites/owasys_old` can be removed.

## Permanent rules

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO BRICOLAGE DELIVERY.  
NO FALLBACK SILENCIEUX.  
ONLY THE OWNER-CONFIRMED OPUS ROOT IS ADMITTED.  
COMPOSER EXPOSES USER COMMANDS ONLY.  
OPUS IS A FRAMEWORK, NOT AN APPLICATION.  
OWASYS IS AN APPLICATION BUILT WITH OPUS.  
NO OWASYS BUSINESS IMPLEMENTATION UNDER `Opus/`.  
ALL OWASYS BUSINESS WRITES CROSS SECURED REST THEN COMPOSER.  
EVERY CONCRETE OPUS CLASS IMPLEMENTS ITS HOMONYMOUS FOUR-MARKER INTERFACE.  
OPUS APPLICATIONS ARE SINGLETON, FSM/I18N/ACL/SSO DRIVEN AND SCORE-ONLY.  
CONFIGURATION CROSSES FILE AND EXPLICIT JSON/XML/YAML PARSERS.  
LOGGER AND PROFILER ARE MANDATORY.  
SECRETS NEVER ENTER GIT, ARGV, LOGS, PROFILER PAYLOADS OR DELIVERY ARTIFACTS.  
SCORE AND BACKEND-FIRST ARE MANDATORY.
