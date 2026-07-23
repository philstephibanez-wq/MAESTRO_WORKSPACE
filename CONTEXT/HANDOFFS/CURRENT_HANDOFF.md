# CURRENT HANDOFF — MAESTRO WORKSPACE

Date: 2026-07-24

## Active milestone

P117U with mandatory HF1, HF2, HF3, HF4 and HF5.

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
- HF5 specification: `CONTEXT/SPECIFICATIONS/OPUS_P117U_HF5_COMPOSER_WORKING_DIRECTORY_SPEC.md`
- HF5 handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117U_HF5_COMPOSER_WORKING_DIRECTORY_2026-07-24.md`
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

## Mandatory artifact order

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF5
```

### HF5

- ZIP: `opus_owasys_p117u_hf5_composer_working_directory.zip`
- SHA-256: `862d870b4e77de6fd74c391c4d1ca41a240419b7ea8bc33daebeb1aee9a8279b`
- files: 1
- ZIP bytes: 3,741

```text
Opus/Rcp/Composer/ComposerCommandExecutor.php
```

P117S and P117T remain rejected.

## Runtime evidence leading to HF5

The HF4 trace `ED5058905D1EF7D3` produced a structured log proving:

```text
Composer alias: owasys:registry-sync
observed exit code: 1
closed exit code: 1
stderr: Could not open input file: scripts\opus.php
```

Composer and the OWASYS alias were found. The child script did not run from the OPUS framework root.

## HF5 framework correction

`Opus\Rcp\Composer\ComposerCommandExecutor` adds:

```text
--working-dir=<validated absolute OPUS root>
```

The existing `proc_open` working directory is retained. The explicit Composer option guarantees that the generic framework entrypoint `scripts/opus.php` resolves from the OPUS project root on Windows and Linux.

The working directory cannot be selected by the browser, REST parameters, OWASYS configuration or environment injection.

No OWASYS application file is modified by HF5.

## Logger and profiler

HF4 remains mandatory and active:

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
```

Every RCP execution remains trace-correlated. Parameters and secrets are excluded from logs and profiler payloads.

## Framework contract

Every concrete class under `Opus/` implements a homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

HF5 modifies one existing concrete framework class and introduces no class or interface.

## Mandatory process topology

```text
127.0.0.1:8792 = REST + Composer backend
127.0.0.1:8000 = SCORE frontend OWASYS
```

Both use the same local environment values and the same canonical `sites/owasys/www/index.php`.

## Pending owner gates

- apply HF5 after HF4;
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
NO OWASYS BUSINESS CODE UNDER `Opus/`.
REST + COMPOSER IS THE OWASYS BACKEND.
LOGGER AND PROFILER ARE EXISTING OPUS SERVICES.
EVERY CONCRETE OPUS CLASS IS EXCEPTION-AWARE AND PROFILER-AWARE.
SECRETS NEVER ENTER GIT, ARGV, LOGS, PROFILER PAYLOADS OR DELIVERY ARTIFACTS.
SCORE AND BACKEND-FIRST ARE MANDATORY.
