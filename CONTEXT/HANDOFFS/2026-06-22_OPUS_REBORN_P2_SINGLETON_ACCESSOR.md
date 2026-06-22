# Handoff — OPUS reborn P2 singleton/accessor

Date: 2026-06-22
Project: OPUS

## Current stable state before P2 local apply

OPUS reborn has validated:

```text
P0_OPUS_REBORN_CLEANUP_SMOKE_OK
P1_OPUS_BOOT_RENDER_SMOKE_OK
P1B_OPUS_VIEW_SCORETEMPLATE_SMOKE_OK
P1D_OPUS_NAMING_SMOKE_OK
```

Framework naming is aligned:

```text
Opus/Controller
Opus/Scaffold
Opus/Html
Opus/Url
Opus/Smtp
```

`Url` is not a component. `Link` remains the component.

## New accepted design point

The historical singleton with automatic getter/setter behavior is part of the intended OPUS architecture.

OPUS must support one singleton instance per site/application scope.

## OPUS tooling delivered

The OPUS repo now includes controlled P2 tooling:

```text
tools/apply_opus_singleton_accessor_p2.py
tools/smoke_opus_singleton_accessor_p2.php
DOC/OPUS_SINGLETON_ACCESSOR_P2.md
```

## Local command sequence

Run in Windows dev:

```cmd
cd /d H:\OPUS
git pull --ff-only
python tools\apply_opus_singleton_accessor_p2.py
python tools\apply_opus_singleton_accessor_p2.py --write
php tools\smoke_opus_singleton_accessor_p2.php
php tools\smoke_opus_boot_render_p1.php
php tools\smoke_opus_view_scoretemplate_p1b.php
python tools\smoke_opus_naming_p1d.py
git status --short
```

Expected:

```text
P2_SINGLETON_ACCESSOR_APPLY_OK
P2_OPUS_SINGLETON_ACCESSOR_SMOKE_OK
P1_OPUS_BOOT_RENDER_SMOKE_OK
P1B_OPUS_VIEW_SCORETEMPLATE_SMOKE_OK
P1D_OPUS_NAMING_SMOKE_OK
```

## If all smokes pass

Commit locally:

```cmd
git add -A
git commit -m "P2_OPUS_SINGLETON_ACCESSOR_CONTRACT"
git push
git status --short
```

## Next after P2

Do not extract sites yet. First audit root-level OPUS responsibilities:

```text
Kernel.php
Package.php
PackageRepository.php
Request.php
Response.php
Support.php
wrapper files such as Acl.php, Fsm.php, I18n.php, Router.php
```

Goal: decide KEEP_CORE, KEEP_FACADE, MOVE_TO_INTERNAL, REVIEW, DELETE_LATER.
