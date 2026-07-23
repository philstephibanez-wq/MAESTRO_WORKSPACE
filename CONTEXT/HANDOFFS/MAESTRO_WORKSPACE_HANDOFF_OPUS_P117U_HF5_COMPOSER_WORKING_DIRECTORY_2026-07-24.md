# MAESTRO_WORKSPACE HANDOFF — OPUS P117U HF5 COMPOSER WORKING DIRECTORY

Date: 2026-07-24
Status: differential prepared; functional process-boundary test green; owner Windows/browser retest pending
Applies after: P117U + HF1 + HF2 + HF3 + HF4
OPUS remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`

## Architectural reminder

OPUS is the framework.

OWASYS is an application built with OPUS. Its current SCORE pages are the frontend. The secured REST + Composer process is its backend. Generated sites are separate OPUS applications.

HF5 is exclusively a generic framework correction under `Opus/`.

## Runtime evidence

HF4 generated trace:

```text
ED5058905D1EF7D3
```

The correlated log showed:

```text
script = owasys:registry-sync
observed_exit_code = 1
closed_exit_code = 1
stderr = Could not open input file: scripts\opus.php
```

This proves that Composer and its alias were found, but the alias subprocess did not execute from the OPUS project root.

## Correction

`ComposerCommandExecutor` now invokes Composer with:

```text
--working-dir=<validated absolute OPUS root>
```

The existing `proc_open` working-directory argument is retained. The explicit Composer option ensures that `@php scripts/opus.php ...` resolves against the OPUS framework root on Windows and Linux.

No value from the REST request or OWASYS frontend controls this directory.

## Artifact

- ZIP: `opus_owasys_p117u_hf5_composer_working_directory.zip`
- SHA-256: `862d870b4e77de6fd74c391c4d1ca41a240419b7ea8bc33daebeb1aee9a8279b`
- Files: 1
- ZIP bytes: 3,741

Content:

```text
Opus/Rcp/Composer/ComposerCommandExecutor.php
```

No application file, root file, root directory, Composer alias, smoke, audit, report, manifest or temporary file is added.

## Contracts preserved

The modified concrete framework class continues to implement `ComposerCommandExecutorInterface`, which extends the four mandatory markers.

HF4 logger/profiler correlation, diagnostic redaction and Windows exit-code resolution remain active.

## Validation

Green:

- PHP lint;
- explicit working-directory argument in the process vector;
- fake Composer validates the trusted OPUS root argument;
- successful JSON result returned;
- ZIP contains exactly one expected framework file;
- ZIP integrity.

## Application order

```text
P117U
HF1
HF2
HF3
HF4
HF5
```

## Owner retest

1. stop backend and frontend;
2. extract HF5;
3. regenerate optimized Composer autoload;
4. optionally clear the previous log/profiler trace;
5. start backend on `127.0.0.1:8792`;
6. verify `/api/v1/status`;
7. start frontend on `127.0.0.1:8000`;
8. open `/fr-FR/applications`;
9. inspect the new trace if another error is returned.

## Permanent rules

OPUS IS A FRAMEWORK, NOT AN APPLICATION.
OWASYS IS AN APPLICATION BUILT WITH OPUS.
NO OWASYS BUSINESS CODE UNDER `Opus/`.
REST + COMPOSER REMAINS THE OWASYS BACKEND.
NO SILENT FALLBACK.
EVERY CONCRETE OPUS CLASS REMAINS EXCEPTION-AWARE AND PROFILER-AWARE.
