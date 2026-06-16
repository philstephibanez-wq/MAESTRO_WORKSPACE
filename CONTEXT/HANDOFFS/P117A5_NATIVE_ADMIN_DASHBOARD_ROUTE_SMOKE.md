# P117A5 - Native Admin Dashboard Route Smoke

## Status

PENDING_RUNTIME_VALIDATION

## Scope

P117A5 advances OPUS from an administrator blocked-state ViewModel smoke to a native administrator dashboard route smoke.

## OPUS commits

```text
35127dd P117A5_ADD_ADMIN_ROUTE_REQUEST
617515b P117A5_ADD_ADMIN_ROUTE_CONTROL_DECISION
494d30f P117A5_ADD_ADMIN_DASHBOARD_ROUTE_CONTROL_PLANE
0e800b7 P117A5_ADD_ADMIN_BLOCKED_STATES_DASHBOARD_ROUTE
9a42fcb P117A5_ADD_NATIVE_ADMIN_DASHBOARD_ROUTE_SMOKE
dc3f435 P117A5_DOCUMENT_NATIVE_ADMIN_DASHBOARD_ROUTE_SMOKE
```

## Added OPUS files

```text
framework/Opus/Admin/AdminRouteRequest.php
framework/Opus/Admin/AdminRouteControlDecision.php
framework/Opus/Admin/AdminDashboardRouteControlPlane.php
framework/Opus/Admin/AdminBlockedStatesDashboardRoute.php
framework/Opus/Runtime/NativeAdminDashboardRouteSmoke.php
DOC/P117A5_NATIVE_ADMIN_DASHBOARD_ROUTE_SMOKE.md
```

## Contract

The OPUS administrator dashboard is a native OPUS surface.

It must be protected by the same FSM / ACL / SSO-like control plane as the public and product runtime surfaces.

No dashboard route may bypass the control plane.

Denied administrator dashboard access must never reveal technical diagnostics to the caller. Public output remains opaque, while protected diagnostics remain available to admin, log or report surfaces.

## Smoke command

```cmd
cd /d H:\OPUS
git pull
git status --short --branch
php -r "$boot=require 'index.php'; $r=\Opus\Runtime\NativeAdminDashboardRouteSmoke::run(); foreach (['ok','gate','admin_route','admin_allowed','admin_surface','admin_blocked_state','admin_reason','anonymous_allowed','anonymous_public_status','anonymous_admin_reason'] as $k) { echo $k.'='.(is_bool($r[$k]) ? ($r[$k] ? 'true' : 'false') : $r[$k]).PHP_EOL; } echo 'anonymous_public_body='.str_replace(\"\n\", ' | ', $r['anonymous_public_body']).PHP_EOL;"
```

## Expected result

```text
ok=true
gate=P117A5_NATIVE_ADMIN_DASHBOARD_ROUTE_SMOKE
admin_route=/admin/blocked-states
admin_allowed=true
admin_surface=admin_dashboard
admin_blocked_state=PUBLIC_REQUEST_BLOCKED
admin_reason=UNKNOWN_PUBLIC_ROUTE
anonymous_allowed=false
anonymous_public_status=503
anonymous_admin_reason=ADMIN_DASHBOARD_ROLE_DENIED
anonymous_public_body=Site temporairement bloqué. | Contactez le support.
```

## Next step after runtime validation

Record P117A5 runtime validation, then proceed to the next native dashboard increment.
