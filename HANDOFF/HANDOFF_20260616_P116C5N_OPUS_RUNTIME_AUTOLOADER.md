# Handoff 2026-06-16 - P116C5N OPUS Runtime Autoloader

## Stable point

OPUS_REF_BOOK has been rolled back to the P116C5H visual baseline by commit b5f00c6.

No more RefBook UI work before OPUS runtime is restored and audited.

## Contract reference

See: CONTEXT/CONTRACTS/OPUS_RUNTIME_AUTOLOADER_AND_VAR_CONTRACT.md

## Rules to preserve

- OPUS/index.php is the unique runtime entry point.
- No root autoload.php script.
- The OPUS autoloader is a class in framework/Opus/Autoload.
- OPUS/var may contain only cache and logs.
- Development storage belongs to MAESTRO_WORKSPACE.
- OPUS_REF_BOOK must not create a parallel OPUS bootstrap/cache/log runtime.

## Current audit notes

OPUS has framework classes for autoload/cache:

- framework/Opus/Autoload/AutoloadCache.php
- framework/Opus/Autoload/ClassMapBuilder.php
- framework/Opus/Cache/Cache.php

OPUS has runtime directories:

- var/cache
- var/logs

OPUS also has local development storage under var. If useful, it must be preserved in MAESTRO_WORKSPACE before OPUS var is made strict.

## Next palier

P116C5N_RESTORE_OPUS_INDEX_AUTOLOADER_AND_STRICT_VAR

Expected result:

- index.php calls the framework autoloader.
- the autoloader rebuilds var/cache when required.
- runtime logs go to var/logs.
- failures are explicit.
- OPUS var contains only cache and logs.
