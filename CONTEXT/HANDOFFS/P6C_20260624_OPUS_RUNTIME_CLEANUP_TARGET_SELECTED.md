# P6C — OPUS runtime cleanup target selected

## Status

```text
VALIDATED
DATE=2026-06-24
REPOSITORY=philstephibanez-wq/OPUS
WORKSPACE=philstephibanez-wq/MAESTRO_WORKSPACE
```

## OPUS commits involved

```text
05fbe29 P6B_ARCHIVE_P6A_MIGRATION
fdb84aa P6C_ADD_RUNTIME_CLEANUP_TARGET_SELECTOR_AUDIT
dfe6801 P6C_REGISTER_RUNTIME_CLEANUP_SELECTOR_AUDIT
3a52a81 P6C_FIX_RUNTIME_REFERENCE_SCOPE
```

## Validated checks

```text
P6C_SELECT_NEXT_RUNTIME_CLEANUP_TARGET_AUDIT_OK
P3B_OPUS_TOOLS_LAYOUT_SMOKE_OK
P5B_CURRENT_RUNTIME_LAYOUT_SMOKE_OK
P5E_BOOTSTRAP_READINESS_AUDIT_OK
P5G_LEGACY_AUTOLOADER_BOOTSTRAP_BRIDGE_AUDIT_OK
P5H_BOOTSTRAP_MOVE_DESIGN_AUDIT_OK
git status clean
```

## P6C decision

```text
DECISION=P6D_RUNTIME_APPLICATION_NAMESPACE_CONTRACT
NEXT_SAFE_STEP=P6D_AUDIT_RUNTIME_APPLICATION_NAMESPACE_READINESS
```

P6C selected the next runtime cleanup target after confirming that the post-Legacy runtime boundary is stable.

## Candidate ranking reported by P6C

```text
CANDIDATE_1=P6D_RUNTIME_APPLICATION_NAMESPACE_CONTRACT
TITLE_1=Runtime Application still exposes the historical global OPUS_Application class.
EVIDENCE_1=Opus/Runtime/Application.php contains class OPUS_Application without namespace Opus\Runtime.
RISK_1=MEDIUM
NEXT_STEP_1=P6D_AUDIT_RUNTIME_APPLICATION_NAMESPACE_READINESS

CANDIDATE_2=P6E_WWW_ENTRYPOINT_RESPONSIBILITY_SPLIT
TITLE_2=www/index.php still owns package asset serving logic before booting the app.
EVIDENCE_2=www/index.php contains opus_serve_package_asset().
RISK_2=LOW_MEDIUM
NEXT_STEP_2=P6E_AUDIT_WWW_ENTRYPOINT_RESPONSIBILITY_SPLIT

CANDIDATE_3=P6F_RUNTIME_BOOTSTRAP_REQUIRE_LIST_REVIEW
TITLE_3=Runtime Bootstrap still owns a manual require list despite Composer being active.
EVIDENCE_3=Opus/Runtime/Bootstrap.php contains 1 require_once instruction(s).
RISK_3=MEDIUM
NEXT_STEP_3=P6F_AUDIT_BOOTSTRAP_REQUIRE_LIST_COMPOSER_READINESS
```

## Stable runtime state after P6C

```text
Opus/Legacy absent.
Opus/Bootstrap.php absent.
Opus/Application.class.php absent.
Opus/autoloader.class.php absent.
Opus/autoloader_new2.class.php absent.
Opus/Runtime/Bootstrap.php stable.
Opus/Runtime/Application.php active but still exposes global OPUS_Application.
www/index.php Composer-only.
```

## Next work

```text
P6D_AUDIT_RUNTIME_APPLICATION_NAMESPACE_READINESS
```

P6D must be audit-first. Do not rename or namespace `OPUS_Application` before an audit proves all references and transition risks.

## Regression guards

```text
Do not recreate Opus/Legacy.
Do not move Bootstrap again without a new blocker audit.
Do not patch OPUS runtime before P6D audit output is validated.
Keep workspace CURRENT_HANDOFF updated after P6D.
```
