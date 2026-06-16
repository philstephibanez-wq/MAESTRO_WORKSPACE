# P117A11 — Native Admin Dashboard HTTP Route Smoke

Status: PENDING RUNTIME VALIDATION
Scope: OPUS native admin dashboard HTTP route visibility
Date: 2026-06-16

## Objective

Expose the native OPUS admin dashboard through the OPUS HTTP runtime entrypoint so it can be viewed as a real local route instead of a temporary HTML file.

## OPUS changes

Code-only changes in OPUS:

- `framework/Opus/Runtime/NativeHttpKernel.php`
- `framework/Opus/Runtime/NativeHttpEmitter.php`
- `framework/Opus/Runtime/NativeAdminDashboardHttpRouteSmoke.php`
- `index.php`

No OPUS documentation, smoke note, patch note, handoff, validation report or pointer file was added.

## Route

Native dashboard route:

```text
/admin/blocked-states
```

Loopback-local HTTP requests receive the protected native admin dashboard response through the admin route control plane.

Non-loopback admin requests are denied and rendered with the opaque public response only.

## Runtime validation command

```cmd
cd /d H:\OPUS
git pull
git status --short --branch
php -r "$boot=require 'index.php'; $r=\Opus\Runtime\NativeAdminDashboardHttpRouteSmoke::run(); foreach (['ok','gate','allowed_status','allowed_content_type','allowed_surface','allowed_route','allowed_body_contains_dashboard','denied_status','denied_is_public_response'] as $k) { echo $k.'='.(is_bool($r[$k]) ? ($r[$k] ? 'true' : 'false') : $r[$k]).PHP_EOL; } echo 'denied_public_body='.str_replace(\"\n\", ' | ', $r['denied_public_body']).PHP_EOL;"
```

## Expected runtime result

```text
ok=true
gate=P117A11_NATIVE_ADMIN_DASHBOARD_HTTP_ROUTE_SMOKE
allowed_status=200
allowed_content_type=text/html; charset=utf-8
allowed_surface=admin_dashboard
allowed_route=blocked-states
allowed_body_contains_dashboard=true
denied_status=503
denied_is_public_response=true
denied_public_body=Site temporairement bloqué. | Contactez le support.
```

## Local browser preview

After the smoke passes:

```cmd
cd /d H:\OPUS
php -S 127.0.0.1:8765 index.php
```

Open:

```text
http://127.0.0.1:8765/admin/blocked-states
```

## Validation notes

Pending user runtime output.
