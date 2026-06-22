# OPUS reborn — P3B tools layout validated

Date: 2026-06-22

## Status

P3B_OPUS_TOOLS_LAYOUT has been validated locally and pushed to GitHub.

## OPUS repository

Repository: `philstephibanez-wq/OPUS`

Validated commit:

```text
 e198cb3 P3B_OPUS_TOOLS_LAYOUT
```

## Validated checks

```text
P3B_OPUS_TOOLS_LAYOUT_SMOKE_OK
P1_OPUS_BOOT_RENDER_SMOKE_OK
P1B_OPUS_VIEW_SCORETEMPLATE_SMOKE_OK
P1D_OPUS_NAMING_SMOKE_OK
P2_OPUS_SINGLETON_ACCESSOR_SMOKE_OK
```

`git status --short` is clean after push.

## Result

The root `tools/` directory no longer contains flat scripts.

Tool layout is now:

```text
tools/audits/
tools/migrations/
tools/smokes/
```

Deleted obsolete temporary migration/smoke scripts:

```text
tools/opus_reborn_cleanup_p0.py
tools/smoke_opus_reborn_cleanup_p0.py
tools/audit_opus_naming_p1c.py
tools/apply_opus_naming_p1d.py
tools/apply_opus_singleton_accessor_p2.py
```

Moved still-useful scripts:

```text
tools/audits/audit_opus_root_cleanup_p3.py
tools/smokes/smoke_opus_boot_render_p1.php
tools/smokes/smoke_opus_view_scoretemplate_p1b.php
tools/smokes/smoke_opus_naming_p1d.py
tools/smokes/smoke_opus_singleton_accessor_p2.php
tools/smokes/smoke_opus_tools_layout_p3b.py
```

## Next logical step

Do not extract sites yet.

Next step should be a targeted root wrapper/runtime audit:

```text
P4_OPUS_KERNEL_PACKAGE_WRAPPER_AUDIT
```

Scope:

```text
Opus/Acl.php
Opus/Fsm.php
Opus/I18n.php
Opus/Router.php
Opus/Kernel.php
Opus/Package.php
Opus/PackageRepository.php
Opus/Request.php
Opus/Response.php
Opus/Support.php
Opus/View.php
```

Goal:

```text
- decide which wrappers are real framework API
- decide what replaces Kernel if OPUS_Application is sovereign
- decide if Package belongs in framework or site layer
- keep OPUS Singleton/accessor policy intact
- no deletion before reference audit
```
