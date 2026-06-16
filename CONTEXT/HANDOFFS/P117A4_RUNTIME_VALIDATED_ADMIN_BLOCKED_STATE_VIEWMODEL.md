# P117A4 — Runtime validated admin blocked-state dashboard ViewModel

Date: 2026-06-16
Status: runtime validated by user

## Runtime validation

The user ran the official smoke locally from `H:\OPUS`:

```cmd
php -r "$boot=require 'index.php'; $r=\Opus\Runtime\AdminBlockedStateDashboardViewModelSmoke::run(); foreach (['ok','gate','public_status','admin_surface','admin_blocked_state','admin_reason','admin_action','admin_public_user_message_policy'] as $k) { echo $k.'='.(is_bool($r[$k]) ? ($r[$k] ? 'true' : 'false') : $r[$k]).PHP_EOL; } echo 'public_body='.str_replace(\"\n\", ' | ', $r['public_body']).PHP_EOL;"
```

Observed result:

```text
ok=true
gate=P117A4_ADMIN_BLOCKED_STATE_DASHBOARD_VIEWMODEL
public_status=503
admin_surface=admin_dashboard
admin_blocked_state=PUBLIC_REQUEST_BLOCKED
admin_reason=UNKNOWN_PUBLIC_ROUTE
admin_action=ADMIN_VIEW_BLOCKED_STATES
admin_public_user_message_policy=opaque_support_only
public_body=Site temporairement bloqué. | Contactez le support.
```

## Validated behavior

- OPUS public blocked response stays opaque.
- OPUS admin ViewModel exposes actionable blocked-state information.
- Public response does not leak admin diagnostics.
- Admin diagnostics are structured for the future native dashboard.

## Product decision

The administrator dashboard is part of OPUS itself.

It is not an external add-on, not a bypass surface, and not a separate security layer.

It is a native OPUS operational surface protected by the same FSM/ACL/SSO-like control plane.

## Updated contract

`20_TECHNICAL_FOUNDATIONS/OPUS/DOC/P117_OPUS_PUBLIC_OPERATIONAL_RELEASE_CONTRACT.md` was updated to replace the previous weaker wording `provide or support an administrator dashboard` with the native OPUS dashboard requirement.

## Next gate

```text
P117A5_NATIVE_ADMIN_DASHBOARD_ROUTE_SMOKE
```

Goal: prove the administrator dashboard can exist as a native OPUS route surface protected by the same control plane, not as an external add-on or bypass.
