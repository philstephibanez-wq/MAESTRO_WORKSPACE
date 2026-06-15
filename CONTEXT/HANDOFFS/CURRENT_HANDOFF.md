# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart from this file without relying on hidden conversation memory.

## Current priority

P116C5N — restore OPUS runtime entrypoint, framework autoloader, strict `var/cache` + `var/logs` contract.

## Immediate stop rule

Do not continue OPUS RefBook UI/CSS work until OPUS runtime is verified again.

Recent OPUS_REF_BOOK UI regressions were reverted by:

```text
b5f00c6 P116C5M_REVERT_REFBOOK_UI_REGRESSIONS_TO_P116C5H
```

The local safety branch exists:

```text
backup/P116C5L_broken_ui_20260616
```

## OPUS runtime contract

Accepted decision:

```text
CONTEXT/DECISIONS/ADR_20260616_OPUS_STRICT_RUNTIME_ENTRYPOINT_VAR_AUTOLOADER.md
```

Runtime rules:

```text
H:\OPUS\index.php                         unique product entrypoint
H:\OPUS\framework\Opus\Autoload\...      framework autoloader classes
H:\OPUS\var\cache                         runtime cache only
H:\OPUS\var\logs                          runtime logs only
```

Forbidden inside `H:\OPUS\var`:

```text
var/tmp
var/audit
var/generated
var/lstsa
var/recipes
var/refbook
var/write_refbook_entrypoint.py
```

If needed, those belong under MAESTRO_WORKSPACE, for example:

```text
H:\MAESTRO_WORKSPACE\var\opus\...
H:\MAESTRO_WORKSPACE\tools\opus\...
```

## Current OPUS audit facts

Current OPUS repository is clean and up to date on `master`.

Tracked runtime/autoload classes found:

```text
framework/Opus/Autoload/AutoloadCache.php
framework/Opus/Autoload/ClassMapBuilder.php
framework/Opus/Cache/Cache.php
```

Tracked `var` placeholders found:

```text
var/.gitkeep
var/README.md
var/cache/.gitkeep
var/logs/.gitkeep
var/tmp/.gitkeep
```

Current local OPUS `var` also contains dev/diagnostic folders that must leave OPUS product storage:

```text
var/audit
var/generated
var/lstsa
var/recipes
var/refbook
var/tmp
var/write_refbook_entrypoint.py
```

## Next safe step

Implement P116C5N in OPUS only:

```text
1. Add/restore root index.php as the unique runtime entrypoint.
2. Add framework class Opus\Autoload\Autoloader.
3. Ensure the autoloader rebuilds its classmap cache when missing or stale.
4. Ensure OPUS writes runtime logs to var/logs.
5. Restrict OPUS var to cache/logs only.
6. Move any dev/diagnostic var content to MAESTRO_WORKSPACE if it must be kept.
7. Add a blocking runtime audit for entrypoint/cache/log/strict-var.
```

Expected audit states:

```text
OPUS_INDEX_ENTRYPOINT_OK
OPUS_AUTOLOAD_CACHE_REBUILD_OK
OPUS_RUNTIME_LOG_WRITE_OK
OPUS_STRICT_VAR_CONTRACT_OK
```

## Active repositories

| Repository | Role | Current state |
|---|---|---|
| MAESTRO_WORKSPACE | Contracts, decisions, handoffs | Canonical coordination layer, updated for P116C5N |
| OPUS | Framework core | Active implementation target: runtime autoloader and strict var |
| OPUS_REF_BOOK | Transitional RefBook repository | Reverted to P116C5H baseline; do not patch UI now |
| MAESTRO_V5 | REAPER/Lua music assistant | Active, not current priority |
| MO_KB_DAEMON | Music KB backend/workers | Active, not current priority |
| MO_KB_FRONT | KB front/backoffice | To align later |

## Explicit blockers / unknowns

- OPUS root `index.php` is not yet restored in the audited state.
- OPUS autoload/cache build scripts were removed from product `tools/`; the runtime role must return as framework class behavior, not as a tools script.
- OPUS RefBook must later be checked to ensure it consumes OPUS through the official runtime contract.
- RefBook UI scroll/footer work is paused until OPUS runtime is stable.

## Fresh chat starter

On reprend depuis MAESTRO_WORKSPACE. Priorité : P116C5N — restaurer OPUS runtime : `index.php` unique point d’entrée, autoloader classe framework, cache dans `OPUS\var\cache`, logs dans `OPUS\var\logs`, `OPUS\var` strictement limité à `cache/logs`. Ne pas toucher au RefBook UI avant validation runtime.