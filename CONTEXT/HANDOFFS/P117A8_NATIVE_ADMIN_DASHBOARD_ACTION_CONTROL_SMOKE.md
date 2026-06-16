# P117A8 — Native Admin Dashboard Action Control Smoke

Status: PENDING RUNTIME VALIDATION

## Scope

P117A8 adds the first native OPUS administrator dashboard action control smoke.

Action under test:

```text
ADMIN_ACKNOWLEDGE_BLOCKED_STATE
```

## Expected runtime result

```text
ok=true
gate=P117A8_NATIVE_ADMIN_DASHBOARD_ACTION_CONTROL_SMOKE
allowed_action=ADMIN_ACKNOWLEDGE_BLOCKED_STATE
allowed_granted=true
allowed_effect=blocked_state_acknowledged
denied_granted=false
denied_reason=ADMIN_DASHBOARD_ACTION_SCOPE_DENIED
denied_public_status=503
denied_is_public_response=true
denied_public_body=Site temporairement bloqué. | Contactez le support.
```

## Validation command

```cmd
cd /d H:\OPUS
git pull
git status --short --branch
php -r "$boot=require 'index.php'; $r=\Opus\Runtime\NativeAdminDashboardActionControlSmoke::run(); foreach (['ok','gate','allowed_action','allowed_granted','allowed_effect','denied_granted','denied_reason','denied_public_status','denied_is_public_response'] as $k) { echo $k.'='.(is_bool($r[$k]) ? ($r[$k] ? 'true' : 'false') : $r[$k]).PHP_EOL; } echo 'denied_public_body='.str_replace(\"\n\", ' | ', $r['denied_public_body']).PHP_EOL;"
```

## Runtime files

```text
framework/Opus/Admin/AdminDashboardActionRequest.php
framework/Opus/Admin/AdminDashboardActionDecision.php
framework/Opus/Admin/AdminDashboardActionControlPlane.php
framework/Opus/Runtime/NativeAdminDashboardActionControlSmoke.php
DOC/P117A8_NATIVE_ADMIN_DASHBOARD_ACTION_CONTROL_SMOKE.md
```
