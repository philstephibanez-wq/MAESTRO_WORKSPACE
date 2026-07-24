# MAESTRO_WORKSPACE HANDOFF — OPUS P117U HF6 COMPOSER AUTOLOAD CALLBACK

Date: 2026-07-24
Status: differential prepared; alias and callback fixtures green; owner Windows/browser retest pending
Applies after: P117U + HF1 + HF2 + HF3 + HF4
Supersedes: HF5
OPUS remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`

## Architectural identity

```text
OPUS = framework
OWASYS = application built with OPUS
OWASYS pages = SCORE frontend
REST + Composer = OWASYS backend
created sites = independent OPUS applications
```

OPUS is not an application.

## Runtime proof

HF4 Logger/Profiler diagnostics remained active after HF5. Two fresh executions failed with the same process stderr:

```text
Could not open input file: scripts\opus.php
```

The traces proved that Composer found `owasys:registry-sync`, but the alias still expanded to a relative `@php scripts/opus.php ...` subprocess. HF5's explicit Composer working directory did not remove that dependency in the owner Windows environment.

## HF6 decision

The relative Composer subprocess is removed.

Every public Composer alias calls:

```text
Opus\Composer\ComposerScripts::run
```

The callback is autoloaded from the OPUS framework. It resolves its root from `__DIR__`, dispatches generic `opus:*` aliases, and reads application-owned aliases through OPUS File + StructuredFileLoader.

`scripts/opus.php` remains the direct CLI launcher. It is no longer invoked by Composer aliases.

## Application separation

The generic callback contains no OWASYS name or command.

OWASYS keeps its alias map in:

```text
sites/owasys/config/composer.commands.json
```

The map is configuration only. The actual Registry and password business implementations remain under `sites/owasys/application/`.

## HF6 artifact

- ZIP: `opus_owasys_p117u_hf6_composer_autoload_callback.zip`
- SHA-256: `d482f4b352c958557e63095f5eacb5fdd9fcbb783853dd2c6202c16ccf79505c`
- Files: 4
- ZIP bytes: 3,332

Contents:

```text
composer.json
Opus/Composer/ComposerScriptsInterface.php
Opus/Composer/ComposerScripts.php
sites/owasys/config/composer.commands.json
```

No new root directory, smoke, audit, test, recipe, report, README, manifest, cache or temporary file is introduced.

## Class contract

`ComposerScripts` implements `ComposerScriptsInterface`. The interface extends the four mandatory OPUS markers. No other concrete framework class is added.

## Validation

Green:

- PHP lint;
- JSON parsing;
- framework alias resolution;
- application alias resolution from application config;
- enabled-provider and declared-command validation;
- no OWASYS reference under `Opus/Composer`;
- all Composer user aliases retained;
- no relative `scripts/opus.php` command in `composer.json`;
- no smoke/audit/test/recipe alias;
- exact ZIP content and integrity.

## Mandatory clean-base order

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6
```

HF5 is superseded. If already applied, no rollback is required; HF6 makes the working-directory workaround irrelevant.

## Owner retest

1. stop backend and frontend;
2. extract HF6;
3. run `composer dump-autoload -o`;
4. optionally clear prior runtime logs and profiler traces;
5. start backend on `127.0.0.1:8792`;
6. verify `/api/v1/status`;
7. start frontend on `127.0.0.1:8000`;
8. open `/fr-FR/applications`;
9. inspect the trace only if a new error occurs.

## Diagnostics

HF4 remains mandatory. Logger and Profiler continue to cover the full REST/Composer execution. No failure is swallowed.

## Permanent rules

OPUS IS A FRAMEWORK, NOT AN APPLICATION.
OWASYS IS AN APPLICATION BUILT WITH OPUS.
NO OWASYS BUSINESS IMPLEMENTATION UNDER `Opus/`.
COMPOSER EXPOSES USER COMMANDS ONLY.
REST + COMPOSER IS THE OWASYS BACKEND.
LOGGER AND PROFILER ARE MANDATORY.
NO SILENT FALLBACK.
