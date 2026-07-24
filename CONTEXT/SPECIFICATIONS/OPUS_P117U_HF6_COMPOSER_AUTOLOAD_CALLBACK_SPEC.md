# OPUS P117U HF6 — COMPOSER AUTOLOAD CALLBACK CONTRACT

Date: 2026-07-24
Status: binding hotfix specification
Applies after: P117U + HF1 + HF2 + HF3 + HF4
Supersedes: HF5 working-directory workaround
OPUS remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`

## 1. Architectural boundary

OPUS is a framework, not an application.

OWASYS is an application built with OPUS. Its current SCORE pages are its frontend. Secured REST + Composer is its backend. Sites created by OWASYS are independent OPUS applications.

HF6 introduces a generic OPUS Composer callback and keeps application alias data inside the application configuration. No OWASYS business implementation is added under `Opus/`.

## 2. Runtime evidence

After HF5, two new trace-correlated executions still failed with:

```text
Could not open input file: scripts\opus.php
```

The backend log proved:

- operation: `registry.sync`;
- Composer script: `owasys:registry-sync`;
- observed process exit code: `1`;
- closed process exit code: `1`;
- stdout empty;
- Composer attempted the relative string `@php scripts/opus.php ...`.

Therefore HF5 did not remove the dependency on Composer's child-process current directory.

## 3. Framework correction

Composer user aliases no longer execute the relative shell command:

```text
@php scripts/opus.php ...
```

Every public Composer alias now calls the autoloaded framework callback:

```text
Opus\Composer\ComposerScripts::run
```

The callback derives the OPUS root from its own framework file location, not from the current process directory.

`scripts/opus.php` remains the direct CLI launcher for users and tools. It is no longer the subprocess target of Composer aliases.

## 4. Generic and application command resolution

Framework aliases are resolved generically:

```text
opus:create-site -> create:site
opus:add-language -> add:language
```

Application aliases are resolved from each application's own configuration:

```text
sites/<site>/config/composer.commands.json
```

OWASYS declares its public alias-to-command mapping in:

```text
sites/owasys/config/composer.commands.json
```

The generic callback scans application registries through `Opus\File\File` and reads them through `StructuredFileLoader`. It validates:

- registry contract;
- enabled provider declaration;
- alias uniqueness;
- target command membership in the provider's declared commands.

No application name or OWASYS command is hard-coded in the generic callback.

## 5. Composer contract

`composer.json` continues to expose user commands only. No smoke, audit, test, recipe, report or internal validation alias is added.

All existing public command names remain unchanged.

## 6. Framework class contract

HF6 adds one concrete framework class:

```text
Opus\Composer\ComposerScripts
```

It implements the homonymous `ComposerScriptsInterface`, which extends:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The class has no OWASYS dependency or reference.

## 7. Configuration contract

The OWASYS alias map is application configuration and is read through the OPUS File/structured-parser boundary. No direct `file_get_contents`, local `json_decode` or ad hoc parser is introduced in the framework callback.

## 8. Differential

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

No new root directory is introduced. `composer.json` is an existing admitted root file.

## 9. Validation completed

- PHP lint for the new interface and class;
- JSON parsing for both modified JSON files;
- all Composer scripts point to the generic callback;
- no smoke/audit/test/recipe alias;
- no `scripts/opus.php` relative Composer command remains;
- framework alias fixture;
- application alias fixture using the application-owned registry;
- target command declaration validation;
- no OWASYS reference in the generic callback;
- exact ZIP contents and integrity.

## 10. Mandatory order

For a clean OPUS base:

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6
```

HF5 is superseded and is not required on a clean base. If already applied, it may remain; HF6 no longer depends on Composer child-process CWD.

## 11. Diagnostics

HF4 remains mandatory. Every backend execution continues to produce trace-correlated Logger and Profiler diagnostics. HF6 does not suppress or bypass them.
