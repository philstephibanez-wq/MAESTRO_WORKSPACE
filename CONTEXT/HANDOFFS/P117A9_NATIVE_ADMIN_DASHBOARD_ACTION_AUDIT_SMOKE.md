# P117A9 — Native Admin Dashboard Action Audit Smoke

Status: PENDING RUNTIME VALIDATION
Date: 2026-06-16
Scope: OPUS / MAESTRO_WORKSPACE

## Purpose

Prove that native OPUS administrator dashboard actions emit protected audit / observability data after passing through the native dashboard action control plane.

## Strict documentation hygiene

All P117 smoke tracking, patch notes, runtime validation reports and handoffs remain in MAESTRO_WORKSPACE only.

OPUS product roots must not receive per-gate smoke documentation, patch notes, handoffs, validation reports, or DOC pointers for this workflow.

## OPUS files added

```text
framework/Opus/Admin/AdminDashboardActionAuditEvent.php
framework/Opus/Admin/AdminDashboardActionAuditTrail.php
framework/Opus/Runtime/NativeAdminDashboardActionAuditSmoke.php
```

## OPUS file updated

```text
framework/Opus/Admin/AdminDashboardActionControlPlane.php
```

Change: admin action diagnostics now include the target site so protected audit events can carry complete operational context.

## Runtime validation command

```cmd
cd /d H:\OPUS
git pull
git status --short --branch
php -r "$boot=require 'index.php'; $r=\Opus\Runtime\NativeAdminDashboardActionAuditSmoke::run(); foreach (['ok','gate','audit_event_count','allowed_audit_decision','allowed_audit_action','allowed_audit_effect','denied_audit_decision','denied_audit_reason','denied_public_status','denied_is_public_response'] as $k) { echo $k.'='.(is_bool($r[$k]) ? ($r[$k] ? 'true' : 'false') : $r[$k]).PHP_EOL; } echo 'denied_public_body='.str_replace(\"\n\", ' | ', $r['denied_public_body']).PHP_EOL;"
```

## Expected result

```text
ok=true
gate=P117A9_NATIVE_ADMIN_DASHBOARD_ACTION_AUDIT_SMOKE
audit_event_count=2
allowed_audit_decision=ALLOW
allowed_audit_action=ADMIN_ACKNOWLEDGE_BLOCKED_STATE
allowed_audit_effect=blocked_state_acknowledged
denied_audit_decision=DENY
denied_audit_reason=ADMIN_DASHBOARD_ACTION_SCOPE_DENIED
denied_public_status=503
denied_is_public_response=true
denied_public_body=Site temporairement bloqué. | Contactez le support.
```

## Validation criteria

- Authorized admin action emits a protected audit event.
- Denied admin action emits a protected audit event.
- Audit event count is exactly `2`.
- Authorized event carries `ALLOW` and the expected action effect.
- Denied event carries `DENY` and the protected denial reason.
- Public denied response remains the opaque support message.
- No audit id, admin action, denial reason, effect, or identity context leaks into public response.
