# OPUS P117U HF5 — COMPOSER WORKING DIRECTORY CONTRACT

Date: 2026-07-24
Status: binding hotfix specification
Applies after: P117U + HF1 + HF2 + HF3 + HF4
OPUS remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`

## 1. Framework boundary

OPUS is a framework, not an application.

HF5 modifies only the generic OPUS Composer process boundary. No OWASYS business implementation, controller, model, template or configuration is modified.

OWASYS remains an application built with OPUS. Its operation catalog selects an allow-listed Composer script, but OPUS owns the generic process execution contract.

## 2. Owner runtime evidence

The HF4 backend log identified the exact failure:

```text
Could not open input file: scripts\opus.php
Script @php scripts/opus.php owasys:registry:sync handling the owasys:registry-sync event returned with error code 1
```

Composer was discovered correctly. The OWASYS alias was resolved correctly. The child command executed outside the OPUS project root and therefore could not resolve the relative generic entrypoint `scripts/opus.php`.

## 3. Correction

`Opus\Rcp\Composer\ComposerCommandExecutor` now adds the trusted global Composer option:

```text
--working-dir=<absolute OPUS root>
```

The value is taken exclusively from the validated constructor root. It is not supplied by the browser, REST parameters, the OWASYS operation catalog or an environment override.

The existing `proc_open` working directory remains the OPUS root as an operating-system boundary. The explicit Composer option is additionally required because Composer and its script subprocesses must share the same project root on Windows and Linux.

## 4. Security

HF5 does not permit:

- browser-selected working directories;
- request-selected executable paths;
- shell fragments;
- arbitrary Composer aliases;
- environment injection;
- local business fallback.

The working directory is an internal absolute OPUS framework value.

## 5. Interface contract

HF5 modifies one existing concrete framework class:

```text
Opus\Rcp\Composer\ComposerCommandExecutor
```

It continues to implement its homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

No new class or interface is introduced.

## 6. Differential

- ZIP: `opus_owasys_p117u_hf5_composer_working_directory.zip`
- SHA-256: `862d870b4e77de6fd74c391c4d1ca41a240419b7ea8bc33daebeb1aee9a8279b`
- Files: 1
- ZIP bytes: 3,741

Contents:

```text
Opus/Rcp/Composer/ComposerCommandExecutor.php
```

No root file, root directory, Composer alias, application file, smoke, audit, test, report, README, manifest, cache or temporary file is included.

## 7. Validation completed

- PHP lint;
- exact ZIP content and integrity;
- functional fake-Composer process;
- explicit `--working-dir=<OPUS root>` observed in process arguments;
- successful JSON result boundary retained;
- HF4 logger/profiler and Windows exit-code behavior retained.

## 8. Mandatory order

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF5
```

After HF5, restart backend first, verify status, then restart the frontend and retest Registry synchronization.
