# P117A12 — Native Admin Dashboard Site Style Smoke

Status: PENDING RUNTIME VALIDATION

## Scope

OPUS now renders the native administrator dashboard as a styled OPUS site surface instead of a raw browser-default HTML document.

## OPUS changes

- Updated `framework/Opus/Admin/AdminBlockedStatesDashboardResponseRenderer.php`.
- Added `framework/Opus/Runtime/NativeAdminDashboardSiteStyleSmoke.php`.

## Hygiene rule

No P117 smoke note, validation report, patch note, handoff, or workflow tracking file is stored inside OPUS. This handoff is kept in `MAESTRO_WORKSPACE` only.

## Runtime validation command

```cmd
cd /d H:\OPUS
git pull
git status --short --branch
php -r "$boot=require 'index.php'; $r=\Opus\Runtime\NativeAdminDashboardSiteStyleSmoke::run(); foreach (['ok','gate','allowed_status','allowed_content_type','has_native_style','has_site_shell','has_hero','has_cards','denied_status','denied_is_public_response'] as $k) { echo $k.'='.(is_bool($r[$k]) ? ($r[$k] ? 'true' : 'false') : $r[$k]).PHP_EOL; } echo 'denied_public_body='.str_replace(\"\n\", ' | ', $r['denied_public_body']).PHP_EOL;"
```

## Expected result

```text
ok=true
gate=P117A12_NATIVE_ADMIN_DASHBOARD_SITE_STYLE_SMOKE
allowed_status=200
allowed_content_type=text/html; charset=utf-8
has_native_style=true
has_site_shell=true
has_hero=true
has_cards=true
denied_status=503
denied_is_public_response=true
denied_public_body=Site temporairement bloqué. | Contactez le support.
```

## Browser validation

With the local PHP server running from `H:\OPUS`:

```cmd
php -S 127.0.0.1:8765 index.php
```

Open:

```text
http://127.0.0.1:8765/admin/blocked-states
```

Expected: dashboard renders as a styled OPUS admin site surface.
