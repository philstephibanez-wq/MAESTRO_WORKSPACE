# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart from this file without relying on hidden conversation memory.

## Current priority

P116C5N — validate OPUS runtime entrypoint, framework autoloader, strict `var/cache` + `var/logs` contract.

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

## P116C5N implementation written to OPUS GitHub

Written directly to `philstephibanez-wq/OPUS`:

```text
index.php
framework/Opus/Autoload/Autoloader.php
framework/Opus/Log/RuntimeLogger.php
.gitignore
```

Tracked OPUS `var` cleanup written to GitHub:

```text
removed var/.gitkeep
removed var/README.md
removed var/tmp/.gitkeep
kept    var/cache/.gitkeep
kept    var/logs/.gitkeep
```

Important: local untracked folders in `H:\OPUS\var` are not removed by Git pull. They must be moved or deleted locally before `index.php` can pass the strict var contract.

Known local folders to move out of OPUS product storage if still present:

```text
var/audit
var/generated
var/lstsa
var/recipes
var/refbook
var/tmp
var/write_refbook_entrypoint.py
```

Recommended workspace destination if preservation is needed:

```text
H:\MAESTRO_WORKSPACE\var\opus\...
```

## Next safe local validation

After pulling OPUS, move any forbidden local `var` entries out of OPUS, then validate:

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
| OPUS | Framework core | Runtime autoloader implanted on GitHub; local pull/validation required |
| OPUS_REF_BOOK | Transitional RefBook repository | Reverted to P116C5H baseline; do not patch UI now |
| MAESTRO_V5 | REAPER/Lua music assistant | Active, not current priority |
| MO_KB_DAEMON | Music KB backend/workers | Active, not current priority |
| MO_KB_FRONT | KB front/backoffice | To align later |

## Explicit blockers / unknowns

- Local OPUS must pull the new runtime commits.
- Local OPUS must move/delete forbidden untracked `var` entries before strict runtime boot can pass.
- OPUS RefBook must later be checked to ensure it consumes OPUS through the official runtime contract.
- RefBook UI scroll/footer work is paused until OPUS runtime is stable.

## Fresh chat starter

On reprend depuis MAESTRO_WORKSPACE. Priorité : P116C5N — valider OPUS runtime : `index.php` unique point d’entrée, autoloader classe framework, cache dans `OPUS\var\cache`, logs dans `OPUS\var\logs`, `OPUS\var` strictement limité à `cache/logs`. OPUS GitHub a reçu `index.php`, `Autoloader.php`, `RuntimeLogger.php`; pull local puis déplacer les anciens dossiers dev de `OPUS\var` vers `MAESTRO_WORKSPACE\var\opus` avant test. Ne pas toucher au RefBook UI avant validation runtime.