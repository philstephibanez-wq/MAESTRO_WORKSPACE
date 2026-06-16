# P117A4 — Admin Blocked State Dashboard ViewModel

Date: 2026-06-16
Status: delivered, runtime validation pending
Scope: OPUS, P117, FSM bastion, public error opacity, admin dashboard foundation

## Context

P117A3 validated the blocked-state event model at runtime:

```text
Public user = opaque support-only message.
Admin/logs/dashboard = structured diagnostics.
```

P117A4 starts the administrator dashboard data layer without building the full UI yet.

## Delivered in OPUS

Commits:

```text
7166ac6 P117A4_DOCUMENT_ADMIN_BLOCKED_STATE_VIEWMODEL
ed8917f P117A4_ADD_ADMIN_BLOCKED_STATE_VIEWMODEL_SMOKE
5d6c19d P117A4_ADD_ADMIN_BLOCKED_STATE_VIEWMODEL
```

Files:

```text
framework/Opus/Admin/AdminBlockedStateViewModel.php
framework/Opus/Runtime/AdminBlockedStateDashboardViewModelSmoke.php
DOC/P117A4_ADMIN_BLOCKED_STATE_DASHBOARD_VIEWMODEL.md
```

## Contract

The admin dashboard ViewModel is an administrator-only representation.

It may contain protected diagnostics such as:

```text
- event_id
- site
- route_key
- blocked_state
- reason
- severity
- admin_action
- recommended_actions
```

It must never be serialized to a public response.

The public response remains:

```text
Site temporairement bloqué.
Contactez le support.
```

## Runtime validation command

```cmd
cd /d H:\OPUS
git pull
git status --short --branch
php -r "$boot=require 'index.php'; $r=\Opus\Runtime\AdminBlockedStateDashboardViewModelSmoke::run(); foreach (['ok','gate','public_status','admin_surface','admin_blocked_state','admin_reason','admin_action','admin_public_user_message_policy'] as $k) { echo $k.'='.(is_bool($r[$k]) ? ($r[$k] ? 'true' : 'false') : $r[$k]).PHP_EOL; } echo 'public_body='.str_replace(\"\n\", ' | ', $r['public_body']).PHP_EOL;"
```

Expected result:

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

## Next gate

After validation, P117A5 can start either:

```text
- protected admin dashboard route/view-model flow
- site declaration/config profile flow
```

Recommended next step:

```text
P117A5_ADMIN_DASHBOARD_PROTECTED_ROUTE_SMOKE
```
