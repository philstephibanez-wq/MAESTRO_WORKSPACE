# OWASYS P117U HF3 — COMPOSER RESULT CONTRACT

Date: 2026-07-23
Status: binding hotfix specification
Applies after: P117U + HF1 + HF2
OPUS remote head reviewed: `05a0639cda2e271e8aa6e77e2b5d8f762d15f6b9`

## 1. Owner runtime incident

With backend and frontend both running and Composer successfully resolved, Registry synchronization failed with:

```text
OPUS_RCP_COMPOSER_RESULT_MISSING
```

The backend process completed without a PHP fatal. The error originated in `Opus\Rcp\Composer\ComposerCommandExecutor::parseResult()`.

## 2. Root cause

The executor accepted only a complete JSON envelope located on one physical stdout line.

A Composer script may prepend its own informational line and may expose the OPUS command result as formatted, multiline JSON when command-line format forwarding is altered. The result remained contract-valid but the line-by-line parser could not reconstruct it.

The OPUS console also defaulted to text output unless `--format=json` reached `scripts/opus.php`. A valid RCP stdin request did not itself force the machine-output contract.

## 3. Framework correction

### OpusConsoleApplication

When stdin contains contract:

```text
OPUS_RCP_COMPOSER_COMMAND_REQUEST_V1
```

`OpusConsoleApplication` forces machine JSON output independently of Composer argument forwarding.

Success output remains:

```text
OPUS_CONSOLE_COMMAND_RESULT_V1
```

Failure output remains:

```text
OPUS_CONSOLE_ERROR_V1
```

### ComposerCommandExecutor

The executor now extracts complete balanced JSON objects from stdout. It therefore supports:

- Composer preamble lines;
- compact JSON;
- formatted multiline JSON;
- nested arrays and objects;
- braces and escaped quotes inside JSON strings;
- more than one JSON object, selecting only an accepted OPUS console contract.

It never treats arbitrary text as a result. Only `OPUS_CONSOLE_COMMAND_RESULT_V1` and `OPUS_CONSOLE_ERROR_V1` are accepted.

If no valid envelope exists:

1. a standalone validated uppercase OPUS error code from stderr may be propagated;
2. a nonzero exit code becomes `OPUS_RCP_COMPOSER_COMMAND_FAILED`;
3. a zero exit without an envelope remains `OPUS_RCP_COMPOSER_RESULT_MISSING`.

No stdout or stderr body is copied to the REST response, logs, profiler payloads or execution store.

## 4. Framework class contract

HF3 modifies two existing concrete framework classes only:

- `Opus\Console\OpusConsoleApplication`;
- `Opus\Rcp\Composer\ComposerCommandExecutor`.

Both continue to implement their homonymous interfaces. Those interfaces extend:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

No new concrete framework class is introduced.

## 5. Security incident discovered during repository reread

The public OPUS repository currently tracks:

```text
runtime/owasys/backend-env.cmd
```

The file contains live-looking values for the three OWASYS backend secrets. The values must never be copied into workspace documentation, delivery artifacts or chat output.

All three values are considered compromised and must be rotated. The tracked file must be removed from the index and local tree. HF3 adds the exact path to the existing root `.gitignore`.

The `.gitignore` change prevents recurrence but does not remove an already tracked file and does not revoke exposed values. Owner cleanup and rotation are mandatory.

## 6. HF3 differential

- ZIP: `opus_owasys_p117u_hf3_composer_result_contract.zip`
- SHA-256: `f0860491df311a997d92c0a82796e7e11921911721bf02e3a8b45aece4ce6f17`
- Files: 3
- Bytes: 5,965

Contents:

```text
.gitignore
Opus/Console/OpusConsoleApplication.php
Opus/Rcp/Composer/ComposerCommandExecutor.php
```

No new root directory is introduced. `.gitignore` is an existing admitted root file. No Composer script, smoke, audit, test, report, README, manifest, cache or temporary file is included.

## 7. Validation completed

- PHP lint for both modified PHP files;
- exact reproduction of pre-HF3 `OPUS_RCP_COMPOSER_RESULT_MISSING`;
- Composer preamble plus multiline JSON accepted after HF3;
- nested data, braces and escaped quote handling;
- RCP stdin request forces one-line machine JSON without `--format=json` dependency;
- safe standalone stderr error-code propagation;
- homonymous interface contract retained;
- ZIP contains exactly three expected files;
- ZIP integrity verified.

## 8. Mandatory application order

```text
P117U -> HF1 -> HF2 -> HF3
```

Then:

1. remove and rotate the exposed runtime secret file;
2. start backend on `127.0.0.1:8792`;
3. verify `/api/v1/status`;
4. start frontend on `127.0.0.1:8000` with the same newly generated secrets;
5. retest `/fr-FR/applications`.

## 9. Permanent boundaries

OPUS remains the generic framework.
OWASYS remains an OPUS application and web UI.
All OWASYS business commands cross secured REST then Composer.
No direct business fallback is added.
No arbitrary executable, shell fragment or browser-provided command is accepted.
Secrets never belong in Git, argv, logs, profiler payloads or ZIP files.
