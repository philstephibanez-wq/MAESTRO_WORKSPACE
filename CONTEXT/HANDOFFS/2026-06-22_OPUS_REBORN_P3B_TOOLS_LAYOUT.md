# OPUS reborn — P3B tools layout

Date: 2026-06-22

## Context

After OPUS P0/P1/P1B/P1D/P2 validation, the user noted that OPUS still had too many scripts directly in `tools/` and asked to remove obsolete scripts when possible.

## Decision

Do not touch runtime yet.

Organize tooling into:

```text
tools/audits/
tools/migrations/
tools/smokes/
```

Remove obsolete one-shot scripts after their milestones are committed and covered by current smokes.

## OPUS commits

```text
39936cd P3B_ADD_TOOLS_LAYOUT_MIGRATION
7ad76cd P3B_ADD_TOOLS_LAYOUT_SMOKE
0e27072 P3B_DOC_OPUS_TOOLS_LAYOUT
```

## User-side commands

```cmd
cd /d H:\OPUS
git pull --ff-only
python tools\migrations\apply_opus_tools_layout_p3b.py
python tools\migrations\apply_opus_tools_layout_p3b.py --write
python tools\smokes\smoke_opus_tools_layout_p3b.py
php tools\smokes\smoke_opus_boot_render_p1.php
php tools\smokes\smoke_opus_view_scoretemplate_p1b.php
python tools\smokes\smoke_opus_naming_p1d.py
php tools\smokes\smoke_opus_singleton_accessor_p2.php
git status --short
```

If all smokes pass, commit locally:

```cmd
git add -A
git commit -m "P3B_OPUS_TOOLS_LAYOUT"
git push
git status --short
```

## Next pending topic

`Opus/Acl.php`, `Opus/Fsm.php`, `Opus/I18n.php`, and `Opus/Router.php` are still root namespace wrappers. They depend on the modern `Kernel.php` layer. Do not remove them before auditing Kernel/Package/Request/Response against the restored OPUS singleton/accessor model.
