# P117A6 - Native Admin Dashboard Rendered Response Smoke

## Status

RUNTIME VALIDATED by user on 2026-06-16.

## OPUS commit chain

```text
b55fb7f P117A6_DOCUMENT_RENDERED_DASHBOARD_RESPONSE_SMOKE
46acf10 P117A6_ADD_RENDERED_DASHBOARD_RESPONSE_SMOKE
54e5852 P117A6_ADD_BLOCKED_STATES_DASHBOARD_RENDERER
e5cda98 P117A6_ADD_ADMIN_DASHBOARD_RESPONSE
```

## Goal

P117A6 moves OPUS from a protected admin dashboard route decision to a rendered native admin dashboard response.

The dashboard remains native to OPUS and protected by the OPUS admin control plane.

## Validation command

```cmd
cd /d H:\OPUS
git pull
git status --short --branch
php -r "$boot=require 'index.php'; $r=\Opus\Runtime\NativeAdminDashboardRenderedResponseSmoke::run(); foreach (['ok','gate','admin_status','admin_content_type','admin_surface_header','admin_body_contains_dashboard','admin_body_contains_blocked_state','denied_status','denied_is_public_response'] as $k) { echo $k.'='.(is_bool($r[$k]) ? ($r[$k] ? 'true' : 'false') : $r[$k]).PHP_EOL; } echo 'denied_public_body='.str_replace(\"\n\", ' | ', $r['denied_public_body']).PHP_EOL;"
```

## User runtime result

```text
ok=true
gate=P117A6_NATIVE_ADMIN_DASHBOARD_RENDERED_RESPONSE_SMOKE
admin_status=200
admin_content_type=text/html; charset=utf-8
admin_surface_header=admin_dashboard
admin_body_contains_dashboard=true
admin_body_contains_blocked_state=true
denied_status=503
denied_is_public_response=true
denied_public_body=Site temporairement bloqué. | Contactez le support.
```

## Validation meaning

P117A6 proves that:

```text
- the native OPUS administrator dashboard route can render an HTML dashboard response;
- the response uses the native admin dashboard surface header;
- the rendered body contains dashboard content and blocked-state information;
- denied contexts still receive only the opaque public support message;
- admin diagnostic data is not exposed in denied/public responses.
```

## Next gate after validation

P117A7 should start shaping the real native OPUS dashboard screen around the rendered response, still without bypassing FSM/ACL/identity controls.
