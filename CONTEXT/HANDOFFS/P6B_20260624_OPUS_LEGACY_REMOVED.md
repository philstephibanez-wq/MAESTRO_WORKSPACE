# P6B — OPUS legacy runtime boundary removed

## Scope

Canonical handoff for the OPUS P6A/P6B runtime cleanup sequence.

```text
Repository : philstephibanez-wq/OPUS
Local root : H:\OPUS
Branch     : master
State      : validated and pushed
```

## Validated commits

```text
545b40b P6A_REMOVE_LEGACY_RUNTIME_BOUNDARY
20febaa P6A_REMOVE_RESIDUAL_LEGACY_AUTOLOADER_NEW2
470a755 P6A_FIX_LEGACY_REMOVAL_SMOKE_CONTRACT
05fbe29 P6B_ARCHIVE_P6A_MIGRATION
```

## Runtime state after P6B

```text
Opus/Legacy removed from Git and disk.
Opus/Runtime/Application.php is now the runtime application class location.
www/index.php is Composer-only and no longer requires Legacy autoloader/application files.
Opus/Runtime/Bootstrap.php remains stable and must not be touched for the next cleanup unless a new audit proves a blocker.
tools/archive/p6_migrations/apply_p6a_remove_legacy_runtime_boundary.py is archived and recognized by the tools layout smoke.
```

## Validation evidence

```text
P3B_OPUS_TOOLS_LAYOUT_SMOKE_OK
P5B_CURRENT_RUNTIME_LAYOUT_SMOKE_OK
P5E_BOOTSTRAP_READINESS_AUDIT_OK
P5G_LEGACY_AUTOLOADER_BOOTSTRAP_BRIDGE_AUDIT_OK
P5H_BOOTSTRAP_MOVE_DESIGN_AUDIT_OK
git status clean
```

## Important cleanup note

A residual untracked/tracked legacy file existed after the first P6A pass:

```text
Opus/Legacy/Autoload/autoloader_new2.class.php
```

It was deleted and pushed with:

```text
20febaa P6A_REMOVE_RESIDUAL_LEGACY_AUTOLOADER_NEW2
```

Future checks must treat any recreated `Opus/Legacy` runtime directory as a regression.

## Next safe step

```text
P6C_SELECT_NEXT_RUNTIME_CLEANUP_TARGET
```

Recommended next targets, in order:

```text
1. Update stale P5 audit names/content so they no longer mention legacy bridge semantics as active architecture.
2. Add/rename permanent P6 runtime smoke/audit for Composer-only www entrypoint and no Opus/Legacy directory.
3. Archive or supersede stale legacy-oriented P5 audits only after a replacement guard exists.
4. Review docs that still mention legacy paths as historical references.
```

## Permanent rules carried forward

```text
NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
```

OPUS code changes stay local-first: assistant may propose scripts/patches, user validates and commits/pushes OPUS. Workspace context may be updated directly when the user explicitly asks for workspace update.
