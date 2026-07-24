# CURRENT HANDOFF — MAESTRO WORKSPACE

Date: 2026-07-24

## Active milestone

P117U with mandatory HF1, HF2, HF3, HF4 and HF6.

```text
OPUS = framework générique
OWASYS = application construite avec OPUS
pages OWASYS actuelles = frontend SCORE
REST + Composer = backend OWASYS
sites créés = applications OPUS indépendantes
```

OPUS n'est pas une application.

## Source of truth

- OPUS repository: `philstephibanez-wq/OPUS`
- branch: `master`
- current remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`
- HF6 specification: `CONTEXT/SPECIFICATIONS/OPUS_P117U_HF6_COMPOSER_AUTOLOAD_CALLBACK_SPEC.md`
- HF6 handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117U_HF6_COMPOSER_AUTOLOAD_CALLBACK_2026-07-24.md`
- site contract: `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`

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
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6
```

HF5 is superseded. If already applied, it may remain; no rollback is required.

### HF6

- ZIP: `opus_owasys_p117u_hf6_composer_autoload_callback.zip`
- SHA-256: `d482f4b352c958557e63095f5eacb5fdd9fcbb783853dd2c6202c16ccf79505c`
- files: 4
- ZIP bytes: 3,332

```text
composer.json
Opus/Composer/ComposerScriptsInterface.php
Opus/Composer/ComposerScripts.php
sites/owasys/config/composer.commands.json
```

P117S and P117T remain rejected.

## Runtime evidence leading to HF6

Two post-HF5 traces still produced:

```text
Could not open input file: scripts\opus.php
```

Composer found the public alias `owasys:registry-sync`, but its script definition still launched a relative `@php scripts/opus.php ...` subprocess. HF5 therefore did not remove the CWD dependency in the owner Windows environment.

## HF6 framework correction

All public Composer aliases now call the generic autoloaded callback:

```text
Opus\Composer\ComposerScripts::run
```

The callback resolves the OPUS root from its framework location. Generic `opus:*` aliases are resolved generically. Application aliases are read from each application's `sites/<site>/config/composer.commands.json` through `File` and `StructuredFileLoader`.

`scripts/opus.php` remains the direct CLI launcher and is no longer a relative Composer subprocess target.

## Application separation

`Opus\Composer\ComposerScripts` contains no OWASYS reference or business command.

OWASYS owns only its alias map in:

```text
sites/owasys/config/composer.commands.json
```

Registry and password implementations remain under `sites/owasys/application/`.

## Framework contract

The new concrete `ComposerScripts` class implements the homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

## Logger and profiler

HF4 remains mandatory and active:

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
```

Every RCP execution remains trace-correlated. Parameters and secrets are excluded.

## Mandatory process topology

```text
127.0.0.1:8792 = REST + Composer backend
127.0.0.1:8000 = SCORE frontend OWASYS
```

## Pending owner gates

- apply HF6 after HF4;
- regenerate optimized autoload;
- restart backend and verify status;
- restart frontend;
- retest Registry synchronization;
- inspect new correlated diagnostics only if another failure occurs;
- validate Registry select/clear/creation-start;
- validate password workflow;
- browser/no-JavaScript;
- HTTPS/Auth0/bastion;
- Windows/Linux parity.

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
REST + COMPOSER IS THE OWASYS BACKEND.
LOGGER AND PROFILER ARE MANDATORY.
EVERY CONCRETE OPUS CLASS IS EXCEPTION-AWARE AND PROFILER-AWARE.
SECRETS NEVER ENTER GIT, ARGV, LOGS, PROFILER PAYLOADS OR DELIVERY ARTIFACTS.
SCORE AND BACKEND-FIRST ARE MANDATORY.
