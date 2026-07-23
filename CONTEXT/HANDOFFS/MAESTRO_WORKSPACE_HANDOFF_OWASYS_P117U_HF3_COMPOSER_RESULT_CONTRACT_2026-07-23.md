# MAESTRO_WORKSPACE HANDOFF — OWASYS P117U HF3 COMPOSER RESULT CONTRACT

Date: 2026-07-23
Status: differential prepared; isolated reproduction and correction gates green; owner Windows/browser retest pending
Applies after: P117U + HF1 + HF2
OPUS remote head reviewed: `05a0639cda2e271e8aa6e77e2b5d8f762d15f6b9`

## Runtime incident

The owner started both mandatory processes:

```text
127.0.0.1:8792 = REST + Composer backend
127.0.0.1:8000 = SCORE frontend
```

The backend accepted and completed the request, but the frontend received:

```text
OPUS_RCP_COMPOSER_RESULT_MISSING
```

The failing source was `ComposerCommandExecutor::parseResult()`.

## Cause

The existing parser inspected stdout one physical line at a time and accepted JSON only when the complete OPUS console envelope occupied one line.

Composer can prefix command output. If `--format=json` is not forwarded as assumed, `OpusConsoleApplication` emits formatted multiline JSON. The command result remains valid but the executor cannot reconstruct it.

## HF3 correction

`OpusConsoleApplication` now treats an RCP stdin contract as a machine-output request and forces JSON independently of forwarded CLI options.

`ComposerCommandExecutor` now extracts complete balanced JSON objects from Composer stdout, including multiline output preceded by Composer messages. It accepts only the declared OPUS console result/error contracts.

No OWASYS-specific code is introduced in the framework and no business fallback is added.

## HF3 artifact

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

The only root file is the existing admitted `.gitignore`. No root directory, smoke, audit, test, report, README, manifest, cache or temporary file is added.

## Interface contract

The two modified concrete framework classes continue to implement their homonymous interfaces extending the four OPUS marker interfaces. HF3 introduces no new concrete class.

## Reproduction and validation

The exact previous parser was exercised against:

```text
Composer preamble
+ formatted multiline OPUS_CONSOLE_COMMAND_RESULT_V1
```

It reproduced `OPUS_RCP_COMPOSER_RESULT_MISSING`.

The same fixture passes after HF3. Additional green gates:

- compact RCP JSON output forced from stdin contract;
- nested JSON objects;
- braces and escaped quotes inside strings;
- safe standalone stderr error code;
- PHP lint;
- exact ZIP content and integrity.

## Security incident discovered during GitHub reread

The OPUS repository is public and currently tracks:

```text
runtime/owasys/backend-env.cmd
```

That file contains the three OWASYS service secrets. Their values are deliberately omitted from this handoff.

Mandatory response:

1. stop frontend and backend;
2. remove the tracked file from Git and local disk;
3. commit and push the deletion plus HF3 `.gitignore` rule;
4. generate three new secrets;
5. restart both processes with the new values;
6. treat every previous value as permanently compromised.

The path has already entered public Git history. Rotation is mandatory even after deletion. History purification is an owner-controlled repository operation and must not be hidden inside a code ZIP.

## Mandatory patch order

```text
P117U
HF1
HF2
HF3
```

## Retest order

1. apply HF3;
2. remove tracked secrets and generate new ones;
3. run `composer dump-autoload -o` through the installed Composer command;
4. start backend on port `8792`;
5. verify `/api/v1/status`;
6. start frontend on port `8000`;
7. load `/fr-FR/applications`;
8. validate Registry snapshot, selection, clear and creation-start operations;
9. validate password change separately.

## Permanent rules

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO FALLBACK SILENCIEUX.
ONLY THE OWNER-CONFIRMED OPUS ROOT IS ADMITTED.
COMPOSER EXPOSES USER COMMANDS ONLY.
OPUS IS THE FRAMEWORK.
OWASYS IS AN OPUS APPLICATION.
REST + COMPOSER IS THE OWASYS BACKEND.
SECRETS NEVER ENTER GIT, ARGV, LOGS OR DELIVERY ARTIFACTS.
SCORE AND BACKEND-FIRST ARE MANDATORY.
