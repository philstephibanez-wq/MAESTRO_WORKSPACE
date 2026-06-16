# P117A1B — OPUS official autoload boot handoff

Date: 2026-06-16
Status: implementation delivered, local smoke validation required

## Context

P117A1 exposed the current OPUS official entry point blocker:

```text
PHP Fatal error:  Uncaught Error: Class "Opus\Autoload\Autoloader" not found in H:\OPUS\index.php:23
```

The OPUS root entry point required `AutoloadCache.php` and `RuntimeLogger.php`, then directly called `Opus\Autoload\Autoloader::boot(...)`. The `Autoloader` class itself was not required before the autoload cache was registered.

This is a bootstrapping issue, not a runtime fallback issue.

## Delivered OPUS commits

```text
2d233dd P117A1B_FIX_OPUS_OFFICIAL_AUTOLOAD_BOOT
b69d1df P117A1B_ADD_BOOT_OK_CONTRACT
```

## Files changed in OPUS

```text
index.php
framework/Opus/Autoload/Autoloader.php
```

## Contract decision

The OPUS root entrypoint remains the only official product runtime entrypoint.

Boot dependencies required before cache-backed autoload registration are explicit and limited to:

```text
framework/Opus/Autoload/AutoloadCache.php
framework/Opus/Log/RuntimeLogger.php
framework/Opus/Autoload/ClassMapBuilder.php
framework/Opus/Autoload/Autoloader.php
```

This is not a hidden fallback loader. It is the explicit bootstrap dependency set required to reach the official cache-backed autoload stage.

## Return contract

`Opus\Autoload\Autoloader::boot()` now returns an explicit `ok => true` when boot succeeds.

Expected boot array keys:

```text
ok
root
cache_file
log_file
class_count
rebuild
```

## Local validation command

```cmd
cd /d H:\OPUS
git pull
git status --short --branch
php -r "$r=require 'index.php'; if (!is_array($r)) { fwrite(STDERR, 'OPUS_BOOT_NOT_ARRAY'.PHP_EOL); exit(10); } foreach (['ok','class_count','cache_file','log_file','rebuild'] as $k) { echo $k.'='.(array_key_exists($k,$r) ? (is_bool($r[$k]) ? ($r[$k] ? 'true' : 'false') : $r[$k]) : '<missing>').PHP_EOL; }"
dir /B var
dir /B var\cache
dir /B var\logs
```

## Expected result

```text
## master...origin/master
ok=true
class_count=<positive integer>
cache_file=H:\OPUS\var\cache\opus\autoload\opus_classmap.php
log_file=H:\OPUS\var\logs\opus_runtime.log
rebuild=true|false
cache
logs
```

## Next gate if validation passes

```text
P117A2_OPUS_PUBLIC_ROUTE_MVC_SMOKE
```

Goal:

```text
site config -> route declaration -> controller -> ViewModel -> ScoreTemplate/response
```

## Next gate if validation fails

Stay on:

```text
P117A1B_FIX_OPUS_OFFICIAL_AUTOLOAD_BOOT
```

and diagnose the next explicit fatal error without adding any fallback.
